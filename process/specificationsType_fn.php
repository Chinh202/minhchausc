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
if (isset($_GET['idUpdate'])) {
    showProducerInfo();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $type_name = post("type_name");
//    die($specifications_name.$type_id);
    execute_query("INSERT INTO `specification_type` VALUES (NULL,'$type_name');");
    redirect("../admin/specification_type.php");
}
function showProducerInfo() {
    $type_id = get("idUpdate");
    $query = "SELECT * FROM `specification_type` where type_id='$type_id'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class = "modal-header">';
        echo '<button type = "button" class = "close" data-dismiss = "modal">&times;';
        echo '</button>';
        echo '<h4 class = "modal-title text-center">Thay đổi thông tin loại thông số</h4>';
        echo '</div>';
        echo '<div class = "modal-body">';  
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-4 col-xs-4">Tên loại thông số :</label>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "text" required class = "form-control" name = "type_name" value="' . $row["type_name"] . '"/></div>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "hidden"  name = "type_id" value="' . $row["type_id"] . '"/></div>';
        echo '</div>';        
        echo '</div>';
        echo '<div class = "modal-footer">';
        echo '<button type = "submit" class = "btn btn-success" name = "update">Lưu</button>';
        echo '<button type = "button" class = "btn btn-default" data-dismiss = "modal">Đóng</button>';
        echo '</div>';
    }
}
function update() {
    $id = post("type_id");
    $type_name = post("type_name");
    execute_query("UPDATE `specification_type` SET  `type_name`= '$type_name' WHERE type_id='$id'");
    redirect("../admin/specification_type.php");
}

function delete() {
    $id = get("id_del");
    $n = get("page");
    execute_query("DELETE FROM `specification_type` WHERE `type_id` = '$id'");
    echo "$n";
    redirect("../admin/specification_type.php?page=$n");
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
