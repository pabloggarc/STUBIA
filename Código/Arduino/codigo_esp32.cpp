#include <WiFi.h>
#include <HTTPClient.h>
#include <freertos/FreeRTOS.h>
#include <freertos/task.h>
#include <freertos/semphr.h>
#include <avr/wdt.h>
  
const char* ssid = "Redmi 9";
const char* password = "patatafeliz"; //192.168.1.1 DHCP ip de 100 en adelante

char aula[] = "NA1";

String sensoresUlibre[2] = { "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=1&estado=2", "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=2&estado=2"};
String sensoresUocupado[2] = { "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=1&estado=1", "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=2&estado=1"};
String sensoresIlibre[1] = { "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=3&estado=2"};
String sensoresIocupado[1] = { "http://192.168.57.222/stubia/ws/ws_setestadopuesto.php?aula=1&puesto=3&estado=1"};

long cm = 0;
bool lectura = NULL;

int puestosU[6][2] = {{1, 2}, {23, 25}, {22, 26}, {14, 17}, {13, 16}, {12, 15}};
int puestosI[5][1] = {{1}, {35}, {21}, {19}, {18}};

int estado_puestosU[6] = {LOW, LOW, LOW, LOW, LOW, LOW}; 
int estado_puestosI[5] = {LOW, LOW, LOW, LOW, LOW}; 

TaskHandle_t comunicar_servidor = NULL; 

xSemaphoreHandle mutex; 
 
long leeSensorUltrasonicoDistancia (int triggerPin, int echoPin){
  
  pinMode(triggerPin, OUTPUT);
  
  digitalWrite(triggerPin, LOW);
  delayMicroseconds(2);
  
  digitalWrite(triggerPin, HIGH);
  delayMicroseconds(10);
  
  digitalWrite(triggerPin, LOW);
  pinMode(echoPin, INPUT);
  
  return (pulseIn(echoPin, HIGH) * 0.01723);
}

void setup() {
  mutex = xSemaphoreCreateMutex(); 
  if(mutex!=NULL){
    xTaskCreate(loop2, "loop2", 1000, NULL, 1, &comunicar_servidor); 

    Serial.begin(9600);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
      delay(1000);
      Serial.println("Connecting to WiFi..");
    }

    pinMode(puestosU[3][0], OUTPUT);
    pinMode(puestosU[4][0], OUTPUT);
    pinMode(puestosU[5][0], OUTPUT);
    pinMode(puestosU[3][1], OUTPUT);
    pinMode(puestosU[4][1], OUTPUT);
    pinMode(puestosU[5][1], OUTPUT);
    pinMode(puestosI[2][0], OUTPUT);
    pinMode(puestosI[3][0], OUTPUT);
    pinMode(puestosI[4][0], OUTPUT);
    pinMode(puestosI[1][0], INPUT);
  }
  else{
    wdt_enable(WDTO_1S);
    wdt_reset();
  }
}
  
void loop() {
  for (int i=0; i<2; i++){
    cm = leeSensorUltrasonicoDistancia(puestosU[1][i], puestosU[2][i]);
    if (cm > 35){
      xSemaphoreTake(mutex, portMAX_delay); 
      estado_puestosU[3] = HIGH; 
      estado_puestosU[5] = LOW; 
      xSemaphoreGive(mutex); 
    }
    else if (cm <= 35){
      xSemaphoreTake(mutex, portMAX_delay); 
      estado_puestosU[3] = LOW; 
      estado_puestosU[5] = HIGH; 
      xSemaphoreGive(mutex); 
    }
    digitalWrite(puestosU[3][i], estado_puestosU[3]);
    digitalWrite(puestosU[5][i], estado_puestosU[5]);
  }
   
  for (int i=0;i<1;i++){
    lectura = digitalRead(puestosI[1][i]);
    if(lectura == LOW){
      xSemaphoreTake(mutex, portMAX_delay); 
      estado_puestosI[2] = HIGH; 
      estado_puestosI[4] = LOW;
      xSemaphoreGive(mutex);
    } 
    else{
      xSemaphoreTake(mutex, portMAX_delay);
      estado_puestosI[2] = LOW; 
      estado_puestosI[4] = HIGH;
      xSemaphoreGive(mutex);
    }
    digitalWrite(puestosI[2][i], estado_puestosI[2]);
    digitalWrite(puestosI[4][i], estado_puestosI[4]);
    delay(10000);
  }
}

void loop2(void* param){
  while(true){
    for (int i=0; i<2; i++){
      HTTPClient http;

      xSemaphoreTake(mutex, portMAX_delay);
      if(estado_puestosU[3] && !estado_puestosU[5]){
        http.begin(sensoresUlibre[i]);
      }
      else if(!estado_puestosU[3] && estado_puestosU[5]){
        http.begin(sensoresUocupado[i]);
      }
      xSemaphoreGive(mutex);

      int httpCode = http.GET();
      String respuesta = http.getString();

      if (respuesta.indexOf("SI") > 0){
        digitalWrite(puestosU[4][i], HIGH); 
      }
      else{
        digitalWrite(puestosU[4][i], LOW); 
      }

      http.end();
    }
   
    for (int i=0; i<1; i++){
      HTTPClient http;
      
      xSemaphoreTake(mutex, portMAX_delay);
      if(estado_puestosI[i]){
        http.begin(sensoresIlibre[i]);
      }
      else{
        http.begin(sensoresIocupado[i]);
      }
      xSemaphoreGive(mutex);

      int httpCode = http.GET();
      String respuesta = http.getString();

      if (respuesta.indexOf("SI") > 0){
        digitalWrite(puestosI[3][i], HIGH); 
      }
      else{
        digitalWrite(puestosI[3][i], LOW); 
      }
      
      http.end();
    }
    vTaskDelay(10000);
  }
}