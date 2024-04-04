<?php
session_start();
if (!isset($_SESSION["unameimalatbaklava"]) && !isset($_SESSION["pswimalatbaklava"])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
<title>Baklava İmalat</title>
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
            <h1 class="w3-center">İmalat<br><span class="w3-text-black"><?php echo ucfirst($_SESSION["unameimalatbaklava"]); ?></span></h1>
        </div>

        <div class="w3-bar w3-black">
            <a href="imalatbaklava.php" class="w3-bar-item w3-button w3-mobile w3-sand w3-border">Seçim Yap</a>
            <a href="logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-border">Çıkış Yap</a>
        </div>

        <!-- DROPDOWN FORM-->
        <br>
        <form action="imalatbaklava.php" method="POST">
            <label for="zaman">Zaman:</label>

            <select name="zaman" id="zaman" autocomplete="off">

                <option value="secim">Seçim Yapın</option>;
                <option value="sonikigun">Son 2 Gün (Dün ve Bugün)</option>;
                <option value="bugun">Bugün (Sadece Bugün)</option>;
                <option value="sonbirhafta">Son 1 Hafta</option>;
                <option value="buhafta">Bu Hafta</option>;
                <option value="sonbiray">Son 1 Ay</option>;
                <option value="sonbiryil">Son 1 Yıl</option>;

            </select><br><br><input type="submit" value="Siparişleri Getir"></input>
            <button onclick="window.print();return false;"><i class="fa fa-print"></i></button>
        </form><br>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $secilenzaman = $_POST["zaman"];
            if ($secilenzaman != "secim") {
                getBaklavaSiparis($secilenzaman);
            }
        }

        function getBaklavaListesi() //rowbaklavalistesi döndürür
        {
            require_once("includes/justdb.php");
            $sqlbaklavalistesi = "SELECT id, baklava_adi FROM baklava ORDER BY id ASC";
            $resultbaklavalistesi = $conn->query($sqlbaklavalistesi);
            if ($resultbaklavalistesi->num_rows > 0) {
                $rowbaklavalistesi = $resultbaklavalistesi->fetch_assoc();
                return $rowbaklavalistesi;
            } else {
                echo "Baklava bulunamadı";
            }
        }

        function getBaklavaSiparis($secilenzaman)
        {
            require_once("includes/justdb.php");
            $baklavadiv = "BAKLAVA(TEPSİ)_div";
            $zaman = ""; // TABLODA ZAMAN ARALIĞINI GÖRÜNTÜLEYEBİLMEK İÇİN SEÇİLEN ZAMANI DEĞİŞKENE DÜZGÜN KELİME İLE KAYIT EDECEĞİZ
            //BUTONU OLUŞTURALIM
            switch ($secilenzaman) {
                case 'sonikigun':
                    $zaman = "Son 2 Gün";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Son 2 Gün</button>";
                    break;

                case 'sonbirhafta':
                    $zaman = "Son 1 Hafta";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Son 1 Hafta</button>";
                    break;

                case 'bugun':
                    $zaman = "Bugün";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Bugün</button>";

                    break;

                case 'buhafta':
                    $zaman = "Bu Hafta";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Bu Hafta</button>";
                    break;

                case 'sonbiray':
                    $zaman = "Son 1 Ay";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Son 1 Ay</button>";
                    break;


                case 'sonbiryil':
                    $zaman = "Son 1 Yıl";
                    echo "<button onclick=\"accordion('$baklavadiv')\" class=\"w3-button w3-block w3-theme-l1 w3-left-align w3-border w3-responsive w3-margin-bottom\"><h2>BAKLAVA (TEPSİ)</h2>Son 1 Yıl</button>";
                    break;

                default:
                    # code...
                    break;
            }

            //SEÇİLEN ZAMANA GÖRE BUTONU OLUŞTURDUK, ŞİMDİ SIRA BUTONA TIKLAYINCA GÖSTERİLİP GİZLENEN DİVDE

            echo "<div class=\"w3-hide w3-ambe\" id=\"$baklavadiv\" style=\"\">";

            // SEÇİLEN ZAMAN ARALIĞINA GÖRE TARİH TARİH ÜRÜN-ŞUBE TOPLARIMINI GETİRELİM, SEÇİLEN ZAMANA GÖRE SQL KOMUTLARIMIZI YAZALIM

            switch ($secilenzaman) {
                case 'sonikigun':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE tarih >= NOW() - INTERVAL 2 DAY GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;

                case 'bugun':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE DAY(tarih) = DAY(CURDATE()) GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;


                case 'sonbirhafta':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE tarih >= NOW() - INTERVAL 7 DAY GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;


                case 'buhafta':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE WEEK(tarih) = WEEK(CURDATE()) GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;


                case 'sonbiray':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE tarih >= NOW() - INTERVAL 1 MONTH GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;


                case 'sonbiryil':
                    $sqlsiparisbyaralik = "SELECT baklava_adi, SUM(baklava_tepsi) as guntoplam, tarih FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE tarih >= NOW() - INTERVAL 1 YEAR GROUP BY tarih,baklava_adi ORDER BY baklava_id ASC, tarih DESC";
                    break;


                default:
                    echo "Geçersiz Seçim";
                    break;
            } //BURADA sqlsiparisbyaralik sadece baklava adı, o gün için şubeler tepsi toplamı ve tarih bilgisini içieriyor, her şube o gün için kaç tepsi burada yok, ayrı çekeceğiz onları

            echo "<div class=\"w3-amber\">";
            //TABLOYU HAZIRLAYALIM
            echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered w3-theme-l3 w3-striped w3-bordered cprint\" style=\"height: 500px; overflow-y: auto;\">";


            //TABLO İÇİN SÜTUN SAYISINI - WIDTH YÜZDESİNİ HESAPLAYALIM,

            $subesayisi = 0;
            $sqlsubelistesi = "SELECT id,kullanici_adi FROM kullanicilar ORDER BY id ASC";
            $resultsubelistesi = $conn->query($sqlsubelistesi);
            if ($resultsubelistesi->num_rows > 0) {

                $subesayisi = $resultsubelistesi->num_rows;
            }


            $sutunsayisi = $subesayisi + 3; // SÜTUNLAR ÜRÜN ADI, TARİH, TOPLAM VE ŞUBELER
            $sutunyuzdesi = round(100 / $sutunsayisi); //TABLO İÇİN SÜTUN SAYISINI - WIDTH YÜZDESİNİ HESAPLADIK

            //TABLONUN BAŞLIK SÜTUNLARINI OLUŞTURALIM // Baklava ADI, TARİH, TOPLAM, VE ŞUBELER
            echo "<tr id=\"wrap\" class=\"w3-brown\" style=\"position: sticky; top:0;\">";
            echo "<th style=\"width:$sutunyuzdesi%\">Baklava Adı</th>";
            echo "<th style=\"width:$sutunyuzdesi%\">Tarih</th>";
            echo "<th style=\"width:$sutunyuzdesi%\">Toplam</th>";

            //TABLONUN BAŞLIKLARINA ŞUBELERİ EKLEMEMİZ LAZIM KAÇ ŞUBE OLDUĞUNU TEK TEK EKLEMEK YERİNE VERİTABANINDAN ÇEKELİM BELKİ İLERİDE ŞUBE EKLENİR  
            if ($resultsubelistesi->num_rows > 0) {
                //echo "OK";
                $subearray[$subesayisi];
                while ($rowsubelistesi = $resultsubelistesi->fetch_assoc()) { //HEM ŞUBE ADLARINI TABLO BAŞLIĞINA EKLİYORUZ HEM DE ŞUBE İD LERİ ŞUBEARRAY DİZİSİNE ATIYORUZ
                    echo "<th style=\"width:$sutunyuzdesi%\">$rowsubelistesi[kullanici_adi]</th>";
                    $subearray[] = $rowsubelistesi["id"];
                }
            }
            echo "</tr>";
            //TARİH TARİH TABLOSUNUN BAŞLIKLIAR HAZIR


            //SEÇİlEN ZAMAN ARALIĞINA GÖRE SİPARİŞLERİMİZİ ÇEKECEĞİMİZ SORGUMUZU ÇALIŞTIRALIM
            //$sqlsiparisbyaralik;

            $resultsqlsiparisbyaralik = $conn->query($sqlsiparisbyaralik);
            if ($resultsqlsiparisbyaralik->num_rows > 0) {
                while ($rowsiparisbyaralik = $resultsqlsiparisbyaralik->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th style=\"width:$sutunyuzdesi%\">$rowsiparisbyaralik[baklava_adi]</th>";
                    $tarihformatli = date('d-m-Y', strtotime($rowsiparisbyaralik["tarih"]));
                    echo "<th style=\"width:$sutunyuzdesi%\">$tarihformatli</th>";
                    echo "<th style=\"width:$sutunyuzdesi%\">$rowsiparisbyaralik[guntoplam]</th>";


                    //ŞİMDİ ŞUBE ŞUBE o gün için tüm sipariş miktarlarını hepsini tek tek alalım


                    for ($i = 0; $i < $subesayisi; $i++) {
                        $uid = $subearray[$i];
                        //$sql="SELECT tarih,baklava_tepsi FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id = baklava.id JOIN kullanicilar ON baklava_siparis.kullanici_id=kullanicilar.id WHERE tarih='2021-06-30' AND baklava_adi='Fıstıklı Bak.' AND kullanici_id=1 ORDER BY kullanici_id ASC, tarih DESC";
                        $sqlsubemiktari = "SELECT tarih,baklava_tepsi FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id = baklava.id JOIN kullanicilar ON baklava_siparis.kullanici_id=kullanicilar.id WHERE tarih='$rowsiparisbyaralik[tarih]' AND baklava_adi='$rowsiparisbyaralik[baklava_adi]' AND kullanici_id=$uid ORDER BY kullanici_id ASC, tarih DESC;";
                        //echo $sqlsubemiktari."<br>";
                        $resultsqlsubemiktari = $conn->query($sqlsubemiktari);
                        if ($resultsqlsubemiktari->num_rows == 1) {
                            $rowsubemiktari = $resultsqlsubemiktari->fetch_assoc();

                            $miktar = $rowsubemiktari["baklava_tepsi"];

                            echo "<th style=\"width:$sutunyuzdesi%\">$miktar</th>";
                        } else
                            echo "<th style=\"width:$sutunyuzdesi%\">0</th>";
                    }
                }
            }

            echo "</table>";echo "</div>"; //EĞER KAYITLAR GELDİYSE TABLOYU DOLDURDUK, TABLOYU KAPATALIM
            //ŞİMDİDE BİR BOŞLUK BIRAKIP GÜN GÜN YERİNE BELİRTİLEN ZAMAN ARALIĞINDA ŞUBE ŞUBE TOPLAMLARI YAZDIRALIM

            echo "<br>";
            echo "<br>";

            echo "<h2 class=\"w3-center\">Bütün Şubeler Baklava Toplamları</h2>";


            echo "<div class=\"w3-amber\">";
            echo "<table class=\"w3-table w3-bordered w3-hoverable w3-mobile w3-responsive w3-centered cprint\" style=\"height: 500px; overflow-y: auto;\">";
            //TABLONUN BAŞLIK SÜTUNLARINI OLUŞTURALIM // ÜRÜN ADI, TARİH, TOPLAM, VE ŞUBELER

            echo "<tr class=\"w3-brown\" style=\"position: sticky; top:0;\">";

            echo "<th style=\"width:$sutunyuzdesi%\">Baklava Adı</th>";
            echo "<th style=\"width:$sutunyuzdesi%\">Zaman</th>";

            $resultsqlsubelistesi = $conn->query($sqlsubelistesi);
            if ($resultsqlsubelistesi->num_rows > 0) {
                while ($rowsubelistesi = $resultsqlsubelistesi->fetch_assoc()) {
                    echo "<th style=\"width:$sutunyuzdesi%\">$rowsubelistesi[kullanici_adi]</th>";
                }
            }

            echo "</tr>";

            $sqlbaklavalistesi = "SELECT id, baklava_adi FROM baklava ORDER BY id ASC";
            $resultbaklavalistesi = $conn->query($sqlbaklavalistesi);
            if ($resultbaklavalistesi->num_rows > 0) {
                while ($rowbaklavalistesi = $resultbaklavalistesi->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th style=\"width:$sutunyuzdesi%\">$rowbaklavalistesi[baklava_adi]</th>";
                    echo "<th style=\"width:$sutunyuzdesi%\">$zaman</th>";
                    for($i=0;$i<$subesayisi;$i++){
                        switch ($secilenzaman) {
                            case 'sonikigun':
                              //$sqlbaklavatoplam = "SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id = baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY baklava_adi;";
                              // bakarsın  $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY baklava_adi;";
                              $zaman="Dün ve Bugün";
                              $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                             break;
                    
                            case 'bugun':
                                
                              $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND DAY(tarih) = DAY(CURDATE()) AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                              break;
                    
                    
                              case 'sonbirhafta':
                                //$sqlbaklavatoplam = "SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id = baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY baklava_adi;";
                                // bakarsın  $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 2 DAY ) AND CURDATE() GROUP BY baklava_adi;";
                                $zaman="Son 1 Hafta";
                                $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 7 DAY ) AND CURDATE() AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                               break;
                      
                    
                            case 'buhafta':
                              $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND WEEK(tarih) = WEEK(CURDATE()) AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                              break;
                    
                    
                            case 'sonbiray':
                              $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 MONTH ) AND CURDATE() AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                              break;
                    
                    
                              case 'sonbiryil':
                                $sqlbaklavatoplam="SELECT baklava_adi, SUM(baklava_tepsi) AS Toplam FROM baklava_siparis JOIN baklava ON baklava_siparis.baklava_id=baklava.id WHERE kullanici_id=$subearray[$i] AND tarih BETWEEN DATE_SUB( CURDATE() ,INTERVAL 1 YEAR ) AND CURDATE() AND baklava_adi='$rowbaklavalistesi[baklava_adi]'";
                                break;
                      
                    
                            default:
                              # code...
                              break;
                          }

                          $resultbaklavatoplam=$conn->query($sqlbaklavatoplam);
                          if($resultbaklavatoplam->num_rows>0){
                              while($rowbaklavatoplam=$resultbaklavatoplam->fetch_assoc()){
                                  $toplam=$rowbaklavatoplam["Toplam"];
                                  if($toplam=="")$toplam=0;
                                  echo "<th style=\"width:$sutunyuzdesitoplam%\">$toplam</th>";
                              }

                          }//else echo "<th style=\"width:$sutunyuzdesitoplam%\">0</th>";
                    }
                }
            } else {
                echo "Baklava bulunamadı";
            }

            echo "</div>"; //baklava divi kapanışı
        }
?>
<script>

document.getElementById("wrap").addEventListener("scroll", function(){
   var translate = "translate(0,"+this.scrollTop+"px)";
   this.querySelector("thead").style.transform = translate;
});
</script>