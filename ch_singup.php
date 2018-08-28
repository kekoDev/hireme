<?php
session_start();
require 'api.php';
if (isset($_SESSION["username"]) and isset($_SESSION["password"])) {
    $keko_d = ch_login($_SESSION["username"]);
    if ($keko_d == "error") {
        if ((string)$keko_d != (string)$_SESSION["password"]) {
            header("Location: loguot.php");
            exit("no");
        }
    }
}

function error(){
    $_SESSION["error"] = "ok";
    if (isset($_SERVER[HTTP_REFERER])){
        header("Location: ".$_SERVER[HTTP_REFERER]);
    }else{
        header("Location: home.php");
    }
    exit("no");
}

$if_POST = $_SERVER['REQUEST_METHOD'];
if (isset($if_POST) and $if_POST == "POST" and (isset($_POST["username"]) and $_POST["username"] != "") and (isset($_POST["password"]) and $_POST["password"] != "") and (isset($_POST["email"]))){
if(isset($_SESSION["ch_singup"]) and $_SESSION["ch_singup"] == "ok"){
    $_SESSION["ch_singup"] = "no";
    if(preg_match("/^[a-zA-Z0-9]+$/", $_POST["username"]) == false) {
        error();
        }elseif(strlen($_POST["username"]) > 30){
        error();
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error();
        }
        elseif(strlen($_POST["email"]) > 99) {
            error();
        }
        else{
            if (strlen($_POST["password"]) > 8 and strlen($_POST["password"]) < 99 ){
               if (ch_username($_POST["username"]) == "open"){
               $keko_singup = sinup_new($_POST["username"],$_POST["email"],$_POST["password"]);
               if ($keko_singup == "ok"){
                   header("Location: home_ch.php");
                   $_SESSION["username"] = $_POST["username"];
                   $_SESSION["password"] = $_POST["password"];
               }else{
                   error();
               }
               }else{
                   error();
               }
            }else{
                error();
            }
        }
    }else{
    error();
}
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["username"])){
    if ( preg_match("/^[a-zA-Z0-9]+$/", $_GET["username"]) == false)
    {
        exit("اسم المستخدم غير متاح");
    }
    $c = ch_username($_GET["username"]);
    if ($c == "open") {
        echo "ok";
    }else{
        echo "error";
    }

}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["get_post"]) and isset($_GET["stats_post"]) and isset($_SESSION["username"])){
if ($_GET["stats_post"] == "dealer"){
   echo htmlspecialchars(get_all_post_dealer($_GET["get_post"],$_GET["get_post"]+10,"nohtml"));
}elseif($_GET["stats_post"] == "worker"){
    echo htmlspecialchars(get_all_post_worker($_GET["get_post"],$_GET["get_post"]+10,"nohtml"));
}elseif ($_GET["stats_post"] == "admin"){
    echo htmlspecialchars(get_all_post_admin($_GET["get_post"],$_GET["get_post"]+10,"nohtml"));
}
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["del_post"]) and isset($_SESSION["is_admin"]) and isset($_GET["id_post_admin"])){
    $nu = (int) filter_var($_GET["del_post"], FILTER_SANITIZE_NUMBER_INT);
    $nuw = (int) filter_var($_GET["id_post_admin"], FILTER_SANITIZE_NUMBER_INT);
    if (strpos($_GET["del_post"], 'id_d') !== false and is_int($nu) and is_int($nuw)){
        del_post_admin($nuw);
        del_post_dealer($nu);
    }elseif( strpos($_GET["del_post"], 'id_w') !== false and is_int($nu) and is_int($nuw) ){
        del_post_worker($nu);
        del_post_admin($nuw);
    }else{
        echo "error";
    }
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["del_ac_and_post"]) and isset($_GET["id_post_admin"]) and isset($_SESSION["is_admin"])){
    $nu = (int) filter_var($_GET["del_ac_and_post"], FILTER_SANITIZE_NUMBER_INT);
    $nuw = (int) filter_var($_GET["id_post_admin"], FILTER_SANITIZE_NUMBER_INT);
    if (strpos($_GET["del_ac_and_post"], 'id_d') !== false and is_int($nu) and is_int($nuw)){
        del_post_admin($nuw);
        $info = get_post_dealer($nu);
        if (is_array($info)) {
            del_ac($info["id_user"]);
            del_post_dealer($nu);
        echo "ok";
        }
    }elseif( strpos($_GET["del_ac_and_post"], 'id_w') !== false and is_int($nu) and is_int($nuw)){
        $info = get_post_worker($nu);
        if (is_array($info)) {
        del_ac($info["id_user"]);
        del_post_worker($nu);
        }
        echo "ok";
    }else{
        echo "error";
    }
    echo "error";
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["username_re"]) and isset($_GET["id_post"])){
    if ($_GET["username_re"] == $_SESSION["username"] and get_post_dealer($_GET["id_post"]) != "error" and if_send_re($_GET["username_re"],"home.php?id_d=" . $_GET["id_post"]) != "yes" ){
        new_post_for_admin($_GET["username_re"],"قام بالبلاغ على المنشور","home.php?id_d=" . $_GET["id_post"]);
        echo "ok";
    }else {
        echo "error";
    }
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["username_re2"]) and isset($_GET["id_post2"])){
    if ($_GET["username_re2"] == $_SESSION["username"] and get_post_worker($_GET["id_post2"]) != "error" and if_send_re($_GET["username_re2"],"home.php?id_w=" . $_GET["id_post2"]) != "yes" ){
        new_post_for_admin($_GET["username_re2"],"قام بالبلاغ على المنشور","home.php?id_w=" . $_GET["id_post2"]);
        echo "ok";
    }else {
        echo "no";
    }
}elseif (isset($if_POST) and $if_POST == "POST" and isset($_POST["new_add_work"])){
    $nu = (int) filter_var($_POST["new_add_work"], FILTER_SANITIZE_NUMBER_INT);
        $keko2 = get_post_user_dealer(get_user_id($_SESSION["username"]));
        if (isset($keko2) and $keko2 != "error"){
            if ($nu < 50 and $nu > 0){
                update_all_work_post($nu);
                $_SESSION["note"] = "تم تغير عدد العمال";
                header("Location: home.php?id_d=" . get_post_user_dealer(get_user_id($_SESSION["username"])));
                exit;
            }else{
                $_SESSION["note"] = "حدث خطا في تغير عدد العمال";
                header("Location: home.php?id_d=".get_post_user_dealer(get_user_id($_SESSION["username"])));
                exit;
            }
        }else{
            header("Location: home.php");
            exit;
        }
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["email"])){

    if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        echo "email is error";
    }
    elseif(strlen($_GET["email"]) > 99)
    {
        echo "email is error";
    }else{
        echo "ok";
    }

}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["password"])){
    if (strlen($_GET["password"]) > 8 and strlen($_GET["password"]) < 99 ){
        echo "ok";
    }else{
        echo "no";
    }
}elseif (isset($if_POST) and $if_POST == "GET" and isset($_GET["name"])){
    if (strlen($_GET["name"]) > 4 and strlen($_GET["name"]) < 50 ){
        echo "ok";
    }else{
        echo "no";
    }
}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["password_l"]) and isset($_POST["password_new"]) and isset($_SESSION["username"])){
if (strlen($_POST["password_new"]) > 8 and strlen($_POST["password_new"]) < 99 ){
if (update_info($_SESSION["username"],$_POST["password_l"],"password",$_POST["password_new"]) == "ok"){
    session_destroy();
    header("Location: login.php");
    }else{
    header("Location: home.php");
    exit("no");
    }
}else {
    header("Location: home.php");
     exit("password");
}
        
}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["name_edit"])){
 if (strlen($_POST["name_edit"]) > 4 and strlen($_POST["name_edit"]) < 50){
    if (update_info($_SESSION["username"],$_SESSION["password"],"name",$_POST["name_edit"]) == "ok"){
        $_SESSION["note"] = "تم تغير الاسم الخاص بك";
        header("Location: home.php");
    }else{
        $_SESSION["note"] = "حدث خطأ في تغير الاسم الخاص بك";
        header("Location: home.php");
    }
 }else {
        $_SESSION["note"] = "حدث خطأ في تغير الاسم الخاص بك";
        header("Location: home.php");
 }

}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["phone"]) and isset($_POST["stey"]) and isset($_POST["stey2"]) and isset($_POST["towork"]) and isset($_POST["school"]) and isset($_POST["time"]) and isset($_POST["bio"])) {
    function ch_is($keko) {
        if (strlen($keko) > 3 and strlen($keko) < 99){
            return "ok";
        }else{
            $_SESSION["error_f"] = "yes";
            header("Location: new.php");
            exit("not");
        }
    }
    if ( ch_is($_POST["phone"]) == "ok"){
        if (ch_is($_POST["stey"]) == "ok"){
            if (ch_is($_POST["stey2"]) == "ok"){
                if (ch_is($_POST["towork"]) == "ok"){
                    if (ch_is($_POST["school"]) == "ok"){
                        if ($_POST["time"] < 25){
                            if (ch_is($_POST["bio"]) == "ok"){
                                $id_is = get_user_id($_SESSION["username"]);
                                $id_post = get_post_user_worker($id_is);
                                if ($id_post != "error"){
                                    $info_post = get_post_worker($id_post);
                                    if (is_array($info_post) and isset($info_post["date_post"]) and $info_post["date_post"] == date("Y/m/d")){
                                        $_SESSION["note"] = "لا يمكنك نشر اكثر من منشور في اليوم الواحد";
                                        header("Location: home.php");
                                        exit("is error");
                                    }else{
                                        del_post_worker($id_post);
                                    }
                                }
                                $stats = new_post_worker($_POST["phone"], $_POST["bio"], $_POST["school"], $_POST["time"], $_POST["stey"], $_POST["stey2"], $_POST["towork"], $_SESSION["username"], $_SESSION["password"]);
                                if (isset($stats) and  $stats == "ok"){
                                    if (isset($id_is) and  $id_is != "error") {
                                        header("Location: home.php?id_w=" . get_post_user_worker($id_is));
                                        exit("not");
                                    }
                                }else{
                                    $_SESSION["error_f"] = "yes";
                                    header("Location: new.php");
                                    exit("not");
                                }
                            }
                        }
                    }
                }
            }
        }
    }else{
        $_SESSION["error_f"] = "yes";
        header("Location: new.php");
        exit("not");
    }

}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["phone"]) and isset($_POST["stey"]) and isset($_POST["stey2"]) and isset($_POST["name_work"]) and isset($_POST["sleep"])  and isset($_POST["time"]) and isset($_POST["bio"]) and isset($_POST["all_worker"])) {
    function ch_is($keko) {
        if (strlen($keko) > 3 and strlen($keko) < 99){
            return "ok";
        }else{
            $_SESSION["error_f"] = "yes";
            header("Location: new.php");
            exit("not");
        }
    }
    if ( ch_is($_POST["phone"]) == "ok") {
        if (ch_is($_POST["stey"]) == "ok") {
            if (ch_is($_POST["stey2"]) == "ok") {
                if (ch_is($_POST["sleep"]) == "ok") {
                    if (ch_is($_POST["name_work"]) == "ok") {
                        if ($_POST["time"] < 25 and $_POST["all_worker"] < 50 and $_POST["all_worker"] > 0) {
                            if (ch_is($_POST["bio"]) == "ok") {
                                $id_is = get_user_id($_SESSION["username"]);
                                $id_post = get_post_user_dealer($id_is);
                                if ($id_post != "error"){
                                    $info_post = get_post_dealer($id_post);
                                    if (is_array($info_post) and isset($info_post["date_post"]) and $info_post["date_post"] == date("Y/m/d")){
                                        $_SESSION["note"] = "لا يمكنك نشر اكثر من منشور في اليوم الواحد";
                                        header("Location: home.php");
                                        exit("is error");
                                    }else{
                                        del_post_dealer($id_post);
                                    }
                                }
                                $stats = new_post_dealer($_POST["phone"], $_POST["bio"], $_POST["sleep"], $_POST["name_work"], $_POST["all_worker"], $_POST["time"], $_POST["stey"], $_POST["stey2"], $_SESSION["username"], $_SESSION["password"]);
                                if (isset($stats) and $stats == "ok") {
                                    $id_is = get_user_id($_SESSION["username"]);
                                    if (isset($id_is) and $id_is != "error") {
                                        header("Location: home.php?id_d=" . get_post_user_dealer($id_is));
                                        exit("not");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $_SESSION["error_f"] = "yes";
    header("Location: new.php");
    exit("not");
}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["name"])) {
    if (strlen($_POST["name"]) > 4 and strlen($_POST["name"]) < 50){
        if (isset($_POST["f"])){
            if (update_info($_SESSION["username"],$_SESSION["password"],"name",$_POST["name"]) == "ok"){
                if (update_info($_SESSION["username"],$_SESSION["password"],"stats","worker") == "ok"){
                    echo "oky";
                    header("Location: home.php");
                }else{
                    echo "name";
                }
            }else{
                echo "namew";
            }

        }elseif (isset($_POST["t"])){
            if (update_info($_SESSION["username"],$_SESSION["password"],"name",$_POST["name"]) == "ok"){
                if (update_info($_SESSION["username"],$_SESSION["password"],"stats","dealer") == "ok"){
                    echo "oky";
                    header("Location: home.php");
                    exit("no");
                }else{
                    header("Location: home_ch.php");
                    exit("no");
                }
            }else{
                header("Location: home_ch.php");
                exit("no");
            }
        }else{
            header("Location: home_ch.php");
            exit("no");
        }
    }else{
        $_SESSION["error"] = "ok";
        header("Location: home_ch.php");
        exit("no");
    }

}elseif(isset($if_POST) and $if_POST == "POST" and isset($_POST["user_login"]) and isset($_POST["pass_login"])){
    if (isset($_SESSION["login"]) and $_SESSION["login"] == "ok"){
        $keko_d = ch_login($_POST["user_login"]);
        if ($keko_d == "error") {
            header("Location: login.php");
            $_SESSION["error"] = "ok";
            exit("no");
        }else{
            if ((string)$keko_d == (string)$_POST["pass_login"]){
                header("Location: home_ch.php");
                $_SESSION["username"] = $_POST["user_login"];
                $_SESSION["password"] = $_POST["pass_login"];
                exit("no");
            }else{
                header("Location: login.php");
                $_SESSION["error"] = "ok";
                exit("no");
            }
        }
    }else{
        header("Location: login.php");
        $_SESSION["error"] = "ok";
        exit("no");
    }
}else{
    error();
}


?>
