<?php

// Nhập giá trị number bằng phương thức post
$number = isset($_POST['number']) ? (int)$_POST['number'] : false;
 
// Kiểm tra number có lớn hơn không hay không
if (!$number){
    die ('<h1>Vui lòng nhập một số lớn hơn không (0)</h1>');
}
 
// Lặp từ 1 tới number để in ra màn hình
for ($i = 1; $i <= $number; $i++){
    echo '<li>Số: '.$i.'</li>';
}