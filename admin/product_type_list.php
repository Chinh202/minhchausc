<?php include_once 'admin_header.php';
$query = "SELECT `type_id`, `type_name`, `url_img` FROM `product_type`";
$result = execute_query($query);
$rowpage = 15;
$n = get("page");
if (!get("page")) {
    $n = 1;
}
$offset = ($n - 1) * $rowpage;

$rs_count = execute_query("SELECT COUNT(*) as cnt FROM `product_type`");
$count_row = mysqli_fetch_assoc($rs_count);
$total = $count_row["cnt"];

$rs = execute_query("$query LIMIT $offset, $rowpage");
$stt = 0;
$total_page = ceil($total / $rowpage);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Loại Sản Phẩm</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>Loại Sản Phẩm</th>
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
                            <td><?php echo $stt; ?></td>
                            <td><?php echo $row["type_name"]; ?></td>     
                            <td><ul class="enlarge"><?php echo $row["url_img"]; ?><li><img src="<?php echo "../imgs/" . $row["url_img"]; ?>" style="width: 1.5em;" alt="anhdaidien"/><span><img src="<?php echo "../imgs/" . $row["url_img"]; ?>" alt="Deckchairs" style="width:400px"/><br /></span></li></ul></td>
                            <td><a href="#" title="Sửa thông tin"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                            <td><a href="../process/producer_type_fn.php?id_del=<?php echo $row["type_id"]; ?>" title="xóa thông tin" id="del" data-del="<?php echo $row["type_id"] ?>"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
                        </tr>img
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="col-lg-6">
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Thêm Mới</button>
            </div>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-md">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" method="post" action="../process/product_type_fn.php?do=add_new" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center text-primary">Thêm mới loại sản phẩm</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Loại sản phẩm:</div>                                    
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="type_name"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Ảnh đại diện:</div>                                  
                                    <div class="col-sm-9 col-xs-9"><input type="file" required name="url_img"/></div>
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

<?php include_once 'admin_footer.php'?>

