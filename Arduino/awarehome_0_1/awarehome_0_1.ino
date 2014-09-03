#include <SPI.h>
#include <Ethernet.h>
#include <dht.h>

#define dht_dpin A2

dht DHT;

byte mac[] = {  0x90, 0xA2, 0xDA, 0x0D, 0x4E, 0xD7 }; // MAC de la tarjeta ethernet shield
byte server[] = { 190,153,212,77 }; // Direccion ip del servidor



EthernetClient client;
float temperatura;
float humedad;

void setup()
{
  Serial.begin(9600);
  
  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Error al conectar Ethernet usando DHCP");
  }
  Serial.print("Direccion IP: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print("."); 
}
  Serial.println();
  delay(1000); // espera 1 segundo despues de inicializar
}

void loop()
{
  DHT.read11(dht_dpin);
  temperatura = DHT.temperature;
  humedad = DHT.humidity;
  Serial.println("Conectando...");
  if (client.connect(server,80)>0) {  // Se conecta al servidor    
    Serial.println("Conexion exitosa");
  }
  else
  {
    Serial.println("Falla en la conexion");
  }
  if (client.connected()) {
    Serial.println("Enviando Datos al Servidor");
    
    client.print("GET /awarehome/arduino/Arduino.php?id_usuario=1");
    client.print("&nombre_sensor=TyH");
    client.print("&temperatura=");
    client.print(temperatura);
    client.print("&humedad=");
    client.print(humedad);
  
    //Serial.print(temperatura);
    //Serial.print(humedad);
  
    client.println(" HTTP/1.0");
    client.println("User-Agent: Arduino 1.0");
    client.println();
  }
  else {
    Serial.println("Desconectado");
  }
  client.stop();
  client.flush();
  delay(5000); // espera 10 segundos antes de volver a sensar la temperatura
}
