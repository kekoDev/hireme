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
     header("Location: loguot.php");
     exit("no");
    }
}
if (isset($_SESSION["username"])){
}else{
    header("Location: login.php");
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
    function copy(text,id) {
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input);

        if (id == "keko1" ){
            document.getElementById("email_new").innerHTML = 'تم النسخ <a  onclick=copy("'+ text + '","keko1")  style="color: #1F8299; font-size: 130%"> ' + text + '</a> <a style="text-align: right">: البريد الكتروني </a> <br>';
        }else{
            document.getElementById("phone_new").innerHTML = ' <a style="text-align: right"> رقم الهاتف :</a> <a onclick=copy("'+ text +'","kekk2") style="color: #1F8299; font-size: 130%;"> ' + text + '</a>  تم النسخ';
        }
    }


    function getinfo(phone,email) {
        document.getElementById("getinfo").innerHTML = "";
        document.getElementById("email_new").innerHTML = '<a onclick=copy("'+ email + '","keko1")  style="color: #1F8299; font-size: 130%;"> ' + email + '</a> <a style="text-align: right">: البريد الكتروني </a> <br>';
        document.getElementById("phone_new").innerHTML = '<a style="text-align: right"> رقم الهاتف :</a> <a onclick=copy("'+ phone +'","kekk2") style="color: #1F8299; font-size: 130%;"> ' + phone + '</a>';
    }

    function re(username,id_post){
        var rep = new XMLHttpRequest();
        rep.onreadystatechange = function () {
            var keko = this.responseText;
            if (keko.includes("ok")) {
                document.getElementById("re_post").innerHTML = "تم الابلاغ";
            } else {
                document.getElementById("re_post").innerHTML = "قمت بالبلاغ";
            }
        }
        rep.open("GET", "ch_singup.php?username_re=" + username + "&id_post=" + id_post , true);
        rep.send();
    }
         function re2(username,id_post){
            var rep = new XMLHttpRequest();
            rep.onreadystatechange = function () {
              var keko = this.responseText;
              if (keko.includes("ok")) {
                 document.getElementById("re_post").innerHTML = "تم الابلاغ";
             } else {
                 document.getElementById("re_post").innerHTML = "قمت بالبلاغ";
             }
         }
        rep.open("GET", "ch_singup.php?username_re2=" + username + "&id_post2=" + id_post , true);
        rep.send();
         }
        function ch(text) {
                var username = new XMLHttpRequest();
                username.onreadystatechange = function () {
                    var keko = this.responseText;
                    if (keko.includes("ok")) {
                        document.getElementById("name").style.borderColor = "blue";
                    }
                    else {
                        document.getElementById("name").style.borderColor = "red";
                    }
                }
                username.open("GET", "ch_singup.php?name=" + text, true);
                username.send();
        }
        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }
        function password(text) {
                var username = new XMLHttpRequest();
                username.onreadystatechange = function () {
                    var keko = this.responseText;
                    if (keko.includes("ok")) {
                        document.getElementById("password_new").style.borderColor = "blue";
                    }
                    else {
                        document.getElementById("password_new").style.borderColor = "red";
                    }
                }
                username.open("GET", "ch_singup.php?password=" + text, true);
                username.send();
        }
    $end = "no";
    $end2 = "no";
       function get_new_post(id,stats_post) {
         if ($end2 && $end2 == "yes"){
             return "end";
         }
           if ($end === "yes"){
               var add2 = document.getElementById("list_show");
               add2.innerHTML += "<a> لا يوجد منشورات</a>";
               $end2 = "yes";
               return "end";
           }
            if (id) {
                document.getElementById("lode").innerHTML = "جاري تحميل المزيد ....";
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
                        var add = document.getElementById("list_show");
                        document.getElementById("lode").innerHTML = "";
                        add.innerHTML += decodeHtml(keko);
                        id_post += 10;
                        return "ok";
                    }
                    if (keko && keko.includes("end posts keko")) {
                        $end = 'yes';
                        document.getElementById("lode").innerHTML = "";
                        return "end";
                    }
                }, false);
                x.open("GET", "ch_singup.php?get_post=" + id + "&stats_post=" + stats_post);
                x.send();

            }
        }
