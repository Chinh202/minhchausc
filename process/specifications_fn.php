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
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $specifications_name = post("specifications_name");
    $type_id = post("type_id");
//    die($specifications_name.$type_id);
    execute_query("INSERT INTO `specifications` VALUES (NULL,'$specifications_name','$type_id');");
    redirect("../admin/specifications.php");
}
function showProducerInfo() {
    $idProducer = get("update");
    $query = "SELECT * FROM `specifications` where producer_id='$idProducer'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class = "modal-header">';
        echo '<button type = "button" class = "close" data-dismiss = "modal">&times;';
        echo '</button>';
        echo '<h4 class = "modal-title text-center">Thay đổi thông tin nhà sản xuất</h4>';
        echo '</div>';
        echo '<div class = "modal-body">';
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-4 col-xs-4">Tên nhà sản xuất:</label>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "text" required class = "form-control" name = "producer_name" value="' . $row["producer_name"] . '"/></div>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "hidden"  name = "producer_id" value="' . $row["producer_id"] . '"/></div>';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-4 col-xs-4">Xuất xứ:</label>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "text" required class = "form-control" name = "country" value="' . $row["country"] . '"/></div>';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-4 col-xs-4">Ảnh đại diện:</label>';
        echo '<div class = "col-sm-8 col-xs-8"><input type = "file" required name = "img_url"/></div>';
        echo '</div>';
        echo '</div>';
        echo '<div class = "modal-footer">';
        echo '<button type = "submit" class = "btn btn-success" name = "updateProducer">Lưu</button>';
        echo '<button type = "button" class = "btn btn-default" data-dismiss = "modal">Đóng</button>';
        echo '</div>';
    }
}
function update() {
    $id = post("id_update");
    $specifications_name = post("specifications_name");
    $type_id = post("type_id");
    execute_query("UPDATE `specifications` SET  `specifications_name`= '$specifications_name' `type_id` = '$type_id' WHERE specifications_id='$id'");
    redirect("../specifications.php");
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
