<?php
///// mysql info //////

$host = "localhost";
$user = "root";
$password = "";

////////////////////
define('host_mysql',$host);
define('user_mysql',$user);
define('password_mysql',$password);

/*

   Create database codeforiraq

*/
function ch_db(){
    $mysqlconnect = mysqli_connect(host_mysql, user_mysql, password_mysql);
    if (!$mysqlconnect){
        $msg = "Error for connect to mysql";
    }
    if (mysqli_query($mysqlconnect,"CREATE DATABASE codeforiraq") === TRUE)
    {
        $msg = "ok create db";
    }
    else
        {
            $msg = "is create";
        }
    mysqli_close($mysqlconnect);
    return $msg;
}
// end Create database


/*

Create table all users website

*/
function ch_tables(){
    if (ch_db() == "Error for connect to mysql"){
        return "Error for connect to mysql";
    }
    $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
    if (!$conn){
        return "Error for connect to mysql";
    }
    $e = "CREATE TABLE all_user (
id INT(60) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
password VARCHAR(99) NOT NULL,
email VARCHAR(99) NOT NULL,
name varchar(99),
stats varchar(10)
) DEFAULT CHARSET=utf8
";
    mysqli_query($conn,$e);
    mysqli_close($conn);
    return "ok";
}
// end table all users


// create table admin_msg
function ch_table_admin_msg(){
    if (ch_db() == "Error for connect to mysql"){
        return "Error for connect to mysql";
    }
    $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
    if (!$conn){
        return "Error for connect to mysql";
    }
    $e = "CREATE TABLE admin_msg (
id INT(60) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
date_post VARCHAR(99) NOT NULL,
msg VARCHAR(99) NOT NULL,
url VARCHAR(99) NOT NULL
) DEFAULT CHARSET=utf8
";
    mysqli_query($conn,$e);
    mysqli_close($conn);
    return "ok";
}
// end table admin


// create table posts worker
function ch_tables2(){
    if (ch_db() == "Error for connect to mysql"){
        return "Error for connect to mysql";
    }
    $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
    if (!$conn){
        return "Error for connect to mysql";
    }
    $e = "CREATE TABLE all_post_worker (
id INT(60) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
id_user INT(100) NOT NULL,
date_post VARCHAR(99) NOT NULL,
bio VARCHAR(100) NOT NULL,
city VARCHAR(99) NOT NULL,
city2 VARCHAR(99) NOT NULL,
school VARCHAR(99) NOT NULL,
towork VARCHAR(99) NOT NULL,
time_work VARCHAR(99) NOT NULL,
phone VARCHAR(99) NOT NULL,
email VARCHAR(99) NOT NULL
) DEFAULT CHARSET=utf8
";
    mysqli_query($conn,$e);
    mysqli_close($conn);
    return "ok";
}
// end table posts worker


// create table posts dealer
function ch_tables3(){
    if (ch_db() == "Error for connect to mysql"){
        return "Error for connect to mysql";
    }
    $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
    if (!$conn){
        return "Error for connect to mysql";
    }
    $e = "CREATE TABLE all_post_dealer (
id INT(60) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
id_user INT(100) NOT NULL,
date_post VARCHAR(99) NOT NULL,
bio VARCHAR(100) NOT NULL,
city VARCHAR(99) NOT NULL,
city2 VARCHAR(99) NOT NULL,
name_work VARCHAR(99) NOT NULL,
sleep VARCHAR(99) NOT NULL,
time_work VARCHAR(99) NOT NULL,
phone VARCHAR(99) NOT NULL,
email VARCHAR(99) NOT NULL,
all_worker VARCHAR(99) NOT NULL
) DEFAULT CHARSET=utf8
";
    mysqli_query($conn,$e);
    mysqli_close($conn);
    return "ok";
}
// end dealer posts

// delete post on all post admin
function del_post_admin($id){
    if (ch_tables2() == "ok") {
        echo $id;
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_query($conn, "DELETE FROM `admin_msg` WHERE id = ".$id);
        echo "ok";
    }
}
// end delete post admin