</script>
</head>
<body>
<div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113); z-index: 980;" uk-sticky="top: 100; animation: uk-animation-slide-top; bottom: #sticky-on-scroll-up">
<h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 class="nav-overlay" style="left: 10%; display: inline;">.org</h6>
<a class="uk-button uk-button-text man" uk-toggle="target: #nav" href="" >القائمه</a>
</div>

<div id="edit" uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar">
            <ul class="uk-nav uk-nav-default">
                <li class="uk-active"><h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6></li>
                <br>
                <br>
                <div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113); text-align: center; border-radius: 10px">
                <li class="uk-active"><a style="display: inline;">
                تغير اسم الحساب
                </a></li>
                <div style="background: windowtext; padding: 1px 30px; margin: 10% auto">
                </div>
                <form action="ch_singup.php" method="POST">
                <div class="uk-margin">
                <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input id="name" onkeyup="ch(this.value)" placeholder="اسمك الثلاثي" class="uk-input" type="text" name="name_edit">
                </div>
                </div>
                <input class="uk-button uk-button-primary" style="border-radius: 10px" type="submit" value="حفظ">
                </form>
                </div>
                <li><h3 class="uk-heading-bullet code-for-iraq2">Code for iraq (2018 - 2019)</h3></li>
            </ul>
        </div>
</div>

<div id="edit_pass" uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar">
            <ul class="uk-nav uk-nav-default">
                <li class="uk-active"><h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6></li>
                <br>
                <br>
                <div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113); text-align: center; border-radius: 10px">
                <li class="uk-active"><a style="display: inline;">
                تغير كلمه سر الحساب
                </a></li>
                <div style="background: windowtext; padding: 1px 30px; margin: 10% auto">
                </div>
                <form action="ch_singup.php" method="POST">
                <div class="uk-margin">
                <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input placeholder="كلمه السر القديمه" class="uk-input" type="password" name="password_l">
                </div>
                </div>
                <div class="uk-margin">
                <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input id="password_new" onkeyup="password(this.value)" placeholder="كلمه السر الجديدة" class="uk-input" type="password" name="password_new">
                </div>
                </div>
                <input class="uk-button uk-button-primary" style="border-radius: 10px" type="submit" value="حفظ">
                </form>
                </div>
                <li><h3 class="uk-heading-bullet code-for-iraq2">Code for iraq (2018 - 2019)</h3></li>
            </ul>
        </div>
</div>


<div id="nav" uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar">
            <ul class="uk-nav uk-nav-default">
                <li class="nav-overlay uk-active"><h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6><a  uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade" style="display: inline-block; margin: 0px 0px 0px 44%""></a></li>
                <div class="nav-overlay uk-navbar-left uk-flex-1" hidden>
                    <div class="uk-navbar-item uk-width-expand">
                        <form class="uk-search uk-search-navbar uk-width-1-1" method="GET">
                            <input class="uk-search-input" type="text" name="search" placeholder="اكنب ما تريد هنا ..." autofocus>
                        </form>
                    </div>
                    <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>
                </div>
                <br>
                <br>
                <div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113); text-align: center; border-radius: 10px">
                <li class="uk-active"><a style="display: inline;">
                <?php
                if (isset($_SESSION["username"])){
                    echo $_SESSION["username"];
                }else{
                }
                ?>
                </a>
                <a style="display: inline; color: #F3FFB9;">
                <?php
                if (isset($_SESSION["username"])){
                    $r = ch_to($_SESSION["username"]);
                    if (isset($r) and $r != "error"){
                        if ($r == "worker") {
                            echo " (عامل)";
                        }elseif ($r == "dealer") {
                            echo " (تاجر)";
                        }else{
                            header("Location: login.php");
                            exit;
                        }
                    }
                }else{
                    header("Location: login.php");
                    exit;
                }
                ?>
                </a></li>
                <div style="background: windowtext; padding: 1px 30px; margin: 10% auto">
                </div>
                <br>
                <?php
                    $r = ch_to($_SESSION["username"]);
                    if (isset($r) and $r != "error"){
                        if ($r == "worker") {
                           $keko_post  = get_post_user_worker(get_user_id($_SESSION["username"]));
                           if (isset($keko_post) and $keko_post != "error"){
                               ?>
                               <li><a class="uk-button uk-button-text" href="home.php?id_w=<?php echo $keko_post; ?>" >المنشور الخاص بك</a></li>
                               <br>
                               <?php
                           }
                        }elseif ($r == "dealer") {
                            $keko_post  = get_post_user_dealer(get_user_id($_SESSION["username"]));
                            if (isset($keko_post) and $keko_post != "error"){
                                ?>
                                <li><a class="uk-button uk-button-text" href="home.php?id_d=<?php echo $keko_post; ?>" >المنشور الخاص بك</a></li>
                                <br>
                            <?php                            }
                        }
                    }
                ?>
                <li><a class="uk-button uk-button-text" href="new.php" >نشر منشور جديد</a></li>
                    <br>
                <li><a class="uk-button uk-button-text" uk-toggle="target: #edit" >تغير اسم الحساب</a></li>
                <br>
                <li><a class="uk-button uk-button-text" uk-toggle="target: #edit_pass" >تغير كلمه سر</a></li>
                <br>
                <li><a class="uk-button uk-button-text" href="loguot.php" >تسجيل خروج</a></li>
                </div>
                <li><h3 class="uk-heading-bullet code-for-iraq2">Code for iraq (2018 - 2019)</h3></li>
            </ul>
        </div>
  </div>
