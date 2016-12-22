<?php
include_once 'admin_header.php';
$query = "SELECT * FROM `specification_type`";
$result = execute_query($query);
$id = get("id");
$rowpage = 10;
$n = get("page");
if (!get("page")) {
    $n = 1;
}
$offset = ($n - 1) * $rowpage;

$rs_count = execute_query("SELECT COUNT(*) as cnt FROM specification_type");
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
            xmlhttp.open("GET", "../process/specificationsType_fn.php?idUpdate=" + IdUpdate, true);
            xmlhttp.send();
        }
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <H2>Danh Sách Loại Thông Số Kỹ Thuật</H2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>STT</th>
                <th>Tên Loại Thông Số</th>                                           
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
                                <td><?php echo $row["type_name"]; ?></td>                                             
                                <td><a href="#" title="Sửa thông tin" onclick="load_ajax(<?php echo $row["type_id"];?>);" data-toggle="modal" data-target="#ModalUpdate"><img src="../imgs/edit-notes.png" class="img-responsive" style="width: 1.5em;"/></a></td>
                                <td><a href="../process/specificationsType_fn.php?id_del=<?php echo $row["type_id"]; ?>&page=<?php echo $n ?>" title="xóa thông tin" id="del"><img src="../imgs/Delete-icon.png" class="img-responsive" style="width: 1.2em;"/></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>           
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <button class="btn btn-info" data-toggle="modal" data-target="#Modalform">Thêm Mới</button>
        </div>                
    </div>
    <!-- Modal -->
    <div id="Modalform" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal" role="form"  accept-charset="utf-8" method="post" action="../process/specificationsType_fn.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center" id="title">Thêm Mới Loại Thông Số Kỹ Thuật</h4>
                    </div>
                    <div class="modal-body">                                             
                        <div class="form-group">                                    
                            <div class="col-sm-3 col-xs-3">Tên thông số :</div>
                            <div class="col-sm-9 col-xs-9"><input type="text" required class="form-control" name="type_name" id="sp"/></div>                                    
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
                <form id="sp-form" class="form-horizontal" role="form" method="post" action="../process/specificationsType_fn.php" enctype="multipart/form-data">                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once 'admin_footer.php'; ?>