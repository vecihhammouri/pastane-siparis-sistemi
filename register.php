<?php
require_once("includes/config.php");
$reguser = $_POST["reguser"];
$reguser = strtolower("$reguser");
$regpass1 = $_POST["regpass1"];
$regpass2 = $_POST["regpass2"];
$adress = $_POST["adress"];
$tel = $_POST["tel"];
//EMPTY FIELD CONTROL
//echo $reguser;
echo "<br>";
//echo $regpass1;


if (isset($_SESSION["uname"]) && isset($_SESSION["psw"])) { //IS THERE ALREADY A SESSION? CHECK
    header("Location: order.php");
    exit();
}

if (empty ($_POST['reguser'])||empty($_POST['regpass1'])||empty($_POST['regpass2'])||empty($_POST['adress'])||empty($_POST['tel'])){ //NO POST, DID YOU DIRECTLY REGISTER.PHP? CHECK
    header("Location: login.php");
    //exit();
}




/*if ($reguser = "" || $regpass1 = "") {
    echo "Boş alanları doldurun..";
    header('Refresh:5; login.php');
    $conn->close();
    exit();
}*/
















/*if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
    //ALREADY EXIST CONTROL
    $sql = "SELECT kullanici_adi FROM kullanicilar";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strcmp($row["kullanici_adi"], $reguser) == 0) {
                echo "Bu kullanıcı adı zaten mevcut, lütfen başka bir kullanıcı adı ile <a href=\"login.php\">tekrar deneyin</a>";
                echo "<br>";
                echo " $row[kullanici_adi]";
                echo "<br>";
                echo "$reguser";
                header('Refresh:5; login.php');
                $conn->close();
                exit();
            }
        }
    } else {
        echo "Bir hata oluştu, lütfen <a href=\"login.php\">tekrar deneyin</a>";
        header('Refresh:5; login.php');
        $conn->close();
        exit();
    }

    if (strcmp($regpass1, $regpass2)) {
        //PASSWORD CONFIRM CONTROL
        $sql = "INSERT INTO kullanicilar (kullanici_adi,parola,adres,telefon) VALUES ('$reguser','$regpass','$adress','$tel')";
    } else {
        echo "Girdiğiniz parolalar eşleşmiyor, lütfen <a href=\"login.php\">tekrar deneyin</a>";
        header('Refresh:5; login.php');
        $conn->close();
        exit();
    }

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo "Kayıt oluşturuldu, giriş sayfasına yönlendiriliyorsunuz...";
        header('Refresh:5; login.php');
    } else{
     echo "Bir hata gerçekleşti, lütfen tekrar deneyin";
     header('Refresh:5; order.php');
    }

}

else
header("Location: order.php");

*/
