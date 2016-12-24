<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
if (isset($_GET['update'])) {
    showProducerInfo();
}
if (isset($_REQUEST['updateProLine'])) {
    pro_update();
    redirect('../admin/product_line.php');
}
if (isset($_GET['id_del'])) {
    delete();
}

function add_new() {
    // KHÔNG dung nhu the nay
    // $username = $_POST['username'];
    $producer_id = post("producer_id");
    $type_id = post("type_id");
    $product_line_name = post("product_line_name");

    execute_query("INSERT INTO `product_lines` VALUES (NULL,'$product_line_name','$type_id','$producer_id');");
    redirect('../admin/product_line.php');
}

function pro_update() {
    $producer_id = post("producer_id");
    $product_line_id = post("product_line_id");
    $type_id = post("type_id");
    $product_line_name = post("product_line_name");

    execute_query("UPDATE `product_lines` SET `product_line_name`='$product_line_name',`type_id`='$type_id',`producer_id`='$producer_id' where `product_line_id`='$product_line_id'");
    redirect('../admin/product_line.php');
}

function showProducerInfo() {
    $idProduciline = get("update");
    $query = "SELECT * FROM `view_product_line` where `product_line_id`='$idProduciline'";
    $query2 = "SELECT * FROM `product_type`";
    $query3 = "SELECT * FROM `producer`";
    $result = execute_query($query);
    $result2 = execute_query($query2);
    $result3 = execute_query($query3);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center text-primary">Thêm mới loại sản phẩm</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Nhà sản xuất:</div>                                     
                            <div class="col-sm-9 col-xs-9">
                                <select name="producer_id" class="col-sm-4 col-xs-4 form-control">';
        while ($row3 = mysqli_fetch_assoc($result3)) {
            echo '<option value="' . $row3['producer_id'] . '" ';
            echo $row["producer_id"]==$row3['producer_id']?"selected":"";
            echo '>
                                            ' . $row3['producer_name'] . '
                                        </option>';
        }
        echo '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Loại sản phẩm:</div>                                         
                            <div class="col-sm-9 col-xs-9">
                                <select id="type_product" name="type_id" class="form-control col-sm-4 col-xs-4">';
        while ($row2 = mysqli_fetch_assoc($result2)) {
            echo '<option value="' . $row2['type_id'] . '"';
            echo $row["type_id"]==$row2['type_id']?"selected":"";
            echo '>
                                            ' . $row2['type_name'] . '
                                        </option>';
        }
        echo '</select>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Dòng sản phẩm:</div>                                  
                            <div class="col-sm-9 col-xs-9"><input id="pro-line" type="text" required class="form-control" name="product_line_name" value="'.$row["product_line_name"].'"/></div>
                        </div>
                        <input id="pro-line" type="hidden" name="product_line_id" value="'.$row["product_line_id"].'"/>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="updateProLine" value="Lưu"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>';
    }
}

function delete() {
    $id = get("id_del");    
    execute_query("DELETE FROM `product_lines` WHERE `product_line_id` = '$id'");
    redirect("../admin/product_line.php");
}
