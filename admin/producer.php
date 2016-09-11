<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `producer`";
$result = execute_query($query);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Nhà Sản Xuất</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>ID</th>
                <th>Tên Nhà SX</th>
                <th>Xuất Xứ</th>
                <th>Ảnh đại diện</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <?php
                    $stt = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $stt++;
                            ?>
                            <tr>
                                <td><?php echo $stt; ?></td>
                                <td><?php echo $row["producer_id"]; ?></td>
                                <td><?php echo $row["producer_name"]; ?></td>
                                <td><?php echo $row["country"]; ?></td>
                                <td><?php echo $row["img_url"]; ?><img src="<?php echo "../imgs/".$row["img_url"];?>" style="width: 1.5em;" alt="anhdaidien"/></td>
                                <td><a href="#" title="Sửa thông tin"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                                <td><a href="../process/producer_fn.php?id_del=<?php echo $row["producer_id"];?>" title="xóa thông tin" id="del" data-del="<?php echo $row["producer_id"]?>"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
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
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" method="post" action="../process/producer_fn.php?do=add_new" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Thêm mới nhà sản xuất</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-4">Tên nhà sản xuất:</label>
                                    <div class="col-sm-8 col-xs-8"><input type="text" required class="form-control" name="producer_name"/></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-4">Xuất xứ:</label>
                                    <div class="col-sm-8 col-xs-8"><input type="text" required class="form-control" name="country"/></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-4">Ảnh đại diện:</label>
                                    <div class="col-sm-8 col-xs-8"><input type="file" required name="img_url"/></div>
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
<script>
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
</script>
<?php include_once 'admin_footer.php' ?>