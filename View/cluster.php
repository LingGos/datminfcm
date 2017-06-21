<?php
$item = @$_GET['item'];
$db = new database();
$fu = new fungsi();
switch ($item) {
    default :
        ?>
        <!--Form tambah data latih-->
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="admin.php">Beranda</a>
                </li>
                <li>
                    <a href="?modul=cluster">Cluster FCM</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Proses Clustering FCM Pada Data Peminjaman Buku </b></h3>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
                        <li class="tab-data-cluster active">
                            <a>Data Peminjaman Buku </a>
                        </li>
                        <li class="tab-cleaning-cluster">
                            <a >Cleaning Data Masukan</a>
                        </li>
                        <li class="tab-normalisasi-cluster">
                            <a >Normalisasi Data Masukan</a>
                        </li>
                        <li class="tab-inisialisasi-cluster">
                            <a >Inisialisasi Parameter FCM</a>
                        </li>
                        <li class="tab-hasil-cluster">
                            <a >Hasil Clustering Data</a>
                        </li>
                        <li class="tab-hasil-cluster-view">
                            <a >Tampilan Hasil Clustering Data</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div  class="tab-pane tabcontent-data-cluster active">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            <p>
                                                <a class="btn btn-info"  type="submit" id="data-btncleaning">
                                                    <i class="ace-icon fa fa-eraser bigger-110" id="data-btncleaning-awal"></i><i id="data-btncleaning-proses" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                                    Cleaning Data
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                        List Data Transaksi Peminjaman Buku 
                                    </div>
                                    <div>
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                                            <thead>
                                                <tr>
                                                    <th class="blue center">No</th>
                                                    <th class="blue center">Kode</th>
                                                    <th class="blue center">Nama</th>
                                                    <th class="blue center">Topik</th>
                                                    <th class="blue center">Penulis</th>
                                                    <th class="blue center">Jumlah Tersedia</th>
                                                    <th class="blue center">Jumlah Peminjamman</th>
                                                    <th class="blue center" colspan="2">Jumlah Anggota</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $json = $db->query_select_array("SELECT * FROM transaksi_buku order by trbTglInput ASC");
                                                $data = json_decode($json, true);
                                                $a = 1;
                                                foreach ($data as $v) {
                                                    ?>
                                                    <tr>
                                                        <td class="center blue"><?php echo $a; ?></td>
                                                        <td class="center blue"><?php echo $v['trbKodeBuku']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbNamaBuku']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbTopikBuku']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbPenulisBuku']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbJmlStok']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbJmlDiminati']; ?></td>
                                                        <td class="center blue"><?php echo $v['trbJmlAnggota']; ?></td>
                                                        <td class="center blue" hidden=""><?php echo $v['trbJmlAnggota']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $a++;
                                                }
                                                ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabcontent-cleaning-cluster  ">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            <p>
                                                <a class="btn btn-info"  type="submit" id="cleaning-btnnormalisasi">
                                                    <i class="ace-icon fa fa-eraser bigger-110" id="cleaning-btnnormalisasi-awal"></i><i id="cleaning-btnnormalisasi-proses" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                                    Normalisasi Data
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                        List Data Cleaning Transaksi Peminjaman Buku 
                                    </div>
                                    <div>
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                                            <thead>
                                                <tr>
                                                    <th class="blue center">No</th>
                                                    <th class="blue center">Kode Buku</th>
                                                    <th class="blue center">Jumlah Tersedia (X1)</th>
                                                    <th class="blue center">Jumlah Peminjaman (X2)</th>
                                                    <th class="blue center">Jumlah Anggota (X3)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myBodyTableCleaningCluster">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabcontent-normalisasi-cluster ">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            <p>
                                                <a class="btn btn-info"  type="submit" id="normalisasi-btninizialisasi">
                                                    <i class="ace-icon fa fa-eraser bigger-110" id="normalisasi-btninizialisasi-awal"></i><i id="normalisasi-btninizialisasi-proses" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                                    Inisialisasi FCM
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                        List Data Normalisasi Transaksi Peminjaman Buku 
                                    </div>
                                    <div>
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                                            <thead>
                                                <tr>
                                                    <th class="blue center">No</th>
                                                    <th class="blue center">Kode Buku</th>
                                                    <th class="blue center">Jumlah Tersedia (X1)</th>
                                                    <th class="blue center">Jumlah Peminjaman (X2)</th>
                                                    <th class="blue center">Jumlah Anggota (X3)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myBodyTableNormalCluster">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabcontent-inisialisasi-cluster ">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <form class="form-horizontal" role="form" id="formx-inisialisasi-cluster" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Banyak Cluster : </label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="nc">
                                                    <option value="">Pilih Banyak Cluster</option>
                                                    <?php
                                                    $json = $db->query_select_array("SELECT * FROM kriteria_claster");
                                                    $datax = json_decode($json, true);
                                                    foreach ($datax as $datax) {
                                                        ?>
                                                        <option value="<?php echo $datax['krcID']; ?>"><?php echo $datax['krcKode']; ?></option>;
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Nilai Minimum Error : </label>
                                            <div class="col-sm-3">
                                                <input type="text" value="1 x 10 (pangkat)" class="col-xs-12 col-sm-12" readonly=""/>
                                            </div>
                                            <label class="col-sm-1 control-label no-padding-right blue bigger" for="form-field-1"> Pangkat : </label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="fo">
                                                    <option value="">Pilih Pangkat</option>
                                                    <?php
                                                    for ($i = -10; $i <= 10; $i++) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>;
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Maksimum Iterasi : </label>
                                            <div class="col-sm-6">
                                                <input type="number" name="mi" class="col-xs-12 col-sm-12"/>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="btn btn-info"  type="submit" id="inisialisasi-btnhasilfcm">
                                                    <i class="ace-icon fa fa-check bigger-110" id="inisialisasi-btnhasilfcm-awal"></i><i id="inisialisasi-btnhasilfcm-proses" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                                    Proses FCM
                                                </button>
                                                &nbsp; &nbsp; &nbsp;
                                                <a href="?modul=cluster" class="btn btn-danger">
                                                    <i class="ace-icon fa fa-remove bigger-110"></i>
                                                    Batal
                                                </a>
                                            </div>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabcontent-hasil-cluster">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <div class="row" >
                                        <div class="col-sm-12">
                                            <div class="clearfix">
                                                <div class="pull-right">
                                                    <p>
                                                        <a class="btn btn-info"  type="submit" id="hasil-btnhasilview">
                                                            <i class="ace-icon fa fa-eraser bigger-110" id="hasil-btnhasilview-awal"></i><i id="hasil-btnhasilview-proses" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                                            Lihat Hasil FCM
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h3 class="header smaller lighter blue"><b>Hasil Cluster Data Transaksi Peminjaman Buku</b></h3>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Jumlah Cluster : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="jml_cls" class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Maximum Iterasi : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="max_itr"  class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Minimum Error : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="min_err" class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Fungsi Objektif Awal : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" value="<?php echo 1000; ?>" class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Fungsi Objektif Akhir : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="fo"  class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Iterasi Berhenti : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="itr" class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        Data Partisi Awal (Random) 
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover myBodyTablePartisiAwalCluster">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        Data Partisi Awal Normal(Random) 
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover myBodyTablePartisiAwalNormalCluster">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        Pusat Cluster Akhir
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover myBodyTablePusatClusterCluster">
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        Data Partisi Akhir
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover myBodyTablePartisiAkhirCluster">
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabcontent-hasil-cluster-view">
                            <div  class="row">
                                <div class="col-xs-12">
                                    <div class="row" >
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h3 class="header smaller lighter blue"><b>Hasil Cluster Data Transaksi Peminjaman Buku</b></h3>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Jumlah Cluster : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="hjml_cls"  class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Waktu Cluster : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="hwkt_cls"  class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Total Data : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="htot_cls"  class="col-xs-12 col-sm-12" readonly/>
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                            <div class="row" >
                                                <div class="col-xs-12">
                                                    <h3 class="header smaller lighter blue"><b>Data Transaksi Peminjaman Buku & Nilai Cluster</b></h3>
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        Jumlah Hasil Cluster Data Transaksi Peminjaman Buku
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover hasilcluster1x">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h3 class="header smaller lighter blue"><b>Data Transaksi Peminjaman Buku & Nilai Cluster</b></h3>
                                                    <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                                                        List Hasil Cluster Data Transaksi Peminjaman Buku
                                                    </div>
                                                    <div>
                                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover tableasilview">
                                                        </table>
                                                    </div>
                                                </div>
                                                <script src="assets/js/chart/fusioncharts/jquery-1.4.js"></script>
                                                <script src="assets/js/chart/fusioncharts/jquery.fusioncharts.js"></script>
                                                <script>
                                                    $('#hasilcluster1x').convertToFusionCharts({
                                                        swfPath: "assets/js/chart/fusioncharts/Charts/",
                                                        type: "MSColumn3D",
                                                        width: "900",
                                                        height: "350",
                                                        dataFormat: "HTMLTable",
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div>
        <!--And Form tambah data latih-->
        <?php
        break;
}
?>

