#include <Arduino.h>

// Wifi
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
// Buat object Wifi
ESP8266WiFiMulti WiFiMulti;
// Buat object http
HTTPClient http; // buat koneksi ke internet
#define USE_SERIAL Serial

String statusAlat = "http://192.168.87.7/sistem-parkir/alat/status?ket=1";
String scan = "http://192.168.87.7/sistem-parkir/alat/scan?noKartu=";
String registrasi = "http://192.168.87.7/sistem-parkir/alat/registrasi?noKartu=";
String getQueue = "http://192.168.87.7/sistem-parkir/alat/getQueue?queue_id=";

// RFID
// SDA > D4/SDA
// SCK > D5/SCK
// MOSI> D7/MOSI
// MISO> D6/MISO
// IRQ> (kosong)
// RST> D3
// GND>GND
// 3.3V>Power nodemcu 8266 // pin rfid ke nodemcu
#include <SPI.h>
#include <MFRC522.h>
#define SS_PIN D4
#define RST_PIN D3 // library buat sensor rfid

MFRC522 mfrc522(SS_PIN, RST_PIN);   // deklarasi RFID

// lcd
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);

// SDA ---------------> D2
// SCL ---------------> D1
// VCC ---------------> VV
// GND ---------------> GND

String no = "", noKartu = "", responRegistrasi = "", responStatus = "", responScan = "", responKode = "", responKet = "", queue_id = "", responQueue = "";

// buzzer
#define buzzer D1

