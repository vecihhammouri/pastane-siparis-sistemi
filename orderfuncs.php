<?php
session_start();
$_SESSION["pastagonderim"] = "henüz belli değil";


function pastaSend()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  //İNPUTLARI ÇEKEBİLMEK İÇİN ÖNCE PASTA IDLERİNİ ÇEKMEMİZ LAZIM ÇÜNKÜ INPUTLARIN ADININ İÇİNDE PASTA tablosunun ID si VAR.


  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $vr = "";
  $sql = "SELECT id FROM pasta ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $vr .= "(";

      for ($i = 0; $i < 4; $i++) {    //ID VE PASTABOYLARI INPUTLARI SIRAYLA ÇEKİLİYOR
        $postname = $row["id"];
        $postname = $postname . "_pastaboy" . $i;
        $pastaArray[$row["id"]][$i] = $_POST[$postname];
        if ($pastaArray[$row["id"]][$i] == "") {
          $pastaArray[$row["id"]][$i] = 0;
        }
        $vr .= "'" . $pastaArray[$row["id"]][$i] . "'" . ",";

        //echo "   ";
      }
      $vr .= "'" . $tarih . "',";
      $vr .= "'" . getUserID() . "',";
      $vr .= "'" . "$row[id]" . "'";
      $vr .= "),";
      $vr .= "\n";
    }

    $vr = substr($vr, 0, -2);

    $sql = "INSERT INTO pasta_siparis (boy0,boy1,boy2,boy3,tarih,kullanici_id,pasta_id) VALUES" . $vr;
    //echo $sql;
    if (checkalreadydate(1)) {
      echo "Bugün Pasta [0][1][2][3] için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->query($sql) === TRUE) {

        echo "Pasta siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
      }
    }
  } else echo "Bir hata gerçekleşti, lütfen tekrar deneyin";
}

function updatePasta()
{

  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $vr = "";
  $sql = "SELECT * FROM pasta_siparis INNER JOIN pasta ON pasta_siparis.pasta_id = pasta.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $sql = "";
    while ($row = $result->fetch_assoc()) {
      $pasta_name = $row["pasta_adi"];
      for ($i = 0; $i < 4; $i++) {    //ID VE PASTABOYLARI INPUTLARI SIRAYLA ÇEKİLİYOR
        $postname = $row["id"];
        $postname = $postname . "_pastaboy" . $i;
        $pastaArray[$row["id"]][$i] = $_POST[$postname];
        if ($pastaArray[$row["id"]][$i] == "") {
          $pastaArray[$row["id"]][$i] = 0;
        }
        $boy_column = "boy" . $i; //boy_column update edilecek sütun ismi
        $boyvalue = $pastaArray[$row["id"]][$i]; //boyvalue inputtaki değer


        $sql .= "UPDATE pasta_siparis INNER JOIN pasta ON pasta_siparis.pasta_id=pasta.id SET $boy_column = '$boyvalue' WHERE kullanici_id='$uid' and pasta_adi='$pasta_name' and tarih='$tarih';";
      }
    } //echo $sql;
    if ($conn->multi_query($sql) === TRUE) {

      echo "Pasta siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  } else {
    echo "güncellenecek kayıt bulunamadı";
  }
  $conn->close();
}


function updateTekPasta(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM tekpasta_siparis INNER JOIN tekpasta ON tekpasta_siparis.tekpasta_id = tekpasta.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postadet=$_POST[$row["tekpasta_id"]."_tekpasta"]; //echo $row["tekpasta_adi"];echo "<br>";
      if($postadet=="")
      {
        $postadet=0;
      }
      $sql.="UPDATE tekpasta_siparis INNER JOIN tekpasta ON tekpasta_siparis.tekpasta_id=tekpasta.id SET tekpasta_adet='$postadet' WHERE kullanici_id='$uid' and tekpasta_adi='$row[tekpasta_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Tek Pasta (Adet) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Tek Pasta kaydı bulunamadı";
  }
  $conn->close();
}


function updateSutluTatli(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM sutlutatli_siparis INNER JOIN sutlutatli ON sutlutatli_siparis.sutlutatli_id = sutlutatli.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postadet=$_POST[$row["sutlutatli_id"]."_sutlutatli"]; //echo $row["sutlutatli_adi"];echo "<br>";
      if($postadet=="")
      {
        $postadet=0;
      }
      $sql.="UPDATE sutlutatli_siparis INNER JOIN sutlutatli ON sutlutatli_siparis.sutlutatli_id=sutlutatli.id SET sutlutatli_adet='$postadet' WHERE kullanici_id='$uid' and sutlutatli_adi='$row[sutlutatli_adi]' and tarih='$tarih';";
   
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Sütlü Tatlı (Adet) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Sütlü Tatlı kaydı bulunamadı";
  }
  $conn->close();
}


