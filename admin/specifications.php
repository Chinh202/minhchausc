<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `specifications`";
$result = execute_query($query);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Các Thông Số Kỹ Thuật</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>ID</th>
                <th>Tên Thông Số Kỹ Thuật</th>              
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
                                <td><?php echo $row["specifications_id"]; ?></td>
                                <td><?php echo $row["specifications_name"]; ?></td>                                             
                                <td><a href="#" title="Sửa thông tin"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                                <td><a href="../process/specifications_fn.php?id_del=<?php echo $row["specifications_id"]; ?>" title="xóa thông tin" id="del"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
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
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" method="post" action="../process/specifications_fn.php" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Thêm Mới Thông Số Kỹ Thuật</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">Tên :</div>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="specifications_name"/></div>                                    
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
<?php include_once 'admin_footer.php'; ?>