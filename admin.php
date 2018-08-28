<?php
//////////////////////////////
// add username
$usernames_admins = ['ikeko','admin'];
//////////////////////////////
session_start();
require "api.php";



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
        header("Location: loguot.php");
        exit("no");
    }
}
if (isset($_SESSION["username"]) and in_array($_SESSION["username"],$usernames_admins)){
}else{
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>وظفني</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="index.css"/>
    <script>
        var id_post = 10;
        $end = "no";
        $end2 = 'no';
        function get_new_post(id) {
            if ($end2 && $end2 == "yes"){
                return "end";
            }
            if ($end === "yes"){
                var add2 = document.getElementById("posts");
                add2.innerHTML += "<a> لا يوجد منشورات</a>";
                $end2 = "yes";
                return "end";
            }
            if (id) {
                var keko = "";
                var x = new XMLHttpRequest();
                x.addEventListener("load", function() {
                    keko = x.responseText;
                    if (keko && keko.includes("div")) {
                        function decodeHtml(str) {
                            var map =
                                {
                                    '&amp;': '&',
                                    '&lt;': '<',
                                    '&gt;': '>',
                                    '&quot;': '"',
                                    '&#039;': "'"
                                };
                            return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function (m) {
                                return map[m];
                            });
                        }
                        var add = document.getElementById("posts");
                        add.innerHTML += decodeHtml(keko);
                        id_post += 10;
                        return "ok";
                    }
                    if (keko && keko.includes("end posts keko")) {
                        $end = 'yes';
                    }
                }, false);
                x.open("GET", "ch_singup.php?get_post=" + id + "&stats_post=admin");
                x.send();
            }
        }
        function del(id_post,id_admin){
            var rep = new XMLHttpRequest();
            rep.onreadystatechange = function () {
                var keko = this.responseText;

                document.getElementById(id_post).innerHTML = '<div style="margin: 3% 10%; padding: 1px;"><div class="uk-card uk-card-default uk-width-1-2@m"> تم حذف المنشور</div></div>';
                }
            rep.open("GET", "ch_singup.php?del_post=" + id_post + "&id_post_admin=" + id_admin , true);
            rep.send();
        }
        function del_ac(id_post,id_admin){
            var rep = new XMLHttpRequest();
            rep.onreadystatechange = function () {
                var keko = this.responseText;
                document.getElementById(id_post).innerHTML = '<div style="margin: 3% 10%; padding: 1px;"><div class="uk-card uk-card-default uk-width-1-2@m"> تم حذف المنشور وحساب الناشر</div></div>';
            }
            rep.open("GET", "ch_singup.php?del_ac_and_post=" + id_post + "&id_post_admin=" + id_admin , true);
            rep.send();
        }

    </script>
</head>
<body>
<div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113);">
    <h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6>
</div>
<br>
<center>
    <div id="posts" >
        <?php
        get_all_post_admin(1,10,"html");
        ?>
    </div>
</center>
<script>
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            get_new_post(id_post);
        }
    }
</script>
<?php
include "end.php";
?>
</body>
</html>
<?php
$_SESSION["is_admin"] = "ok";
?>


