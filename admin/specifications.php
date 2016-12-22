<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `view_specifications`";
$query1 = "SELECT * FROM `specification_type`";
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
<?php
$sql = "Select * from specification_type";
$result_spt = execute_query($sql);
?>
<script language="javascript">
//    function submit_ajax() {
//        $.ajax({
//            url: "../process/specifications_fn.php",
//            type: "post",
//            dateType: "text",
//            data: $("#sp-form").serialize(),
//            success: function (result) {
//                $('#bd').html(result);
//            }
//        });
//    }
    function load_ajax(IdUpdate) {
        if (IdUpdate.length == 0) {
            document.getElementById("sp-form").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("sp-form").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "../process/specifications_fn.php?idUpdate=" + IdUpdate, true);
            xmlhttp.send();
        }
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <H2>Danh Sách Các Thông Số Kỹ Thuật</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>Tên Thông Số Kỹ Thuật</th>              
                <th>Loại Thông Số</th>              
                <th></th>
                <th></th>
                </thead>
                <tbody id="bd">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        for ($i = 0; $i < mysqli_num_rows($rs); $i++) {
                            $stt = $i + 1 + $offset;
                            $row = mysqli_fetch_assoc($rs)
                            ?>
                            <tr>    
                                <td><?php echo $stt; ?></td>
                                <td><?php echo $row["specifications_name"]; ?></td>                                             
                                <td><?php echo $row["type_name"]; ?></td>                                             
                                <td><a href="#" title="Sửa thông tin" onclick="load_ajax(<?php echo $row["specifications_id"]?>)" data-toggle="modal" data-target="#ModalUpdate"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
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
                if ($total_page > 1) {
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($n == $i) {
                            echo "<li class='active'>" . "<a href='?page=$i'>$i</a>";
                        } else {
                            echo "<li><a href='?page=$i'>$i</a>";
                        }
                    }
                }
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
                        <form class="form-horizontal" role="form"  accept-charset="utf-8" method="post" action="../process/specifications_fn.php" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="title">Thêm Mới Thông Số Kỹ Thuật</h4>
                            </div>
                            <div class="modal-body">                                
                                <div class="form-group">                                    
                                    <div class="col-sm-3 col-xs-3">Loại thông số :</div>
                                    <div class="col-sm-9 col-xs-9">
                                        <select class="input-sm" name="type_id">
                                            <?php
                                            while ($row_spt = mysqli_fetch_assoc($result_spt)) {
                                                ?>
                                                <option value="<?php echo $row_spt["type_id"]; ?>"><?php echo $row_spt["type_name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="form-group">                                    
                                    <div class="col-sm-3 col-xs-3">Tên thông số :</div>
                                    <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="specifications_name" id="sp"/></div>                                    
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
            <div id="ModalUpdate" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form id="sp-form" class="form-horizontal" role="form" method="post" action="../process/specifications_fn.php" enctype="multipart/form-data" name="update">                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'admin_footer.php'; ?>