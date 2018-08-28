<?php
session_start();
require 'api.php';
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>انشاء حساب</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <link rel="stylesheet" href="index.css"/>

</head>
<body>
<script>
    var i = false;
    var i2 = false;
    var i3 = false;
    function ch(textk,ke) {
        if (ke === "username") {
            var username = new XMLHttpRequest();
            username.onreadystatechange = function () {
                var keko = this.responseText;
                if (keko.includes("ok")) {
                    document.getElementById("username").style.borderColor = "blue";
                    i= true;
                }
                else {
                    document.getElementById("username").style.borderColor = "red";
                }
            }
            username.open("GET", "ch_singup.php?username=" + textk, true);
            username.send();

        }else if (ke === "email"){

            var email = new XMLHttpRequest();
            email.onreadystatechange = function () {
                var keko = this.responseText;
                if (keko.includes("ok")) {
                    document.getElementById("email").style.borderColor = "blue";
                i2 = true;
                }
                else {
                    document.getElementById("email").style.borderColor = "red";
                }
            }
            email.open("GET", "ch_singup.php?email=" + textk, true);
            email.send();

        }else if (ke === "password"){
            var password = new XMLHttpRequest();
            password.onreadystatechange = function () {
                var keko = this.responseText;
                if (keko.includes("ok")) {
                    document.getElementById("password").style.borderColor = "blue";
                    i3 = true;
                }
                else {
                    document.getElementById("password").style.borderColor = "red";
                }
            }
            password.open("GET", "ch_singup.php?password=" + textk, true);
            password.send();
        }
        if ( i===true && i2 ===true && i3 === true ){
            document.getElementById("ck").style.borderColor = "blue";
        }else{
            document.getElementById("ck").style.borderColor = "red";
        }
    }

</script>
<div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113);">
<h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6>
</div>
<br>
<div>
    <center>
        <form action="ch_singup.php" method="POST" class="uk-card uk-card-primary uk-card-body keko_pp" style="background-color: rgb(35, 106, 113);">
            <div class="uk-width-auto">
                <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="users"></span>
            </div>
            <div class="keko_p" >
            <a>انشاء حساب جديد</a>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: user"></span>
            <input id="username" onkeyup="ch(this.value,'username')" placeholder="اسم المستخدم" class="uk-input" type="text" name="username">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: mail"></span>
            <input id="email" onkeyup="ch(this.value,'email')" placeholder="البريد الإلكتروني" class="uk-input" type="text" name="email">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: lock"></span>
            <input id="password" onkeyup="ch(this.value,'password')"  placeholder="كلمه السر" class="uk-input" type="password" name="password">
            </div>
            </div>
            <p id="error_msg" class="uk-margin">
            </p>
            <p class="uk-margin">
            <input id="ck" class="uk-button uk-button-primary" type="submit" value="انشاء حساب الان">
            </p>
            <a class="uk-button uk-button-text" style="font-size:10px;" href="login.php" >لديك حساب مسبقا</a>
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
$_SESSION["ch_singup"] = "ok";
if (isset($_SESSION["error"]) and $_SESSION["error"] == "ok"){
    ?>
    <script>
        document.getElementById("username").style.borderLeftColor = "red";
        document.getElementById("username").style.borderRightColor = "red";
        document.getElementById("password").style.borderLeftColor = "red";
        document.getElementById("password").style.borderRightColor = "red";
        document.getElementById("email").style.borderLeftColor = "red";
        document.getElementById("email").style.borderRightColor = "red";
        document.getElementById("error_msg").innerHTML = '<a style="color:red">عليك ملئ الحقول بشكل الصحيح</a>';
     </script>
    <?php
    unset($_SESSION["error"]);
}
?>
