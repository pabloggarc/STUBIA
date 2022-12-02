//Ficheros de configuracion
#include "constantes.h"
#include "config.h"

//Librerias usadas
#include <WiFi.h>
#include <HTTPClient.h>
#include <freertos/FreeRTOS.h>
#include <freertos/task.h>
#include <freertos/semphr.h>

//Concurrencia
TaskHandle_t comunicar_servidor = NULL; 
xSemaphoreHandle mutex = NULL;

//Hardware
estado_semaforo estado_semaforos[3] = {{LOW, LOW, LOW}, {LOW, LOW, LOW}, {LOW, LOW, LOW}}; 
semaforo semaforos[3] = {{18, 19, 21, &estado_semaforos[0]}, {12, 13, 14, &estado_semaforos[1]}, {15, 16, 17, &estado_semaforos[2]}}; 
puesto_fijo puestos_fijos[1] = {{AULA_TEORIA, 3, 35, &semaforos[0]}}; 
puesto_movible puestos_movibles[2] = {{AULA_LABORATORIO, 1, 23, 22, &semaforos[1]}, {AULA_LABORATORIO, 2, 25, 26, &semaforos[2]}}; 

int size_fijos = sizeof(puestos_fijos)/sizeof(puesto_fijo); 
int size_movibles = sizeof(puestos_movibles)/sizeof(puesto_movible); 

//Funciones
void setup_wifi(){
  WiFi.begin(WIFI_NAME, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Contectandose a la red");
  }

  Serial.println("Conectado con éxito a la red"); 
}

void setup_pines(puesto_fijo* puestos_teoria, puesto_movible* puestos_lab){
  for(int i = 0; i<size_fijos; i++){
    pinMode(puestos_teoria[i].pin_sensor, INPUT); 
    pinMode(puestos_teoria[i].sem->led_rojo, OUTPUT); 
    pinMode(puestos_teoria[i].sem->led_amarillo, OUTPUT); 
    pinMode(puestos_teoria[i].sem->led_verde, OUTPUT); 
  }

  for(int i = 0; i<size_movibles; i++){
    pinMode(puestos_lab[i].pin_trigger, OUTPUT); 
    pinMode(puestos_lab[i].pin_echo, INPUT); 
    pinMode(puestos_lab[i].sem->led_rojo, OUTPUT);
    pinMode(puestos_lab[i].sem->led_amarillo, OUTPUT); 
    pinMode(puestos_lab[i].sem->led_verde, OUTPUT); 
  }
}

long lectura_ultrasonidos(int triggerPin, int echoPin){
  digitalWrite(triggerPin, LOW);
  delayMicroseconds(2);
  
  digitalWrite(triggerPin, HIGH);
  delayMicroseconds(10);
  
  digitalWrite(triggerPin, LOW);
  
  return (pulseIn(echoPin, HIGH) * 0.01723);
}

