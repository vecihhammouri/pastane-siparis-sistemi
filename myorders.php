<?php
require_once("getproductforms.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
  header("Location: login.php");
}
echo "<script type=\"text/javascript\" src=\"js.js\"></script>";
?>
<!DOCTYPE html>
<html>
<title>Bayi Sipariş</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
  <meta http-equiv="pragma" content="no-cache" />
</head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-cyan.css">
<?php echo "<script type=\"text/javascript\" src=\"js.js\"></script>"; ?>

<body>

  <div class="w3-card-4">
    <!-- BU Div buttonlar ve içerikleri çekildikten sonra kapatılacak -->
    <div class="w3-container w3-theme w3-card">
      <h1 class="w3-center">Bayi Sipariş<br><span class="w3-text-black"><?php echo ucfirst($_SESSION["uname"]); ?></span></h1>
    </div>


    <div class="w3-bar w3-black">
      <a href="order.php" class="w3-bar-item w3-button w3-mobile w3-border">Sipariş Ver</a>
      <a href="myorders.php" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Siparişler</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
    </div>
    <?php

    date_default_timezone_set('Europe/Istanbul');
    $tarih = date('Y-m-d');




    function showPastaForm()
    {

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







      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM pasta_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('PASTA[0][1][2][3]_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>PASTA [0][1][2][3] Siparişleri </h2></button>";
        $updatepastaformdiv = "<form action=\"updatepastapost.php\" method=\"POST\" name=\"updatepastaform\">";
        $updatepastaformdiv = $updatepastaformdiv . "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">"; //HER ÜRÜNDE DİVİN ID SİNİ GİRİYORUZ. BU, VERİTABANI TABLOSUNDAKİ ADIN BOŞLUKLARI SİLİNMİŞ HALİ ($whitoutspace))
        while ($row = $result->fetch_assoc()) {
          $updatepastaformdiv = $updatepastaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 52%;\">" . getPastaName($row["pasta_id"]) . "</label>";
          for ($i = 0; $i < 4; $i++) {
            $boy_i = "boy" . $i;
            $updatepastaformdiv = $updatepastaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter editpasta\" type=\"number\" min=\"0\" name=\"$row[pasta_id]_pastaboy$i\"  placeholder=\"[$i]\" value=\"$row[$boy_i]\" disabled style=\"width: 12%;\">";
            // PASTAID_PASTABOYUNU İÇEREN İNPUTLAR OLUŞTURUYORUZ. 
          }
        }
        $updatepastaformdiv = $updatepastaformdiv . "<br><input class =\"editpasta\" disabled type=\"submit\"value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editpasta')\">Pasta Siparişini Güncelle</input></p></div></form>";
        echo $updatepastaformdiv;
      } else {
        $tarih = date('d.m.Y');
        //echo "<p class=\"w3-center\">Bugün için PASTA[0][1][2][3] siparişi verilmemiş.<br>" . $tarih . "</p>";
      }
      $conn->close();
    }


    function showTekPastaForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM tekpasta_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('TEKPASTA(ADET)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>TEK PASTA (ADET) Siparişleri </h2></button>";
        $updatetekpastaformdiv = "<form action=\"updatetekpastapost.php\" method=\"POST\" name=\"updatetekpastaform\">";
        $updatetekpastaformdiv .= "<div class=\"w3-hide\" id=\"TEKPASTA(ADET)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatetekpastaformdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getTekPastaName($row["tekpasta_id"]) . "</label>";
          $updatetekpastaformdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter edittekpasta\" disabled  type=\"number\" min=\"0\" name=\"$row[tekpasta_id]_tekpasta\" value=\"$row[tekpasta_adet]\" placeholder=\"Adet\" style=\"width: 35%;\">";
        }
        $updatetekpastaformdiv = $updatetekpastaformdiv . "<br><input class =\"edittekpasta\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('edittekpasta')\">Tek Pasta Siparişini Güncelle</input></p></div></form>";
        echo $updatetekpastaformdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }


    function showPetifurCesitForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM petifurcesit_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('PETİFÜRÇEŞİT(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>PETİFÜR ÇEŞİT (KG) Siparişleri </h2></button>";
        $updatepetifurcesitdiv = "<form action=\"updatepetifurcesitpost.php\" method=\"POST\" name=\"updatepetifurcesitform\">";
        $updatepetifurcesitdiv .= "<div class=\"w3-hide\" id=\"PETİFÜRÇEŞİT(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatepetifurcesitdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getPetifurCesitName($row["petifurcesit_id"]) . "</label>";
          $updatepetifurcesitdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editpetifurcesit\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[petifurcesit_id]_petifurcesit\" value=\"$row[petifurcesit_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatepetifurcesitdiv = $updatepetifurcesitdiv . "<br><input class =\"editpetifurcesit\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editpetifurcesit')\">Petifür Çeşit Siparişini Güncelle</input></p></div></form>";
        echo $updatepetifurcesitdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }

    function showFigurluTekForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM figurlutek_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('FİGÜRLÜTEK(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>FİGÜR TEK (KG) Siparişleri </h2></button>";
        $updatefigurlutekdiv = "<form action=\"updatefigurlutekpost.php\" method=\"POST\" name=\"updatefigurlutekform\">";
        $updatefigurlutekdiv .= "<div class=\"w3-hide\" id=\"FİGÜRLÜTEK(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatefigurlutekdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getfigurlutekName($row["figurlutek_id"]) . "</label>";
          $updatefigurlutekdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editfigurlutek\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[figurlutek_id]_figurlutek\" value=\"$row[figurlutek_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatefigurlutekdiv = $updatefigurlutekdiv . "<br><input class =\"editfigurlutek\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editfigurlutek')\">Figürlü Tek Siparişini Güncelle</input></p></div></form>";
        echo $updatefigurlutekdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }

    function showSutlutatliForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM sutlutatli_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('SÜTLÜTATLI(ADET)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>SÜTLÜ TATLI (ADET) Siparişleri </h2></button>";
        $updatesutlutatliformdiv = "<form action=\"updatesutlutatlipost.php\" method=\"POST\" name=\"updatesutlutatliform\">";
        $updatesutlutatliformdiv .= "<div class=\"w3-hide\" id=\"SÜTLÜTATLI(ADET)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatesutlutatliformdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getsutlutatliName($row["sutlutatli_id"]) . "</label>";
          $updatesutlutatliformdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editsutlutatli\" disabled  type=\"number\" min=\"0\" name=\"$row[sutlutatli_id]_sutlutatli\" value=\"$row[sutlutatli_adet]\" placeholder=\"Adet\" style=\"width: 35%;\">";
        }
        $updatesutlutatliformdiv = $updatesutlutatliformdiv . "<br><input class =\"editsutlutatli\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editsutlutatli')\">Sütlü Tatlı Siparişini Güncelle</input></p></div></form>";
        echo $updatesutlutatliformdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }

    function showAdetlerForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM adetler_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('ADETLER_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>ADETLER Siparişleri </h2></button>";
        $updateadetlerformdiv = "<form action=\"updateadetlerpost.php\" method=\"POST\" name=\"updateadetlerform\">";
        $updateadetlerformdiv .= "<div class=\"w3-hide\" id=\"ADETLER_div\">";
        while ($row = $result->fetch_assoc()) {
          $updateadetlerformdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getadetlerName($row["adetler_id"]) . "</label>";
          $updateadetlerformdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editadetler\" disabled  type=\"number\" min=\"0\" name=\"$row[adetler_id]_adetler\" value=\"$row[adetler_adet]\" placeholder=\"Adet\" style=\"width: 35%;\">";
        }
        $updateadetlerformdiv = $updateadetlerformdiv . "<br><input class =\"editadetler\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editadetler')\">Adetler Siparişini Güncelle</input></p></div></form>";
        echo $updateadetlerformdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }
    function showPogacaForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM pogaca_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('POĞAÇA(ADET)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>POĞAÇA (ADET) Siparişleri </h2></button>";
        $updatepogacaformdiv = "<form action=\"updatepogacapost.php\" method=\"POST\" name=\"updatepogacaform\">";
        $updatepogacaformdiv .= "<div class=\"w3-hide\" id=\"POĞAÇA(ADET)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatepogacaformdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getpogacaName($row["pogaca_id"]) . "</label>";
          $updatepogacaformdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editpogaca\" disabled  type=\"number\" min=\"0\" name=\"$row[pogaca_id]_pogaca\" value=\"$row[pogaca_adet]\" placeholder=\"Adet\" style=\"width: 35%;\">";
        }
        $updatepogacaformdiv = $updatepogacaformdiv . "<br><input class =\"editpogaca\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editpogaca')\">Poğaça Siparişini Güncelle</input></p></div></form>";
        echo $updatepogacaformdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }


    function showDondurmaForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM dondurma_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('DONDURMA(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>DONDURMA (KG) Siparişleri </h2></button>";
        $updatedondurmadiv = "<form action=\"updatedondurmapost.php\" method=\"POST\" name=\"updatedondurmaform\">";
        $updatedondurmadiv .= "<div class=\"w3-hide\" id=\"DONDURMA(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatedondurmadiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getdondurmaName($row["dondurma_id"]) . "</label>";
          $updatedondurmadiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editdondurma\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[dondurma_id]_dondurma\" value=\"$row[dondurma_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatedondurmadiv = $updatedondurmadiv . "<br><input class =\"editdondurma\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editdondurma')\">Dondurma Siparişini Güncelle</input></p></div></form>";
        echo $updatedondurmadiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }

    function showTzKurabiyeForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM tzkurabiye_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('KURABİYETUZLU(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>TUZLU KURABİYE (KG) Siparişleri </h2></button>";
        $updatetzkurabiyediv = "<form action=\"updatetzkurabiyepost.php\" method=\"POST\" name=\"updatetzkurabiyeform\">";
        $updatetzkurabiyediv .= "<div class=\"w3-hide\" id=\"KURABİYETUZLU(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatetzkurabiyediv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . gettzkurabiyeName($row["tzkurabiye_id"]) . "</label>";
          $updatetzkurabiyediv .= "<input class=\"w3-input w3-border w3-cell w3-quarter edittzkurabiye\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[tzkurabiye_id]_tzkurabiye\" value=\"$row[tzkurabiye_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatetzkurabiyediv = $updatetzkurabiyediv . "<br><input class =\"edittzkurabiye\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('edittzkurabiye')\">Tuzlu Kurabiye Siparişini Güncelle</input></p></div></form>";
        echo $updatetzkurabiyediv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }
    function showTtKurabiyeForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM ttkurabiye_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('KURABİYETATLI(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>TATLI KURABİYE (KG) Siparişleri </h2></button>";
        $updatettkurabiyediv = "<form action=\"updatettkurabiyepost.php\" method=\"POST\" name=\"updatettkurabiyeform\">";
        $updatettkurabiyediv .= "<div class=\"w3-hide\" id=\"KURABİYETATLI(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatettkurabiyediv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getttkurabiyeName($row["ttkurabiye_id"]) . "</label>";
          $updatettkurabiyediv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editttkurabiye\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[ttkurabiye_id]_ttkurabiye\" value=\"$row[ttkurabiye_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatettkurabiyediv = $updatettkurabiyediv . "<br><input class =\"editttkurabiye\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editttkurabiye')\">Tatlı Kurabiye Siparişini Güncelle</input></p></div></form>";
        echo $updatettkurabiyediv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }
    function showPaketUrunlerForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM paketurunler_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('PAKETÜRÜNLER(KG)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>PAKET ÜRÜNLER (KG) Siparişleri </h2></button>";
        $updatepaketurunlerdiv = "<form action=\"updatepaketurunlerpost.php\" method=\"POST\" name=\"updatepaketurunlerform\">";
        $updatepaketurunlerdiv .= "<div class=\"w3-hide\" id=\"PAKETÜRÜNLER(KG)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatepaketurunlerdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getPaketUrunlerName($row["paketurunler_id"]) . "</label>";
          $updatepaketurunlerdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editpaketurunler\" disabled  type=\"number\" min=\"0\" step=\"0.01\" name=\"$row[paketurunler_id]_paketurunler\" value=\"$row[paketurunler_kg]\" placeholder=\"KG\" style=\"width: 35%;\">";
        }
        $updatepaketurunlerdiv = $updatepaketurunlerdiv . "<br><input class =\"editpaketurunler\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editpaketurunler')\">Paket Ürünler Siparişini Güncelle</input></p></div></form>";
        echo $updatepaketurunlerdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }
    function showBaklavaForm()
    {
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

      $tarih = date('Y-m-d');
      $uid = getUserID();
      $sql = "SELECT * FROM baklava_siparis where tarih='$tarih' and kullanici_id='$uid'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<button onclick=\"accordion('BAKLAVA(TEPSİ)_div')\" class=\"w3-button w3-block w3-brown w3-left-align w3-border\"><h2>BAKLAVA (TEPSİ) Siparişleri </h2></button>";
        $updatebaklavaformdiv = "<form action=\"updatebaklavapost.php\" method=\"POST\" name=\"updatebaklavaform\">";
        $updatebaklavaformdiv .= "<div class=\"w3-hide\" id=\"BAKLAVA(TEPSİ)_div\">";
        while ($row = $result->fetch_assoc()) {
          $updatebaklavaformdiv .= "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">" . getBaklavaName($row["baklava_id"]) . "</label>";
          $updatebaklavaformdiv .= "<input class=\"w3-input w3-border w3-cell w3-quarter editbaklava\" disabled  type=\"number\" min=\"0\" name=\"$row[baklava_id]_baklava\" value=\"$row[baklava_tepsi]\" placeholder=\"Tepsi\" style=\"width: 35%;\">";
        }
        $updatebaklavaformdiv = $updatebaklavaformdiv . "<br><input class =\"editbaklava\" type=\"submit\" disabled value=\"Güncelle\"><p class=\"w3-center\"><input type=\"checkbox\" autocomplete=\"off\" required onchange=\"enabledisable('editbaklava')\">Baklava Siparişini Güncelle</input></p></div></form>";
        echo $updatebaklavaformdiv;
      } else {
        //echo "Güncellenecek kayıt bulunamadı";
      }
      $conn->close();
    }

    function getPastaName(int $pastaId): string //PASTA [0][1][2][3]
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT pasta_adi FROM pasta WHERE id='$pastaId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["pasta_adi"];
      } else {
        echo "Pasta yok";
        return "";
      }
    }
    function getTekPastaName(int $tekpastaId): string //TEK PASTA ADET
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT tekpasta_adi FROM tekpasta WHERE id='$tekpastaId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["tekpasta_adi"];
      } else {
        echo "Tek Pasta yok";
        return "";
      }
    }

    function getPetifurCesitName(int $petifurcesitId): string //Petifür Çeşit kg
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT petifurcesit_adi FROM petifurcesit WHERE id='$petifurcesitId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["petifurcesit_adi"];
      } else {
        echo "Petifür Çeşit yok";
        return "";
      }
    }

    function getFigurluTekName(int $figurlutekId): string //Figürlü Tek kg
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT figurlutek_adi FROM figurlutek WHERE id='$figurlutekId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["figurlutek_adi"];
      } else {
        echo "Figürlü Tek yok";
        return "";
      }
    }

    function getSutluTatliName(int $sutlutatliId): string //Sütlü Tatlı Adet
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT sutlutatli_adi FROM sutlutatli WHERE id='$sutlutatliId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["sutlutatli_adi"];
      } else {
        echo "Sütlü Tatlı yok";
        return "";
      }
    }
    function getBaklavaName(int $baklavaId): string //Baklava tepsi
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT baklava_adi FROM baklava WHERE id='$baklavaId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["baklava_adi"];
      } else {
        echo "Baklava yok";
        return "";
      }
    }
    function getAdetlerName(int $adetlerId): string //Adetler
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT adetler_adi FROM adetler WHERE id='$adetlerId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["adetler_adi"];
      } else {
        echo "Adetler yok";
        return "";
      }
    }

    function getPogacaName(int $pogacaId): string //pogaca
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT pogaca_adi FROM pogaca WHERE id='$pogacaId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["pogaca_adi"];
      } else {
        echo "Poğaça yok";
        return "";
      }
    }

    function getDondurmaName(int $dondurmaId): string //DONDURMA kg
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT dondurma_adi FROM dondurma WHERE id='$dondurmaId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["dondurma_adi"];
      } else {
        echo "Dondurma Çeşit yok";
        return "";
      }
    }

    function getTzKurabiyeName(int $tzkurabiyeId): string //DONDURMA kg
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT tzkurabiye_adi FROM tzkurabiye WHERE id='$tzkurabiyeId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["tzkurabiye_adi"];
      } else {
        echo "Tuzlu Kurabiye Çeşit yok";
        return "";
      }
    }

    function getTtKurabiyeName(int $ttkurabiyeId): string //DONDURMA kg
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT ttkurabiye_adi FROM ttkurabiye WHERE id='$ttkurabiyeId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["ttkurabiye_adi"];
      } else {
        echo "Tatlı Kurabiye Çeşit yok";
        return "";
      }
    }

    function getPaketUrunlerName(int $paketurunlerId): string //PAKET ÜRÜNLER KG
    {
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "testdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
      }

      //önce productid'den ürün adını belirleyeceğiz. hangi ürün grubunundan ürüne güncelleme yapacağımızı belirleyebilmek için 
      $sql = "SELECT paketurunler_adi FROM paketurunler WHERE id='$paketurunlerId'";
      $result = $conn->query(($sql));
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["paketurunler_adi"];
      } else {
        echo "Paket Ürünler yok";
        return "";
      }
    }

    showPastaForm();
    showTekPastaForm();
    showPetifurCesitForm();
    showFigurluTekForm();
    showSutlutatliForm();
    showAdetlerForm();
    showPogacaForm();
    showDondurmaForm();
    showTzKurabiyeForm();
    showTtKurabiyeForm();
    showPaketUrunlerForm();
    showBaklavaForm();
    ?>




  </div>
</body>

</html>