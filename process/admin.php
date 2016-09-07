<?php
require_once '../include/process.php';    
function ad_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $username = post("username");
    $password = sha1(post("password"));
    $fullname = post("fullname");
    $email = post ("email");
    $phone = post ("phone");
    $role = post ("role");
   //die();
    execute_query("INSERT INTO `manager` VALUES ('$username','$password','$fullname','$email','$phone','$role');");
    redirect("../admin_list");
}
function pro_new(){
   
    $name = post ("name");
    $price = post ("price");
    execute_query("INSERT INTO `product` VALUES (NULL,'$name','$price',NULL,NULL );");
    redirect("../pro_list");
}
function pro_update()
{
    $name = post ("name");
    $price = post ("price");
    $product_id = post ("product_id");
    execute_query("UPDATE `product` SET  `name`= '$name' `price` = '$price' WHERE product_id='$product_id'");
    redirect("../pro_list");
}

function ad_update() {
    $username = post("username");
    $password = sha1(post("password"));
    $fullname = post("fullname");
    $email = post("email");
    $phone = post("phone");
    $role = post("role");
    execute_query("UPDATE `manager` SET  `password`='$password', `fullname`='$fullname', `email`='$email', `phone`='$phone', `role`='$role' WHERE username='$username'");
    redirect("../admin_list");
}
function del_admin(){
    $username = post("username");
    echo post("username");
    execute_query("DELETE FROM `manager` WHERE `username` = '$username'");
    
    redirect("../admin_list");
}

function do_login() {
    $username = post("username");
    $password = sha1(post("password"));
    $query = "SELECT * FROM `manager` WHERE `username`='$username' AND `password`='$password'";

    //echo $query;	
    $result = execute_query($query);

    if (mysqli_num_rows($result) ==1) {
        $row =  mysqli_fetch_array($result);
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['username'] = $row['username'];

        redirect("../admin_list");
    } 
    else {
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
