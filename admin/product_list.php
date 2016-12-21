<?php
include_once 'admin_header.php';
$query1 = "SELECT * from `view_product`";
$query2 = "SELECT * FROM `product_type`";
$query3 = "SELECT * FROM `producer`";
$query4 = "SELECT * FROM `specification_type`";
$query5 = "SELECT * FROM `specifications`";
$result1 = execute_query($query1);
$result2 = execute_query($query2);
$result3 = execute_query($query3);
$result4 = execute_query($query4);
$rowpage = 15;
$n = get("page");
if (!get("page")) {
    $n = 1;
}
$offset = ($n - 1) * $rowpage;

$rs_count = execute_query("SELECT COUNT(*) as cnt FROM product");
$count_row = mysqli_fetch_assoc($rs_count);
$total = $count_row["cnt"];

$rs = execute_query("$query1 LIMIT $offset, $rowpage");
$stt = 0;
$total_page = ceil($total / $rowpage);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <H2>Danh Sách Sản Phẩm</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>               
                <th>Tên Sản Phẩm</th>
                <th>Giá Sản Phẩm</th>
                <th>Loại</th>
                <th>Nhà Sản Xuất</th>                
                <th>Ảnh</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < mysqli_num_rows($rs); $i++) {
                        $stt = $i + 1 + $offset;
                        $row = mysqli_fetch_assoc($rs)
                        ?>
                        <tr>
                            <td style="vertical-align: middle"><?php echo $stt; ?></td>                            
                            <td style="vertical-align: middle"><?php echo $row["product_name"]; ?></td>
                            <td style="vertical-align: middle"><?php echo number_format($row["product_price"]); ?></td>
                            <td style="vertical-align: middle"><?php echo $row["type_name"]; ?></td>
                            <td style="vertical-align: middle"><?php echo $row["producer_name"]; ?></td>                                  
                            <td style="vertical-align: middle"><ul class="enlarge"><?php echo $row["img_url"]; ?><li><img src="<?php echo $row["img_url"]; ?>" style="width: 1.5em;" alt="anhdaidien"/><span><img src="<?php echo $row["img_url"]; ?>" alt="Deckchairs" style="width:400px"/><br /></span></li></ul></td>
                            <td style="width: 30px;vertical-align: middle"><a href="#" onclick="showHint(<?php echo $row["product_id"]; ?>)" title="Sửa thông tin" data-toggle="modal" data-target="#myModalUpdate"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                            <td style="width: 30px;vertical-align: middle"><a href="../process/product_fn.php?id_del=<?php echo $row["product_id"]; ?>" title="xóa thông tin" id="del" data-del="<?php echo $row["producer_id"] ?>"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Thêm Mới</button>
        </div>
    </div>            
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content" style="padding-left: 15px;padding-right: 15px;padding-bottom: 10px;padding-top: 10px">
                <form id="pro-form" accept-charset="utf-8" class="form-horizontal" role="form" method="post" action="../process/product_fn.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="form-title" class="modal-title text-center text-primary">Thêm mới sản phẩm</h4>
                    </div>
                    <div class="modal-body" id="form-body">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Mã sản phẩm:</div>
                            <div class="col-sm-9 col-xs-9"><input id="pro-code" type="text" required class="form-control" name="product_code"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Tên sản phẩm:</div>                                    
                            <div class="col-sm-9 col-xs-9"><input id="pro-name" type="text" required class="form-control" name="product_name"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Giá sản phẩm:</div>
                            <div class="col-sm-9 col-xs-9"><input id="pro-price" type="text" required class="form-control" name="product_price"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Loại sản phẩm:</div>                                         
                            <div class="col-sm-9 col-xs-9">
                                <select id="type_product" name="type_id" class="form-control col-sm-4 col-xs-4">    
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
                            <div class="col-sm-9 col-xs-9"><input id="pro-imgs" type="file" required name="img_url"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 text-center"><h4>Thông số kỹ thuật</h6></div>                                                                     
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">Loại Thông số kỹ thuật:</div>                                     
                            <div class="col-sm-6 col-xs-6">
                                <select id="sp_type" name="sp_type" class="col-sm-4 col-xs-4 form-control">    
                                    <?php while ($row4 = mysqli_fetch_assoc($result4)) { ?>
                                        <option value="<?php echo $row4['type_id'] ?>">
                                            <?php echo $row4['type_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
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
                                <tbody id="bd-sp">                                                                            
                                </tbody>
                            </table>                            
                        </div>                                                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="add_new">Thêm</button>
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="myModalUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content" style="padding-left: 15px;padding-right: 15px;padding-bottom: 10px;padding-top: 10px">
                <form id="pro-form-update" accept-charset="utf-8" class="form-horizontal" role="form" method="post" action="../process/product_fn.php" enctype="multipart/form-data">                    
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
//    $(Document).ready(function () {
//        $(window).load(function () {
//            $("#sp_type option:first").attr('selected', 'selected');
//            var id_sp = $('#sp_type').val();
//            $.ajax({
//                type: "POST",
//                url: "../process/load_sp.php",
//                data: "type_id=" + id_sp,
//                success: function (data) {
//                    $("#bd-sp").append(data);
//                }
//            });
//        });
//
//    });
//Thêm sản phẩm
    function add_pro() {
        var row = '<tr><td><select name="specifications_id" class="col-sm-4 col-xs-4 form-control">'
                + '<?' + 'php while ($row4 = mysqli_fetch_assoc($result4)) { ?>'
                + ' <option value=' + '<?' + 'php echo $row4["specifications_id"] ?>' + '>'
                + '<?' + 'php echo $row4["specifications_name"] ?></option><?' +
                'php } ?></select></td><td><textarea name="specifications_des" ' +
                'class="form-control col-sm-9 col-xs-9"></textarea></td></tr> ';
        //Thực hiện chèn
        $('#bd-sp').append(row);
    }
    function remove_pro(el) {
        if (confirm('Xóa thông số ?')) {
            $(el).parent().parent().remove();
        }
    }
    function load_sp() {
        var id_sp = $('#sp_type').val();
        $.ajax({
            type: "POST",
            url: "../process/load_sp.php",
            data: "type_id=" + id_sp,
            success: function (data) {
                $("#bd-sp").append(data);
            }
        });
    }
//    function clearform() {
//        $('#bd-sp').empty();
//        $('#pro-code').val('');
//        $('#pro-name').val('');
//        $('#pro-price').val('');                
//    }
    function showHint(IdUpdate) {
        if (IdUpdate.length == 0) {
            document.getElementById("pro-form-update").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("pro-form-update").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "../process/product_fn.php?updateid=" + IdUpdate, true);
            xmlhttp.send();
        }
    }
   
</script>
<?php include_once 'admin_footer.php' ?>