#include <SPI.h>
#include <Ethernet.h>
#include <dht.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

#define dht_dpin A0
 /*
 En arduino mega se conecta como dice en la pantalla, vcc, gnd, sda y scl
 En arduino uno se conecta vcc y gnd normal, luego para la coneccion 
 SDA se conecta en el pin A4
 SCL se conecta en el pin A5
 */
 
dht DHT;
LiquidCrystal_I2C lcd(0x27,16,2); // 0x27 es la direccion del LCD 16x2

byte mac[] = {  0x90, 0xA2, 0xDA, 0x0D, 0x4E, 0xD7 }; // MAC de la tarjeta ethernet shield
byte server[] = { 192,168,1,158 }; // Direccion ip del servidor
                 //190.107.177.241

EthernetClient client;
int temperatura = 0;
int humedad = 0;
int gas = 0;


void setup()
{
  lcd.init(); 
  lcd.backlight(); //enciende la iluminacion
  lcd.setCursor(0, 0);
  lcd.print("Iniciando.");
  delay(1000);
  lcd.clear();
  lcd.print("Iniciando..");
  delay(1000);
  lcd.clear();
  lcd.print("Iniciando...");
  delay(1000);
  lcd.clear();
  Serial.begin(9600);
  // start the Ethernet connection:
  
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Error al conectar Ethernet usando DHCP");
    lcd.setCursor(0, 0);
    lcd.print("ERROR DHCP");
    delay(1000);
    lcd.clear();
  }
  Serial.print("Direccion IP: ");
  lcd.setCursor(0, 0);
  lcd.print("IP:");
  lcd.setCursor(0, 1);
  
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    lcd.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print("."); 
    lcd.print("."); 
  }
  Serial.println();
  delay(1000); // espera 1 segundo despues de inicializar
  lcd.clear();
}

void loop()
{
  DHT.read11(dht_dpin);
  temperatura = DHT.temperature;
  humedad = DHT.humidity;
  gas = analogRead(1); //imprime el valor de gas de 20ppm a 3000ppm (partes por millon de gas

  
  Serial.print("temperatura: ");
  Serial.println(temperatura);
  Serial.print("humedad: ");
  Serial.println(humedad);
  Serial.print("gas: ");
  Serial.println(gas);
  
  Serial.println("Conectando...");
  
  if (client.connect(server,80)>0) 
  {  // Se conecta al servidor    
    Serial.println("Conexion exitosa");
  }
  else
  {
    Serial.println("Falla en la conexion");
  }
  if (client.connected()) {
    Serial.println("Enviando Datos al Servidor");
    Serial.println("");
    
    client.print("GET /awarehome/arduino/Arduino.php?id_usuario=1");
    client.print("&temperatura=");
    client.print(temperatura);
    client.print("&humedad=");
    client.print(humedad);
    client.print("&gas=");
    client.print(gas);
  
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
  
  //imprime por pantalla
  lcd.setCursor(0, 0);
  lcd.print("T:");
  lcd.print(temperatura);
  lcd.print(" C   ");
  lcd.print("H: ");
  lcd.print(humedad);
  lcd.print("%   ");
  lcd.setCursor(0,1);
  lcd.print("Gas: ");
  lcd.print(gas);
  lcd.print("PPM");
 
  delay(5000);
  
  //delay(5000); // espera 5 segundos antes de volver a sensar la temperatura
}