void loop2(void* param){

  while(true){
    //Enviar datos y preguntar reserva de los puestos tipo laboratorio
    for(int i = 0; i<size_fijos; i++){
      HTTPClient http; 

      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        if(puestos_fijos[i].sem->estados->estado_led_rojo && !puestos_fijos[i].sem->estados->estado_led_verde){
          String url=String(HTTP); 
          url+=SERVER_IP+String(WS)+String("aula=")+String(puestos_fijos[i].aula)+
          String("&puesto=")+String(puestos_fijos[i].puesto)+String("&estado=1"); 

          http.begin(url); 
        }
        else if(!puestos_fijos[i].sem->estados->estado_led_rojo && puestos_fijos[i].sem->estados->estado_led_verde){
          String url=String(HTTP); 
          url+=SERVER_IP+String(WS)+String("aula=")+String(puestos_fijos[i].aula)+
          String("&puesto=")+String(puestos_fijos[i].puesto)+String("&estado=2"); 

          http.begin(url);
        }
      }
      xSemaphoreGive(mutex); 

      int httpCode = http.GET(); 
      String respuesta = http.getString();

      if(respuesta.indexOf("SI")>0){
        puestos_fijos[i].sem->estados->estado_led_amarillo = HIGH; 
      }
      else{
        puestos_fijos[i].sem->estados->estado_led_amarillo = LOW;
      }
      http.end(); 
      digitalWrite(puestos_fijos[i].sem->led_amarillo, puestos_fijos[i].sem->estados->estado_led_amarillo); 
    }

    //Enviar datos y preguntar reserva de los puestos tipo fijo
    for(int i = 0; i<size_movibles; i++){
      HTTPClient http; 

      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        if(puestos_movibles[i].sem->estados->estado_led_rojo && !puestos_movibles[i].sem->estados->estado_led_verde){
          String url=String(HTTP); 
          url+=SERVER_IP+String(WS)+String("aula=")+String(puestos_movibles[i].laboratorio)+
          String("&puesto=")+String(puestos_movibles[i].puesto)+String("&estado=1"); 

          http.begin(url); 
        }
        else if(!puestos_movibles[i].sem->estados->estado_led_rojo && puestos_movibles[i].sem->estados->estado_led_verde){
          String url=String(HTTP); 
          url+=SERVER_IP+String(WS)+String("aula=")+String(puestos_movibles[i].laboratorio)+
          String("&puesto=")+String(puestos_movibles[i].puesto)+String("&estado=2"); 

          http.begin(url);
        }
      }
      xSemaphoreGive(mutex); 

      int httpCode = http.GET(); 
      String respuesta = http.getString(); 

      if(respuesta.indexOf("SI")>0){
        puestos_movibles[i].sem->estados->estado_led_amarillo = HIGH; 
      }
      else{
        puestos_movibles[i].sem->estados->estado_led_amarillo = LOW;
      }
      http.end(); 
      digitalWrite(puestos_movibles[i].sem->led_amarillo, puestos_movibles[i].sem->estados->estado_led_amarillo); 
    }
    vTaskDelay(WAIT_SERVER_CORE);
  }
}

void setup() {
  //Iniciamos terminal
  Serial.begin(115200);
  //Iniciamos mutex
  while(!mutex){
    mutex = xSemaphoreCreateMutex(); 
  }

  //Iniciamos wifi
  setup_wifi(); 

  //Iniciamos pines
  setup_pines(puestos_fijos, puestos_movibles); 

  //Iniciamos tarea secundaria
  xTaskCreate(loop2, "loop2", configMINIMAL_STACK_SIZE * 20, NULL, 1, NULL); 
}

void loop() { 
  //Leemos y actualizamos estados de los sensores tipo aula fija
  for(int i = 0; i<size_fijos; i++){
    bool inclinado = digitalRead(puestos_fijos[i].pin_sensor);
    if(!inclinado){
      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        puestos_fijos[i].sem->estados->estado_led_verde = LOW; 
        puestos_fijos[i].sem->estados->estado_led_rojo = HIGH; 
      }
      xSemaphoreGive(mutex); 
    }
    else{
      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        puestos_fijos[i].sem->estados->estado_led_verde = HIGH; 
        puestos_fijos[i].sem->estados->estado_led_rojo = LOW; 
      }
      xSemaphoreGive(mutex); 
    }
    digitalWrite(puestos_fijos[i].sem->led_rojo, puestos_fijos[i].sem->estados->estado_led_rojo); 
    digitalWrite(puestos_fijos[i].sem->led_verde, puestos_fijos[i].sem->estados->estado_led_verde); 
  }

  //Leemos y actualizamos estados de los sensores tipo laboratorio
  for(int i = 0; i<size_movibles; i++){
    int dist = lectura_ultrasonidos(puestos_movibles[i].pin_trigger, puestos_movibles[i].pin_echo); 
    if(dist > 35){
      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        puestos_movibles[i].sem->estados->estado_led_verde = HIGH; 
        puestos_movibles[i].sem->estados->estado_led_rojo = LOW; 
      }
      xSemaphoreGive(mutex); 
    }
    else if(dist <= 35){
      if(xSemaphoreTake(mutex, portMAX_delay) == pdTRUE){
        puestos_movibles[i].sem->estados->estado_led_verde = LOW; 
        puestos_movibles[i].sem->estados->estado_led_rojo = HIGH; 
      }
      xSemaphoreGive(mutex); 
    }
    digitalWrite(puestos_movibles[i].sem->led_rojo, puestos_movibles[i].sem->estados->estado_led_rojo); 
    digitalWrite(puestos_movibles[i].sem->led_verde, puestos_movibles[i].sem->estados->estado_led_verde); 
  }
  delay(WAIT_SENSOR_CORE); 
}