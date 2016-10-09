<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_GET['id_upd'])) {
    update();
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $type_name = post("type_name");
    $url_img = $_FILES["url_img"]["name"];
    $type_img = $_FILES['url_img']['type'];
    echo "$url_img+$type_img";
    if ($_FILES['url_img']['name'] != NULL) { // Đã chọn file
        // Tiến hành code upload file
        if ($_FILES['url_img']['type'] == "image/jpeg" || $_FILES['url_img']['type'] == "image/png" || $_FILES['url_img']['type'] == "image/gif") {
            // là file ảnh
            // Tiến hành code upload 
            if ($_FILES['url_img']['size'] > 1048576) {
                echo "File không được lớn hơn 1mb";
            } else {
                // file hợp lệ, tiến hành upload
                $path = "../imgs/"; // file sẽ lưu vào thư mục data
                $tmp_name = $_FILES['url_img']['tmp_name'];
                $name = $_FILES['url_img']['name'];
                $type = $_FILES['url_img']['type'];
                $size = $_FILES['url_img']['size'];
                // Upload file
                move_uploaded_file($tmp_name, $path . $name);
                echo "File uploaded! <br />";
                echo "Tên file : " . $name . "<br />";
                echo "Kiểu file : " . $type . "<br />";
                echo "File size : " . $size;
                execute_query("INSERT INTO `product_type` (`type_id`, `type_name`, `url_img`) "
                        . " SELECT MAX(`type_id`) + 1 , '$type_name','$url_img' FROM `product_type`");
                redirect("../admin/product_type_list.php");
            }
        } else {
            // không phải file ảnh
            echo "Kiểu file không hợp lệ";
        }
    } else {
        echo "Vui lòng chọn file";
    }
    //die();
}

function update() {
    $type_id = get("id_upd");
    $type_name = post("type_name");
    execute_query("UPDATE `product_type` SET  `type_name`= '$type_name' WHERE type_id='$type_id'");
    redirect("../admin/product_type_list.php");
}

function delete() {
    $id = get("id_del");    
    $query = "SELECT * FROM `product_type` WHERE `type_id` = '$id'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $file = $row["url_img"];
    }
    if ($file != NULL) {
        echo "$file";
        $path = "../imgs/"."$file";
        echo "$path";
        if (file_exists($path)) {
            unlink($path);
        }
    }
    execute_query("DELETE FROM `product_type` WHERE `type_id` = '$id'");
    redirect("../admin/product_type_list.php");
}

function do_login() {
    $username = post("username");
    $password = sha1(post("password"));
    $query = "SELECT * FROM `manager` WHERE `username`='$username' AND `password`='$password'";

    //echo $query;	
    $result = execute_query($query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['username'] = $row['username'];

        redirect("../admin_list");
    } else {
        redirect("../admin_login?error=1");
    }
}

function logout() {
    unset($_SESSION['fullname']);
    unset($_SESSION["username"]);
    unset($_SESSION["cart"]);
    session_destroy();
    redirect("../admin_login?error=3");
}
