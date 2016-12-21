<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_GET['update'])) {
    showProducerInfo();
}
if (isset($_REQUEST['updateProducer'])) {
    pro_update();
    redirect('../admin/producer.php');
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $proname = post("producer_name");
    $country = post("country");
    $url= "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
    if (upload_image() == 'true') {
        execute_query("INSERT INTO `producer` VALUES (NULL,'$proname','$country','$url');");
        redirect('../admin/producer.php');
    } else {
        $message = upload_image();
        echo "<script type='text/javascript'>alert('$message');</script>";
    }  
    //die();
}

function upload_image() {
    $url = $_FILES["img_url"]["name"];
    $type = $_FILES['img_url']['type'];
//    echo "$url+$type";
//    die($_FILES['img_url']['name']);
    if ($_FILES['img_url']['name'] != NULL) { // Đã chọn file
        // Tiến hành code upload file
        if ($_FILES['img_url']['type'] == "image/jpeg" || $_FILES['img_url']['type'] == "image/png" || $_FILES['img_url']['type'] == "image/gif") {
            // là file ảnh
            // Tiến hành code upload    
            if ($_FILES['img_url']['size'] > 1048576) {
                return "File không được lớn hơn 1mb";
            } else {
                // file hợp lệ, tiến hành upload
                $path = "../imgs/"; // file sẽ lưu vào thư mục data
                $tmp_name = $_FILES['img_url']['tmp_name'];
                $name = $path . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
                $type = $_FILES['img_url']['type'];
                $size = $_FILES['img_url']['size'];
                // Upload file
                move_uploaded_file($tmp_name, $name);                
                return 'true';
            }
        } else {
            // không phải file ảnh
            return "Kiểu file không hợp lệ";
        }
    } else {
        return "Vui lòng chọn file";
    }
}

function pro_update() {
    $pro_name = post("producer_name");
    $contry = post("country");
    $producer_id = post("producer_id");
    $url_name = "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
    if ($_FILES['img_url']['name'] == NULL) {
        $query = "UPDATE `producer` SET  `producer_name`= '$pro_name', `country` = '$contry' WHERE producer_id='$producer_id'";
        execute_query($query);
    } else {
        upload_image();
        $query = "UPDATE `producer` SET  `producer_name`= '$pro_name', `country` = '$contry',  `img_url`='$url_name' WHERE producer_id='$producer_id'";
        execute_query($query);
    }
//    $query = "SELECT * FROM `producer`";
//    $result = execute_query($query);
//    $stt = 0;
//    while ($row = mysqli_fetch_assoc($result)) {
//        $stt++;
//        echo'<tr>';
//        echo'<td>' . $stt . '</td>';
//        echo'<td>' . $row["producer_name"] . '</td>';
//        echo'<td>' . $row["country"] . '</td>';
//        echo'<td><ul class = "enlarge">' . $row["img_url"];
//        echo'<li><img src="../imgs/' . $row["img_url"] . '" style="width: 1.5em;" alt="anhdaidien"/><span><img src="../imgs/' . $row["img_url"] . '" alt="Deckchairs" style="width:400px"/><br /></span></li></ul></td>';
//        echo'<td><a href="#" onclick="showHint(' . $row["producer_id"] . ')" title="Sửa thông tin" data-toggle="modal" data-target="#ModalUpdate"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>';
//        echo'<td><a href="../process/producer_fn.php?id_del=' . $row["producer_id"] . '" title="xóa thông tin" id="del" data-del="' . $row["producer_id"] . '"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>';
//        echo'</tr>';
//    }
}

function showProducerInfo() {
    $idProducer = get("update");
    $query = "SELECT * FROM `producer` where producer_id='$idProducer'";
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

function delete() {
    $id = get("id_del");
    $query = "SELECT * FROM `producer` WHERE `producer_id` = '$id'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $file = $row["img_url"];
    }
    echo "$file";
    $path = "../imgs/" . "$file";
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
