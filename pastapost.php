<?php
require_once("includes/config.php");
require_once("getproductforms.php");
require_once("orderfuncs.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
  header("Location: login.php");
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  pastaSend();
  //echo "Pasta siparişiniz gönderildi...";
  header("Refresh:3; order.php");
  exit();
} else {
  echo "Sipariş bilgileri alınamadı";
  header("Refresh:3; order.php");
  exit();
}


?>
<!DOCTYPE html>
<html>
<title>Bayi Sipariş</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
      <a href="#" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Sipariş Ver</a>
      <a href="#" class="w3-bar-item w3-button w3-mobile w3-border\">Siparişler</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
    </div>

    <?php
    //ÜRÜNLERİ FORMUNU GETİRECEĞİZ
    $sql = "SELECT urun_adi FROM urunler1 ORDER BY ID ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $withoutspace = $row["urun_adi"]; //WITHOUTSPACE ürün adını boşluksuz bir şekilde accordion için div id'sine verir.
        $withoutspace = str_replace(' ', '', $row["urun_adi"] . "_div");
        echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-dark w3-left-align w3-border\"><h2>$row[urun_adi]</h2></button>";

        switch ($row["urun_adi"]) { //  ÜRÜN BUTONLARINI GETİR
          case "PASTA [0][1][2][3]":
            pastaForm(); //getproducts sayfasından bu fonksiyon

            break;
          case "tek_pasta":
            //getTekPasta();
            $urunAdi = "Tek Pasta [Adet]";
            break;
          case "petifur_cesit":
            $urunAdi =  "Petifür Çeşit [kg]";
            break;
          case "figurlu_tek":
            $urunAdi =  "Figürlü Tek [kg]";
            break;
          case "sutlu_tatli":
            $urunAdi =  "Sütlü Tatlı [kg]";
            break;
          case "adetler":
            $urunAdi =  "Adetler [Adet]";
            break;
          case "pogaca":
            $urunAdi =  "Poğaça [Adet]";
            break;
          case "dondurma":
            $urunAdi =  "Dondurma [kg]";
            break;
          case "kurabiyeler_tuzlu":
            $urunAdi =  "Kurabiyeler Tuzlu [kg]";
            break;
          case "kurabiyeler_tatli":
            $urunAdi =  "Kurabiyeler Tatlı [kg]";
            break;
          case "paket_urunler":
            $urunAdi =  "Paket Ürünler [kg]";
            break;
          default:
            $urunAdi =  "HATA";
        }
      }
    }
