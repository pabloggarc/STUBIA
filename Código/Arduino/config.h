//Tareas
#define portMAX_delay (TickType_t)0xffffffffUL
#define WAIT_SENSOR_CORE 1000
#define WAIT_SERVER_CORE 10000

//Hardware
struct estado_semaforo{
  int estado_led_rojo; 
  int estado_led_amarillo; 
  int estado_led_verde; 
};

struct semaforo{
  int led_rojo; 
  int led_amarillo; 
  int led_verde;
  estado_semaforo* estados; 
};

struct puesto_fijo{
  int aula; 
  int puesto; 
  int pin_sensor; 
  semaforo* sem; 
};

struct puesto_movible{
  int laboratorio; 
  int puesto; 
  int pin_trigger; 
  int pin_echo; 
  semaforo* sem; 
};