<?php
require_once("getproductforms.php");
require_once("orderfuncs.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
  header("Location: login.php");
}

function pastaForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $pastasiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM pasta ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $pastaformdiv = "<form action=\"pastapost.php\" method=\"POST\" name=\"pastaform\">"; //ÜRÜNSİPARİŞ.PHP ACTIONU DEĞİŞTİRMEYİ UNUTMA
    $pastaformdiv = $pastaformdiv . "<div class=\"w3-hide\" id=\"PASTA[0][1][2][3]_div\">"; //HER ÜRÜNDE DİVİN ID SİNİ GİRİYORUZ. BU, VERİTABANI TABLOSUNDAKİ ADIN BOŞLUKLARI SİLİNMİŞ HALİ ($whitoutspace))

    while ($row = $result->fetch_assoc()) {
      $pastaformdiv = $pastaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 52%;\">$row[pasta_adi]</label>";

      for ($i = 0; $i < 4; $i++) {

        $pastaformdiv = $pastaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_pastaboy$i\"  placeholder=\"[$i]\" style=\"width: 12%;\">";
        // PASTAID_PASTABOYUNU İÇEREN İNPUTLAR OLUŞTURUYORUZ. 
      }
    }
    if (checkalreadydate(1)) $pastasiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Pasta [0][1][2][3]</b> Siparişleri gönderildi. ";
    else $pastasiparisdurumu = "";
    $pastaformdiv = $pastaformdiv . "<br><input type=\"submit\" value=\"Pasta Sipariş Ver\"></div><section class=\"w3-center\">$pastasiparisdurumu</section></form>";
    echo $pastaformdiv;
  } else {
    echo "Hata";
  }
  //$conn->close();
}


function tekPastaForm()

{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $tekpastasiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM tekpasta ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $tekpastaformdiv = "<form action=\"tekpastapost.php\" method=\"POST\" name=\"tekpastaform\">";
    $tekpastaformdiv .= "<div class=\"w3-hide\" id=\"TEKPASTA(ADET)_div\">";


    while ($row = $result->fetch_assoc()) {
      $tekpastaformdiv = $tekpastaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[tekpasta_adi]</label>";


      $tekpastaformdiv = $tekpastaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_tekpasta\" placeholder=\"Adet\" style=\"width: 35%;\">";
    }
    //$tekpastaformdiv = $tekpastaformdiv . "</div>";
    if (checkalreadydate(2)) $tekpastasiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Tek Pasta (Adet)</b> Siparişleri gönderildi. ";
    else $tekpastasiparisdurumu = "";
    $tekpastaformdiv = $tekpastaformdiv . "<br><input type=\"submit\" value=\"Tek Pasta Sipariş Ver\"></div><section class=\"w3-center\">$tekpastasiparisdurumu</section></form>";
    echo $tekpastaformdiv;
  } else {
    echo "Tek Pasta bulunamadı";
  }
  $conn->close();
}


function petifurcesitForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $petifurcesitsiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM petifurcesit ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $petifurcesitformdiv = "<form action=\"petifurcesitpost.php\" method=\"POST\" name=\"petifurcesitform\">";
    $petifurcesitformdiv .= "<div class=\"w3-hide\" id=\"PETİFÜRÇEŞİT(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $petifurcesitformdiv = $petifurcesitformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[petifurcesit_adi]</label>";


      $petifurcesitformdiv = $petifurcesitformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_petifurcesit\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$petifurcesitformdiv = $petifurcesitformdiv . "</div>";
    if (checkalreadydate(3)) $petifurcesitsiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Petifür Çeşit</b> Siparişleri gönderildi. ";
    else $petifurcesitsiparisdurumu = "";
    $petifurcesitformdiv = $petifurcesitformdiv . "<br><input type=\"submit\" value=\"Petifür Çeşit Sipariş Ver\"></div><section class=\"w3-center\">$petifurcesitsiparisdurumu</section></form>";
    echo $petifurcesitformdiv;
  } else {
    echo "Petifür Çeşit bulunamadı";
  }
  $conn->close();
}


function figurlutekForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $figurluteksiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM figurlutek ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $figurlutekformdiv = "<form action=\"figurlutekpost.php\" method=\"POST\" name=\"figurlutekform\">";
    $figurlutekformdiv .= "<div class=\"w3-hide\" id=\"FİGÜRLÜTEK(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $figurlutekformdiv = $figurlutekformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[figurlutek_adi]</label>";


      $figurlutekformdiv = $figurlutekformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_figurlutek\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$figurlutekformdiv = $figurlutekformdiv . "</div>";
    if (checkalreadydate(4)) $figurluteksiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Figürlü Tek</b> Siparişleri gönderildi. ";
    else $figurluteksiparisdurumu = "";
    $figurlutekformdiv = $figurlutekformdiv . "<br><input type=\"submit\" value=\"Figürlü Tek Sipariş Ver\"></div><section class=\"w3-center\">$figurluteksiparisdurumu</section></form>";
    echo $figurlutekformdiv;
  } else {
    echo "Figürlü Tek bulunamadı";
  }
  $conn->close();
}

function sutluTatliForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $sutlutatlisiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM sutlutatli ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $sutlutatliformdiv = "<form action=\"sutlutatlipost.php\" method=\"POST\" name=\"sutlutatliform\">";
    $sutlutatliformdiv .= "<div class=\"w3-hide\" id=\"SÜTLÜTATLI(ADET)_div\">";


    while ($row = $result->fetch_assoc()) {
      $sutlutatliformdiv = $sutlutatliformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[sutlutatli_adi]</label>";


      $sutlutatliformdiv = $sutlutatliformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_sutlutatli\" placeholder=\"Adet\" style=\"width: 35%;\">";
    }
    //$sutlutatliformdiv = $sutlutatliformdiv . "</div>";
    if (checkalreadydate(5)) $sutlutatlisiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Sütlü Tatlı (Adet)</b> Siparişleri gönderildi. ";
    else $sutlutatlisiparisdurumu = "";
    $sutlutatliformdiv = $sutlutatliformdiv . "<br><input type=\"submit\" value=\"Sütlü Tatlı Sipariş Ver\"></div><section class=\"w3-center\">$sutlutatlisiparisdurumu</section></form>";
    echo $sutlutatliformdiv;
  } else {
    echo "Sütlü Tatlı bulunamadı";
  }
  $conn->close();
}

function adetlerForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $adetlersiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM adetler ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $adetlerformdiv = "<form action=\"adetlerpost.php\" method=\"POST\" name=\"adetlerform\">";
    $adetlerformdiv .= "<div class=\"w3-hide\" id=\"ADETLER_div\">";


    while ($row = $result->fetch_assoc()) {
      $adetlerformdiv = $adetlerformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[adetler_adi]</label>";


      $adetlerformdiv = $adetlerformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_adetler\" placeholder=\"Adet\" style=\"width: 35%;\">";
    }
    //$adetlerformdiv = $adetlerformdiv . "</div>";
    if (checkalreadydate(6)) $adetlersiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Adetler</b> Siparişi gönderildi. ";
    else $adetlersiparisdurumu = "";
    $adetlerformdiv = $adetlerformdiv . "<br><input type=\"submit\" value=\"Adetler Sipariş Ver\"></div><section class=\"w3-center\">$adetlersiparisdurumu</section></form>";
    echo $adetlerformdiv;
  } else {
    echo "Adetler bulunamadı";
  }
  $conn->close();
}
function pogacaForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $pogacasiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM pogaca ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $pogacaformdiv = "<form action=\"pogacapost.php\" method=\"POST\" name=\"Poğaçaform\">";
    $pogacaformdiv .= "<div class=\"w3-hide\" id=\"POĞAÇA(ADET)_div\">";


    while ($row = $result->fetch_assoc()) {
      $pogacaformdiv = $pogacaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[pogaca_adi]</label>";


      $pogacaformdiv = $pogacaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_pogaca\" placeholder=\"Adet\" style=\"width: 35%;\">";
    }
    //$pogacaformdiv = $pogacaformdiv . "</div>";
    if (checkalreadydate(7)) $pogacasiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Poğaça (Adet)</b> Siparişleri gönderildi. ";
    else $pogacasiparisdurumu = "";
    $pogacaformdiv = $pogacaformdiv . "<br><input type=\"submit\" value=\"Poğaça Sipariş Ver\"></div><section class=\"w3-center\">$pogacasiparisdurumu</section></form>";
    echo $pogacaformdiv;
  } else {
    echo "Poğaça bulunamadı";
  }
  $conn->close();
}
function dondurmaForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $dondurmasiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM dondurma ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $dondurmaformdiv = "<form action=\"dondurmapost.php\" method=\"POST\" name=\"dondurmaform\">";
    $dondurmaformdiv .= "<div class=\"w3-hide\" id=\"DONDURMA(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $dondurmaformdiv = $dondurmaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[dondurma_adi]</label>";


      $dondurmaformdiv = $dondurmaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_dondurma\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$dondurmaformdiv = $dondurmaformdiv . "</div>";
    if (checkalreadydate(8)) $dondurmasiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Dondurma</b> Siparişleri gönderildi. ";
    else $dondurmasiparisdurumu = "";
    $dondurmaformdiv = $dondurmaformdiv . "<br><input type=\"submit\" value=\"Dondurma Sipariş Ver\"></div><section class=\"w3-center\">$dondurmasiparisdurumu</section></form>";
    echo $dondurmaformdiv;
  } else {
    echo "Dondurma bulunamadı";
  }
  $conn->close();
}

function tzkurabiyeForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $tzkurabiyesiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM tzkurabiye ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $tzkurabiyeFormdiv = "<form action=\"tzkurabiyepost.php\" method=\"POST\" name=\"tzkurabiyeform\">";
    $tzkurabiyeFormdiv .= "<div class=\"w3-hide\" id=\"KURABİYETUZLU(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $tzkurabiyeFormdiv = $tzkurabiyeFormdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[tzkurabiye_adi]</label>";


      $tzkurabiyeFormdiv = $tzkurabiyeFormdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_tzkurabiye\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$tzkurabiyeFormdiv = $tzkurabiyeFormdiv . "</div>";
    if (checkalreadydate(9)) $tzkurabiyesiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Tuzlu Kurabiye</b> Siparişleri gönderildi. ";
    else $tzkurabiyesiparisdurumu = "";
    $tzkurabiyeFormdiv = $tzkurabiyeFormdiv . "<br><input type=\"submit\" value=\"Tuzlu Kurabiye Sipariş Ver\"></div><section class=\"w3-center\">$tzkurabiyesiparisdurumu</section></form>";
    echo $tzkurabiyeFormdiv;
  } else {
    echo "Tuzlu Kurabiye bulunamadı";
  }
  $conn->close();
}

function ttKurabiyeForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $ttkurabiyesiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM ttkurabiye ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $ttkurabiyeFormdiv = "<form action=\"ttkurabiyepost.php\" method=\"POST\" name=\"ttkurabiyeform\">";
    $ttkurabiyeFormdiv .= "<div class=\"w3-hide\" id=\"KURABİYETATLI(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $ttkurabiyeFormdiv = $ttkurabiyeFormdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[ttkurabiye_adi]</label>";


      $ttkurabiyeFormdiv = $ttkurabiyeFormdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_ttkurabiye\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$ttkurabiyeFormdiv = $ttkurabiyeFormdiv . "</div>";
    if (checkalreadydate(10)) $ttkurabiyesiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Tatlı Kurabiye</b> Siparişleri gönderildi. ";
    else $ttkurabiyesiparisdurumu = "";
    $ttkurabiyeFormdiv = $ttkurabiyeFormdiv . "<br><input type=\"submit\" value=\"Tatlı Kurabiye Sipariş Ver\"></div><section class=\"w3-center\">$ttkurabiyesiparisdurumu</section></form>";
    echo $ttkurabiyeFormdiv;
  } else {
    echo "Tatlı Kurabiye bulunamadı";
  }
  $conn->close();
}

function paketUrunlerForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $paketurunlersiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM paketurunler ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $paketurunlerFormdiv = "<form action=\"paketurunlerpost.php\" method=\"POST\" name=\"paketurunlerform\">";
    $paketurunlerFormdiv .= "<div class=\"w3-hide\" id=\"PAKETÜRÜNLER(KG)_div\">";


    while ($row = $result->fetch_assoc()) {
      $paketurunlerFormdiv = $paketurunlerFormdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[paketurunler_adi]</label>";


      $paketurunlerFormdiv = $paketurunlerFormdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" step=\"0.01\" min=\"0\" name=\"$row[id]_paketurunler\" placeholder=\"KG\" style=\"width: 35%;\">";
    }
    //$paketurunlerFormdiv = $paketurunlerFormdiv . "</div>";
    if (checkalreadydate(11)) $paketurunlersiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Paket Ürünler</b> Siparişleri gönderildi. ";
    else $paketurunlersiparisdurumu = "";
    $paketurunlerFormdiv = $paketurunlerFormdiv . "<br><input type=\"submit\" value=\"Paket Ürünler Sipariş Ver\"></div><section class=\"w3-center\">$paketurunlersiparisdurumu</section></form>";
    echo $paketurunlerFormdiv;
  } else {
    echo "Paket Ürünler bulunamadı";
  }
  $conn->close();
}


function baklavaForm()
{
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "testdb";

  $baklavasiparisdurumu = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM baklava ORDER BY id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $baklavaformdiv = "<form action=\"baklavapost.php\" method=\"POST\" name=\"baklavaform\">";
    $baklavaformdiv .= "<div class=\"w3-hide\" id=\"BAKLAVA(TEPSİ)_div\">";

    while ($row = $result->fetch_assoc()) {
      $baklavaformdiv = $baklavaformdiv . "<label class=\"w3-cell w3-quarter w3-input w3-quarter\" style=\"width: 65%;\">$row[baklava_adi]</label>";


      $baklavaformdiv = $baklavaformdiv . "<input class=\"w3-input w3-border w3-cell w3-quarter\" type=\"number\" min=\"0\" name=\"$row[id]_baklava\" placeholder=\"Tepsi\" style=\"width: 35%;\">";
    }
    //$baklavaformdiv = $baklavaformdiv . "</div>";
    if (checkalreadydate(12)) $baklavasiparisdurumu = "  Bugün için " . ucfirst($_SESSION["uname"]) . "  <b>Baklava (Tepsi)</b> Siparişleri gönderildi. ";
    else $baklavasiparisdurumu = "";
    $baklavaformdiv = $baklavaformdiv . "<br><input type=\"submit\" value=\"Baklava Sipariş Ver\"></div><section class=\"w3-center\">$baklavasiparisdurumu</section></form>";
    echo $baklavaformdiv;
  } else {
    echo "Baklava bulunamadı";
  }
  $conn->close();
}
