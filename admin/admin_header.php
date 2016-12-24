<?php
header("Content-Type: text/html; charset=utf-8");
include_once '../include/functions.php';
include_once '../include/config.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Cung cấp các giải pháp an ninh, giám sát, camera ...">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <title>MinhChauSC - Safe Your's House</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
        <link href="../css/metisMenu.css" rel="stylesheet" type="text/css"/>
        <link href="../css/zoom_img.css" rel="stylesheet" type="text/css"/>
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <!--        <link href="../css/home.css" rel="stylesheet" type="text/css"/>-->
        <script src="../javascript/jquery.js" type="text/javascript"></script>
        <script src="../javascript/bootstrap.min.js" type="text/javascript"></script>
        <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="../javascript/nav-js.js" type="text/javascript"></script> 
        <script src="../javascript/sb-admin-2.js" type="text/javascript"></script>
        <script src="../javascript/metisMenu.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="wrapper">


            <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="background-color:#fff;">
                        <a>Menu</a>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">MinhChauSC - Admin Page</a>
                </div>
                <div class="navbar-collapse collapse">

                </div>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li><a href="#" data-toggle="collapse" data-target="#menuProduct" >Sản Phẩm <span class="caret"></span></a>
                                <ul class="nav nav-second-level" id="menuProduct">
                                    <li><a href="product_type_list.php">Loại sản phẩm</a></li>
                                    <li><a href="product_line.php">Dòng sản phẩm</a></li>
                                    <li><a href="product_list.php">Danh sách sản phẩm</a></li>
                                </ul>
                            </li>
                            <li><a href="producer.php">Hãng sản xuất</a></li>
                            <li><a href="specifications.php">Các thông số kỹ thuật <span class="caret"></span></a>
                                <ul class="nav nav-second-level" id="menuProduct">
                                    <li><a href="specification_type.php">Loại thông số</a></li>
                                    <li><a href="specifications.php">Thông số kỹ thuật</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Bài Viết</a></li>                            
                            <li><a href="#">Thông tin Admin</a></li>                            
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
        </div>

        <div id="page-wrapper">

