<?php
include_once '../include/functions.php';
include_once '../include/config.php';
class breadcrumb {
    private $breadcrumb;
    private $separator = '';
    private $domain = 'http://localhost:82/MinhChauSC';

    public function build($array) {

        $breadcrumbs = array_merge(array('Trang chủ' => 'index.php'), $array);

        $count = 0;

        foreach ($breadcrumbs as $title => $link) {
            $this->breadcrumb .= '
			<li>
			<a href="' . $this->domain . '/' . $link . '" itemprop="url">'
                    . $title .
                    '</a>
			</li>';

            $count++;

            if ($count !== count($breadcrumbs)) {
                $this->breadcrumb .= $this->separator;
            }
        }
        return $this->breadcrumb;
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Cung cấp các giải pháp an ninh, giám sát, camera ...">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <title>MinhChauSC - Safe Your's House</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/font-awesome/../css/font-awesome.css" rel="stylesheet" type="text/css"/>        
        <link href="../css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
        <link href="../css/metisMenu.css" rel="stylesheet" type="text/css"/>
        <link href="../css/zoom_img.css" rel="stylesheet" type="text/css"/>
        <link href="../css/home.css" rel="stylesheet" type="text/css"/>
        <script src="../javascript/jquery.js" type="text/javascript"></script>
        <script src="../javascript/bootstrap.min.js" type="text/javascript"></script>
        <script src="../javascript/nav-js.js" type="text/javascript"></script> 
        <script src="../javascript/sb-admin-2.js" type="text/javascript"></script>
        <script src="../javascript/metisMenu.js" type="text/javascript"></script>
        <script>
            function initNav(nav_colorTextActive, nav_colorTextNornal) {
//                $(".nav a").on("click", function () {
//                    $(".nav").find(".active").removeClass("active");
//
//                    $(this).parent().addClass("active");
//
//                });
                $(".li-menu").on("click", function () {
                    $(this).toggleClass('active');//                                
                });
                $(".top-li").on("click", function () {
//                    $(this).find('span').toggleClass('glyphicon glyphicon-minus-sign').toggleClass('glyphicon glyphicon-plus-sign');
                    $(this).toggleClass('li-active');
                    $(this).parent().toggleClass('active');

                });
            }
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container" style="padding:15px 0 5px;">
                <div class="col-lg-4">
                    <img src="../imgs/minhchausc_logo.png" alt="" class="img-responsive" style="height: 85px"/>
                </div>                    
                <div class="col-lg-4">
                    <div class="well text-center" style="margin:0px;padding: 0px">
                        <h4 style="font-weight: bold;color:#d71921;text-transform: uppercase">Hỗ Trợ Kỹ Thuật</h4>
                        <p style="margin: 0"><i class="fa fa-phone" style="color:#00AE42;font-size: 14px"></i><a style="font-weight: bold;color:#d71921;text-transform: uppercase;padding: 0;font-size: 18px"> 0988 098 945</a><a title=" " href="skype:vinhcv?chat" class="btn"><img src="../imgs/chatbutton_32px.png" alt="Talk with me via Skype" class="img-responsive" style="height: 20px;"/></a></p>                                                        

                    </div>                 
                </div>             
            </div>
            <div class="container">
                <div class="navbar navbar-default" style="margin-bottom: 5px">
                    <div class="navbar-header">
                        <button class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="background-color:#fff;">
                            <a>Menu</a>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>                            
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="http://localhost:82/MinhChauSC/index.php">TRANG CHỦ</a></li>
                            <li class="dropdown"><a href="#bootstrap" class="dropdown-toggle" data-toggle="dropdown">GIỚI THIỆU <span class="caret"></span></a>
                                <div class="dropdown-menu col-lg-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Giới thiệu về Hikvision</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Giới thiệu về MinhChauSC</a></li>
                                    </ul>
                                </div>                                
                            </li>
                            <li class="dropdown"><a href="http://localhost:82/MinhChauSC/product/pr_hikvision.php" class="dropdown-toggle" data-toggle="dropdown">Sản Phẩm <span class="caret"></span></a>
                                <div class="dropdown-menu col-lg-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Camera Hikvision</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Báo cháy</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Kiểm soát vào ra</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Báo giờ</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Báo động</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Điện thoại gọi cửa có hình</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Khóa điện</a></li>
                                    </ul>
                                </div>                                
                            </li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">HỖ TRỢ <span class="caret"></span></a>
                                <div class="dropdown-menu col-lg-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-angle-right" ></i>Giải pháp</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Khuyến cáo</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Hướng dẫn sử dụng</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Video hướng dẫn</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Câu hỏi thường gặp</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Khái niệm cơ bản</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">DOWNLOAD <span class="caret"></span></a>
                                <div class="dropdown-menu col-lg-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-angle-right" ></i>Firmware</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Client Software</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>SDK</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Tools</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i>Phần mềm hỗ trợ từ xa</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="#sass">LIÊN HỆ </a></li>
                        </ul>
                    </div>
                </div>
            </div>
<!--                <img src="../imgs/product-page-cover.png" alt="banner" class="img-responsive"/>-->    
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="../imgs/product-page-cover.png" class="img-responsive"/>
                    </div>
                </div>
            </div>

            <div class="container" style="margin-bottom: 0">
                <ul class="breadcrumb">
                    <?php
                    $breadcrumb = new breadcrumb();
                    echo $breadcrumb->build(array('Sản phẩm' => 'product/pr_hikvision.php', 'PHP Breadcrumb' => 'php-breadcrumb.html'));
                    ?>                    
                </ul>
            </div>            
            <div class="container" id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3 menu-left">
                            <div class="navbar-default sidebar" role="navigation">
                                <div class="sidebar-nav navbar-collapse">
                                    <h3 class="head-text text-center">Sản Phẩm</h3>
                                    <ul class="nav ul-nav" id="side-menu">
                                        <li class="li-menu"><a href="#" data-toggle="collapse" data-target="#menuProduct" class="top-li"></span> Sản Phẩm</a>
                                            <ul class="nav nav-second-level" id="menuProduct">
                                                <li><a href="product_type_list.php">Loại sản phẩm</a></li>
                                                <li><a href="product_list.php">Danh sách sản phẩm</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="producer.php">Hãng sản xuất</a></li>
                                        <li><a href="specifications.php">Các thông số kỹ thuật</a></li>
                                        <li><a href="#">Bài Viết</a></li>                            
                                        <li><a href="#">Thông tin Admin</a></li>                            
                                    </ul>
                                </div>
                                <!-- /.sidebar-collapse -->
                            </div>
                        </div>
