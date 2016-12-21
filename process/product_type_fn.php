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
    $type_name = post("type_name");
    $url = "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
    if (upload_image() == 'true') {
        execute_query("INSERT INTO `product_type` Values (NULL,'$type_name','$url')");
        redirect("../admin/product_type_list.php");
    } else {
        $message = upload_image();
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
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
                return iconv("utf-8", "cp936", "File không được lớn hơn 1mb");
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
            return iconv("utf-8", "cp936", "Kiểu file không hợp lệ");
        }
    } else {
        return iconv("utf-8", "cp936", "Vui lòng chọn file");
    }
}

function update() {
    $type_id = get("id_upd");
    $type_name = post("type_name");
    $type_img = iconv("utf-8", "cp936", $_FILES['img_url']['name']);
    if ($type_img == NULL) {
        execute_query("UPDATE `product_type` SET  `type_name`= '$type_name' WHERE type_id='$type_id'");
    } else {
        $url = "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
        if (upload_image() == 'true') {
            execute_query("UPDATE `product_type` SET  `type_name`= '$type_name', `url_img`='$url_img' WHERE type_id='$type_id'");
            redirect("../admin/product_type_list.php");
        } else {
            $message = upload_image();
            redirect("../admin/product_type_list.php");
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}

function delete() {
    $id = get("id_del");
    deleteImg($id);
    execute_query("DELETE FROM `product_type` WHERE `type_id` = '$id'");
    redirect("../admin/product_type_list.php");
}

function insertImg() {
    $val = $_FILES["url_img"]["name"];
    $url_img = normalizeChars($val);
    if ($_FILES['url_img']['name'] != NULL) { // Đã chọn file
        // Tiến hành code upload file
        if ($_FILES['url_img']['type'] == "image/jpeg" || $_FILES['url_img']['type'] == "image/png" || $_FILES['url_img']['type'] == "image/gif") {
            // là file ảnh //check file exists
            if (file_exists("../imgs/" . $url_img) == 1) {
                return "-9";
            } else {
                // Tiến hành code upload 
                if ($_FILES['url_img']['size'] > 1048576) {
                    return "-3"; //echo "File không được lớn hơn 1mb";
                } else {
                    // file hợp lệ, tiến hành upload
                    $path = "../imgs/"; // file sẽ lưu vào thư mục data
                    $tmp_name = $_FILES['url_img']['tmp_name'];
                    // Upload file
                    move_uploaded_file($tmp_name, $path . $url_img);
                    return $url_img;
                }
            }
        } else {
            // không phải file ảnh
            return "-2"; //echo "Kiểu file không hợp lệ";
        }
    } else {
        return "-1"; //echo "Vui lòng chọn file";
    }
}

function deleteImg($idProductType) {
    $query = "SELECT * FROM `product_type` WHERE `type_id` = '$idProductType'";
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $file = $row["url_img"];
    }
    if ($file != NULL) {
        echo "$file";
        $path = "../imgs/" . "$file";
        echo "$path";
        if (file_exists($path)) {
            unlink($path);
        }
    }
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

function normalizeChars($s) {
    $replace = array(
        'ъ' => '-', 'Ь' => '-', 'Ъ' => '-', 'ь' => '-',
        'Ă' => 'A', 'Ą' => 'A', 'À' => 'A', 'Ã' => 'A', 'Á' => 'A', 'Æ' => 'A', 'Â' => 'A', 'Å' => 'A', 'Ä' => 'Ae',
        'Þ' => 'B',
        'Ć' => 'C', 'ץ' => 'C', 'Ç' => 'C',
        'È' => 'E', 'Ę' => 'E', 'É' => 'E', 'Ë' => 'E', 'Ê' => 'E',
        'Ğ' => 'G',
        'İ' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Í' => 'I', 'Ì' => 'I',
        'Ł' => 'L',
        'Ñ' => 'N', 'Ń' => 'N',
        'Ø' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe',
        'Ş' => 'S', 'Ś' => 'S', 'Ș' => 'S', 'Š' => 'S',
        'Ț' => 'T',
        'Ù' => 'U', 'Û' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
        'Ý' => 'Y',
        'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z',
        'â' => 'a', 'ǎ' => 'a', 'ą' => 'a', 'á' => 'a', 'ă' => 'a', 'ã' => 'a', 'Ǎ' => 'a', 'а' => 'a', 'А' => 'a', 'å' => 'a', 'à' => 'a', 'א' => 'a', 'Ǻ' => 'a', 'Ā' => 'a', 'ǻ' => 'a', 'ā' => 'a', 'ä' => 'ae', 'æ' => 'ae', 'Ǽ' => 'ae', 'ǽ' => 'ae',
        'б' => 'b', 'ב' => 'b', 'Б' => 'b', 'þ' => 'b',
        'ĉ' => 'c', 'Ĉ' => 'c', 'Ċ' => 'c', 'ć' => 'c', 'ç' => 'c', 'ц' => 'c', 'צ' => 'c', 'ċ' => 'c', 'Ц' => 'c', 'Č' => 'c', 'č' => 'c', 'Ч' => 'ch', 'ч' => 'ch',
        'ד' => 'd', 'ď' => 'd', 'Đ' => 'd', 'Ď' => 'd', 'đ' => 'd', 'д' => 'd', 'Д' => 'D', 'ð' => 'd',
        'є' => 'e', 'ע' => 'e', 'е' => 'e', 'Е' => 'e', 'Ə' => 'e', 'ę' => 'e', 'ĕ' => 'e', 'ē' => 'e', 'Ē' => 'e', 'Ė' => 'e', 'ė' => 'e', 'ě' => 'e', 'Ě' => 'e', 'Є' => 'e', 'Ĕ' => 'e', 'ê' => 'e', 'ə' => 'e', 'è' => 'e', 'ë' => 'e', 'é' => 'e',
        'ф' => 'f', 'ƒ' => 'f', 'Ф' => 'f',
        'ġ' => 'g', 'Ģ' => 'g', 'Ġ' => 'g', 'Ĝ' => 'g', 'Г' => 'g', 'г' => 'g', 'ĝ' => 'g', 'ğ' => 'g', 'ג' => 'g', 'Ґ' => 'g', 'ґ' => 'g', 'ģ' => 'g',
        'ח' => 'h', 'ħ' => 'h', 'Х' => 'h', 'Ħ' => 'h', 'Ĥ' => 'h', 'ĥ' => 'h', 'х' => 'h', 'ה' => 'h',
        'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ì' => 'i', 'į' => 'i', 'ĭ' => 'i', 'ı' => 'i', 'Ĭ' => 'i', 'И' => 'i', 'ĩ' => 'i', 'ǐ' => 'i', 'Ĩ' => 'i', 'Ǐ' => 'i', 'и' => 'i', 'Į' => 'i', 'י' => 'i', 'Ї' => 'i', 'Ī' => 'i', 'І' => 'i', 'ї' => 'i', 'і' => 'i', 'ī' => 'i', 'ĳ' => 'ij', 'Ĳ' => 'ij',
        'й' => 'j', 'Й' => 'j', 'Ĵ' => 'j', 'ĵ' => 'j', 'я' => 'ja', 'Я' => 'ja', 'Э' => 'je', 'э' => 'je', 'ё' => 'jo', 'Ё' => 'jo', 'ю' => 'ju', 'Ю' => 'ju',
        'ĸ' => 'k', 'כ' => 'k', 'Ķ' => 'k', 'К' => 'k', 'к' => 'k', 'ķ' => 'k', 'ך' => 'k',
        'Ŀ' => 'l', 'ŀ' => 'l', 'Л' => 'l', 'ł' => 'l', 'ļ' => 'l', 'ĺ' => 'l', 'Ĺ' => 'l', 'Ļ' => 'l', 'л' => 'l', 'Ľ' => 'l', 'ľ' => 'l', 'ל' => 'l',
        'מ' => 'm', 'М' => 'm', 'ם' => 'm', 'м' => 'm',
        'ñ' => 'n', 'н' => 'n', 'Ņ' => 'n', 'ן' => 'n', 'ŋ' => 'n', 'נ' => 'n', 'Н' => 'n', 'ń' => 'n', 'Ŋ' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'Ň' => 'n', 'ň' => 'n',
        'о' => 'o', 'О' => 'o', 'ő' => 'o', 'õ' => 'o', 'ô' => 'o', 'Ő' => 'o', 'ŏ' => 'o', 'Ŏ' => 'o', 'Ō' => 'o', 'ō' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'ǒ' => 'o', 'ò' => 'o', 'Ǿ' => 'o', 'Ǒ' => 'o', 'ơ' => 'o', 'ó' => 'o', 'Ơ' => 'o', 'œ' => 'oe', 'Œ' => 'oe', 'ö' => 'oe',
        'פ' => 'p', 'ף' => 'p', 'п' => 'p', 'П' => 'p',
        'ק' => 'q',
        'ŕ' => 'r', 'ř' => 'r', 'Ř' => 'r', 'ŗ' => 'r', 'Ŗ' => 'r', 'ר' => 'r', 'Ŕ' => 'r', 'Р' => 'r', 'р' => 'r',
        'ș' => 's', 'с' => 's', 'Ŝ' => 's', 'š' => 's', 'ś' => 's', 'ס' => 's', 'ş' => 's', 'С' => 's', 'ŝ' => 's', 'Щ' => 'sch', 'щ' => 'sch', 'ш' => 'sh', 'Ш' => 'sh', 'ß' => 'ss',
        'т' => 't', 'ט' => 't', 'ŧ' => 't', 'ת' => 't', 'ť' => 't', 'ţ' => 't', 'Ţ' => 't', 'Т' => 't', 'ț' => 't', 'Ŧ' => 't', 'Ť' => 't', '™' => 'tm',
        'ū' => 'u', 'у' => 'u', 'Ũ' => 'u', 'ũ' => 'u', 'Ư' => 'u', 'ư' => 'u', 'Ū' => 'u', 'Ǔ' => 'u', 'ų' => 'u', 'Ų' => 'u', 'ŭ' => 'u', 'Ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'ű' => 'u', 'Ű' => 'u', 'Ǖ' => 'u', 'ǔ' => 'u', 'Ǜ' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'У' => 'u', 'ǚ' => 'u', 'ǜ' => 'u', 'Ǚ' => 'u', 'Ǘ' => 'u', 'ǖ' => 'u', 'ǘ' => 'u', 'ü' => 'ue',
        'в' => 'v', 'ו' => 'v', 'В' => 'v',
        'ש' => 'w', 'ŵ' => 'w', 'Ŵ' => 'w',
        'ы' => 'y', 'ŷ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ÿ' => 'y', 'Ŷ' => 'y',
        'Ы' => 'y', 'ž' => 'z', 'З' => 'z', 'з' => 'z', 'ź' => 'z', 'ז' => 'z', 'ż' => 'z', 'ſ' => 'z', 'Ж' => 'zh', 'ж' => 'zh'
    );
    return strtr($s, $replace);
}
