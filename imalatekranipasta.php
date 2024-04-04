<?php
session_start();
if (!isset($_SESSION["unameimalatpasta"]) && !isset($_SESSION["pswimalatpasta"])) {
  header("Location: login.php");
}


?>


<!DOCTYPE html>
<html>
<title>Bayi İmalat</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-cyan.css">
<?php echo "<script type=\"text/javascript\" src=\"js.js\"></script>"; ?>


<body>

  <div class="w3-card-4">
    <!-- BU Div buttonlar ve içerikleri çekildikten sonra kapatılacak -->
    <div class="w3-container w3-theme w3-card">
      <h1 class="w3-center">İmalat<br><span class="w3-text-black"><?php echo ucfirst($_SESSION["unameimalat"]); ?></span></h1>
    </div>


    <div class="w3-bar w3-black">
      <a href="imalat.php" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Seçim Yap</a>
      <a href="myorders.php" class="w3-bar-item w3-button w3-mobile w3-border">Siparişler</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
    </div>





    <!-- DROPDOWN FORM-->
    <br>
    <form action="imalatekranipasta.php" method="POST">
      <label for="zaman">Zaman:</label>

      <select name="zaman" id="zaman" autocomplete="off">

        <option value="secim">Seçim Yapın</option>;
        <option value="son24saat">Son 24 Saat</option>;
        <option value="bugun">Bugün (Sadece Bugün)</option>;
        <option value="sonbirhafta">Son 1 Hafta</option>;
        <option value="buhafta">Bu Hafta</option>;
        <option value="sonbiray">Son 1 Ay</option>;
        <option value="sonbiryil">Son 1 Yıl</option>;

      </select><br><br><input type="submit" value="Siparişleri Getir"></input>
    </form><br>



    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $secilenzaman = $_POST["zaman"];
      if ($secilenzaman != "secim") {
        urunurun($secilenzaman);
      }
    }





    //SECİLEN ZAMANA GÖRE ÜRÜN ÜRÜN ŞUBE ŞUBE SİPARİŞLERİ GÖSTERİR
    function urunurun($secilenzaman)
    {

      require_once("includes/justdb.php");
      $withoutspace = ""; //div için

      //ÜRÜN ÜRÜN ÇEKECEĞİMİZ İÇİN ÖNCE ÜRÜNLERİ ÜRÜN LİSTESİNİ BAKLAVA HARİÇ ÇEKELİM
      $sqlurunlistesipasta = "SELECT id, urun_adi FROM urunler1 WHERE id<>12 ORDER BY urunler1.id ASC";
      $resultsqlurunliste = $conn->query($sqlurunlistesipasta);
      $withoutspace = $rowurunliste["urun_adi"]; //WITHOUTSPACE ürün adını boşluksuz bir şekilde accordion için div id'sine verir. Bu div buton için göster gizle
      $withoutspace = str_replace(' ', '', $rowurunliste["urun_adi"] . "_div");


      //KULLANICI LİSTESİNİ ÇEKMEK İÇİN SQL KODUNU DA HAZIRLAYALIM
      $sqlsubeliste = "SELECT id,kullanici_adi from kullanicilar order by id asc";
      $resultsqlsubeliste = $conn->query($sqlsubeliste);
      $subesayisi = $resultsqlsubeliste->num_rows; //SUBE SAYISINI DEĞİŞKENE ATADIK. BUNU TABLOLARDAKİ SÜTUN SAYISINI BELİRLEMEDE KULLANACAĞIZ

      if ($resultsqlurunliste->num_rows > 0) {






        //echo "<div class=\"w3-hide\" id=\"$withoutspace\">";
        /*echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered\">"; //TABLOYU OLUŞTURUYORUZ
        echo "<tr>";
        //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
        $pastaicinsutunsayisi = 7;
        $pastaicinsutunyuzde = round(100 / 7);

        echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
        echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";

        echo "</tr></table>";*/

        //echo "<br><br><br><br><br>";







        while ($rowurunliste = $resultsqlurunliste->fetch_assoc()) { //ÜRÜNLERİ LİSTELİYORUZ
          //HER ÜRÜN İÇİN ŞUBE ŞUBE DEĞERLERİ OKUYACAĞIMIZ İÇİN ŞUBELERİ DE ÜRÜN DÖNGÜSÜNÜN İÇİNDE DÖNGÜYE ALMAMIZ GEREK

          //EĞER ÜRÜN İD 1 İSE YANİ PASTA İSE BUNU AYRI YAPACAĞIZ SÜTUNLARI FAZLA BUNUN
          if ($rowurunliste["id"] == 1) {

            $withoutspace = "PASTA[0][1][2][3]_div";
            //BUTONDA BELİRTMEK İÇİN DROPDOWNDAKİ LİSTEYİ KONTROL EDECEĞİZ
            switch ($secilenzaman) {
              case 'son24saat':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 24 Saat</button>";
                break;

                case 'sonbirhafta':
                  echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Hafta</button>";
                  break;

              case 'bugun':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA [0][1][2][3] (ADET) Siparişleri</h2>Bugün</button>";

                break;

                case 'buhafta':
                  echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Bu Hafta</button>";
                  break;

                  case 'sonbiray':
                    echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Ay</button>";
                    break;


                    case 'sonbiryil':
                      echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Yıl</button>";
                      break;


           

              default:
                # code...
                break;
            }
            //PASTA[][][][] KISMI BURAYI YAZDIRACAĞIZ
            //ÖNCE BÜTÜN ŞUBELER GENEL TOPLAM YAZILACAK BOY0 BOY 1 BOY2 BOY3
            $sqlpastatoplam = "";

            //SEÇİLEN ZAMANA GÖRE SQL KODUNDA TARİH KISMINI AYARLAYACAĞIZ
            $sqlpasta = "";


            switch ($secilenzaman) {
              case 'son24saat':
                //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
                $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
                $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
                if ($resultsqlpastatablosu->num_rows > 0) {
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {
                    $sqlpastatoplam .= "SELECT pasta_adi, SUM(boy0), SUM(boy1), SUM(boy2), SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id = pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih >= NOW() - INTERVAL 1 DAY ORDER BY pasta_id ASC;";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
                    
                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ 
                    echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
                    echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";





                    do { //DÖNGÜ İÇİNDE YAZDIRACAZ
                      // Store first result set
                      if ($resultpastatoplam = $conn->store_result()) {
                        while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
                          //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
                        }
                        $resultpastatoplam->free_result();
                      }
                      // if there are more result-sets, the print a divider
                      if ($conn->more_results()) {
                        //echo "</tr>";
                      //echo "<br>";
                      }//echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

   //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
   $pastaicinsutunyuzde = round(100 / 7);
 
                echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



                echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
              echo "<tr class=\"w3-brown\">";
             

              echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
              echo "</tr>";


                $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE tarih >= NOW() - INTERVAL 1 DAY ORDER BY kullanici_id ASC, tarih DESC"; //BURADA DA AYRI AYRI HER ŞUBE KAÇ TANE SİPARİŞ VERMİŞ O TARİH İÇİN
                break;

              case 'bugun':
                //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
                $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
                $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
                if ($resultsqlpastatablosu->num_rows > 0) {
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {
                    $sqlpastatoplam .= "SELECT pasta_adi, SUM(boy0), SUM(boy1), SUM(boy2), SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id = pasta.id WHERE pasta_id=$rowpastatablosu[id] AND DAY(tarih) = DAY(CURDATE()) ORDER BY pasta_id ASC;";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
                    
                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ 
                    echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
                    echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";





                    do { //DÖNGÜ İÇİNDE YAZDIRACAZ
                      // Store first result set
                      if ($resultpastatoplam = $conn->store_result()) {
                        while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
                          //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
                        }
                        $resultpastatoplam->free_result();
                      }
                      // if there are more result-sets, the print a divider
                      if ($conn->more_results()) {
                        //echo "</tr>";
                      //echo "<br>";
                      }//echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

   //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
   $pastaicinsutunyuzde = round(100 / 7);
 
                echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



                echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
              echo "<tr class=\"w3-brown\">";
             

              echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
              echo "</tr>";
                $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE DAY(tarih) = DAY(CURDATE()) ORDER BY kullanici_id ASC, tarih DESC";
                break;




//xxxx
case 'buhafta':
  //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
  $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
  $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
  if ($resultsqlpastatablosu->num_rows > 0) {
    while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {
      $sqlpastatoplam .= "SELECT pasta_adi, SUM(boy0), SUM(boy1), SUM(boy2), SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id = pasta.id WHERE pasta_id=$rowpastatablosu[id] AND  WEEK(tarih) = WEEK(CURDATE()) ORDER BY pasta_id ASC;";
    } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
    //echo $sqlpastatoplam;

    //sorguyu çalıştıracaz
    if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
      
      //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ 
      echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
      echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
      echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
      echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
      echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
      echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
      echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";





      do { //DÖNGÜ İÇİNDE YAZDIRACAZ
        // Store first result set
        if ($resultpastatoplam = $conn->store_result()) {
          while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
            //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
            echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
            echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
            echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
            echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
            echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
          }
          $resultpastatoplam->free_result();
        }
        // if there are more result-sets, the print a divider
        if ($conn->more_results()) {
          //echo "</tr>";
        //echo "<br>";
        }//echo "<br><br>";
        //Prepare next result set
      } while ($conn->next_result());
    }
  }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

//önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
$pastaicinsutunyuzde = round(100 / 7);

  echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



  echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
echo "<tr class=\"w3-brown\">";


echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
echo "</tr>";


  $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE WEEK(tarih) = WEEK(CURDATE())ORDER BY kullanici_id ASC, tarih DESC"; //BURADA DA AYRI AYRI HER ŞUBE KAÇ TANE SİPARİŞ VERMİŞ O TARİH İÇİN
  break;







  case 'sonbirhafta':
    //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
    $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
    $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
    if ($resultsqlpastatablosu->num_rows > 0) {
      while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {//BURADAN DEVAAM ET
        $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 7 DAY ) AND CURDATE();";
      } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
      //echo $sqlpastatoplam;
  
      //sorguyu çalıştıracaz
      if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
        
        //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
        echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
        echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
        echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
        echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
        echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
        echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
        echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";
  
  
  
  
  
        do { //DÖNGÜ İÇİNDE YAZDIRACAZ
          // Store first result set
          if ($resultpastatoplam = $conn->store_result()) {
            while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
              //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
              echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
              echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
              echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
              echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
              echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
            }
            $resultpastatoplam->free_result();
          }
          // if there are more result-sets, the print a divider
          if ($conn->more_results()) {
            //echo "</tr>";
          //echo "<br>";
          }//echo "<br><br>";
          //Prepare next result set
        } while ($conn->next_result());
      }
    }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA
  
  //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
  $pastaicinsutunyuzde = round(100 / 7);
  
    echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN
  
  
  
    echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
  echo "<tr class=\"w3-brown\">";
  
  
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
  echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
  echo "</tr>";
  
  
    $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 7 DAY ) AND CURDATE() ORDER BY kullanici_id ASC, tarih DESC;"; //BURADA DA AYRI AYRI HER ŞUBE KAÇ TANE SİPARİŞ VERMİŞ O TARİH İÇİN
    break;


    case 'sonbiray':
      //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
      $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
      $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
      if ($resultsqlpastatablosu->num_rows > 0) {
        while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {//BURADAN DEVAAM ET
          $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 30 DAY ) AND CURDATE();";
        } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
        //echo $sqlpastatoplam;
    
        //sorguyu çalıştıracaz
        if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
          
          //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
          echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
          echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
          echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
          echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
          echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
          echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
          echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";
    
    
    
    
    
          do { //DÖNGÜ İÇİNDE YAZDIRACAZ
            // Store first result set
            if ($resultpastatoplam = $conn->store_result()) {
              while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
                //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
                echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
                echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
                echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
                echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
                echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
              }
              $resultpastatoplam->free_result();
            }
            // if there are more result-sets, the print a divider
            if ($conn->more_results()) {
              //echo "</tr>";
            //echo "<br>";
            }//echo "<br><br>";
            //Prepare next result set
          } while ($conn->next_result());
        }
      }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA
    
    //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
    $pastaicinsutunyuzde = round(100 / 7);
    
      echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN
    
    
    
      echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
    echo "<tr class=\"w3-brown\">";
    
    
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
    echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
    echo "</tr>";
    
    
      $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 30 DAY ) AND CURDATE() ORDER BY kullanici_id ASC, tarih DESC;"; //BURADA DA AYRI AYRI HER ŞUBE KAÇ TANE SİPARİŞ VERMİŞ O TARİH İÇİN
      break;

      case 'sonbiryil':
        //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
        $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
        $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
        if ($resultsqlpastatablosu->num_rows > 0) {
          while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {//BURADAN DEVAAM ET
            $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 YEAR ) AND CURDATE();";
          } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
          //echo $sqlpastatoplam;
      
          //sorguyu çalıştıracaz
          if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
            
            //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
            echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
            echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
            echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
            echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
            echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
            echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
            echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";
      
      
      
      
      
            do { //DÖNGÜ İÇİNDE YAZDIRACAZ
              // Store first result set
              if ($resultpastatoplam = $conn->store_result()) {
                while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
                  //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
                  echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
                  echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
                  echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
                  echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
                  echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
                }
                $resultpastatoplam->free_result();
              }
              // if there are more result-sets, the print a divider
              if ($conn->more_results()) {
                //echo "</tr>";
              //echo "<br>";
              }//echo "<br><br>";
              //Prepare next result set
            } while ($conn->next_result());
          }
        }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA
      
      //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
      $pastaicinsutunyuzde = round(100 / 7);
      
        echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN
      
      
      
        echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
      echo "<tr class=\"w3-brown\">";
      
      
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
      echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
      echo "</tr>";
      
      
        $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id  WHERE tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 YEAR ) AND CURDATE() ORDER BY kullanici_id ASC, tarih DESC;"; //BURADA DA AYRI AYRI HER ŞUBE KAÇ TANE SİPARİŞ VERMİŞ O TARİH İÇİN
        break;



              case 'tumzamanlar':
                //PASTA SİPARİNİN BÜTÜN ŞUBELER TOPLAMI İÇİN,  HER PASTA ÇEŞİDİ İÇİN TOPLAMLARI ALACAĞIZ. BU YÜZDEN PASTA TABLOSUNDAN PASTA ÇEŞİTLERİNİ ÇEKELİM
                $sqlpastatablosu = "SELECT id,pasta_adi FROM pasta ORDER BY id ASC";
                $resultsqlpastatablosu = $conn->query($sqlpastatablosu);
                if ($resultsqlpastatablosu->num_rows > 0) {
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) {
                    $sqlpastatoplam .= "SELECT pasta_adi, SUM(boy0), SUM(boy1), SUM(boy2), SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id = pasta.id WHERE pasta_id=$rowpastatablosu[id]  ORDER BY pasta_id ASC;";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
                    
                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ 
                    echo "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">";
                    echo "<h4 class=\"w3-center\">Bütün Şubeler Pasta[ Pasta Boyu ] Toplamları</h4><br>"; //ŞEKLİ DÜZEL ORTALA TOPLAM OLDUĞUNU BELİRT
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 36%;\">Pasta Adı</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[0]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[1]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[2]</label>";
                    echo "<label class=\"w3-cell w3-quarter w3-input w3-quarter w3-center\" style=\"width: 16%;\">[3]</label>";





                    do { //DÖNGÜ İÇİNDE YAZDIRACAZ
                      // Store first result set
                      if ($resultpastatoplam = $conn->store_result()) {
                        while ($rowpastatoplam = $resultpastatoplam->fetch_row()) {
                          //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter \" disabled   value=\"$rowpastatoplam[0]\"  style=\"width: 36%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[1]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[2]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[3]\"  style=\"width: 16%; font-size:13px;\">";
                          echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpastatoplam[4]\"  style=\"width: 16%; font-size:13px;\">";
                        }
                        $resultpastatoplam->free_result();
                      }
                      // if there are more result-sets, the print a divider
                      if ($conn->more_results()) {
                        //echo "</tr>";
                      //echo "<br>";
                      }//echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                }//PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

   //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
   $pastaicinsutunyuzde = round(100 / 7);
 
                echo "<h6>&nbsp</h6><br>";//BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



                echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
              echo "<tr class=\"w3-brown\">";
             

              echo "<th style=\"width:$pastaicinsutunyuzde%\">Şube</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Tarih</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Pasta Adı</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[0]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[1]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[2]</th>";
              echo "<th style=\"width:$pastaicinsutunyuzde%\">Boy[3]</th>";
              echo "</tr>";
                $sqlpasta = "SELECT kullanici_adi, tarih, pasta_adi, boy0, boy1, boy2, boy3 FROM pasta_siparis JOIN kullanicilar ON pasta_siparis.kullanici_id = kullanicilar.id JOIN pasta ON pasta_siparis.pasta_id=pasta.id ORDER BY kullanici_id ASC, tarih DESC";
                break;


              default:
                # code...
                break;
            }


            $resultpasta = $conn->query($sqlpasta);
            if ($resultpasta->num_rows > 0) {
              
              while ($rowpasta = $resultpasta->fetch_assoc()) { //BURADA PASTAYI[][][][] YAZDIRACAZ ŞİMDİ AMA ÖNCE FORM OLUŞTURMAMIZ


                echo "<tr>";
             

                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[kullanici_adi]</th>";
                $tarihformat = date_create($rowpasta["tarih"]);
                $tarihformat = date_format($tarihformat,"d-m-Y");

                echo "<th style=\"width:$pastaicinsutunyuzde%\">$tarihformat</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[pasta_adi]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy0]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy1]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy2]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy3]</th>";

                echo "</tr>";
               
                






                 //echo "<br>";
                 /*echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[kullanici_adi]\"  style=\"width: $12%;\">";
                 //date_default_timezone_set('Europe/Istanbul');
                  
                  
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$tarihformat\"  style=\"width: $pastaicinsutunyuzde%;\">";
                 $tarihformat;
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[pasta_adi]\"  style=\"width: 17%;\">";
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[boy0]\"  style=\"width: $pastaicinsutunyuzde%;\">";
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[boy1]\"  style=\"width: $pastaicinsutunyuzde%;\">";
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[boy2]\"  style=\"width: $pastaicinsutunyuzde%;\">";
                 echo "<input class=\"w3-input w3-border w3-cell w3-quarter w3-center\" disabled   value=\"$rowpasta[boy3]\"  style=\"width: $pastaicinsutunyuzde%;\">";*/
                //echo $rowpasta["kullanici_adi"] . "    " . $rowpasta["tarih"] . "    " . $rowpasta["pasta_adi"] . "    " . $rowpasta["boy0"] . "    " . $rowpasta["boy1"] . "    " . $rowpasta["boy2"] . "    " . $rowpasta["boy3"] . "<br>";
              }echo "</tr></table>";//BU DİV KAPANMASI İLE PASTA[] KISMI BİTER 
            } else {
              echo "Seçilen zamana ait sipariş bulunamadı.";
            }echo "</table></div><br>";
          } else {
            // PASTA[][][][] DIŞINDAKİ DİĞER ÜRÜNLERİ BURADA YAZDIRACAĞIZ
            $withoutspace = str_replace(' ', '', $rowurunliste["urun_adi"] . "_div");
            switch ($secilenzaman) {
              case 'son24saat':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Son 24 Saat</button>";
                break;

                case 'sonbirhafta':
                  echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Son 1 Hafta</button>";
                  break;

              case 'bugun':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Bugün</button>";

                break;

                case 'buhafta':
                  echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Bu Hafta</button>";
                  break;

                  case 'sonbiray':
                    echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Son 1 Ay</button>";
                    break;


                    case 'sonbiryil':
                      echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive\"><h2>$rowurunliste[urun_adi]</h2>Son 1 Yıl</button>";
                      break;


           

              default:
                # code...
                break;
            }
echo "<div class=\"w3-hide\" id=\"$withoutspace\" style=\"background-color:red;\">";
//echo $subesayisi;
$sqlsubeliste = "SELECT id,kullanici_adi from kullanicilar order by id asc";
$resultsqlsubeliste=$conn->query($sqlsubeliste);
if($resultsqlsubeliste->num_rows>0)
{$sqlurunsiparislistele="";//ÇOKLU SORGU OLACAK
  //TABLOYU YAPALIM PASTA HARİÇ DİĞERLERİ BU TOPLAM YANLARINDA
  echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered\">";
  while ($rowsubeliste = $resultsqlsubeliste->fetch_assoc()) {
    //HANGİ ÜRÜNÜN TABLOSUNDAN VERİ ÇEKECEĞİZ, ÜRÜN LİSTESİNİN ÜRÜN_ID SİNDEN siparis TABLOSUNDAN ÖĞRENECEĞİZ
    $siparistablo = "";
    $sqlsiparistablo = "SELECT siparis_adi,birim FROM siparis where urun_id=$rowurunliste[id]";
    $resultsqlsiparistablo = $conn->query($sqlsiparistablo);
    if ($resultsqlsiparistablo->num_rows == 1) {
      $rowsiparistablo=$resultsqlsiparistablo->fetch_assoc();
      $siparistablo = $rowsiparistablo["siparis_adi"];//siparis adını aldık şimdi bu siparişin ürünlerini çekelim
      $siparisbirim=$rowsiparistablo["birim"];//her ürünün birimi aynı değil bu yüzden birimi de almamız gerekli
      //siparis tablosundan ürün grubundaki her ürünün adını çekebilmek için ürün_siparis değil ürün tablosundan okumamız gerek bunun için _siparis kısmını atacaz
      $uruntablo=str_replace('_siparis', '', $rowsiparistablo["siparis_adi"]);//
      $urunadi=$uruntablo."_adi";// ürün tablosundan ürün adını alacaz
      $urunid=$uruntablo."_id";//ürün id
      switch ($secilenzaman) {
        case 'son24saat':
          //$sqlurunsiparislistele.="SELECT $urunadi, tarih, $siparisbirim FROM $siparistablo JOIN $uruntablo ON $siparistablo.$urunid=$uruntablo.id WHERE kullanici_id=$rowsubeliste[id] and tarih >= NOW() - INTERVAL 96 DAY;";//TEK TEK DÖNGÜ İLE BÜTÜN ŞUBELERİN O TARİHE AİT BİRİMİNİ ALIYORUZ
          $sqlurunsiparistoplam  ="SELECT $urunadi, tarih, SUM($siparisbirim) as toplam FROM $siparistablo JOIN $uruntablo ON $siparistablo.$urunid=$uruntablo.id WHERE tarih >= NOW() - INTERVAL 2 DAY GROUP BY tarih, $urunadi ORDER BY $urunadi asc, tarih desc";
          
          //$sqlurunsiparislistele.="SELECT tekpasta_adi, tarih, tekpasta_adet FROM tekpasta_siparis JOIN tekpasta ON tekpasta_siparis.tekpasta_id = tekpasta.id WHERE kullanici_id = 1 and tarih >= NOW() - INTERVAL 96 DAY UNION ALL";
          //echo $sqlurunsiparislistele; exit();
          break;
        //DİĞER DROPDOWN CASE LERİ DEVAM EDİLECEK TOPLU SQL YAPIYORUZ UNION ALL İLE
        default:
          # code...
          break;
      }
      //$sqlurunsiparislistele.="SELECT $urunadi,tarih, $siparisbirim FROM $siparistablo JOIN uruntablo ON $siparistablo.$urunid=$uruntablo.id WHERE kullanici_id=$rowsubeliste[id] UNION ALL";//TEK TEK DÖNGÜ İLE BÜTÜN ŞUBELERİN O TARİHE AİT BİRİMİNİ ALIYORUZ
      $resultsiparistoplam=$conn->query($sqlurunsiparistoplam);
      $sutunsayisi=$subesayisi+3;//sütunlar şubeler, tarih, toplam, ürün çeşidi adı
        $sutunyuzde=round(100/$sutunsayisi);
        echo "<tr class=\"w3-brown\">";
        $sutunurunadi=ucfirst($uruntablo)." Adı";
        echo "<th style=\"width:$sutunyuzde%\">$sutunurunadi</th>";
        echo "<th style=\"width:$sutunyuzde%\">Tarih</th>";
        echo "<th style=\"width:$sutunyuzde%\">Toplam</th>";

        /*$sutunbirimadi=$siparisbirim;
        $sutunbirimadi=stristr($sutunbirimadi,'_');
        $sutunbirimadi = ucfirst(ltrim($sutunbirimadi,"_"));//Birim adını aldık örneğin tekpasta_adet -> Adet oldu //ŞİMDİLİK KALSIN BİRİM CİNSİ ZATEN BUTONDA YAZIYOR
        echo "<th style=\"width:$sutunyuzde%\">$sutunbirimadi</th>";*/
        //şube şube o günün değerleri için şube sayısı kadar sütun oluşturuyoruz.

        echo "<th style=\"width:$sutunyuzde%\">$rowsubeliste[kullanici_adi]</th>";//şu anki şubeyi yazdır

        while($rowsubelisteinner=$resultsqlsubeliste->fetch_assoc()){//kalanları döngüyle yazdır
          echo "<th style=\"width:$sutunyuzde%\">$rowsubelisteinner[kullanici_adi]</th>";
        }
        


//USTA
  //echo $sqlurunsiparislistele;
/*if ($resultsiparistoplam = $conn->multi_query($sqlurunsiparislistele) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 
 
 

  //echo $sqlurunsiparislistele;



  do { //DÖNGÜ İÇİNDE YAZDIRACAZ
    // Store first result set
    if ($resultsiparistoplam = $conn->store_result()) {
      while ($rowsiparisliste = $resultsiparistoplam->fetch_row()) {
        //echo $rowpastatoplam[0] . " " . $rowpastatoplam[1] . " " . $rowpastatoplam[2] . " " . $rowpastatoplam[3] . " " . $rowpastatoplam[4] . " ";
        echo "<tr>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[0]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[1]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[2]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[3]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[4]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[5]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[6]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[7]</th>";
        echo "<th style=\"width:$sutunyuzde%\">$rowsiparisliste[8]</th>";
        echo "</tr>";
        //echo $sqlurunsiparislistele;

      }
      $resultsiparistoplam->free_result();
    }
    // if there are more result-sets, the print a divider
    if ($conn->more_results()) {
      //echo "</tr>";
    //echo "<br>";
    }//echo "<br><br>";
    //Prepare next result set
  } while ($conn->next_result());
}*/


//*/USTAA


$sqlsubesube = "SELECT id,kullanici_adi from kullanicilar order by id asc";//DİĞER DÖNGÜLERLE KARIŞMASIN DİYE YENİ ŞUBE LİSTESİ DÖNGÜSÜ HAZIRLADIK. O TARİHE AİT ADET- VERİSİNİ ŞUBE ŞUBE ÇEKECEK
$resultsqlsubesube = $conn->query($sqlsubesube);
$ua="";//html tablo sütunundan ürün adını çekecez şube şube sorguda kullanmak için
$trh="";//html tablo sütunundan tarihi çekecez sorguda kullanacaz
      if($resultsiparistoplam->num_rows>0){echo "OKKK";
        


        while($rowsiparistoplam=$resultsiparistoplam->fetch_assoc()){//echo $rowsiparislistele;
          

          
          echo "<tr>";
          //echo "<th style=\"width:$sutunyuzde%\">uname $rowsiparistoplam[kullanici_adi]</th>";
          echo "<th style=\"width:$sutunyuzde%\">$rowsiparistoplam[$urunadi]</th>";
          $ua=$rowsiparistoplam[$urunadi];
          echo "<th style=\"width:$sutunyuzde%\">$rowsiparistoplam[tarih]</th>";
          $trh=$rowsiparistoplam["tarih"];
          echo "<th style=\"width:$sutunyuzde%\">$rowsiparistoplam[toplam]</th>";

     


          
        }
        
        while($rowsiparistoplamm=$resultsiparistoplamm->fetch_assoc()){
        
          while($rowsubesube=$resultsqlsubesube->fetch_assoc()){//şube şube yazdırmak için tarih ve ürün adı sütunlarını buradan kontrol ediyooruz bu şube döngüsü ile tek tek sorgu ekliyoruz
            $sqlurunsiparislistele.="SELECT $siparisbirim FROM $siparistablo JOIN $uruntablo ON $siparistablo.$urunid=$uruntablo.id JOIN kullanicilar ON $siparistablo.kullanici_id=kullanicilar.id WHERE $urunadi='$rowsiparistoplamm[$urunadi]' and tarih='$rowsiparistoplamm[tarih]' and kullanici_adi='$rowsubesube[kullanici_adi]';";//
          }
        }
        



        if ($conn->multi_query($sqlurunsiparislistele)) {
          do {
            // Store first result set
            if ($resulturunsiparislistele = $conn->store_result()) {
              //while ($rowurunsiparislistele = $resulturunsiparislistele->fetch_row()) {
                $rowurunsiparislistele = $resulturunsiparislistele->fetch_row();
                if($rowurunsiparislistele[0]=="")$rowurunsiparislistele[0]=0;
                echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[0]</th>";
              
               

                /*echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[1]</th>";
                echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[2]</th>";
                echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[3]</th>";
                echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[4]</th>";*/

                //echo "<th style=\"width:$sutunyuzde%\">$rowurunsiparislistele[0]</th>";
                
              //}
              
            }//$resulturunsiparislistele->free_result();
            // if there are more result-sets, the print a divider
            if ($conn->more_results()) {
              echo "MORE RESULTS";
            }
             //Prepare next result set
          } while ($conn->next_result());
        }
        
        
        
        echo "</tr>"; echo $sqlurunsiparislistele;
      }echo "</table>";
    }
    else{
      echo "Sipariş tablosu bulunamadı";  
    }

  }echo $sqlurunsiparislistele;
}
else echo "Şube bulunamadı";      

            //echo $resultsqlsubeliste; // bunda hata verdittiriyir
            echo "test log $rowurunliste[urun_adi] div";
            echo "</div>";
          }
        }
      } else {
        echo "Ürün bulunamadı";
      }

      /*


        //HANGİ ÜRÜNDEYSEK O ÜRÜNÜN SİPARİŞ TABLOSUNU ÖĞRENMEMİZ LAZIM. BUNU DA SİPARİS TABLOSUNDAN URUN ID YE GÖRE ÖĞRENECEĞİZ
        $sqlUrunSprTbBirim="SELECT siparis_adi,birim FROM siparis WHERE urun_id='ÜRÜN AYDİĞ'"; //BURADA HEM ÜRÜNÜN SİPARİŞ TABLOSUNU HEMDE BİRİMİNİ ÖĞRENDİK

        $sqlbirimtoplam="SELECT SUM($sqlUrunSprTbBirim bunun birimi) FROM siparis where tarih= son bir gün ";
        if($secilenzaman=="sonbirgun"){
            $sql_sonbirgun="SELECT tarih toplam şube1birim şube2birim.. ";
        }*/
    }



    ?>