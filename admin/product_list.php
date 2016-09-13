<?php
include_once 'admin_header.php';
$query1 = "SELECT `product_id`,`product_name`,`product_price`,`production_year`,product.url_img,`type_name`,`producer_name` FROM `product` INNER JOIN `product_type` ON product.type_id = product_type.type_id INNER JOIN `producer` ON product.producer_id = producer.producer_id ";
$query2 = "SELECT * FROM `product_type`";
$query3 = "SELECT * FROM `producer`";
$query4 = "SELECT * FROM `specifications`";
$result1 = execute_query($query1);
$result2 = execute_query($query2);
$result3 = execute_query($query3);
$result4 = execute_query($query4);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Sản Phẩm</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá Sản Phẩm</th>
                <th>Loại</th>
                <th>Nhà Sản Xuất</th>
                <th>Năm Sản Xuất</th>
                <th>Ảnh</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <?php
                    $stt = 0;
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $stt++;
                            ?>
                            <tr>
                                <td><?php echo $stt; ?></td>
                                <td><?php echo $row["product_id"]; ?></td>
                                <td><?php echo $row["product_name"]; ?></td>
                                <td><?php echo $row["product_price"]; ?></td>
                                <td><?php echo $row["type_name"]; ?></td>
                                <td><?php echo $row["producer_name"]; ?></td>
                                <td><?php echo $row["production_year"]; ?></td>          
                                <td><ul class="enlarge"><?php echo $row["img_url"]; ?><li><img src="<?php echo "../imgs/" . $row["img_url"]; ?>" style="width: 1.5em;" alt="anhdaidien"/><span><img src="<?php echo "../imgs/" . $row["img_url"]; ?>" alt="Deckchairs" style="width:400px"/><br /></span></li></ul></td>
                                <td><a href="#" title="Sửa thông tin"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                                <td><a href="../process/producer_fn.php?id_del=<?php echo $row["producer_id"]; ?>" title="xóa thông tin" id="del" data-del="<?php echo $row["producer_id"] ?>"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="col-lg-6">
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Thêm Mới</button>
            </div>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" method="post" action="../process/producer_fn.php?do=add_new" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center text-primary">Thêm mới sản phẩm</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Mã sản phẩm:</div>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="producer_name"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Tên sản phẩm:</div>                                    
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="country"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Giá sản phẩm:</div>                                      <label class="col-sm-4 col-xs-4"></label>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="country"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Loại sản phẩm:</div>                                         
                                    <div class="col-sm-9 col-xs-9">
                                        <select name="type_id" class="form-control col-sm-4 col-xs-4">    
                                            <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                                                <option value="<?php echo $row2['type_id'] ?>">
                                                    <?php echo $row2['type_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Nhà sản xuất:</div>                                     
                                    <div class="col-sm-9 col-xs-9">
                                        <select name="producer_id" class="col-sm-4 col-xs-4 form-control">    
                                            <?php while ($row3 = mysqli_fetch_assoc($result3)) { ?>
                                                <option value="<?php echo $row3['producer_id'] ?>">
                                                    <?php echo $row3['producer_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Ảnh đại diện:</div>                                  
                                    <div class="col-sm-9 col-xs-9"><input type="file" required name="img_url"/></div>
                                </div>
                                <div class="form-group">
                                  <div class="col-sm-3 col-xs-3">Thông số kỹ thuật:</div> 
                                    <div class="col-sm-9 col-xs-9">
                                        <select name="specifications_id" class="col-sm-4 col-xs-4 form-control">    
                                            <?php while ($row4 = mysqli_fetch_assoc($result4)) { ?>
                                                <option value="<?php echo $row4['specifications_id'] ?>">
                                                    <?php echo $row4['specifications_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Mô tả:</div>                                    
                                    <div class=" col-sm-9 col-xs-9">
                                        <textarea name="specifications_des" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3"><button class="btn btn-success" type="button">Thêm Thông số</button></div>                                    
                                    <div class=" col-sm-9 col-xs-9">                                        
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="add_new">Thêm</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--<script>
    function del() {
        $.ajax({
            url: "../process/producer_fn.php",
            type: "post",
            dateType: "text",
            data: {
                producer_id: $('#number').val()
            },
            success: 
        });
    }
</script>-->
<?php include_once 'admin_footer.php' ?>