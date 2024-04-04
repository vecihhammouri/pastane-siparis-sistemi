<?php
require_once("includes/config.php"); 


if(empty($_POST["whichuser"])){
    $_SESSION["radiosecim"]= "secilmedi";
    header("Location: login.php");
    exit();
}
if($_POST["whichuser"]=="bayi") {

    $sql = "SELECT * FROM kullanicilar where kullanici_adi='$user' and parola='$pass'";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        $_SESSION["uname"]=$user;
        $_SESSION["psw"]=$pass;
        header("Location: order.php");
        exit();
    }
    else{
        $_SESSION["yanlis"]="yanlis";
        header("Location: login.php");
        exit();
    }
}

elseif($_POST["whichuser"]=="imalat"){
    $sql = "SELECT * FROM kullanici_imalat where kullaniciadi_imalat='$user' and parola_imalat='$pass'";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        $_SESSION["unameimalatpasta"]=$user;
        $_SESSION["pswimalatpasta"]=$pass;
        header("Location: imalat.php");
        exit();
    }
    else{
        $_SESSION["yanlis"]="yanlis";
        header("Location: login.php");
        exit();
    }
    
}
else {
    echo ("Bir hata oluştu, tekrar deneyin");
    header('Refresh:5; login.php');
    exit();
}
