<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $proname = post("producer_name");
    $country = post("country");
    $url = $_FILES["img_url"]["name"];
    $type = $_FILES['img_url']['type'];
    echo "$url+$type";
    if ($_FILES['img_url']['name'] != NULL) { // Đã chọn file
        // Tiến hành code upload file
        if ($_FILES['img_url']['type'] == "image/jpeg" || $_FILES['img_url']['type'] == "image/png" || $_FILES['img_url']['type'] == "image/gif") {
            // là file ảnh
            // Tiến hành code upload    
            if ($_FILES['img_url']['size'] > 1048576) {
                echo "File không được lớn hơn 1mb";
            } else {
                // file hợp lệ, tiến hành upload
                $path = "../imgs/"; // file sẽ lưu vào thư mục data
                $tmp_name = $_FILES['img_url']['tmp_name'];
                $name = $_FILES['img_url']['name'];
                $type = $_FILES['img_url']['type'];
                $size = $_FILES['img_url']['size'];
                // Upload file
                move_uploaded_file($tmp_name, $path . $name);
                echo "File uploaded! <br />";
                echo "Tên file : " . $name . "<br />";
                echo "Kiểu file : " . $type . "<br />";
                echo "File size : " . $size;
                execute_query("INSERT INTO `producer` VALUES (NULL,'$proname','$country','$url');");
                redirect("../admin/producer.php");
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

function pro_update() {
    $name = post("name");
    $price = post("price");
    $product_id = post("product_id");
    execute_query("UPDATE `product` SET  `name`= '$name' `price` = '$price' WHERE product_id='$product_id'");
    redirect("../pro_list");
}

function delete() {
    $id = get("id_del");    
    $query = "SELECT * FROM `producer` WHERE `producer_id` = '$id'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $file = $row["img_url"];
    }
    echo "$file";
    $path = "../imgs/"."$file";
    echo "$path";
    if (file_exists($path)) {
        unlink($path);
    }
    execute_query("DELETE FROM `producer` WHERE `producer_id` = '$id'");
    redirect("../admin/producer.php");
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

function do_test() {
    die("TEST OK");
}

function test2() {
    die("Test2");
}
