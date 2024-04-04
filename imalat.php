<?php
session_start();
if (!isset($_SESSION["unameimalatpasta"]) && !isset($_SESSION["pswimalatpasta"])) {
  header("Location: login.php");
}


?>


<!DOCTYPE html>
<html>
<title>Pasta İmalat</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-cyan.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo "<script type=\"text/javascript\" src=\"js.js\"></script>"; ?>

<style>
table {

  position:relative;
  
}
@media all {
  .page-break { display: none; }
}

@media print {
  .page-break { display: block; page-break-before: always; }
  .cprint { height: auto !important; }
  
}

</style>

<body>

  <div class="w3-card-4">
    <!-- BU Div buttonlar ve içerikleri çekildikten sonra kapatılacak -->
    <div class="w3-container w3-theme w3-card">
      <h1 class="w3-center">İmalat<br><span class="w3-text-black"><?php echo ucfirst($_SESSION["unameimalatpasta"]); ?></span></h1>
    </div>


    <div class="w3-bar w3-black">
      <a href="imalat.php" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Seçim Yap</a>
      <a href="myorders.php" class="w3-bar-item w3-button w3-mobile w3-border">Siparişler</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
    </div>





    <!-- DROPDOWN FORM-->
    <br>
    <form action="imalat.php" method="POST">
      <label for="zaman">Zaman:</label>

      <select name="zaman" id="zaman" autocomplete="off">

        <option value="secim">Seçim Yapın</option>;
        <option value="sonikigun">Son 2 Gün (Dün ve Bugün)</option>;
        <option value="bugun">Bugün (Sadece Bugün)</option>;
        <option value="sonbirhafta">Son 1 Hafta</option>;
        <option value="buhafta">Bu Hafta</option>;
        <option value="sonbiray">Son 1 Ay</option>;
        <option value="sonbiryil">Son 1 Yıl</option>;

      </select><br><br><input type="submit" value="Siparişleri Getir" onclick="checkboxprint()"></input>
      <input class="checkboxprint" type="checkbox" id="checkboxexpandcollapse" name="expandcheck" value="Tümünü Genişlet" onclick="expandcollapse()" hidden></input>
      <label class="checkboxprint" for="checkboxexpandcollapse" hidden>Tümünü Genişlet/Daralt</label>
      <button onclick="window.print();return false;"><i class="fa fa-print"></i></button>
      
    </form><br>



    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $secilenzaman = $_POST["zaman"];
      if ($secilenzaman != "secim") {
        urunurun($secilenzaman);
        echo "<script>checkboxprint()</script>";
      }
    }





    //SECİLEN ZAMANA GÖRE ÜRÜN ÜRÜN ŞUBE ŞUBE SİPARİŞLERİ GÖSTERİR
    function urunurun($secilenzaman)
    {

      require_once("includes/justdb.php");
      $withoutspace = ""; //div için

      //ÜRÜN ÜRÜN ÇEKECEĞİMİZ İÇİN ÖNCE ÜRÜNLERİ ÜRÜN LİSTESİNİ BAKLAVA HARİÇ ÇEKELİM
      $sqlurunlistesipasta = "SELECT id, urun_adi FROM urunler1 WHERE id<>12 ORDER BY urunler1.id ASC";
      $resultsqlurunlistesi = $conn->query($sqlurunlistesipasta);
      $withoutspace = $rowurunlistesi["urun_adi"]; //WITHOUTSPACE ürün adını boşluksuz bir şekilde accordion için div id'sine verir. Bu div buton için göster gizle
      $withoutspace = str_replace(' ', '', $rowurunlistesi["urun_adi"] . "_div");


      //KULLANICI LİSTESİNİ ÇEKMEK İÇİN SQL KODUNU DA HAZIRLAYALIM
      $sqlsubelistesi = "SELECT id,kullanici_adi from kullanicilar order by id asc";
      $resultsqlsubelistesi = $conn->query($sqlsubelistesi);
      $subesayisi = $resultsqlsubelistesi->num_rows; //SUBE SAYISINI DEĞİŞKENE ATADIK. BUNU TABLOLARDAKİ SÜTUN SAYISINI BELİRLEMEDE KULLANACAĞIZ

      $subearray[$subesayisi];
      while ($rowsubelistesi = $resultsqlsubelistesi->fetch_assoc()) {
        $subearray[] = $rowsubelistesi["id"];
      }

      if ($resultsqlurunlistesi->num_rows > 0) {






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







        while ($rowurunlistesi = $resultsqlurunlistesi->fetch_assoc()) { //ÜRÜNLERİ LİSTELİYORUZ
          //HER ÜRÜN İÇİN ŞUBE ŞUBE DEĞERLERİ OKUYACAĞIMIZ İÇİN ŞUBELERİ DE ÜRÜN DÖNGÜSÜNÜN İÇİNDE DÖNGÜYE ALMAMIZ GEREK

          //EĞER ÜRÜN İD 1 İSE YANİ PASTA İSE BUNU AYRI YAPACAĞIZ SÜTUNLARI FAZLA BUNUN
          if ($rowurunlistesi["id"] == 1) {

            $withoutspace = "PASTA[0][1][2][3]_div";
            //BUTONDA BELİRTMEK İÇİN DROPDOWNDAKİ LİSTEYİ KONTROL EDECEĞİZ
            switch ($secilenzaman) {
              case 'sonikigun':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 2 Gün</button>";
                break;

              case 'sonbirhafta':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Hafta</button>";
                break;

              case 'bugun':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA [0][1][2][3] (ADET) Siparişleri</h2>Bugün</button>";

                break;

              case 'buhafta':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Bu Hafta</button>";
                break;

              case 'sonbiray':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Ay</button>";
                break;


              case 'sonbiryil':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>PASTA[0][1][2][3] (ADET) Siparişleri</h2>Son 1 Yıl</button>";
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
              case 'sonikigun':
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
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) { //BURADAN DEVAAM ET
                    $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 7 DAY ) AND CURDATE();";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 

                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) { //BURADAN DEVAAM ET
                    $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 30 DAY ) AND CURDATE();";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 

                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                  while ($rowpastatablosu = $resultsqlpastatablosu->fetch_assoc()) { //BURADAN DEVAAM ET
                    $sqlpastatoplam .= "SELECT pasta_adi,SUM(boy0),SUM(boy1),SUM(boy2),SUM(boy3) FROM pasta_siparis JOIN pasta ON pasta_siparis.pasta_id=pasta.id WHERE pasta_id=$rowpastatablosu[id] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 YEAR ) AND CURDATE();";
                  } //SQLPASTATOPLAM SORGUSUYLA BÜTÜN PASTA ÇEŞİTLERİNİN TEK TEK HER BOYUN TÜM ŞUBE TOPLAMLARINI ALIYORUZ. SORGU HAZIR
                  //echo $sqlpastatoplam;

                  //sorguyu çalıştıracaz
                  if ($resultpastatoplam = $conn->multi_query($sqlpastatoplam) == TRUE) { //TOPLU SORGUYU PASTA[][] İÇİN ŞUBE TOPLAMLARINI ÇEKTİK 

                    //TOPLAM PASTA SİPARİŞLERİ İÇİN DİV VE TABLO OLUŞUTURABİLİRİZ
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                    echo "<div class=\"w3-hide urundiv\" id=\"PASTA[0][1][2][3]_div\">";
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
                      } //echo "<br><br>";
                      //Prepare next result set
                    } while ($conn->next_result());
                  }
                } //PASTA İÇİN TOPLAMLAR TAMAM SIRA ŞUBE ŞUBE YAZDIRMAADA

                //önce tabloyu sütun sayısını genişliklerini falan ayarlayacaz
                $pastaicinsutunyuzde = round(100 / 7);

                echo "<h6>&nbsp</h6><br>"; //BOŞLUK BIRAKIP TOPLU VE ŞUBE ŞUBE GÖRÜNÜM ARASINA BOŞLUK BIRAKMAK İÇİN



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
                $tarihformat = date_format($tarihformat, "d-m-Y");

                echo "<th style=\"width:$pastaicinsutunyuzde%\">$tarihformat</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[pasta_adi]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy0]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy1]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy2]</th>";
                echo "<th style=\"width:$pastaicinsutunyuzde%\">$rowpasta[boy3]</th>";

                echo "</tr>";
              }
              echo "</tr></table>"; //BU DİV KAPANMASI İLE PASTA[] KISMI BİTER 
            } else {
              echo "Seçilen zamana ait sipariş bulunamadı.";
            }
            echo "</table></div>";echo"<div class=\"page-break\"></div>";
          } else { //ÜRÜN ÜRÜN GİDİYORUZ ŞU AN WHİLE İÇİNDEYİZ URUNLİSTE
            // PASTA[][][][] DIŞINDAKİ DİĞER ÜRÜNLERİ BURADA YAZDIRACAĞIZ

            $withoutspace = str_replace(' ', '', $rowurunlistesi["urun_adi"] . "_div");
            switch ($secilenzaman) {
              case 'sonikigun':
                $zaman = "Son 2 Gün";
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Son 2 Gün</button>";
                break;

              case 'sonbirhafta':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Son 1 Hafta</button>";
                break;

              case 'bugun':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Bugün</button>";

                break;

              case 'buhafta':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Bu Hafta</button>";
                break;

              case 'sonbiray':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Son 1 Ay</button>";
                break;


              case 'sonbiryil':
                echo "<button onclick=\"accordion('$withoutspace')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>$rowurunlistesi[urun_adi]</h2>Son 1 Yıl</button>";
                break;




              default:
                # code...
                break;
            }

            echo "<div class=\"w3-hide w3-orange urundiv\" id=\"$withoutspace\" style=\"\">";
            //HER ÜRÜN BUTONUNA TIKLAYINCA GÖSTERİLİP GİZLENECEK DİV (ÜRÜN ÜRÜMN WHİLEDAYIZ)
            //BU DİVİN İÇİNDE NE OLACAK? HANGİ ÜRÜN HANGİ TARİHTE HANGİ MİKTARDA SİPARİŞ VERİLMİŞ, O TARİHTE BÜTÜN ŞUBELER TOPLAM NE KADAR SİPARİŞ VERMİŞ BUNUN BİLGİSİ OLACAK
            //BUNUN İÇİN HANGİ ÜRÜNÜ KONTROL EDECEĞİMİZ BELLİ, ÜRÜNLER İÇİN WHİLE DÖNGÜSÜ İÇİNDEYİZ ŞUAN (PASTA DISINDAKİ İD)
            //BİZE ÜRÜNÜN SİPARİŞ TABLOSU LAZIM BUNUN İÇİN ÜRÜN İD KULLANARAK SİPARİŞ TABLOSUNDAN BİRİME VE URUN_SİPARİŞ TABLOSUNA ERİŞECEZ, 
            //SONRA O SİPARİŞ TABLOSUNDAN O ÜRÜNÜN BİRİMİNE, HANGİ ŞUBEDEN NE KADAR HANGİ TARİHTE SİPARİŞ VERİLDİĞİNE ULAŞABİLECEĞİZ

            //HER ÜRÜN İÇİN O ÜRÜNÜN SİPARİŞ TABLOSUNA, BİRİMİNE ERİŞELİM,
            $siparistablo = "";
            $birim = "";
            $uruntabloadi = "";
            $urunadi = "";
            $sqlsiparistablo = "SELECT siparis_adi,birim FROM siparis where urun_id=$rowurunlistesi[id]";
            $resultsqlsiparistablo = $conn->query($sqlsiparistablo);
            if ($resultsqlsiparistablo->num_rows == 1) {
              $rowsiparistablo = $resultsqlsiparistablo->fetch_assoc();
              $siparistablo = $rowsiparistablo["siparis_adi"]; //HANGİ ÜRÜNDEYSEK O ÜRÜNÜN SİPARİŞ TABLOSUNU ALDIK (Örnek: tekpasta_siparis) 

              $uruntabloadi = str_replace('_siparis', '', $rowsiparistablo["siparis_adi"]); //ÜRÜNÜN BİRİMİNİN ÇEŞİTLERİNİN OLDUĞU SİPARİŞ OLMAYAN TABLO ADI, (Örnek: pasta, tekpasta, petifurcesit..) 
              //ürünün tablo adını aldıkki ürünün çeşidini belirtmek için bu tablodan veri çekebilelim. (Örnek: tekpasta için  Alman Muzlu)

              $urunadi = $uruntabloadi . "_adi"; // ÜRÜN ADININ SÜTUNU, (Örnek: tekpasta_adi)
            }
            $birimadi = $rowsiparistablo["birim"]; //HANGİ ÜRÜNDEYSEK O ÜRÜNÜN BİRİMİNİ ALDIK (Örnek: tekpasta_adet)

            $urunadi_id = $uruntabloadi . "_id"; //ÜRÜN_SİPARİS TABLOSUNDAKİ ürünadi_id kolonunu alalım, ürünlistesi id ile eşletirebilmek ve zaman aralığı sorgusunda join yapabilmek için
            //ŞU AN Kİ ÜRÜNÜN SİPARİŞ TABLOSUNU BİRİMİNİ ALDIK, HANGİ TARİH ARALIĞINA GÖRE SORGULAMA YAPACACAĞIMIZI BELİRLEMEK İÇİN ÖNCE TARİH ARALIĞINI ÇEKELİM ONA GÖRE CASE OLUŞTURALIM
            switch ($secilenzaman) {
              case 'sonikigun':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Son 2 Gün";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE tarih >= NOW() - INTERVAL 2 DAY GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;

              case 'bugun':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Bugün";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE DAY(tarih) = DAY(CURDATE()) GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;

              case 'sonbirhafta':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Son 1 Hafta";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE tarih >= NOW() - INTERVAL 7 DAY GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;


              case 'buhafta':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Bu Hafta";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE WEEK(tarih) = WEEK(CURDATE()) GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;


              case 'sonbiray':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Son 1 Ay";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE tarih >= NOW() - INTERVAL 1 MONTH GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;


              case 'sonbiryil':

                //urunadi için uruntablo adini join etmemiz lazım. şube için kullanicilar tablosunu join etmemiz lazım
                $zaman = "Son 1 Yıl";
                $sqlsiparisbyaralik = "SELECT $urunadi_id, $urunadi, SUM($birimadi) AS guntoplam, tarih FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE tarih >= NOW() - INTERVAL 1 YEAR GROUP BY tarih,$urunadi_id ORDER BY $urunadi ASC, tarih DESC";
                //BURADA SADECE ürünid, ürünadı, gün toplamını ve tarihi çektik, şube şube sipariş miktarlarını sonra çekeceğiz *** ŞİMDİ ÇEKMEMİZ GEREKİRSE ŞİMDİ ÇEKERİZ BAKACAĞIZ
                break;


              default:
                # code...
                break;
            }
            //echo "Divi görüntüle";
            //TABLOYU HAZIRLAYALIM
            echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered cprint\" style=\"height: 500px; overflow-y: auto;\">";

            //TABLO İÇİN SÜTUN SAYISINI - WIDTH YÜZDESİNİ HESAPLAYALIM,
            $sutunsayisi = $subesayisi + 3; // SÜTUNLAR ÜRÜN ADI, TARİH, TOPLAM VE ŞUBELER
            $sutunyuzdesi = round(100 / $sutunsayisi);

            //TABLONUN BAŞLIK SÜTUNLARINI OLUŞTURALIM // ÜRÜN ADI, TARİH, TOPLAM, VE ŞUBELER
            echo "<tr class=\"w3-brown\" style=\"position: sticky; top:0;\">";
            $baslikurunadi = ucfirst($uruntabloadi . " Adı");
            echo "<th style=\"width:$sutunyuzdesi%\">$baslikurunadi</th>";
            echo "<th style=\"width:$sutunyuzdesi%\">Tarih</th>";
            echo "<th style=\"width:$sutunyuzdesi%\">Toplam</th>";

            $resultsqlsubelistesi = $conn->query($sqlsubelistesi);
            while ($rowsubelistesi = $resultsqlsubelistesi->fetch_assoc()) {
              echo "<th style=\"width:$sutunyuzdesi%\">$rowsubelistesi[kullanici_adi]</th>";
            }
            echo "</tr>";
            //TABLONUN BAŞLIK SÜTUNLARI TAMAM

            //SEÇİlEN ZAMAN ARALIĞINA GÖRE SİPARİŞLERİMİZİ ÇEKECEĞİMİZ SORGUMUZU ÇALIŞTIRALIM
            //echo $sqlsiparisbyaralik;
            $resultsqlsiparisbyaralik = $conn->query($sqlsiparisbyaralik);
            if ($resultsqlsiparisbyaralik->num_rows > 0) {
              while ($rowsiparisbyaralik = $resultsqlsiparisbyaralik->fetch_assoc()) {
                echo "<tr>";
                echo "<th style=\"width:$sutunyuzdesi%\">$rowsiparisbyaralik[$urunadi]</th>";
                $tarihformatli = date('d-m-Y', strtotime($rowsiparisbyaralik["tarih"]));
                echo "<th style=\"width:$sutunyuzdesi%\">$tarihformatli</th>";
                $guntoplam = $rowsiparisbyaralik["guntoplam"];
                $x = strlen($guntoplam);
                if ($x > 14)
                  $guntoplam = round($guntoplam, 2, PHP_ROUND_HALF_UP);
                //$guntoplam=round($guntoplam,1,PHP_ROUND_HALF_UP);
                echo "<th style=\"width:$sutunyuzdesi%\">$guntoplam</th>";

                //ŞİMDİ ŞUBE ŞUBE o gün için tüm sipariş miktarlarını hepsini tek tek alalım


                $sqlsubemiktari = "";

                for ($i = 0; $i < $subesayisi; $i++) {
                  $uid = $subearray[$i]; //echo $uid;

                  $sqlsubemiktari = "SELECT tarih,$birimadi FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id JOIN kullanicilar ON $siparistablo.kullanici_id=kullanicilar.id WHERE tarih='$rowsiparisbyaralik[tarih]' AND $urunadi='$rowsiparisbyaralik[$urunadi]' AND kullanici_id=$uid ORDER BY kullanici_id ASC, tarih DESC;";
                  $resultsqlsubemiktari = $conn->query($sqlsubemiktari);
                  if ($resultsqlsubemiktari->num_rows == 1) {
                    $rowsubemiktari = $resultsqlsubemiktari->fetch_assoc();

                    $miktar = $rowsubemiktari[$birimadi];


                    echo "<th style=\"width:$sutunyuzdesi%\">$miktar</th>";
                  } else
                    echo "<th style=\"width:$sutunyuzdesi%\">0</th>";
                }




                //echo $sqlsubemiktari;







              }
            } else {
              echo "Seçilen zamana ait kayıt bulunamadı";
            }

            echo "</table>"; //EĞER KAYITLAR GELDİYSE TABLOYU DOLDURDUK, TABLOYU KAPATALIM



            //ŞİMDİDE BİR BOŞLUK BIRAKIP GÜN GÜN YERİNE BELİRTİLEN ZAMAN ARALIĞINDA ŞUBE ŞUBE TOPLAMLARI YAZDIRALIM
            //AMA BUNU KAYITLAR GELDİYSE YAPALIM BOŞ BOŞUNA 0 0 0 YAZIP EKRANDA GEREKSİZ YER KAPLAMASIN BURAYI İF İÇİNE ALACAZ

            if($resultsqlsiparisbyaralik->num_rows>0){
              echo "<br>";
            echo "<br>";

            $basliktoplam = ucfirst($uruntabloadi);
            echo "<h2 class=\"w3-center\">Bütün Şubeler $basliktoplam Toplamları</h2>";
            echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered cprint\" style=\"height: 500px; overflow-y: scroll;\">";
            $sutunsayisitoplam = $subesayisi + 3; // SÜTUNLAR ÜRÜN ADI, TARİH, TOPLAM VE ŞUBELER
            $sutunyuzdesitoplam = round(100 / $sutunsayisitoplam);

            //TABLONUN BAŞLIK SÜTUNLARINI OLUŞTURALIM // ÜRÜN ADI, TARİH, TOPLAM, VE ŞUBELER
            echo "<tr class=\"w3-brown\" style=\"position: sticky; top:0;\">";

            echo "<th style=\"width:$sutunyuzdesitoplam%\">$baslikurunadi</th>";
            echo "<th style=\"width:$sutunyuzdesitoplam%\">Zaman</th>";


            $resultsqlsubelistesi = $conn->query($sqlsubelistesi);
            while ($rowsubelistesi = $resultsqlsubelistesi->fetch_assoc()) {
              echo "<th style=\"width:$sutunyuzdesi%\">$rowsubelistesi[kullanici_adi]</th>";
            }
            echo "</tr>";

            //TABLONUN BAŞLIK SÜTUNLARI TAMAM









            //ARALIK



            $sqluruntoplam = "0";
            $sqlaraliktoplam = "SELECT $urunadi FROM $uruntabloadi ORDER BY id ASC"; //echo $sqlaraliktoplam; exit();
            $resultaraliktoplam = $conn->query($sqlaraliktoplam);
            if ($resultaraliktoplam->num_rows > 0) {
              while ($rowaraliktoplam = $resultaraliktoplam->fetch_assoc()) {
                echo "<tr>";
                echo "<th style=\"width:$sutunyuzdesi%\">$rowaraliktoplam[$urunadi]</th>";
                echo "<th style=\"width:$sutunyuzdesi%\">$zaman</th>";
                for ($i = 0; $i < $subesayisi; $i++) {
                  switch ($secilenzaman) {
                    case 'sonikigun':
                      //$sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY $urunadi;";
                      // bakarsın  $sqluruntoplam="SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY $urunadi;";
                      $zaman = "Son 2 Gün";
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;

                    case 'bugun':
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND DAY(tarih) = DAY(CURDATE()) AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;


                    case 'sonbirhafta':
                      //$sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id = $uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY $urunadi;";
                      // bakarsın  $sqluruntoplam="SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY $urunadi;";
                      $zaman = "Son 1 Hafta";
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 7 DAY ) AND CURDATE() AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;


                    case 'buhafta':
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND WEEK(tarih) = WEEK(CURDATE()) AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;


                    case 'sonbiray':
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 MONTH ) AND CURDATE() AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;


                    case 'sonbiryil':
                      $sqluruntoplam = "SELECT $urunadi, SUM($birimadi) AS Toplam FROM $siparistablo JOIN $uruntabloadi ON $siparistablo.$urunadi_id=$uruntabloadi.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 YEAR ) AND CURDATE() AND $urunadi='$rowaraliktoplam[$urunadi]'";
                      break;


                    default:
                      # code...
                      break;
                  }
                  //echo $sqluruntoplam;

                  $resulturuntoplam = $conn->query($sqluruntoplam); //echo $sqluruntoplam;
                  if ($resulturuntoplam->num_rows > 0) {
                    $rowuruntoplam = $resulturuntoplam->fetch_assoc();
                    $toplam = $rowuruntoplam["Toplam"];
                    $y = strlen($toplam);
                    if ($y > 14)
                      $toplam = round($toplam, 2, PHP_ROUND_HALF_UP);
                    if ($toplam == "") $toplam = 0;
                    echo "<th style=\"width:$sutunyuzdesitoplam%\">$toplam</th>";
                  }
                  //else echo "<th style=\"width:$sutunyuzdesitoplam%\">0</th>";
                }
                echo "</tr>";
              }


              //echo "<br><br>".$sqlaralik;









            }
            echo "</tr>";

            echo "</table>";
            }



            echo "</div>"; //GÖSTER GİZLE DİVİ KAPANIŞ
            echo"<div class=\"page-break\"></div>";


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
