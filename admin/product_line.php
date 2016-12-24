<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `view_product_line`";
$query2 = "SELECT * FROM `product_type`";
$query3 = "SELECT * FROM `producer`";
$result = execute_query($query);
$result2 = execute_query($query2);
$result3 = execute_query($query3);
$rowpage = 15;
$n = get("page");
if (!get("page")) {
    $n = 1;
}
$offset = ($n - 1) * $rowpage;

$rs_count = execute_query("SELECT COUNT(*) as cnt FROM `view_product_line`");
$count_row = mysqli_fetch_assoc($rs_count);
$total = $count_row["cnt"];

$rs = execute_query("$query LIMIT $offset, $rowpage");
$stt = 0;
$total_page = ceil($total / $rowpage);
?>
<script>
    function checkupload() {
        // lay dung luong va kieu file tu the input file
        var fsize = $("#submit")[0].files[0].size;
        var ftype = $("#submit")[0].files[0].type;
        var fname = $("#submit")[0].files[0].name;

        if (ftype == 'image/png' || 'image/gif') {
            return true;
        }
        return false;
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Dòng Sản Phẩm</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th style="text-align: center">STT</th>
                <th style="text-align: center">Dòng Sản Phẩm</th>
                <th style="text-align: center">Loại Sản Phẩm</th>
                <th style="text-align: center">Nhà Sản Xuất</th>
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
                            <td align="center"><?php echo $stt; ?></td>
                            <td><?php echo $row["product_line_name"]; ?></td>     
                            <td><?php echo $row["type_name"]; ?></td>     
                            <td><?php echo $row["producer_name"]; ?></td>                                 
                            <td align="center"><a href="#" data-toggle="modal" data-target="#myModalUpdate" title="Sửa thông tin" onclick="updateProductline(<?php echo $row["product_line_id"] ?>)"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                            <td align="center"><a href="../process/product_line_fn.php?id_del=<?php echo $row["product_line_id"]; ?>" title="xóa thông tin" id="del" onclick="return confirm('Bạn muốn xóa dòng sản phẩm này ?')"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
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
            <button class="btn btn-info" data-toggle="modal" data-target="#myModalInsert">Thêm Mới</button>
        </div>
    </div>
    <!-- Modal add new -->
    <div id="myModalInsert" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="insert-form" accept-charset="utf-8" class="form-horizontal" role="form" method="post" action="../process/product_line_fn.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center text-primary">Thêm mới loại sản phẩm</h4>
                    </div>
                    <div class="modal-body">
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
                            <div class="col-sm-3 col-xs-3">Dòng sản phẩm:</div>                                  
                            <div class="col-sm-9 col-xs-9"><input id="pro-line" type="text" required class="form-control" name="product_line_name"/></div>
                        </div>                                                                                              
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="add_new" value="Thêm"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Modal edit -->
    <div id="myModalUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="formUpdate" accept-charset="utf-8" class="form-horizontal" role="form" method="post" action="../process/product_line_fn.php" enctype="multipart/form-data">                    
                </form>
            </div>
            <script type="text/javascript">
                function updateProductline(IdUpdate) {
                    if (IdUpdate.length == 0) {
                        document.getElementById("formUpdate").innerHTML = "";
                        return;
                    } else {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("formUpdate").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "../process/product_line_fn.php?update=" + IdUpdate, true);
                        xmlhttp.send();
                    }
                }
            </script>
        </div>
    </div>
</div>

<?php include_once 'admin_footer.php'; ?>