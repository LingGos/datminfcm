<?php
$item = @$_GET['item'];
$db = new database();
$fu = new fungsi();
switch ($item) {
    case 'detail':
        $id = @$_GET['id'];
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
                    <a href="?modul=transaksi">Laporan Hasil Cluster FCM</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <?php
        $json = $db->query_select_array("SELECT * FROM transaksi_buku_cluster WHERE tbcID=?", array($id));
        $dataxy = json_decode($json, true);
        $id = $dataxy[0]['tbcTglCluster'];

        $json = $db->query_select_array("SELECT tbcKrcID,COUNT(*) AS jmlpercluster FROM transaksi_buku tb,transaksi_buku_cluster tbc, kriteria_claster kc WHERE tb.trbID=tbc.tbcTrbID AND tbc.tbcKrcID=kc.krcID AND tbcTglCluster=? group by tbcKrcID order by tbcTglCluster ASC", array($id));
        $datax = json_decode($json, true);
        //query untuk dibawaah
        $json = $db->query_select_array("SELECT * FROM transaksi_buku tb,transaksi_buku_cluster tbc, kriteria_claster kc WHERE tb.trbID=tbc.tbcTrbID AND tbc.tbcKrcID=kc.krcID AND tbcTglCluster=? order by tbcTglCluster ASC", array($id));
        $data = json_decode($json, true);
        ?>
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
                                <input type="text" value="<?php echo count($datax); ?>" class="col-xs-12 col-sm-12" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Waktu Cluster : </label>
                            <div class="col-sm-6">
                                <input type="text" value="<?php echo $id; ?>"  class="col-xs-12 col-sm-12" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Total Data : </label>
                            <div class="col-sm-6">
                                <input type="text" value="<?php echo count($data); ?>" class="col-xs-12 col-sm-12" readonly/>
                            </div>
                        </div>
                    </form> 
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="header smaller lighter blue"><b>Chart Pesentase Hasil Cluster</b></h3>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-sm-12">
                        <div  class="row">
                            <div class="col-xs-12">
                                <center>
                                    <table id="hasilcluster" style="display: none;">
                                        <tr>
                                            <td>Cluster</td>
                                            <td>Total Data</td>
                                            <?php
                                            foreach ($datax as $v) {
                                                $json = $db->query_select_array("SELECT * FROM kriteria_claster WHERE krcID=?", array($v['tbcKrcID']));
                                                $dataxx = json_decode($json, true);
                                                echo '<td>' . $dataxx[0]['krcKode'] . '</td>';
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td><?php echo count($data); ?></td>
                                            <?php
                                            foreach ($datax as $v) {
                                                echo '<td>' . $v['jmlpercluster'] . '</td>';
                                            }
                                            ?>
                                        </tr>
                                    </table></center>
                            </div>
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
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th class="blue center">No</th>
                                        <th class="blue center">Kode Buku</th>
                                        <th class="blue center">Nama Buku</th>
                                        <th class="blue center">Topik Buku</th>
                                        <th class="blue center">Cluster</th>
                                        <th class="blue center">Saran Lama Peminjaman</th>
                                        <th class="blue center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($data as $v) {
                                        ?>
                                        <tr>
                                            <td class="center blue"><?php echo $a; ?></td>
                                            <td class="center blue"><?php echo $v['trbKodeBuku']; ?></td>
                                            <td class="center blue"><?php echo $v['trbNamaBuku']; ?></td>
                                            <td class="center blue"><?php echo $v['trbTopikBuku']; ?></td>
                                            <td class="center blue"><?php echo $v['krcKode']; ?></td>
                                            <td class="center blue"><?php echo $v['krcLama'] . ' Hari'; ?></td>
                                            <td class="center blue"><?php echo $v['krcNama']; ?></td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <script src="assets/js/chart/fusioncharts/jquery-1.4.js"></script>
                    <script src="assets/js/chart/fusioncharts/jquery.fusioncharts.js"></script>
                    <script>
                        $('#hasilcluster').convertToFusionCharts({
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

        <!--And Form tambah data latih
        <?php
        break;
    default:
        ?>
        <!--Halaman Kelola/List data latih-->
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
                    <a href="?modul=transaksi">Kelola Data Transaksi</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Hasil Cluster Data Transaksi Peminjaman Buku</b></h3>
                <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                    List Hasil Cluster Data Transaksi Peminjaman Buku
                </div>
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th class="blue center">No</th>
                                <th class="blue center">Nama Cluster</th>
                                <th class="blue center">Jumlah Cluster</th>
                                <th class="blue center">Waktu Cluster</th>
                                <th class="blue center" colspan="3"><center>Aksi</center></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $json = $db->query_select_array("SELECT tbcTglCluster,tbcID FROM transaksi_buku_cluster group by tbcTglCluster order by tbcTglCluster ASC");
                            $data = json_decode($json, true);
                            $a = 1;
                            foreach ($data as $v) {
                                $jsonx = $db->query_select_array("SELECT tbcKrcID FROM transaksi_buku_cluster WHERE tbcTglCluster=? group by tbcKrcID order by tbcTglCluster ASC", array($v['tbcTglCluster']));
                                $datax = json_decode($jsonx, true);
                                $jml_cluster = count($datax);
                                ?>
                                <tr>
                                    <td class="center blue"><?php echo $a; ?></td>
                                    <td class="center blue"><?php echo 'Cluster Data Koleksi Buku (' . $a . ')'; ?></td>
                                    <td class="center blue"><?php echo $jml_cluster; ?></td>
                                    <td class="center blue"><?php echo $v['tbcTglCluster']; ?></td>
                                    <td class="center" hidden=""></td>
                                    <td class="center" hidden=""></td>
                                    <td class="center">
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a title="Liat Detail" href="admin.php?modul=hasil&item=detail&id=<?php echo $v['tbcID']; ?>" class="blue" ><i class="ace-icon fa fa-desktop bigger-130"></i></a>
                                        </div>
                                    </td>
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
        <!--And Halaman Kelola/List data latih-->
        <?php
        break;
}
?>
