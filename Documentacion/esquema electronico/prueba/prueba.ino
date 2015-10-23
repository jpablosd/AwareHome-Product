
#include <dht.h>

#define dht_dpin A0
dht DHT;
const int buttonPin = 2;
int temperatura = 0;
int humedad = 0;
int gas = 0;
int buttonState = 0;

void setup() {
  // put your setup code here, to run once:
  pinMode(buttonPin, INPUT);     
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
  DHT.read11(dht_dpin);
  temperatura = DHT.temperature;
  Serial.print(temperatura);
  Serial.println(" T");
  humedad = DHT.humidity;
  Serial.print(humedad);
  Serial.println(" H");

  gas = analogRead(1); //imprime el valor de gas de 20ppm a 3000ppm (partes por millon de gas
  Serial.print(gas);
  Serial.println(" G");

  buttonState = digitalRead(buttonPin);
  Serial.print(buttonState);
  Serial.println(" M");

  delay(1000);
}
