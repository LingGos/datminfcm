<!DOCTYPE html>
<?php
error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', -1);
ini_set('post_max_size', -1);

include 'config/config_inc.php';
//kalo pake login buka koment ini
session_start();
if (!isset($_SESSION['USER']) && !isset($_SESSION['PASSWORD_ENCRIP'])) {
    header("Location:index.php");
}
date_default_timezone_set('Asia/Jakarta');
?>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?php echo 'Beranda -' . FUA_APP_NAME; ?></title>
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
        <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <script src="assets/js/ace-extra.min.js"></script>
    </head>
    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>
            <div class="navbar-container" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-header pull-left">
                    <a href="admin.php" class="navbar-brand">
                        <small>
                            <i class="fa fa-camera"></i>
                            <?php echo FUA_APP_NAME; ?>
                        </small>
                    </a>
                </div>
                                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                                    <ul class="nav ace-nav">
                                        <li class="light-blue">
                                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                                <img class="nav-user-photo" src="assets/avatars/avatar2.png" alt="Jason's Photo" />
                                                <span class="user-info">
                                                    <small>Selamat Datang,</small>
                                                    Admin
                                                </span>
                                                <i class="ace-icon fa fa-caret-down"></i>
                                            </a>
                                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="javascript:void(0)"  class="btn-ubah-kunci" id="<?php echo $_SESSION['ID'];  ?>" pass="<?php echo $_SESSION['PASSWORD'];  ?>">
                                                        <i class="ace-icon fa fa-cog"></i>
                                                        Ubah Password
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="?modul=keluar">
                                                        <i class="ace-icon fa fa-power-off"></i>
                                                        Keluar
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
            </div><!-- /.navbar-container -->
        </div>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>
            <div id="sidebar" class="sidebar                  responsive">
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>
                <ul class="nav nav-list">
                    <li class="active">
                        <a href="index.php">
                            <i class="menu-icon fa fa-home"></i>
                            <span class="menu-text"> Beranda </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="?modul=kriteria">
                            <i class="menu-icon fa fa-archive"></i>
                            <span class="menu-text"> Kriteria Cluster </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="?modul=buku">
                            <i class="menu-icon fa fa-book"></i>
                            <span class="menu-text"> Data Buku</span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="?modul=cluster">
                            <i class="menu-icon fa fa-cloud-upload"></i>
                            <span class="menu-text"> Cluster FCM </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="?modul=hasil">
                            <i class="menu-icon fa fa-area-chart"></i>
                            <span class="menu-text"> Hasil Cluster FCM </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul><!-- /.nav-list -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </div>
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <?php
                        include 'config/database.php';
                        include 'config/fungsi.php';
                        $modul = @$_GET['modul'];
                        switch ($modul) {
                            case "kriteria":
                                include 'view/kriteria.php';
                                break;
                            case "buku":
                                include 'view/buku.php';
                                break;
                            case "cluster":
                                include 'view/cluster.php';
                                break;
                            case "hasil":
                                include 'view/hasilcluster.php';
                                break;
                            case "kunci":
                                include 'view/ubahkunci.php';
                                break;
                            case "keluar":
                                session_destroy();
                                echo "<script>window.location.href='index.php';</script>";
                                break;
                            default:
                                include 'view/beranda.php';
                                break;
                        }
                        ?>
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->
            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">Teknik Informatika-UIN SUSKA Riau</span>
                            &copy; 2016
                        </span>
                    </div>
                </div>
            </div>
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        <!--MODAL UBAH PASSWORD-->
        <div id="modal-form-ubah-pass" class="modal fade in" tabindex="-1" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="blue bigger"><li class="ace-icon fa fa-pencil-square-o fit"></li> Ubah Password Administrator</h4>
                    </div>
                    <form class="form-horizontal" role="form" id="form-ubah-pass">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" name="id" id="id"/>
                                    <input type="hidden" name="pass" id="pass"/>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label no-padding-right blue bigger" for="form-field-1"> Password Lama : </label>
                                                <div class="col-xs-9">
                                                    <input type="password" name="passLama" id="passLama"  class="col-xs-12" required=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label no-padding-right blue bigger" for="form-field-1"> Password Baru : </label>
                                                <div class="col-xs-9">
                                                    <input type="password" name="passBaru1" id="passBaru1"  class="col-xs-12" required=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label no-padding-right blue bigger" for="form-field-1"> Ulangi Password Baru : </label>
                                                <div class="col-xs-9">
                                                    <input type="password" name="passBaru2" id="passBaru2"  class="col-xs-12" required=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                <i class="ace-icon fa fa-times"></i>
                                Batal
                            </button>
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>      
        </div><!-- modal form -->
        <!--END MODAL UBAH PASSWORD-->
        <script src="assets/js/jquery.2.1.1.min.js"></script>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='assets/js/jquery.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <!-- ace scripts -->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>
        <!-- form scripts -->
       	<!-- page specific plugin scripts -->
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="assets/js/dataTables.tableTools.min.js"></script>
        <script src="assets/js/dataTables.colVis.min.js"></script>

        <!--        SCRIPT NEW FOR TABLE SCROLL-->

        <script src="assets/new/js/FixedColumns.min.js"></script>
        <script src="assets/new/js/eakroko.min.js"></script>

        <!--        form        -->
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/chosen.jquery.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/jquery.knob.min.js"></script>
        <script src="assets/js/jquery.autosize.min.js"></script>
        <script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="assets/js/bootstrap-tag.min.js"></script>
        <!-- page specific plugin scripts -->
        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="app.js"></script>
        <script src="buku.js"></script>
        <script src="cluster.js"></script>
        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function($) {
                //initiate dataTables plugin
                var oTable1 =
                        $('#dynamic-table')
                        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                        .dataTable({
                    bAutoWidth: false,
                    "aoColumns": [
                        {"bSortable": false},
                        null, null, null, null, null,
                        {"bSortable": false}
                    ],
                    "aaSorting": [],
                });
                //oTable1.fnAdjustColumnSizing();
                /********************************/
                //add tooltip for small view action buttons in dropdown menu
                $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

                //tooltip placement on right or left
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('table')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    //var w2 = $source.width();

                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                        return 'right';
                    return 'left';
                }
            })
        </script>
    </body>
</html>
