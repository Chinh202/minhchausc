<?php

require_once '../include/config.php';
require_once '../include/functions.php';
if (isset($_REQUEST['add_new'])) {
    add_new();
}
$id_type = post("type_id");
$query = "SELECT * FROM `view_sp_type` where type_id='$id_type'";
$result = execute_query($query);

while ($row = mysqli_fetch_assoc($result)) {
    echo
    '<tr>
    <td>
    ' . $row["specifications_name"] . '
        <input type="hidden" name="specifications_id[]" value="'.$row["specifications_id"].'">
    </td>
    <td>
    ' . $row["type_name"] . '
    </td>
    <td>
    <textarea name = "specifications_des" class = "form-control col-sm-9 col-xs-9"></textarea>
    </td>
    <td>
    <button type = "button" class = "btn btn-success" onclick = "remove_pro(this)">Xóa</button>
    </td>
    </tr>';
}
