<!DOCTYPE html>
<?php
require 'api.php';  
session_start();
$_SESSION["login"] = "ok";
if (isset($_SESSION["username"]) and isset($_SESSION["password"])) {
    $keko_d = ch_login($_SESSION["username"]);
    if ($keko_d != "error") {
        if ((string)$keko_d != (string)$_SESSION["password"]) {
            header("Location: loguot.php");
            exit("no");
        }else{
            header("Location: home.php");
            exit("no");
        }
    }else{
        header("Location: loguot.php");
        exit("no");  
    }
}
?>
<html>
<head>
<meta charset="UTF-8">
<title>وظفني</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/uikit.min.css" />
<script src="js/uikit.min.js"></script>
<script src="js/uikit-icons.min.js"></script>
<link rel="stylesheet" href="index.css"/>
</head>
<body>
<div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113);">
<h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6>
</div>
<br>
<div>
    <center>

        <form action="ch_singup.php" method="POST" class="uk-card uk-card-primary uk-card-body keko_pp" style="background-color: rgb(35, 106, 113);">
            <div class="uk-width-auto">
                <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="info"></span>
            </div>
            <div class="keko_p" >
            <a>تسجيل الدخول</a>
            <br>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: user"></span>
            <input id="username" placeholder="اسم المستخدم" class="uk-input" type="text" name="user_login">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: lock"></span>
            <input id="password" placeholder="كلمه السر" class="uk-input" type="password" name="pass_login">
            </div>
            </div>
            <a class="uk-button uk-button-text" style="font-size:10px;" href="singup.php" >انشاء حساب جديد</a>
            <br>
            <p class="uk-margin">
            <input class="uk-button uk-button-primary" type="submit" value="تسجيل الدخول">
            </p>
            </div>
        </form>
    </center>
</div>
<?php
include "end.php";
?>
</body>
</html>
<?php
if (isset($_SESSION["error"]) and $_SESSION["error"] == "ok"){
    ?>
    <script>
        document.getElementById("username").style.borderLeftColor = "red";
        document.getElementById("username").style.borderRightColor = "red";
        document.getElementById("password").style.borderLeftColor = "red";
        document.getElementById("password").style.borderRightColor = "red";
    </script>
    <?php
    $_SESSION["error"] = "no";
}
?>