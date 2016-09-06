<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `producer`";
$result = execute_query($query);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
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
                                <td><?php echo $row["img_url"]; ?></td>
                                <td><a href="#" title="Sửa thông tin"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1em;"/></a></td>
                                <td><a href="#" title="xóa thông tin"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1em;"/></a></td>
                            </tr>
                        <?php }
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
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Thêm mới nhà sản xuất</h4>
                        </div>
                        <div class="modal-body">
                            <p>Some text in the modal.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success">Thêm</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'admin_footer.php' ?>