// print all posts admin
function get_all_post_admin($start,$end,$stats){
    $keko_uif = 'no';
    if (ch_tables2() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM `admin_msg` ORDER BY `admin_msg`.`id` DESC");
        if (mysqli_num_rows($s)) {
            $i = 1;
            $posts = "";
            while ($o = mysqli_fetch_assoc($s)) {
                if ($start <= $i and $end >= $i){
                    if ($stats == "html") {
                        echo '  <div id="'. $o["url"] .'" style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id(get_user_id($o["username"])) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                    </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right">
                    @'.$o["username"].'
                </p>
            </div>
        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>الرساله</a>
                : ' . $o["msg"] . '
            </div>

            </p>
        </div>
        <div class="uk-card-footer">
            <a onclick="del('. "'" . $o["url"] . "','" . $o["id"]. "'" . ')" class="uk-button uk-button-text" style="color: red" >حذف المنشور</a>
            <a onclick="del_ac('. "'" . $o["url"] . "','" . $o["id"]. "'" . ')" class="uk-button uk-button-text" style="color: red; margin: 3% 20%">حذف الحساب والمنشور</a>
            <a href="' . $o["url"] . '" class="uk-button uk-button-text">المنشور</a>
        </div>
    </div>
</div>
';
                        $keko_uif = "ok";
                    }else{
                        $posts = $posts . " " . ' <div id="'. $o["url"] .'" style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id(get_user_id($o["username"])) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                    </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right">
                    @'.$o["username"].'
                </p>
            </div>
        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>الرساله</a>
                : ' . $o["msg"] . '
            </div>

            </p>
        </div>
        <div class="uk-card-footer">
            <a onclick="del('. "'" . $o["url"] . "','" . $o["id"]. "'" . ')" class="uk-button uk-button-text" style="color: red" >حذف المنشور</a>
            <a onclick="del_ac('. "'" . $o["url"] . "','" . $o["id"]. "'" . ')" class="uk-button uk-button-text" style="color: red; margin: 3% 20%">حذف الحساب والمنشور</a>
            <a href="' . $o["url"] . '" class="uk-button uk-button-text">المنشور</a>
        </div>
    </div>
</div>';
                    }
                }elseif ($end <= $i){
                    if (isset($posts)){
                        return $posts;
                    }
                    break;
                }
                $i++;
            }
            if ($posts != ""){
                return $posts;
            }elseif ($posts == "" and $keko_uif == "no"){
                echo "end posts keko";
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }

}
// end print posts admin


// get id by username
function get_user_id($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            $s = mysqli_query($conn, "SELECT id FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                    return $o["id"];
                    break;
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end get id by username


// get email by username
function get_email($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            $s = mysqli_query($conn, "SELECT email FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                    return $o["email"];
                    break;
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end get email

// if user send report or not send
function if_send_re($username,$post_id){
    if (ch_table_admin_msg() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT url FROM admin_msg WHERE username = '" . $username . "'");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                if (isset($o["url"]) and  $o["url"] == $post_id){
                    return 'yes';
                }
            }
            return "error";
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end if user send report


// send new report for admin
function new_post_for_admin($username,$msg,$url){
    if (isset($_SESSION["username"]) and $_SESSION["username"] == $username and isset($_SESSION["password"]) ){
        if (ch_table_admin_msg() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            if (mysqli_query($conn, "INSERT INTO admin_msg (`id`, `username`, `date_post`, `msg`, `url`) VALUES (NULL , '$username', '". date("Y/m/d") ."' , '$msg' ,  '$url')")) {
                return "ok";
            } else {
                return "Error for ok";
            }
            mysqli_close($conn);
        }else{
            return "Error";
        }
    } else {
        return "Error";
    }
}
// end send report

// get your post worker by id
function get_post_user_worker($id){
    if (ch_tables2() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT id FROM all_post_worker WHERE id_user = '" . $id . "'");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                return $o["id"];
                break;
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end get post by id

// get all info post worker
function get_post_worker($id){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_worker WHERE id = '" . $id . "'");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                return $o;
                break;
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end get all info post woreker

// delete post worker by id post
function del_post_worker($id){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_query($conn, "DELETE FROM all_post_worker WHERE id = '" . $id . "'");
        return "ok";
    } else {
        return "error";
    }
}
// end delete post worker

// delete post dealer by id post
function del_post_dealer($id){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_query($conn, "DELETE FROM all_post_dealer WHERE id = '" . $id . "'");
        return "ok";
    } else {
        return "error";
    }
}
// end delete psot dealer

// delete user on 'all_user' by id user
function del_ac($id){
    if (ch_tables() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_query($conn, "DELETE FROM all_user WHERE id = '" . $id . "'");
        return "ok";
    } else {
        return "error";
    }
}
// end delete user

// new post worker
function new_post_worker($phone, $bio, $school, $time, $stey, $stey2, $towork, $username, $password){
    if (isset($_SESSION["username"]) and $_SESSION["username"] == $username and isset($_SESSION["password"]) and $_SESSION["password"] == $password){
        $id_is = get_user_id($username);
        if (isset($id_is) and  $id_is != "error"){
            $email = get_email($username);
            if (isset($email) and  $email != "error"){
                if (ch_tables2() == "ok") {
                $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
                if (mysqli_query($conn, "INSERT INTO all_post_worker (`id`, `id_user`, `date_post`, `bio`, `city`, `city2`, `school`, `towork`, `time_work`, `phone` , `email`) VALUES (NULL , '$id_is', '". date("Y/m/d") ."' , '$bio' ,  '$stey' , '$stey2' , '$school' , '$towork' , '$time' , '$phone' , '$email')")) {
                    return "ok";
                } else {
                    return "Error for ok";
                }
                mysqli_close($conn);

                }else{
                return "Error";
                    }
            }else {
                return "Error";
                }
        }else{
            return 'error';
        }
    }else{
        return 'error';
    }
}
// end new post

// get all post woreker
function get_all_post_worker($start,$end,$stats){
    $keko_uif = 'no';
    if (ch_tables2() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_worker ORDER BY id DESC;");
        if (mysqli_num_rows($s)) {
            $i = 1;
            $posts = "";
            while ($o = mysqli_fetch_assoc($s)) {
                if ($start <= $i and $end >= $i){
                    if ($stats == "html") {
                        echo '  
    <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                   </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right">
                عامل
                </p>
            </div>
        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>سكن العامل</a>
                : '.$o["city"].'/'.$o["city2"].'
            </div>
            <div class="keko_text">
                <a>حول العامل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_w=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div>';
                        $keko_uif = "ok";
                    }else{
                        $posts = $posts . " " . ' 
    <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                   </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right">
                عامل
                </p>
            </div>
        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>سكن العامل</a>
                : '.$o["city"].'/'.$o["city2"].'
            </div>
            <div class="keko_text">
                <a>حول العامل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_w=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div>';
                    }
                }elseif ($end <= $i){
                    if (isset($posts)){
                        return $posts;
                    }
                    break;
                }
                $i++;
            }
            if ($posts != ""){
                return $posts;
            }elseif ($posts == "" and $keko_uif == "no"){
                echo "end posts keko";
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }

}
// end

// update data post dealer
function update_all_work_post($new){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_set_charset($conn, "utf8");
            if (mysqli_query($conn, "UPDATE all_post_dealer SET all_worker='" . $new . "' WHERE id='" . get_post_user_dealer(get_user_id($_SESSION['username'])) . "'")) {
                return "ok";
            } else {
                echo "error";
            }
    }
return "error";
}
// end update

// get all pst dealer
function get_all_post_dealer($start,$end,$stats){
    $keko_uif = "no";
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_dealer ORDER BY id DESC;");
        if (mysqli_num_rows($s)) {
           $i = 1;
           $posts = "";
            while ($o = mysqli_fetch_assoc($s)) {
            if ($start <= $i and $end >= $i){
                if ($stats == "html") {
                    echo ' 
       <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                    </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right" title="اسم المهنه">
                    '.$o["name_work"].'
                </p>
            </div>

        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>مكان العمل</a>
                : '.$o["city"].'/'.$o["city2"].'
            </div>
            <div class="keko_text">
                <a>حول العمل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_d=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div>';
                    $keko_uif = "ok";
                }else{
                    $posts = $posts . " " . ' 
       <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                    </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right" title="اسم المهنه">
                    '.$o["name_work"].'
                </p>
            </div>

        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>مكان العمل</a>
                : '.$o["city"].'/'.$o["city2"].'
            </div>
            <div class="keko_text">
                <a>حول العمل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_d=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div>';
                }
            }elseif ($end <= $i){

                if (isset($posts) and $keko_uif == "no"){
                    return $posts;
                }
                break;
            }
                $i++;
            }
            if ($posts != ""){
                return $posts;
            }elseif ($posts == "" and $keko_uif == "no"){
                echo "end posts keko";
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end get all psot


// serach on text
function speed_strpos($text,$text2){
    foreach( $text2 as $keko_new ) {
        if (isset($keko_new)) {
            if (strpos($keko_new, $text) !== false) {
                return "ok";
            }
        }
    }
}
// end

// dealer search post
function get_all_post_dealer_search($text){
    $is = "no";
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_dealer ORDER BY id DESC;");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                if (speed_strpos($text,$o) == "ok") {
                    echo ' <center>
       <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                    </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right" title="اسم المهنه">
                    ' . $o["name_work"] . '
                </p>
            </div>

        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>مكان العمل</a>
                : ' . $o["city"] . '/' . $o["city2"] . '
            </div>
            <div class="keko_text">
                <a>حول العمل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_d=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div></center>';
                    $is = "ok";
                }
            }
        }else{
            return "error";
        }
        if ($is == "no"){
            return "error";
        }
    }

}
// end serach post dealer

// worker search post
function get_all_post_worker_search($text){
    $is = "no";
    if (ch_tables2() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_worker ORDER BY id DESC;");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                if (speed_strpos($text,$o) == "ok") {
                    echo ' <center>
    <div style="margin: 3% 10%; padding: 1px;">
    <div class="uk-card uk-card-default uk-width-1-2@m">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <span class="uk-margin-small-right uk-border-circle" width="30" height="40" uk-icon="user"></span>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom" style="text-align: left">' . get_name_by_id($o["id_user"]) . '</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="text-align: left">
                        <time>' . $o["date_post"] . '</time>
                   </p>
                </div>
                <p style="color: #1F8299; font-size: 150%; text-align: right">
                عامل
                </p>
            </div>
        </div>

        <div class="uk-card-body">
            <p>
            <div class="keko_text">
                <a>سكن العامل</a>
                : '.$o["city"].'/'.$o["city2"].'
            </div>
            <div class="keko_text">
                <a>حول العامل</a>
                 : ' . $o["bio"] . '
            </div>
            
            </p>
        </div>
        <div class="uk-card-footer">
            <a href="home.php?id_w=' . $o["id"] . '" class="uk-button uk-button-text">المزيد</a>
        </div>
    </div>
</div></center>';
                    $is = "ok";
                }
            }
        }else{
            return "error";
        }
        if ($is == "no"){
            return "error";
        }
    }
}
// end serach post worker

// get post user dealer by id user
function get_post_user_dealer($id){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT id FROM all_post_dealer WHERE id_user = '" . $id . "'");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                return $o["id"];
                break;
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end get post

// get info post dealer by id psot
function get_post_dealer($id){
    if (ch_tables3() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        $s = mysqli_query($conn, "SELECT * FROM all_post_dealer WHERE id = '" . $id . "'");
        if (mysqli_num_rows($s)) {
            while ($o = mysqli_fetch_assoc($s)) {
                return $o;
                break;
            }
        }else{
            return "error";
        }
    } else {
        return "error";
    }
}
// end get info post dealer

// new post dealer
function new_post_dealer($phone, $bio, $sleep, $name, $all_worker, $time, $stey, $stey2, $username, $password){
        if (isset($_SESSION["username"]) and $_SESSION["username"] == $username and isset($_SESSION["password"]) and $_SESSION["password"] == $password) {
            $id_is = get_user_id($username);
            if (isset($id_is) and $id_is != "error") {
                $email = get_email($username);
                if (isset($email) and $email != "error") {
                    if (ch_tables3() == "ok") {
                        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
                        if (mysqli_query($conn, "INSERT INTO all_post_dealer (`id`, `id_user`, `date_post`, `bio`, `city`, `city2`, `name_work`, `sleep`, `time_work`, `phone`, `email`, `all_worker`) VALUES (NULL , '$id_is', '" . date("Y/m/d") . "' , '$bio' ,  '$stey' , '$stey2' , '$name' , '$sleep' , '$time' , '$phone' , '$email' , '$all_worker')")) {
                            return "ok";
                        } else {
                            return "Error for ok";
                        }
                        mysqli_close($conn);

                    } else {
                        return "Error";
                    }
                } else {
                    return "Error";
                }
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
}
// end new post dealer

// check usernaem
function ch_username($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            if (!$conn) {
                return "error";
            }
            $select = mysqli_query($conn, "SELECT username FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($select)) {
                return "error";
            } else {
                return "open";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end check username

// get password py usernaem  ( login )
function ch_login($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            $s = mysqli_query($conn, "SELECT password FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                    return $o["password"];
                    break;
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end get password py usernaem

// get stats [ worekre , dealer ] BY usernaem
function ch_to($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            $s = mysqli_query($conn, "SELECT stats FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                   if ($o["stats"] == false){
                       return "error";
                   }else{
                       return $o["stats"];
                   }
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end get stats

// get name by username
function get_name($username){
    if (strlen($username) >= 4) {
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            mysqli_set_charset($conn, "utf8");
            $s = mysqli_query($conn, "SELECT name FROM all_user WHERE username = '" . $username . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                    if ($o["name"] == false){
                        return "error";
                    }else{
                        return $o["name"];
                    }
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
    }else{
        return "error";
    }
}
// end get name by username

// get name by id user
function get_name_by_id($id){
        if (ch_tables() == "ok") {
            $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
            mysqli_set_charset($conn, "utf8");
            $s = mysqli_query($conn, "SELECT name FROM all_user WHERE id = '" . $id . "'");
            if (mysqli_num_rows($s)) {
                while ($o = mysqli_fetch_assoc($s)) {
                    if ($o["name"] == false){
                        return "error";
                    }else{
                        return $o["name"];
                    }
                }
            }else{
                return "error";
            }
        } else {
            return "error";
        }
}
// end get name

// sing up
function sinup_new($username,$email,$password){
    if (ch_tables() == "ok") {
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        if (mysqli_query($conn, "INSERT INTO all_user (`id`, `username`, `password`, `email`, `name`, `stats`) VALUES (NULL , '$username', '$password' , '$email' , NULL , NULL)")) {
            return "ok";
        } else {
            return "Error for ok";
        }
        mysqli_close($conn);
    }else
    {
        return "Error";
    }
}
// end sing up

// update info user
function update_info($username,$password,$w,$new){
    $keko_d = ch_login($username);
    if ($keko_d == "error") {
        if ($keko_d != $password) {
            return "error";
        }
        return "error";
    }
        $conn = mysqli_connect(host_mysql, user_mysql, password_mysql, "codeforiraq");
        mysqli_set_charset($conn, "utf8");
        if ($w == "name") {
            if (mysqli_query($conn, "UPDATE all_user SET name='".$new."' WHERE username='".$username."'")) {
                return "ok";
            } else {
                echo "error";
            }
        }elseif ($w == "password"){
            if (mysqli_query($conn, "UPDATE all_user SET password='".$new."' WHERE username='".$username."'")) {
                return "ok";
            } else {
                return "error";
            }
        }elseif ($w == "stats"){
            if (mysqli_query($conn, "UPDATE all_user SET stats='".$new."' WHERE username='".$username."'")) {
                return "ok";
            } else {
                return "error";
            }
        }elseif ($w == "email"){
            if (mysqli_query($conn, "UPDATE all_user SET email='".$new."' WHERE username='".$username."'")) {
                return "ok";
            } else {
                return "error";
            }
        }else{
            return "error";
        }
        mysqli_close($conn);

}
// end

?>


