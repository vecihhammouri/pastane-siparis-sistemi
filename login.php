<?php
require_once("includes/config.php");


if (isset($_SESSION["uname"]) && isset($_SESSION["psw"])) {  //ZATEN GİRİŞ YAPILMIŞSA ORDER EKRANINA YÖNLENDİR
  header("Location: order.php");
}
if (isset($_SESSION["unameimalatpasta"]) && isset($_SESSION["pswimalatpasta"])) {  //ZATEN GİRİŞ YAPILMIŞSA İMALAT EKRANINA YÖNLENDİR
  header("Location: imalat.php");
}


$whichErr="";
if (isset($_SESSION["radiosecim"])) { //KULLANICI İMALAT MI ŞUBE Mİ SEÇİLMEDİYSE HATA MESAJI YAZSIN
  $whichErr = "Kullanıcı seçimi yapın";
  unset($_SESSION['radiosecim']);
}

//HATALI KULLANICI ADI YA DA PAROLA GİRİLDİYSE LOGİN DİVİNDE HATA MESAJI YAZSIN
$wrongErr = "";
if (isset($_SESSION["yanlis"])) {
  $wrongErr = "Hatalı kullanıcı adı ya da parola girdiniz";
  unset($_SESSION['yanlis']);
}



$nameErr = $reguserErr = $regpassErr1 = $regpassErr2 = $adressErr = $telErr = "";
$name = $regusr = $regpsw1 = $regpsw2 = $regadress = $regtel;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["reguser"])) {
    $nameErr = "Kullanıcı adınızı girin";
  } else {
    $name = test_input($_POST["reguser"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-'0-9]*$/", $name)) {
      $nameErr = "Sadece harf ve sayı kullanabilirsiniz";
    }
  }


  if (strcmp($_POST["regpass1"], $_POST["regpass2"]) != 0) {
    $regpassErr1 = "Parolalar eşleşmiyor";
  }
}
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>
<title>Bayi Sipariş Sistemi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
  .error {
    color: #FF0000;
  }
</style>

<body>

  <div class="w3-container">
    <div class="w3-display-middle w3-center">
      <h2>Bayi Sipariş Sistemi</h2>
      <button onclick="document.getElementById('login').style.display='block'" class="w3-button w3-green w3-large w3-margin-top">Giriş Yap</button>

    </div>


    <div id="login" class="w3-modal">
      <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

        <div class="w3-center"><br>
          <span onclick="document.getElementById('login').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Kapat">&times;</span>
          <img src="images/logo.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
        </div>

        <form class="w3-container" action="check.php" method="POST" name="loginform">
          <div class="w3-section">
            <label><b>Kullanıcı Adı</b></label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Kullanıcı Adınızı Girin" name="user" value="<?php echo $user; ?>" required>
            <label><b>Parola</b></label>
            <input class="w3-input w3-border" type="password" placeholder="Parolanızı Girin" name="pass" required><br>
            <div class="w3-center">
              <input class="w3-radio" type="radio" name="whichuser" value="bayi" checked required >
              <label class="w3-margin-right">Bayi</label>
              <input class="w3-radio w3-margin-left" type="radio" name="whichuser" value="imalatpasta" required > 
              <label>Pasta İmalat</label>
              <input class="w3-radio w3-margin-left" type="radio" name="whichuser" value="imalatbaklava" required > 
              <label>Baklava İmalat</label>
              <br>
            </div><span class="error"> <?php echo $whichErr; ?></span>
            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Giriş Yap</button><span class="error"> <?php echo $wrongErr; ?></span>
          </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
          <button onclick="document.getElementById('login').style.display='none'" type="button" class="w3-button w3-red">Kapat</button>
        </div>

      </div>
    </div>





    <?php



    if (strlen($wrongErr)>0 || strlen($whichErr)>0) { //EĞER LOGİN OLURKEN YANLIŞ KULLANICI ADI ŞİFRE GİRİLDİYSE LOGİN DİVİNİ AÇSIN

      echo " 
  <script>
  document.getElementById(\"login\").style.display = \"block\";
  </script>";
    }









    ?>


  </div>
  <!--<script type="text/javascript">
    document.getElementById('login').style.display = 'block';!
  </script>-->
</body>

</html>