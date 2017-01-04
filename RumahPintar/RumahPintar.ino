//ARDUINO 1.0+ ONLY
//ARDUINO 1.0+ ONLY
#include <Ethernet.h>
#include <SPI.h>
#include <Servo.h>

boolean reading = false;
Servo myservo;

////////////////////////////////////////////////////////////////////////
//CONFIGURE
////////////////////////////////////////////////////////////////////////
  byte ip[] = { 192, 168, 137, 3 };   //Manual setup only
  byte gateway[] = { 192, 168, 1, 1 }; //Manual setup only
  byte subnet[] = { 255, 255, 255, 0 }; //Manual setup only

  // if need to change the MAC address (Very Rare)
  byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };

  EthernetServer server = EthernetServer(80); //port 80
  //EthernetClient client;
  unsigned long lastConnectionTime = 0;          // last time you connected to the server, in milliseconds
  boolean lastConnected = false;                 // state of the connection last time through the main loop
  const unsigned long postingInterval = 60*1000;  // delay between updates, in milliseconds
////////////////////////////////////////////////////////////////////////

int ledPin[] = {2,3,4,5,8,7};//output pin 2 = lampu 5 watt, pin 3 = kipas, pin 5,4 = hbridge, pin 8 = led, pin 7 = servo
int switchPin[] = {9,16,17,18,19};//input
int switchState[] = {LOW,LOW,LOW,LOW,LOW};
int ledState[] = {LOW,HIGH,LOW,LOW,LOW};
String derajat = String(100);
int readswitch,previous,state;           // the current reading from the input pin
boolean tiraiBuka= true;
boolean lampuNyala= false;
boolean lampu5wattNyala= false;
boolean pintuBuka= false;
boolean kipasNyala = false;

// the follow variables are long's because the time, measured in miliseconds,
// will quickly become a bigger number than can be stored in an int.
long time = 0;         // the last time the output pin was toggled
long debounce = 500;   // the debounce time, increase if the output flickers
long waktujalan = 0;
boolean lagijalan = false;


void setup(){
  Serial.begin(9600);
  myservo.attach(7);
  for (int thisPin = 0; thisPin < 5; thisPin++)  {
    pinMode(ledPin[thisPin],OUTPUT);
    digitalWrite(ledPin[thisPin], ledState[thisPin]);
  }
  
  for (int thisPin = 0; thisPin < 5; thisPin++)  {
    pinMode(switchPin[thisPin],INPUT);
  }

 //Ethernet.begin(mac);
  //Ethernet.begin(mac, ip, gateway, subnet); //for manual setup
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip);
  }

  server.begin();
  Serial.println(Ethernet.localIP());
  httpRequest("ip",DisplayAddress(Ethernet.localIP()));
}

void cekjalan() {
  if (waktujalan < millis()) {
    digitalWrite(ledPin[2], HIGH);
    digitalWrite(ledPin[3], HIGH);
    lagijalan = false;
  }
}


String DisplayAddress(IPAddress address) {
 return String(address[0]) + "." + 
        String(address[1]) + "." + 
        String(address[2]) + "." + 
        String(address[3]);
}

void loop(){
  // listen for incoming clients, and process qequest.
  checkForClient();
  checkForButton();
  if (lagijalan) cekjalan();
}


void checkForClient(){

  EthernetClient client = server.available();
  //client = server.available();

  if (client) {

    // an http request ends with a blank line
    boolean currentLineIsBlank = true;
    boolean sentHeader = false;

    while (client.connected()) {
      if (client.available()) {

        if(!sentHeader){
          // send a standard http response header
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println("Connection: close");
          client.println();
          client.println("OK");
          sentHeader = true;
        }

        char c = client.read();

        if(reading && c == ' ') {
          reading = false;
        }
        if(c == '?') reading = true; //found the ?, begin reading the info

        if(reading){
          Serial.print(c);
          
           switch (c) {
            case 'a':
              turnOffLed();
              //ledState[0] = LOW;
              break;
            case 'A':
              turnOnLed();
              //ledState[0] = HIGH;
              break;
            case 'b':
              TutupTirai();
              //ledState[0] = LOW;
              break;
            case 'B':
              BukaTirai();
              //ledState[0] = HIGH;
              break;
            case 'c':
              tutupPintu();
              break;
            case 'C':
              bukaPintu();
              break;
            case 'd':
              turnOffFan();
              //ledState[0] = LOW;
              break;
            case 'D':
              turnOnFan();
              //ledState[0] = HIGH;
              break;
            case 'e':
              turnOffLed5watt();
              //ledState[0] = LOW;
              break;
            case 'E':
              turnOnLed5watt();
              //ledState[0] = HIGH;
              break;
          }
        }

        if (c == '\n' && currentLineIsBlank)  break;

        if (c == '\n') {
          currentLineIsBlank = true;
          reading = false;
        }else if (c != '\r') {
          currentLineIsBlank = false;
        }
        

      }
    }

    delay(1); // give the web browser time to receive the data
    client.stop(); // close the connection:

  }

}



