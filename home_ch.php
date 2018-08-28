<!DOCTYPE html>
<html>
<head>
<?php
require "api.php";
session_start();
if (isset($_SESSION["username"]) and isset($_SESSION["password"])) {
    $keko_d = ch_login($_SESSION["username"]);
    if ($keko_d != "error") {
        if ((string)$keko_d != (string)$_SESSION["password"]) {
            header("Location: loguot.php");
            exit("no");
        }
    }else{
        header("Location: loguot.php");
        exit("no");  
    }
}
if (isset($_SESSION["username"]) and isset($_SESSION["password"])){
    if (ch_to($_SESSION["username"]) == "error") {
?>
<meta charset="UTF-8">
<title>اكمال التسجيل</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/uikit.min.css" />
<script src="js/uikit.min.js"></script>
<script src="js/uikit-icons.min.js"></script>
<link rel="stylesheet" href="index.css"/>
<script>
        function ch(text) {
                var username = new XMLHttpRequest();
                username.onreadystatechange = function () {
                    var keko = this.responseText;
                    if (keko.includes("ok")) {
                        document.getElementById("name").style.borderColor = "blue";
                        i = true;
                    }
                    else {
                        document.getElementById("name").style.borderColor = "red";
                    }
                }
                username.open("GET", "ch_singup.php?name=" + text, true);
                username.send();
        }

    </script>
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
            <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="star"></span>
        </div>
        <div class="keko_p" >
            <h2>اكمال عمليه التسجيل</h2>
            <br>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: user"></span>
            <input id="name" onkeyup="ch(this.value)" placeholder="اسمك الثلاثي" class="uk-input" type="text" name="name">
            </div>
            </div>
            <br>
            <p class="uk-margin">
            <input class="uk-button uk-button-primary" style="border-radius: 10px; margin: 0px 3px;" type="submit" value="حساب تاجر" name="t">
            <input class="uk-button uk-button-primary" style="border-radius: 10px; margin: 0px 3px;" type="submit" value="حساب عامل" name="f">
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
}else{
    header("Location: home.php");
    exit("no");
    }
}else{
    header("Location: login.php");
    exit("no");
}
if (isset($_SESSION["error"]) and $_SESSION["error"] == "ok"){
    ?>
    <script>
        document.getElementById("name").style.borderLeftColor = "red";
        document.getElementById("name").style.borderRightColor = "red";
    </script>
    <?php
    $_SESSION["error"] = "no";
}

?>