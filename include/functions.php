<?php

/* Hàm rút gọn để chạy câu lệnh sql */

function execute_query($query) {
    global $connection;
    // $query = mysqli_real_escape_string($connection, $query);
    return mysqli_query($connection, $query);
}

/*
 * hàm dùng để chuyển hướng trang
 * */

function redirect($str) {
    header("location: $str");
}

/*
 * bắt lỗi  khi không có hàm xử lí
 */

function handleNoFunction() {
    
}

/*
 * bỏ ký tự đặc biệt để tránh hack
 * */

function escape_str($value) {
    if (get_magic_quotes_gpc()) {
        return addslashes($value);
    }
    return $value;
}

/*
 * lấy dữ liêu từ $_GET một cách an toàn
 * */

function get($param) {
    if (isset($_GET[$param])) {
        return escape_str($_GET[$param]);
    } else {
        return "";
    }
}

/*
 * lấy dữ liêu từ $_POST một cách an toàn
 * */

function post($param) {
    if (isset($_POST[$param])) {
        return escape_str($_POST[$param]);
    } else {
        return "";
    }
}

/*
  Sử dụng để tạo mệnh đề LIMIT khi phân trang
 *  */

function createLimitForPaging($pageNumber) {
    if ($pageNumber < 1) {
        $pageNumber = 1;
    }
    $start = ($pageNumber - 1) * PAGE_ROW;
    return " LIMIT $start, " . PAGE_ROW;
}

/*
  Tính tổng số lượng trang với từng bảng
 *  */

function getMaxPage($table) {
    $count_query = "SELECT COUNT(*) AS cnt FROM $table";
    $count_result = execute_query($count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    //echo $count_row["cnt"];
    return ceil($count_row["cnt"] / PAGE_ROW);
}

function base_url($url = "") {
    $base = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER["SERVER_PORT"] . "/" . BASE . "/" . $url;
    echo $base;
}

function uploadImage() {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