void checkForButton(){
  for (int xIndex = 0; xIndex < 5; xIndex++)  {
    readswitch = digitalRead(switchPin[xIndex]);
    previous = switchState[xIndex];
    switchState[xIndex] = readswitch;

    if (readswitch == HIGH && previous == LOW && millis() - time > debounce) {
      switch (xIndex){
        
        case 0 : cekLampu();break;
        case 1 : cekTirai();break;
        case 2 : cekPintu();break;
        case 3 : cekKipas();break;
        case 4 : cekLed();break;
      }

      time = millis();
Serial.print("to");
Serial.print(xIndex);
    }

  
  }
  
}

void cekPintu(){
  if (pintuBuka==true){
    tutupPintu();}
    else { 
      bukaPintu();}
    Serial.print("\r\ncekpintu");
}

void bukaPintu() {
  myservo.write(100);       
pintuBuka = true;
delay(25);  
}
void tutupPintu() {
  myservo.write(10);      
pintuBuka = false;
delay(25);  
}

void cekLampu(){
      if (lampu5wattNyala==false) turnOnLed5watt();
      else turnOffLed5watt();
Serial.print("\r\nceklampu");
}

void cekLed(){
      if (lampuNyala==false) turnOnLed();
      else turnOffLed();
Serial.print("\r\ncekled");
}

void cekKipas(){
      if (kipasNyala==false) turnOnFan();
      else turnOffFan();
Serial.print("\r\ncekkipas");
}

void cekTirai(){
  if (tiraiBuka==true){
    TutupTirai();}
    else { 
      BukaTirai();}
Serial.print("\r\ncektirai");

}

void BukaTirai() {
     digitalWrite(ledPin[2], HIGH);
      digitalWrite(ledPin[3], LOW);
      tiraiBuka=true;
      waktujalan = millis() + 1400;
      lagijalan = true;
}
void TutupTirai() {
    digitalWrite(ledPin[2], LOW);
    digitalWrite(ledPin[3], HIGH);
    tiraiBuka=false;
    waktujalan = millis() + 1400;
    lagijalan = true;
}

void turnOnLed5watt() {
  digitalWrite(ledPin[0], LOW);
  lampu5wattNyala = true;

}
void turnOffLed5watt() {
  digitalWrite(ledPin[0], HIGH);
  lampu5wattNyala = false;
}

void turnOnLed() {
  digitalWrite(ledPin[4], LOW);
  lampuNyala = true;

}
void turnOffLed() {
  digitalWrite(ledPin[4], HIGH);
  lampuNyala = false;
}

void turnOnFan() {
  digitalWrite(ledPin[1], LOW);
  kipasNyala = true;

}
void turnOffFan() {
  digitalWrite(ledPin[1], HIGH);
  kipasNyala = false;
}

boolean httpRequest(String dName, String dValue) {
  //byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
  char hostname[] = "192.168.137.1";
  String host = hostname;
  //IPAddress ip(192,168,1,103);
  EthernetClient client = server.available();
  // start the Ethernet connection:
  //if (Ethernet.begin(mac) == 0) {
  //  Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    // try to congifure using IP address instead of DHCP:
  //  Ethernet.begin(mac, ip);
  //}
  // give the Ethernet shield a second to initialize:
  //delay(1000);
  Serial.println("connecting...");

  // if you get a connection, report back via serial:
  if (client.connect(hostname, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    client.println("GET /callback.php?" + dName + "=" + dValue + " HTTP/1.1");
    client.println("Host: " + host);
	Serial.println("Host: " + host);
    client.println("Connection: close");
    client.println();
    delay(1);
    //client.stop(); // close the connection:
    return true;
  } 
  else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
    delay(1);
    //client.stop(); // close the connection:
    return false;
  }
  //Serial.println(Ethernet.localIP());
}
