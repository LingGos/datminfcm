<?php
//header("Location:admin.php");
//kalo pake login buka komen ini
session_start();
if (isset($_SESSION['USER']) && isset($_SESSION['PASSWORD_ENCRIP'])) {
    header("Location:admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Masuk Admin</title>
        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
    </head>
    <body class="login-layout light-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h3>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">Aplikasi Clustering Datamining FCM</span>
                                    <span class="grey" > (Lama Peminjaman Buku)</span>
                                </h3>
                                <h5 class="blue" >Studi Kasus : Perpustakaan UIN SUSKA RIAU</h5>
                            </div>
                            <div class="space-6"></div>
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="ace-icon fa fa-user green"></i>
                                                Masuk Administrator
                                            </h4>
                                            <div class="space-6"></div>
                                            <form action="" method="POST">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input name="username" type="text" class="form-control" name="pegUsername" placeholder="Username" />
                                                            <i class="ace-icon fa fa-user"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input name="password" type="password" class="form-control" name="pegPassword" placeholder="Password" />
                                                            <i class="ace-icon fa fa-lock"></i>
                                                        </span>
                                                    </label>
                                                    <div class="space"></div>
                                                    <div class="clearfix">
                                                        <button name="login" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">Masuk</span>
                                                        </button>
                                                    </div>
                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /.widget-main -->
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->
                            </div><!-- /.position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->
        <script src="assets/js/jquery.2.1.1.min.js"></script>
    </body>
</html>
<?php
include 'config/config_inc.php';
include 'config/database.php';
include 'config/security.php';
if (isset($_POST["login"])) {
    $secur = new security();
    $username = $_POST['username'];
    $password2 = $_POST['password'];
    $password = $secur->encryptStringArray($password2);
//    echo $password;exit();
    $db = new database();
    $chek = $db->query_select_row("SELECT * FROM pengguna WHERE penUsername=? AND penPassword=?", array($username, $password));
    if ($chek > 0) {
        $data_json = $db->query_select_array("SELECT * FROM pengguna WHERE PenUsername=? AND PenPassword=?", array($username, $password));
        $data = json_decode($data_json, true);
        $_SESSION['ID'] = $data[0]['penID'];
        $_SESSION['USER'] = $username;
        $_SESSION['PASSWORD_ENCRIP'] = $password;
        $_SESSION['PASSWORD'] = $password2;
        echo "<script>
                        alert('Login Sukses..');
                        window.location.href='admin.php';
                      </script>";
    } else {
//        echo $password;
        echo "<script>
                        alert('Username Dan Password Tidak Benar..');
                        window.location.href='index.php';
                      </script>";
    }
}
?>