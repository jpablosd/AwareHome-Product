#include <SPI.h>
#include <Ethernet.h>
#include <dht.h>

#define dht_dpin A2

dht DHT;

byte mac[] = {  0x90, 0xA2, 0xDA, 0x0D, 0x4E, 0xD7 }; // MAC de la tarjeta ethernet shield
byte ip[] = { 192,168,1,200 }; // Direccion ip local
byte server[] = { 190,153,212,77 }; // Direccion ip del servidor

EthernetClient client;
float temperatura;
float humedad;

void setup()
{
  Serial.begin(9600);
  Ethernet.begin(mac, ip); // inicializa ethernet shield
  delay(1000); // espera 1 segundo despues de inicializar
}

void loop()
{
  DHT.read11(dht_dpin);
  temperatura = DHT.temperature;
  humedad = DHT.humidity;
  Serial.println("Conectando...");

  if (client.connect(server,80)>0) {  // Se conecta al servidor    
    
    /**
    Mandar: 
    HABITACION_ID_HABITACION
    NOMBRE_SENSOR
    TEMPERATURA
    HUMEDAD
    FECHA
    */
    client.print("GET /JP/awarehome/arduino/arduino.php?id_habitacion=1"); // Envia los datos utilizando GET
    client.print("&nombre_sensor=TyH");
    client.print("&temperatura=");
    client.print(temperatura);
    client.print("&humedad=");
    client.print(humedad);
  
    client.println(" HTTP/1.0");
    client.println("User-Agent: Arduino 1.0");
    client.println();
    Serial.println("Conexion exitosa");
  }
  else
  {
    Serial.println("Falla en la conexion");
  }
  if (client.connected()) {}
  else {
    Serial.println("Desconectado");
  }
  client.stop();
  client.flush();
  delay(5000); // espera 1 segundo antes de volver a sensar la temperatura
}
