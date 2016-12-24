<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_GET['updateid'])) {
    showProducerInfo();
}
if (isset($_REQUEST['updateProduct'])) {
    pro_update();
    redirect('../admin/product_list.php');
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
// KHÔNG dung nhu the nay
// $username = $_POST['username'];
    $product_code = post("product_code");
    $product_name = post("product_name");
    $product_price = post("product_price");
    $type_id = post("type_id");
    $product_line_id = post("product_line_id");
    $producer_id = post("producer_id");
    $img_url = "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);

    if (upload_image() == 'true') {
        $result = execute_query("INSERT INTO `product` VALUES (NULL,'$product_code','$product_name','$product_price','$type_id','$product_line_id','$producer_id','$img_url');");
        if ($result) {
            insert_product_details();
            redirect('../admin/product_list.php');
        }
    } else {
        $message = upload_image();
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
//die();
}

function insert_product_details() {
    $result = execute_query("SELECT MAX(product_id) FROM product");
    $row = mysqli_fetch_row($result);
    $product_id = $row[0];
    $sp_id = post("specifications_id");
    $sp_des = post("specifications_des");
    $pro_details = "INSERT INTO `product_details` (product_id,specifications_id,specifications_des) VALUES ";
    $comma = "";
    for ($i = 0; $i < count($sp_id); $i++) {
        $pro_details .=$comma . "('$product_id','$sp_id[$i]','$sp_des[$i]')";
        $comma = ",";
    }
//    die($pro_details);
    execute_query($pro_details);
}
function update_product_details() {    
    $product_id = post("product_id");
    $sp_id = post("specifications_id");
    $sp_des = post("specifications_des");    
  
    for ($i = 0; $i < count($sp_id); $i++) {
        $pro_details = "UPDATE `product_details` SET `specifications_des`='$sp_des[$i]' WHERE `product_id`=$product_id AND `specifications_id`=$sp_id[$i]";              
        execute_query($pro_details);
    }
//    die($pro_details);
    
}

function upload_image() {
//    $url = $_FILES["img_url"]["name"];
//    $type = $_FILES['img_url']['type'];
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
                $path = "../imgs/"; // file sẽ lưu vào thư mục imgs
                $tmp_name = $_FILES['img_url']['tmp_name'];
                $name = $path . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
//                $type = $_FILES['img_url']['type'];
//                $size = $_FILES['img_url']['size'];
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

function pro_update() {
    $product_id = post("product_id");
    $product_code = post("product_code");
    $product_name = post("product_name");
    $product_price = post("product_price");
    $type_id = post("type_id");
    $product_line_id = post("product_line_id");
    $producer_id = post("producer_id");
    
    if ($_FILES['img_url']['name'] == NULL) {
        $query = "UPDATE `product` SET  `product_code`= '$product_code', `product_name` = '$product_name', `product_price` = '$product_price', `type_id` = '$type_id',`product_line_id`=$product_line_id, `producer_id` = '$producer_id' WHERE product_id='$product_id'";
//        die(iconv("utf-8", "cp936",$query));
        execute_query($query);
    } else {
        $img_url = "../imgs/" . iconv("utf-8", "cp936", $_FILES['img_url']['name']);
        upload_image();
        $query = "UPDATE `product` SET  `product_code`= '$product_code', `product_name` = '$product_name', `product_price` = '$product_price', `type_id` = '$type_id', `producer_id` = '$producer_id',`img_url` = '$img_url' WHERE product_id='$product_id'";
        execute_query($query);
    }
    update_product_details();
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
    $idProduct = get("updateid");
    $query = "SELECT * FROM `product` where product_id='$idProduct'";
    $query1 = "SELECT * FROM `product_details` where product_id='$idProduct'";
    $query2 = "SELECT * FROM `product_type`";
    $query3 = "SELECT * FROM `producer`";
    $query4 = "SELECT * FROM `specification_type`";
    $query5 = "SELECT * FROM `view_product_details` where product_id='$idProduct'";
    $query6 = "SELECT * FROM `product_lines`";
    $result2 = execute_query($query2);
    $result3 = execute_query($query3);
    $result4 = execute_query($query4);
    $result5 = execute_query($query5);
    $result6 = execute_query($query6);
    $result = execute_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
            <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="form-title" class="modal-title text-center text-primary">Thay đổi thông tin sản phẩm</h4>
                    </div>
                    <div class="modal-body" id="form-body">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Mã sản phẩm:</div>
                            <div class="col-sm-9 col-xs-9"><input id="pro-code" type="text" value="' . $row["product_code"] . '" required class="form-control" name="product_code"/></div>
                            <div class="col-sm-9 col-xs-9"><input id="pro-id" type="hidden" value="' . $row["product_id"] . '" required class="form-control" name="product_id"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Tên sản phẩm:</div>                                    
                            <div class="col-sm-9 col-xs-9"><input id="pro-name" type="text" value="' . $row["product_name"] . '" required class="form-control" name="product_name"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Giá sản phẩm:</div>
                            <div class="col-sm-9 col-xs-9"><input id="pro-price" type="text" value="' . $row["product_price"] . '" required class="form-control" name="product_price"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Loại sản phẩm:</div>                                         
                            <div class="col-sm-9 col-xs-9">
                                <select id="type_product" name="type_id" class="form-control col-sm-4 col-xs-4">';
        while ($row2 = mysqli_fetch_assoc($result2)) {
            echo '<option value="' . $row2["type_id"] . '"';
            echo $row2["type_id"] == $row["type_id"] ? "selected" : "";
            echo '>
                                                                    ' . $row2['type_name'] . '
                                                                </option>';
        }
        echo '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Nhà sản xuất:</div>                                     
                            <div class="col-sm-9 col-xs-9">
                                <select name="producer_id" class="col-sm-4 col-xs-4 form-control">';
        while ($row3 = mysqli_fetch_assoc($result3)) {
            echo '<option value="' . $row3["producer_id"] . '"';
            echo $row3["producer_id"] == $row["producer_id"] ? "selected" : "";
            echo '>
                                                                    ' . $row3['producer_name'] . '
                                                                </option>';
        }
        echo
        '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Dòng sản phẩm:</div>                                     
                            <div class="col-sm-9 col-xs-9">
                                <select name="product_line_id" class="col-sm-4 col-xs-4 form-control">';    
                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                       echo '<option value="'.$row6['product_line_id'].'"';
                                       echo $row6["product_line_id"] == $row["product_line_id"] ? "selected" : "";
                                       echo '>'.
                                            $row6['product_line_name'].'
                                        </option>';
                                    }
                              echo  '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Ảnh đại diện:</div>                                  
                            <div class="col-sm-9 col-xs-9"><input id="pro-imgs" type="file" name="img_url"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 text-center"><h4>Thông số kỹ thuật</h6></div>                                                                     
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Loại Thông số kỹ thuật:</div>                                     
                            <div class="col-sm-6 col-xs-6">
                                <select id="sp_type" name="sp_type" class="col-sm-4 col-xs-4 form-control">';
        while ($row4 = mysqli_fetch_assoc($result4)) {
            echo '<option value="' . $row4['type_id'] . '">
                                            ' . $row4['type_name'] . '
                                        </option>';
        }
        echo '</select>
                            </div>   
                            <div class="col-sm-3 col-xs-3">
                                <button type="button" class="btn btn-success" onclick="load_sp()">Thêm thông số</button>
                            </div>  
                        </div>                        
                        <div class="form-group">                            
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Thông số Kỹ thuật</th>
                                        <th>Loại</th>
                                        <th>Mô tả</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bd-sp">';
        while ($row5 = mysqli_fetch_assoc($result5)) {
            echo
            '<tr>
    <td>
    ' . $row5["specifications_name"] . '
        <input type="hidden" name="specifications_id[]" value="' . $row5["specifications_id"] . '">
    </td>
    <td>
    ' . $row5["type_name"] . '
    </td>
    <td>
    <textarea name = "specifications_des[]" class = "form-control col-sm-9 col-xs-9">' . $row5["specifications_des"] . '</textarea>
    </td>
    <td>
    <button type = "button" class = "btn btn-success" onclick = "remove_pro(this)">Xóa</button>
    </td>
    </tr>';
        }
        echo '</tbody>
                            </table>                            
                        </div>                                                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="updateProduct">Lưu</button>
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>';
    }
}

function delete() {
    $id = get("id_del");
    $result = execute_query($query);
    execute_query("DELETE FROM `product` WHERE `product_id` = '$id'");
    redirect("../admin/product_list.php");
}
