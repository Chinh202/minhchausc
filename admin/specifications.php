<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `specifications`";
$result = execute_query($query);
$id = get("id");
$rowpage = 10;
$n = get("page");
if (!get("page")) {
    $n = 1;
}
$offset = ($n - 1) * $rowpage;

$rs_count = execute_query("SELECT COUNT(*) as cnt FROM specifications");
$count_row = mysqli_fetch_assoc($rs_count);
$total = $count_row["cnt"];

$rs = execute_query("$query LIMIT $offset, $rowpage");
$stt = 0;
$total_page = ceil($total / $rowpage);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Các Thông Số Kỹ Thuật</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>Tên Thông Số Kỹ Thuật</th>              
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        for ($i = 0; $i < mysqli_num_rows($rs); $i++) {
                            $stt = $i + 1 + $offset;
                            $row = mysqli_fetch_assoc($rs)
                            ?>
                            <tr>    
                                <td><?php echo $stt; ?></td>
                                <td><?php echo $row["specifications_name"]; ?></td>                                             
                                <td><a href="#" title="Sửa thông tin" onclick="update();"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                                <td><a href="../process/specifications_fn.php?id_del=<?php echo $row["specifications_id"]; ?>&page=<?php echo $n ?>" title="xóa thông tin" id="del"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <ul class="pagination">
                <li>
                    <?php
                    if ($n > 1) {
                        echo "<a href='?page=" . ($n - 1) . "'>&laquo;</a>";
                    }
                    ?>

                </li>
                <?php
                for ($i = 1; $i <= $total_page; $i++) {
                    ?>                   
                    <li><?php echo "<a href='?page=$i'>$i</a>"; ?></li>                    
                <?php }
                ?> 
                <li>                         
                    <?php
                    if ($n <= ($total_page - 1)) {
                        echo "<a href='?page=" . ($n + 1) . "'>&raquo;</a>";
                    }
                    ?>
                </li>
            </ul>
            <div class="col-lg-6">
                <button class="btn btn-info" data-toggle="modal" data-target="#Modalform">Thêm Mới</button>
            </div>
            <!-- Modal -->
            <div id="Modalform" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" method="post" action="../process/specifications_fn.php" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="title">Thêm Mới Thông Số Kỹ Thuật</h4>
                            </div>
                            <div class="modal-body">
                                <input name="specifications_id" value="" style="visibility: hidden"/>
                                <div class="form-group">                                    
                                    <div class="col-sm-3 col-xs-3">Tên :</div>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="specifications_name"/></div>                                    
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="add_new">Thêm</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="submit">Đóng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function update() {
        $("#Modalform").modal('show');
        jQuery.noConflict(); 
        $("#title").val("Sửa Tên Thông Số");
        $("#submit").attr("name", "update");        
    }
</script>
<?php include_once 'admin_footer.php'; ?>