<?php
function error_not(){
    exit("         <center>
            <div style=\"margin: 3% 10%; padding: 1px;\">
                <div class=\"uk-card uk-card-default uk-width-1-2@m\">
                    <div class=\"uk-card-header\">
                        <div class=\"uk-grid-small uk-flex-middle\" uk-grid>
                            <div class=\"uk-width-auto\">
                            <span class=\"uk-margin-small-right uk-border-circle\" width=\"30\" height=\"40\"
                                  uk-icon=\"ban\"></span>
                            </div>
                            <div class=\"uk-width-expand\">
                                <h3 class=\"uk-card-title uk-margin-remove-bottom\" style=\"text-align: left\">Error</h3>
                                <p class=\"uk-text-meta uk-margin-remove-top\" style=\"text-align: left\">
                                    <time></time>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class=\"uk-card-body\">
                        <p style=\"color: red\"> لا يوجد هاكذا منشور</p>
                    </div>
                    <div class=\"uk-card-footer\">
                        <a href=\"home.php\" class=\"uk-button uk-button-text\" >رجوع</a>
                    </div>
                </div>
            </div>
    </center>");
}
$if_POST = $_SERVER['REQUEST_METHOD'];
if (isset($if_POST) and $if_POST == "GET" and isset($_GET["search"])){
    $search_text = filter_var($_GET["search"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   if (isset($search_text) and ! empty($search_text)) {
       $r = ch_to($_SESSION["username"]);
       if ($r == "worker") {
           if (get_all_post_dealer_search($search_text) == "error" ){
               error_not();
           }
       } elseif ($r == "dealer") {
          if (get_all_post_worker_search($search_text) == "error" ){
              error_not();
          }
       }

   }else{
       error_not();
   }
}elseif (isset($if_POST) and $if_POST == "GET" and (isset($_GET["id_d"]) or isset($_GET["id_w"]))){
    if (isset($_GET["id_d"]) and filter_var($_GET["id_d"], FILTER_VALIDATE_INT)){
        $all_info_post = get_post_dealer($_GET["id_d"]);
        if ($all_info_post == "error"){
            error_not();
        }
        ?>
        <center>
            <div style="margin: 3% 10%; padding: 1px;">
                <div class="uk-card uk-card-default uk-width-1-2@m">
                    <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                            <span class="uk-margin-small-right uk-border-circle" width="30" height="40"
                                  uk-icon="user"></span>
                            </div>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left"> <?php
                                    if (isset($all_info_post["id_user"])){
                                        echo get_name_by_id($all_info_post["id_user"]);
                                    }
                                    ?> </h3>
                                <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                                    <time>
                                        <?php
                                        if (isset($all_info_post["date_post"])){
                                        echo $all_info_post["date_post"];
                                        }
                                        ?>
                                    </time>
                                </p>
                            </div>
                            <p style="color: #1F8299; font-size: 150%; text-align: right" title="اسم المهنه">
                                <?php
                                if (isset($all_info_post["name_work"])){
                                    echo $all_info_post["name_work"];
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="keko_text">
                    <a style="text-align: right;" >: وصف حول العمل </a>
                    <p style="color: #1F8299; font-size: 120%;">
                    <?php
                    if (isset($all_info_post["bio"])){
                    echo $all_info_post["bio"];
                    }
                    ?>
                    </p>
                    </div>
                    <hr class="uk-alert">
                    <div class="keko_text">
                    <a style="text-align: right">ساعات العمل :</a>
                    <p style="display: initial; color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["time_work"])){
                    echo $all_info_post["time_work"];
                    }
                    ?>
                    ساعات</p>
                    </div>
                    <div class="keko_text">
                    <a style="text-align: right"> ساعات الراحه :</a>
                    <a style="color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["sleep"])){
                    echo $all_info_post["sleep"];
                    }
                    ?>
                    </a>
                    </div>
                    <hr class="uk-alert">
                    <div class="keko_text">
                    <a style="text-align: right"> مكان العمل :</a>
                    <a style="color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["city"]) and isset($all_info_post["city2"])){
                    echo $all_info_post["city"] . " / ". $all_info_post["city2"];
                    }
                    ?>
                    </a>
                    </div>
                    <hr class="uk-alert">
                    <div class="keko_text">
                        <a style="text-align: right"> عدد العمال المطلوب :</a>
                        <a style="color: #1F8299; font-size: 130%;">
                            <?php
                            if (isset($all_info_post["all_worker"])){
                                echo $all_info_post["all_worker"];
                            }
                            ?>
                            عامل
                        </a>
                        <?php
                        if (isset($keko_post) and $keko_post != "error" and isset($_GET["id_d"]) and $_GET["id_d"] == $keko_post){
                            ?>
                            <a style="display: initial;"  uk-toggle="target: #edit_work_add" class="uk-button uk-button-text">تعديل</a>

                            <div id="edit_work_add" uk-offcanvas="overlay: true">
                                <div class="uk-offcanvas-bar">
                                    <ul class="uk-nav uk-nav-default">
                                        <li class="uk-active"><h3 class="uk-heading-bullet keko_r">وظفني</h3><h6 style="left: 10%; display: inline;">.org</h6></li>
                                        <br>
                                        <br>
                                        <div class="uk-card uk-card-primary uk-card-body" style="background-color: rgb(35, 106, 113); text-align: center; border-radius: 10px">
                                            <li class="uk-active"><a style="display: inline;">
                                                    تغير عدد العمال المطلوب
                                                </a></li>
                                            <div style="background: windowtext; padding: 1px 30px; margin: 10% auto">
                                            </div>
                                            <form action="ch_singup.php" method="POST">
                                                <div class="uk-margin">
                                                    <div class="uk-inline">
                                                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                        <input placeholder="عدد العمال الجديد" class="uk-input" type="number" name="new_add_work">
                                                    </div>
                                                </div>
                                                <input class="uk-button uk-button-primary" style="border-radius: 10px" type="submit" value="حفظ">
                                            </form>
                                        </div>
                                        <li><h3 class="uk-heading-bullet code-for-iraq2">Code for iraq (2018 - 2019)</h3></li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="phone_new" class="keko_text">
                    </div>
                    <div id="email_new" class="keko_text">
                    </div>
                    <div class="uk-card-footer" style="text-align: center; ">
                        <a id="re_post" onclick="re('<?php  echo $_SESSION['username']; ?>', '<?php echo $_GET["id_d"]; ?>' )" class="uk-button uk-button-text" style="color: red" >ابلاغ</a>
                        <?php
                        if (isset($_SESSION["username"])){
                            $r = ch_to($_SESSION["username"]);
                            if (isset($r) and $r != "error"){
                                if ($r == "worker") {
                                ?>
                                <a id="getinfo" onclick="getinfo('<?php echo $all_info_post["phone"]; ?>','<?php echo $all_info_post["email"]; ?>')" class="uk-button uk-button-text" style="margin: 3% 20%">تواصل</a>
                                <?php
                                }else{
                                    echo "<a style='margin: 3% 20%'></a>";
                                }
                            }
                        }else{
                            header("Location: login.php");
                            exit;
                        }
                        ?>
                        <a href="home.php" class="uk-button uk-button-text" style="left: initial" >رجوع</a>
                    </div>

                </div>
            </div>
        </center>
        <br>
    <?php
    }elseif(isset($_GET["id_w"]) and filter_var($_GET["id_w"], FILTER_VALIDATE_INT)){
$all_info_post = get_post_worker($_GET["id_w"]);
if ($all_info_post == "error"){
    error_not();
}
?>
<center>
    <div style="margin: 3% 10%; padding: 1px;">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left"> <?php
                            if (isset($all_info_post["id_user"])){
                                echo get_name_by_id($all_info_post["id_user"]);
                            }
                            ?> </h3>
                        <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                            <time>
                                <?php
                                if (isset($all_info_post["date_post"])){
                                    echo $all_info_post["date_post"];
                                }
                                ?>
                            </time>
                        </p>
                    </div>
                    <p style="color: #1F8299; font-size: 150%; text-align: right"">
                       عامل
                    </p>
                </div>
            </div>
            <div class="keko_text">
                <a style="text-align: right;" >: وصف حول العامل </a>
                <p style="color: #1F8299; font-size: 120%;">
                    <?php
                    if (isset($all_info_post["bio"])){
                        echo $all_info_post["bio"];
                    }
                    ?>
                </p>
            </div>
            <hr class="uk-alert">
            <div class="keko_text">
                <a style="text-align: right">ساعات العمل :</a>
                <p style="display: initial; color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["time_work"])){
                        echo $all_info_post["time_work"];
                    }
                    ?>
                    ساعات</p>
            </div>
            <hr class="uk-alert">
            <div class="keko_text">
                <a style="text-align: right">  المهنه السابقه :</a>
                <a style="color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["towork"])){
                        echo $all_info_post["towork"];
                    }
                    ?>
                </a>
            </div>
            <div class="keko_text">
                <a style="text-align: right">  المحصل الدراسي :</a>
                <a style="color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["school"])){
                        echo $all_info_post["school"];
                    }
                    ?>
                </a>
            </div>
            <hr class="uk-alert">
            <div class="keko_text">
                <a style="text-align: right"> مكان الشخص :</a>
                <a style="color: #1F8299; font-size: 130%;">
                    <?php
                    if (isset($all_info_post["city"]) and isset($all_info_post["city2"])){
                        echo $all_info_post["city"] . " / ". $all_info_post["city2"];
                    }
                    ?>
                </a>
            </div>

            <div id="phone_new" class="keko_text">
            </div>
            <div id="email_new"  class="keko_text">
            </div>

            <div class="uk-card-footer" style="text-align: center; ">
                <a id="re_post" onclick="re2('<?php  echo $_SESSION['username']; ?>', '<?php echo $_GET["id_w"]; ?>' )" class="uk-button uk-button-text" style="color: red" >ابلاغ</a>
                <?php
                if (isset($_SESSION["username"])){
                    $r = ch_to($_SESSION["username"]);
                    if (isset($r) and $r != "error"){
                        if ($r != "worker") {
                            ?>
                <a id="getinfo" onclick="getinfo('<?php echo $all_info_post["phone"]; ?>','<?php echo $all_info_post["email"]; ?>')" class="uk-button uk-button-text" style="margin: 3% 20%">تواصل</a>
                <?php
                        }else{
                            echo "<a style='margin: 3% 20%'></a>";
                        }
                    }
                }else{
                    header("Location: login.php");
                    exit;
                }
                ?>
                <a href="home.php" class="uk-button uk-button-text" style="left: initial" >رجوع</a>
            </div>

        </div>
    </div>
</center>
<br>
    <?php
    }else{
        error_not();
    }

}else{
?>

<center>
    <div id="list_show">
        <?php
        if (isset($_SESSION["username"])) {
            $r = ch_to($_SESSION["username"]);
            if (isset($r) and $r != "error") {
                if ($r == "worker") {
                    get_all_post_dealer(1, 10, "html");
                } elseif ($r == "dealer") {
                    get_all_post_worker(1, 10, "html");
                }
            }
        }
        ?>
    </div>
    </div>
    <br>
    <div id="lode">
    </div>
    <?php
    }
    ?>
</center>
<script>
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            <?php
            $r = ch_to($_SESSION["username"]);
            if (isset($r) and $r != "error")
            {
                if ($r == "worker") {
                    echo "get_new_post(id_post,'dealer');";
                } else {
                    echo "get_new_post(id_post,'worker');";
                }
            }
            ?>

        }
    }
</script>
</body>
</html>

<?php
if (isset($_SESSION["note"]) and $_SESSION["note"] != "no"){
      echo "
     <script>
     UIkit.notification('".$_SESSION["note"]."');
      </script>";
     unset($_SESSION["note"]);
  }
?>