void setup() {
  Serial.begin(115200);   //Komunikasi baud rate
  
  USE_SERIAL.begin(115200);
  USE_SERIAL.setDebugOutput(false);

  lcd.begin(16,2);
  lcd.init();
  lcd.backlight();

  for (uint8_t t = 4; t > 0; t--) {
    USE_SERIAL.printf("[SETUP] Tunggu %d...\n", t);
    USE_SERIAL.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("Redmi", "12345678"); // Sesuaikan SSID dan password ini

  for (int u = 1; u <= 5; u++)
  {
    if ((WiFiMulti.run() == WL_CONNECTED))
    {
      USE_SERIAL.println("Internet Connected"); // serial monitor
      USE_SERIAL.flush();

      lcd.setCursor(6, 0);
      lcd.print("WiFi");
      lcd.setCursor(2, 1);
      lcd.print("CONNECTED!!!");
      
      delay(1000);
    }
    else
    {
      Serial.println("No Internet Connected");

      lcd.setCursor(6, 0);
      lcd.print("WiFi");
      lcd.setCursor(0, 1);
      lcd.print("NOT CONNECTED");
      
      delay(1000);
    }
  }

  lcd.clear();
  
  lcd.setCursor(4, 0);
  lcd.print("KOTAK AMAL");
  lcd.setCursor(0, 1);
  lcd.print("KEAMANAN 2 LAPIS");

  pinMode(buzzer, OUTPUT);
  digitalWrite(buzzer, LOW);

  SPI.begin(); //
  mfrc522.PCD_Init();

  delay(1000);
  lcd.clear();
}

void loop() {
  cekStatus(); // ada dibaris 193

  Serial.println("");
  Serial.println("Status alat : " + responStatus);
  Serial.println("Tempelkan Kartu");
  Serial.println("");

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("STATUS : " + responStatus);
  lcd.setCursor(0, 1);
  lcd.print("TEMPELKAN KARTU");

  responQueue = "";
  cekQueue("0", "masuk"); 

  while (responQueue == "Menunggu") {
    cekQueue("0", "masuk");
    delay(1000);
  }

  delay(100);

  if ( ! mfrc522.PICC_IsNewCardPresent())
  {
    return;
  }
  if ( ! mfrc522.PICC_ReadCardSerial())
  {
    return;
  }

  //Menampilkan UID TAG Di Serial Monitor
  Serial.print("NO Kartu :");
  String content = "";
  byte letter; // untuk menyimpan nomer
  for (byte i = 0; i < mfrc522.uid.size; i++)
  {
    Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
    Serial.print(mfrc522.uid.uidByte[i], HEX);
    content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
    content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }

  Serial.println();
  no = content.substring(1);
  noKartu = content.substring(1);

  noKartu.replace(" ", "%20");

  noKartu.toUpperCase();
  no.toUpperCase();

  delay(300);

  if (responStatus == "REGISTRASI")
  {
    handleRegistrasi();
  }
  else if (responStatus == "SCAN")
  {
    handleScan();
  }

  Serial.println();
}

void cekStatus()
{
  if ((WiFiMulti.run() == WL_CONNECTED)) // mengecek wifi
  {
    http.begin( statusAlat ); // mengambil data

    int httpCode = http.GET();

    if (httpCode > 0) // sama dengan 200 maka respon
    {
      if (httpCode == HTTP_CODE_OK)
      {
        responStatus = http.getString(); // menuju website
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }
}

void handleRegistrasi()
{
  if ((WiFiMulti.run() == WL_CONNECTED))
  {
    USE_SERIAL.print("[HTTP] Memulai...\n");

    http.begin( registrasi + (String) noKartu ); //

    USE_SERIAL.print("[HTTP] Registrasikan ke database ...\n");
    int httpCode = http.GET();

    if (httpCode > 0)
    {
      USE_SERIAL.printf("[HTTP] kode response GET : %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK)
      {
        responRegistrasi = http.getString();
        delay(200);
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }

  lcd.clear();
  
  if (responRegistrasi == "SUKSES")
  {
    USE_SERIAL.print("Respon : ");
    USE_SERIAL.print(responRegistrasi);
    USE_SERIAL.println(", Kartu berhasil ditambahkan");

    lcd.setCursor(0, 0);
    lcd.print("SUKSES");
    lcd.setCursor(0, 1);
    lcd.print("REGISTRASI");

    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
    delay(100);
    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
    delay(100);
    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
  }
  else
  {
    USE_SERIAL.print("Respon : ");
    USE_SERIAL.print(responRegistrasi);
    USE_SERIAL.println(", kartu sudah terdaftar");

    lcd.setCursor(0, 0);
    lcd.print("SUDAH REGISTRASI");

    digitalWrite(buzzer, HIGH);
    delay(1000);
    digitalWrite(buzzer, LOW);
    delay(200);
    digitalWrite(buzzer, HIGH);
    delay(1000);
    digitalWrite(buzzer, LOW);
    delay(200);
    digitalWrite(buzzer, HIGH);
    delay(1000);
    digitalWrite(buzzer, LOW);
  }

  delay(2000);
}

void handleScan() {
  if ((WiFiMulti.run() == WL_CONNECTED))
  {
    USE_SERIAL.print("[HTTP] Memulai...\n");
    
    http.begin( scan + (String) noKartu + "&act=masuk" );
    
    USE_SERIAL.print("[HTTP] Cek user ke database ...\n");
    int httpCode = http.GET();

    if(httpCode > 0)
    {
      USE_SERIAL.printf("[HTTP] kode response GET : %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK)
      {
        responScan = http.getString();  
        delay(100);
        
        responKode = getValue(responScan, '#', 0);
        responKet = getValue(responScan, '#', 1);
        queue_id = getValue(responScan, '#', 2);

        Serial.println("Respon Kode : " + responKode);
        Serial.println("Keterangan : " + responKet);
        delay(100);
        
        if (responKode == "SUKSES") {
          responQueue = "";
          cekQueue(queue_id, "0"); 

          while (responQueue == "Menunggu") {
            cekQueue(queue_id, "0");
            delay(1000);
          }
        }   
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }

  lcd.clear();
  
  if (responKode == "GAGAL")
  {
    Serial.println(responKode + ", " + no + " " + responKet);

    lcd.setCursor(0, 0);
    lcd.print(responKode);
    lcd.setCursor(0, 1);
    lcd.print(responKet);

    digitalWrite(buzzer, HIGH);
    delay(1500);
    digitalWrite(buzzer, LOW);
    delay(200);
    digitalWrite(buzzer, HIGH);
    delay(1500);
    digitalWrite(buzzer, LOW);
    delay(200);
    digitalWrite(buzzer, HIGH);
    delay(1500);
    digitalWrite(buzzer, LOW);
  }
  else if (responKode == "SUKSES")
  {
    Serial.println(responKode + ", " + responKet);

    lcd.setCursor(0, 0);
    lcd.print(responKode);
    lcd.setCursor(0, 1);
    lcd.print(responKet);

    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
    delay(100);
    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
    delay(100);
    digitalWrite(buzzer, HIGH);
    delay(200);
    digitalWrite(buzzer, LOW);
  }
  
  delay(1000);
}

void cekQueue(String queueId, String act) {
  if ((WiFiMulti.run() == WL_CONNECTED))
  {
    USE_SERIAL.print("[HTTP] Memulai...\n");
    
    http.begin( getQueue + (String) queueId + "&act=" +  act);
    
    USE_SERIAL.print("[HTTP] Cek queue ke database ...\n");
    int httpCode = http.GET();

    if(httpCode > 0)
    {
      USE_SERIAL.printf("[HTTP] kode response GET : %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK)
      {
        responQueue = http.getString();

        Serial.println("Respon Queue : " + responQueue);
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }

  delay(500);
}

String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = {0, -1};
  int maxIndex = data.length()-1;
 
  for(int i=0; i <= maxIndex && found <= index; i++){
    if(data.charAt(i) == separator || i == maxIndex){
        found++;
        strIndex[0] = strIndex[1]+1;
        strIndex[1] = (i == maxIndex) ? i+1 : i;
    }
  } 
 
  return found>index ? data.substring(strIndex[0], strIndex[1]) : "";
}
