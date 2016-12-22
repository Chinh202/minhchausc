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
    $specifications_name = post("specifications_name");
    $type_id = post("type_id");
//    die($specifications_name.$type_id);
    execute_query("INSERT INTO `specifications` VALUES (NULL,'$specifications_name','$type_id');");
    redirect("../admin/specifications.php");
}

function showProducerInfo() {
    $specifications_id = get("idUpdate");
    $query = "SELECT `specifications_id`,`specifications_name`,`type_id` FROM `specifications` where `specifications_id`='$specifications_id'";
    $result = execute_query($query);   
    $query1 = "SELECT * FROM `specification_type`";
    $result1 = execute_query($query1);
    while ($row = mysqli_fetch_assoc($result)) {        
        echo '<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="title">Thay Đổi Thông Tin Kỹ Thuật</h4>
                            </div>
                            <div class="modal-body">
                                <input name="specifications_id" value="' . $row["specifications_id"] . '" type="hidden"/>
                                <div class="form-group">                                    
                                    <div class="col-sm-3 col-xs-3">Loại thông số :</div>
                                    <div class="col-sm-9 col-xs-9">
                                        <select name="type_id" class="form-control">';
        while ($row1 = mysqli_fetch_assoc($result1)) {
            echo '<option value="' . $row1["type_id"] . '"';
            echo $row["type_id"] == $row1["type_id"] ? "selected" : "";
            echo '>' . $row1["type_name"] . '</option>';
        }
        echo '</select></div></div>
                                <div class="form-group">                                    
                                    <div class="col-sm-3 col-xs-3">Tên thông số :</div>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="specifications_name" id="sp" value="' . $row["specifications_name"] . '"/></div>                                    
                                </div> 
                                </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="update">Lưu</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            </div>';
    }
}

function update() {
    $id = post("specifications_id");
    $specifications_name = post("specifications_name");
    $type_id = post("type_id");
    execute_query("UPDATE `specifications` SET  `specifications_name`= '$specifications_name', `type_id` = '$type_id' WHERE specifications_id='$id'");
    redirect("../admin/specifications.php");
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