function updatePogaca(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM pogaca_siparis INNER JOIN pogaca ON pogaca_siparis.pogaca_id = pogaca.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postadet=$_POST[$row["pogaca_id"]."_pogaca"]; //echo $row["pogaca_adi"];echo "<br>";
      if($postadet=="")
      {
        $postadet=0;
      }
      $sql.="UPDATE pogaca_siparis INNER JOIN pogaca ON pogaca_siparis.pogaca_id=pogaca.id SET pogaca_adet='$postadet' WHERE kullanici_id='$uid' and pogaca_adi='$row[pogaca_adi]' and tarih='$tarih';";
   
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Poğaça (Adet) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Poğaça kaydı bulunamadı";
  }
  $conn->close();
}


function updateBaklava(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM baklava_siparis INNER JOIN baklava ON baklava_siparis.baklava_id = baklava.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $posttepsi=$_POST[$row["baklava_id"]."_baklava"]; //echo $row["baklava_adi"];echo "<br>";
      if($posttepsi=="")
      {
        $posttepsi=0;
      }
      $sql.="UPDATE baklava_siparis INNER JOIN baklava ON baklava_siparis.baklava_id=baklava.id SET baklava_tepsi='$posttepsi' WHERE kullanici_id='$uid' and baklava_adi='$row[baklava_adi]' and tarih='$tarih';";
   
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Baklava (Tepsi) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Baklava kaydı bulunamadı";
  }
  $conn->close();
}





function tekpastaSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM tekpasta ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postadet = $_POST[$row["id"] . "_tekpasta"]; //tekpasta tablosunun id si _ tekpasta
      if ($postadet == "") {
        $postadet = 0;
      }
      $query .= "INSERT INTO tekpasta_siparis (tekpasta_adet,tekpasta_id,kullanici_id,tarih) VALUES ('$postadet','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(2)) {
      echo "Bugün Tek Pasta (Adet) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Tek Pasta (Adet) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}



function petifurcesitSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM petifurcesit ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_petifurcesit"]; //petifurcesit tablosunun id si _ petifurcesit
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO petifurcesit_siparis (petifurcesit_kg,petifurcesit_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(3)) {
      echo "Bugün Petifür Çeşit (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Petifür Çeşit (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}



function figurlutekSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM figurlutek ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_figurlutek"]; //figurlutek tablosunun id si _ figurlutek
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO figurlutek_siparis (figurlutek_kg,figurlutek_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(4)) {
      echo "Bugün Figürlü Tek (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Figürlü Tek (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}


function sutlutatliSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM sutlutatli ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postadet = $_POST[$row["id"] . "_sutlutatli"]; //sutlutatli tablosunun id si _ sutlutatli
      if ($postadet == "") {
        $postadet = 0;
      }
      $query .= "INSERT INTO sutlutatli_siparis (sutlutatli_adet,sutlutatli_id,kullanici_id,tarih) VALUES ('$postadet','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(5)) {
      echo "Bugün Sütlü Tatlı (Adet) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Sütlü Tatlı (Adet) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}

function adetlerSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM adetler ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postadet = $_POST[$row["id"] . "_adetler"]; //adetler tablosunun id si _ adetler
      if ($postadet == "") {
        $postadet = 0;
      }
      $query .= "INSERT INTO adetler_siparis (adetler_adet,adetler_id,kullanici_id,tarih) VALUES ('$postadet','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(6)) {
      echo "Bugün Adetler için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Adetler siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}
function pogacaSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM pogaca ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postadet = $_POST[$row["id"] . "_pogaca"]; //pogaca tablosunun id si _ pogaca
      if ($postadet == "") {
        $postadet = 0;
      }
      $query .= "INSERT INTO pogaca_siparis (pogaca_adet,pogaca_id,kullanici_id,tarih) VALUES ('$postadet','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(7)) {
      echo "Bugün Poğaça (Adet) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Poğaça (Adet) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}


function dondurmaSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM dondurma ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_dondurma"]; //dondurma tablosunun id si _ dondurma
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO dondurma_siparis (dondurma_kg,dondurma_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(8)) {
      echo "Bugün Dondurma (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Dondurma (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}


function tzkurabiyeSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM tzkurabiye ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_tzkurabiye"]; //tzkurabiye tablosunun id si _ tzkurabiye
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO tzkurabiye_siparis (tzkurabiye_kg,tzkurabiye_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(9)) {
      echo "Bugün Tuzlu Kurabiye (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Tuzlu Kurabiye (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}

function ttkurabiyeSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM ttkurabiye ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_ttkurabiye"]; //ttkurabiye tablosunun id si _ ttkurabiye
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO ttkurabiye_siparis (ttkurabiye_kg,ttkurabiye_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(10)) {
      echo "Bugün Tatlı Kurabiye (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Tatlı Kurabiye (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}
function paketUrunlerSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM paketurunler ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $postkg = $_POST[$row["id"] . "_paketurunler"]; //paketurunler tablosunun id si _ paketurunler
      if ($postkg == "") {
        $postkg = 0;
      }
      $query .= "INSERT INTO paketurunler_siparis (paketurunler_kg,paketurunler_id,kullanici_id,tarih) VALUES ('$postkg','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(11)) {
      echo "Bugün Paket Ürünler (KG) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Paket Ürünler (KG) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}


function baklavaSend()
{ //multiquery ile yapalım
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";
  $uid = getUserID();
  $query = "";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $sql = "SELECT id FROM baklava ORDER BY id ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $posttepsi = $_POST[$row["id"] . "_baklava"]; //baklava tablosunun id si _ baklava
      if ($posttepsi == "") {
        $posttepsi = 0;
      }
      $query .= "INSERT INTO baklava_siparis (baklava_tepsi,baklava_id,kullanici_id,tarih) VALUES ('$posttepsi','$row[id]','$uid','$tarih');";
    }
    $sql = "$query";
    if (checkalreadydate(5)) {
      echo "Bugün Baklava (Tepsi) için zaten sipariş verilmiş. İsterseniz <a href=\"myorders.php\">Siparişler</a> sayfasından siparişinizi güncelleyebilirsiniz.";
      header("Refresh:5; myorders.php");
      exit();
    } else {
      if ($conn->multi_query($sql) === TRUE) {

        echo "Baklava (Tepsi) siparişiniz gönderildi...";
      } else {
        echo "<b>HATA:</b>" . "<br>" . $conn->error;
        echo "<br>";echo $sql; exit();
      }
    }
  }
}




function updatePetifurCesit(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM petifurcesit_siparis INNER JOIN petifurcesit ON petifurcesit_siparis.petifurcesit_id = petifurcesit.id WHERE tarih='$tarih' and kullanici_id=$uid ORDER BY petifurcesit_id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["petifurcesit_id"]."_petifurcesit"]; //echo $row["petifurcesit_id"]."_petifurcesit";echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      //if($postkg!="")
      $sql.="UPDATE petifurcesit_siparis INNER JOIN petifurcesit ON petifurcesit_siparis.petifurcesit_id=petifurcesit.id SET petifurcesit_kg='$postkg' WHERE kullanici_id='$uid' and petifurcesit_adi='$row[petifurcesit_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Petifür Çeşit (kg) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Petifür Çeşit kaydı bulunamadı";
  }
  $conn->close();
  
}

function updateFigurluTek(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM figurlutek_siparis INNER JOIN figurlutek ON figurlutek_siparis.figurlutek_id = figurlutek.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["figurlutek_id"]."_figurlutek"]; //echo $row["figurlutek_adi"];echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      $sql.="UPDATE figurlutek_siparis INNER JOIN figurlutek ON figurlutek_siparis.figurlutek_id=figurlutek.id SET figurlutek_kg='$postkg' WHERE kullanici_id='$uid' and figurlutek_adi='$row[figurlutek_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Figürlü Tek (kg) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Figürlü Tek kaydı bulunamadı";
  }
  $conn->close();
  
}

function updateAdetler(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM adetler_siparis INNER JOIN adetler ON adetler_siparis.adetler_id = adetler.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postadet=$_POST[$row["adetler_id"]."_adetler"]; //echo $row["adetler_adi"];echo "<br>";
      if($postadet=="")
      {
        $postadet=0;
      }
      $sql.="UPDATE adetler_siparis INNER JOIN adetler ON adetler_siparis.adetler_id=adetler.id SET adetler_adet='$postadet' WHERE kullanici_id='$uid' and adetler_adi='$row[adetler_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Adetler siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Adetler kaydı bulunamadı";
  }
  
}


