<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_REQUEST['update'])) {
    update();
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $specifications_name = post("specifications_name");

    execute_query("INSERT INTO `specifications` VALUES (NULL,'$specifications_name');");
    redirect("../admin/specifications.php");

    //die();
}

function update() {
    $id = post("id_update");
    $specifications_name = post("specifications_name"); 
    execute_query("UPDATE `product` SET  `name`= '$name' `price` = '$price' WHERE product_id='$product_id'");
    redirect("../pro_list");
}

function delete() {
    $id = get("id_del");
    $n = get("page");  
    execute_query("DELETE FROM `specifications` WHERE `specifications_id` = '$id'");
    echo "$n";
    redirect("../admin/specifications.php?page=$n");
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
