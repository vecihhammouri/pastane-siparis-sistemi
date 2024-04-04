<?php
require_once("includes/config.php");
require_once("getproductforms.php");
require_once("orderfuncs.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
  if(!isset($_SESSION["unameimalat"]) && !isset($_SESSION["pswimalat"]))
    header("Location: login.php");
}
//echo "Welcome ".$_SESSION["uname"];
//echo "<a href=\"logout.php\">Çıkış Yap</a>";

//echo getLastAddedDate(2);
$pastasiparisdurumu = "";
if (isset($_SESSION["pastagonderim"])) {
  if ($_SESSION["pastagonderim"] == "  " . ucfirst($_SESSION["uname"]) . " için Pasta [0][1][2][3] Siparişleri gönderildi.") {
    $pastasiparisdurumu = $_SESSION["pastagonderim"];
    unset($_SESSION["pastagonderim"]);
  }
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
      <a href="order.php" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Sipariş Ver</a>
      <a href="myorders.php" class="w3-bar-item w3-button w3-mobile w3-border">Siparişler</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
    </div>

    <?php
    $checkalreadymessage = "";
    //zaten eklenen ürün var mı kontrolü için mesaj



    //ÜRÜNLERİ FORMUNU GETİRECEĞİZ
    $sql = "SELECT id,urun_adi FROM urunler1 ORDER BY ID ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {



      while ($row = $result->fetch_assoc()) {

        $withoutspace = $row["urun_adi"]; //WITHOUTSPACE ürün adını boşluksuz bir şekilde accordion için div id'sine verir.
        $withoutspace = str_replace(' ', '', $row["urun_adi"] . "_div");

        /*if (checkalreadydate($row["id"])) {//BURASI YÜZÜNDEN DİĞER BUTONLAR GELMİYOR NEDEN?????????????????????????
          $checkalreadymessage = "  Bugün zaten " . ucfirst($_SESSION["uname"]) . " için Pasta [0][1][2][3] Siparişleri gönderildi.";
        }*/
  
        
        /*if(getLastAddedDate($row["id"])==$tarih){
        $checkalreadymessage = "  Bugün zaten " . ucfirst($_SESSION["uname"]) . " için Pasta [0][1][2][3] Siparişleri gönderildi.";
        }*/

        echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-dark w3-left-align w3-border\"><h2>$row[urun_adi]</h2>$checkalreadymessage</button>"; // ÜRÜN BUTONLARINI GETİR
        $checkalreadymessage = "";
        switch ($row["urun_adi"]) {
          case "PASTA [0][1][2][3]":
            pastaForm(); //getproducts sayfasından bu fonksiyon

            break;
          case "TEK PASTA (ADET)":
            tekPastaForm();
            break;
          case "PETİFÜR ÇEŞİT (KG)":
            petifurcesitForm();

            break;
          case "FİGÜRLÜ TEK (KG)":
            figurlutekForm();
            
            break;
          case "SÜTLÜ TATLI (ADET)":
            sutluTatliForm();

            break;
          case "ADETLER":
            adetlerForm();

            break;
          case "POĞAÇA (ADET)":
            pogacaForm();

            break;
          case "DONDURMA (KG)":
            dondurmaForm();

            break;
          case "KURABİYE TUZLU (KG)":
            tzkurabiyeForm();

            break;
          case "KURABİYE TATLI (KG)":
            ttKurabiyeForm();
            break;
          case "PAKET ÜRÜNLER (KG)":
            paketUrunlerForm();
            break;
            case "BAKLAVA (TEPSİ)":
              baklavaForm();
              break;

          default:
            $urunAdi =  "HATA";
        }
      }
    }

    ?>

  </div>
</body>

</html>