function updateDondurma(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM dondurma_siparis INNER JOIN dondurma ON dondurma_siparis.dondurma_id = dondurma.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["dondurma_id"]."_dondurma"]; //echo $row["dondurma_adi"];echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      $sql.="UPDATE dondurma_siparis INNER JOIN dondurma ON dondurma_siparis.dondurma_id=dondurma.id SET dondurma_kg='$postkg' WHERE kullanici_id='$uid' and dondurma_adi='$row[dondurma_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Dondurma (kg) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Dondurma kaydı bulunamadı";
  }
  $conn->close();
  
}


function updateTzKurabiye(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM tzkurabiye_siparis INNER JOIN tzkurabiye ON tzkurabiye_siparis.tzkurabiye_id = tzkurabiye.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["tzkurabiye_id"]."_tzkurabiye"]; //echo $row["tzkurabiye_adi"];echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      $sql.="UPDATE tzkurabiye_siparis INNER JOIN tzkurabiye ON tzkurabiye_siparis.tzkurabiye_id=tzkurabiye.id SET tzkurabiye_kg='$postkg' WHERE kullanici_id='$uid' and tzkurabiye_adi='$row[tzkurabiye_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Tuzlu Kurabiye (KG) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Tuzlu Kurabiye kaydı bulunamadı";
  }
  $conn->close();
  
}

function updateTtKurabiye(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM ttkurabiye_siparis INNER JOIN ttkurabiye ON ttkurabiye_siparis.ttkurabiye_id = ttkurabiye.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["ttkurabiye_id"]."_ttkurabiye"]; //echo $row["ttkurabiye_adi"];echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      $sql.="UPDATE ttkurabiye_siparis INNER JOIN ttkurabiye ON ttkurabiye_siparis.ttkurabiye_id=ttkurabiye.id SET ttkurabiye_kg='$postkg' WHERE kullanici_id='$uid' and ttkurabiye_adi='$row[ttkurabiye_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Tatlı Kurabiye (KG) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Tatlı Kurabiye kaydı bulunamadı";
  }
  $conn->close();
  
}

function updatePaketUrunler(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  $uid = getUserID();
  $sql = "SELECT * FROM paketurunler_siparis INNER JOIN paketurunler ON paketurunler_siparis.paketurunler_id = paketurunler.id WHERE tarih='$tarih' and kullanici_id=$uid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    $sql="";
    while ($row = $result->fetch_assoc()){
      $postkg=$_POST[$row["paketurunler_id"]."_paketurunler"]; //echo $row["paketurunler_adi"];echo "<br>";
      if($postkg=="")
      {
        $postkg=0;
      }
      $sql.="UPDATE paketurunler_siparis INNER JOIN paketurunler ON paketurunler_siparis.paketurunler_id=paketurunler.id SET paketurunler_kg='$postkg' WHERE kullanici_id='$uid' and paketurunler_adi='$row[paketurunler_adi]' and tarih='$tarih';";
    }
    if ($conn->multi_query($sql) === TRUE) {

      echo "Paket Ürünler (KG) siparişiniz gönderildi...";
    } else {
      echo "<b>HATA:</b>" . "<br>" . $conn->error;
      exit();
    }
  }
  else
  {
    echo "Güncellenecek Paket Ürünler kaydı bulunamadı";
  }
  $conn->close();
  
}

function getUserID(): int
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  //İNPUTLARI ÇEKEBİLMEK İÇİN ÖNCE PASTA IDLERİNİ ÇEKMEMİZ LAZIM ÇÜNKÜ INPUTLARIN ADININ İÇİNDE PASTA tablosunun ID si VAR.


  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
  }

  $sql = "SELECT id FROM kullanicilar WHERE kullanici_adi='$_SESSION[uname]' AND parola='$_SESSION[psw]'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
      return $row["id"];
    }
  }
}


function getLastAddedDate(int $productId): string
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $productname = ""; //siparis tablosundan ürünadi_siparis seklinde ürün sipariş tablosunun ismini alacağız
  $sql = "SELECT siparis_adi FROM siparis WHERE urun_id='$productId'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $productname = $row["siparis_adi"];
  } else echo "Ürün bulunamadı";
  $uid = getUserID();
  $sql = "SELECT tarih FROM $productname WHERE kullanici_id='$uid' ORDER BY tarih DESC LIMIT 1";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row["tarih"];
  } //else {echo "Kayıt bulunamadı";}
  else return "";
}


function checkalreadydate(int $productId): bool
{
  date_default_timezone_set('Europe/Istanbul');
  $tarih = date('Y-m-d');
  if ($tarih == getLastAddedDate($productId))
    return true;
  else
    return false;
}
