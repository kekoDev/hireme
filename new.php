<?php
require 'api.php';
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
     header("Location: home_ch.php");
     exit("no");
    }
  }
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>new post </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/uikit.min.css" />
<script src="js/uikit.min.js"></script>
<script src="js/uikit-icons.min.js"></script>
<link rel="stylesheet" href="index.css"/>
<script>
        function ch(text,id) {
            if ((id == "time" || id == "all_worker" )&& parseInt(text) > 1 && parseInt(text) < 25){
                document.getElementById(id).style.borderColor = "blue";
            }else {
                if (text.length < 99 && text.length > 3) {
                    document.getElementById(id).style.borderColor = "blue";
                }
                else {
                    document.getElementById(id).style.borderColor = "red";
                }

            }

        }

    </script>
</head>
<body>
<div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113);">
<h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6>
<a class="uk-button uk-button-text man" href="home.php" >رجوع</a>
</div>
<br>
<div>
    <center>
        <form action="ch_singup.php" method="POST" class="uk-card uk-card-primary uk-card-body keko_pp2" style="background-color: rgb(35, 106, 113);">
            <div class="keko_p2" >
            <h2>نشر منشور</h2>
            <br>
            <?php 
             if (isset($_SESSION["username"])){
                    $r = ch_to($_SESSION["username"]);
                    if (isset($r) and $r != "error"){
                        if ($r == "worker") {
            ?>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: receiver"></span>
            <input id="phone" onkeyup="ch(this.value,this.id)" placeholder="رقم الهاتف الخاص بك" class="uk-input" type="text" name="phone">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: location"></span>
            <input id="stey" onkeyup="ch(this.value,this.id)" placeholder="المحافضه" class="uk-input" type="text" name="stey">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: location"></span>
            <input id="stey2" onkeyup="ch(this.value,this.id)" placeholder="المدينه" class="uk-input" type="text" name="stey2">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: history"></span>
            <input id="toowrk" onkeyup="ch(this.value,this.id)" placeholder="المهنه السابقه" class="uk-input" type="text" name="towork">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: rss"></span>
            <input id="shcool" onkeyup="ch(this.value,this.id)" placeholder="الشهادة او المحصل الدراسي" class="uk-input" type="text" name="school">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: clock"></span>
            <input id="time" onkeyup="ch(this.value,this.id)"placeholder=" عدد ساعات وقت العمل" class="uk-input" type="number" name="time">
            </div>
            </div>
            <div class="uk-margin">
            <textarea id="pio" onkeyup="ch(this.value,this.id)" placeholder="اكتب وصف مختصر عنك" rows="4" class="uk-textarea" name="bio"></textarea>
            </div>
            <?php
            }elseif ($r == "dealer"){ 
            ?>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: rss"></span>
            <input id="shcool" onkeyup="ch(this.value,this.id)" placeholder="اسم المهنة" class="uk-input" type="text" name="name_work">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: receiver"></span>
            <input id="phone" onkeyup="ch(this.value,this.id)" placeholder="رقم الهاتف الخاص بك" class="uk-input" type="text" name="phone">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: location"></span>
            <input id="stey" onkeyup="ch(this.value,this.id)" placeholder="المحافضه" class="uk-input" type="text" name="stey">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: location"></span>
            <input id="stey2" onkeyup="ch(this.value,this.id)" placeholder="المدينه" class="uk-input" type="text" name="stey2">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: history"></span>
            <input id="toowrk" onkeyup="ch(this.value,this.id)" placeholder="اوقات الاستراحه" class="uk-input" type="text" name="sleep">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: clock"></span>
            <input id="time" onkeyup="ch(this.value,this.id)"placeholder=" عدد ساعات وقت العمل" class="uk-input" type="number" name="time">
            </div>
            </div>
            <div class="uk-margin">
            <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="icon: users"></span>
            <input id="all_worker" onkeyup="ch(this.value,this.id)"placeholder="عدد العمال المطلوب" class="uk-input" type="number" name="all_worker">
            </div>
            </div>
            <div class="uk-margin">
            <textarea id="pio" onkeyup="ch(this.value,this.id)" placeholder="اكتب وصف مختصر المهنه او المتجر" rows="4" class="uk-textarea" name="bio"></textarea>
            </div>
            <?php 
               }else{
                            header("Location: login.php");
                        }
                    }
                }else{
                    header("Location: login.php");
                }  
             ?>
        <p class="uk-margin" style="color: red">
            <?php
            if (isset($_SESSION["error_f"])){
                echo "عليك ملئ الحقول بشكل صحيح";
                unset($_SESSION["error_f"]);
            }

            ?>
        </p>
            <p class="uk-margin">
                <input class="uk-button uk-button-primary" style="border-radius: 10px; padding: 0.5% 10%" type="submit" value="نشر" >
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
