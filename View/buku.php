<?php
$item = @$_GET['item'];
$db = new database();
$fu = new fungsi();
switch ($item) {
    case 'reset':
        $delete1 = $db->query_delete("DELETE FROM transaksi_buku");
        $delete2 = $db->query_delete("DELETE FROM transaksi_buku_cluster");
        if ($delete1 && $delete2) {
            echo "<script>
                        alert('Semua Data Berhasil Direset..');
                        window.location.href='admin.php?modul=buku';
                      </script>";
        } else {
            echo "<script>
                        alert('Semua Data Gagal Direset..');
                        window.location.href='admin.php?modul=buku';
                      </script>";
        }
        break;
    case 'hapus':
        $id = @$_GET['id'];
        $delete = $db->query_delete("DELETE FROM transaksi_buku WHERE trbID=?", array($id));
        $delete2 = $db->query_delete("DELETE FROM transaksi_buku_cluster WHERE tbcTrbID=?", array($id));
        if ($delete && $delete2) {
            echo "<script>
                        alert('Data Berhasil Dihapus..');
                        window.location.href='admin.php?modul=buku';
                      </script>";
        } else {
            echo "<script>
                        alert('Data Gagal Dihapus..');
                        window.location.href='admin.php?modul=buku';
                      </script>";
        }
        break;
    case 'import':
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
                    <a href="?modul=buku">Kelola Data Buku</a>
                </li>
                <li>
                    <a href="?modul=buku&item=import">Import</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Form Import Data Buku</b></h3>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-12">
                <div  class="row">
                    <div class="col-xs-12">
                        <form class="form-horizontal" role="form"  enctype="multipart/form-data" action="Controller/Buku.php?task=import" method="POST">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> File Data Transaksi : </label>
                                <div class="col-sm-3">
                                    <input type="file" name="file_data_transaksi" id="file_data_transaksi" onchange="ValidateSingleInput(this);" class="col-xs-10 col-sm-5"/>
                                    <!--<input type="file" name="file_data_transaksi" class="col-xs-10 col-sm-5" required=""/>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Reset Data Sebelumnya : </label>
                                <div class="col-sm-8">
                                    <div class="control-group">
                                        <div class="radio">
                                            <label>
                                                <input name="resetdata" value='Y' type="radio" class="ace" />
                                                <span class="lbl red bigger"> Ya</span>
                                            </label>
                                            <label>
                                                <input name="resetdata" value='N' type="radio" class="ace" checked />
                                                <span class="lbl red bigger"> Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info"  type="submit">
                                        <i class="ace-icon fa fa-check bigger-110" id="lattandaprosesawalsegmentasi"></i><i id="lattandaprosesmulaisegmentasi" class="ace-icon fa fa-spinner fa-spin white bigger-130 hide"></i>
                                        Import Data
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <a href="?modul=buku" class="btn btn-danger " id="latbtnBatalSegmentasi">
                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </form>                
                    </div>
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
                    <a href="?modul=buku">Kelola Data Buku</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Kelola Data Buku</b></h3>
                <div class="clearfix">
                    <div class="pull-right">
                        <p>
                            <a href="?modul=buku&item=import" class="btn btn-white btn-info btn-bold">
                                <i class="ace-icon fa  fa-plus bigger-120 blue"></i>
                                Import Data </a>
                            <a href="?modul=buku&item=reset" class="btn btn-white btn-danger btn-bold" title="Reset Semua Data" onclick="return confirm('Yakin,Apakah Anda Ingin Mereset Semua Data Ini..?')">
                                <i class="ace-icon fa fa-eraser bigger-120 red"></i>
                                Reset Semua Data
                            </a>
                        </p>
                    </div>
                </div>
                <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                    List Data Buku Peminjaman Buku
                </div>
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th class="blue center">Kode</th>
                                <th class="blue center">Nama</th>
                                <th class="blue center">Topik</th>
                                <th class="blue center">Jumlah Tersedia</th>
                                <th class="blue center">Jumlah Peminjaman</th>
                                <th class="blue center">Jumlah Anggota</th>
                                <th class="blue center"><center>Aksi</center></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $json = $db->query_select_array("SELECT * FROM transaksi_buku order by trbTglInput ASC");
                            $data = json_decode($json, true);
                            foreach ($data as $v) {
                                ?>
                                <tr>
                                    <td class="center blue"><?php echo (($v['trbKodeBuku']<0)?"":$v['trbKodeBuku']); ?></td>
                                    <td class="center blue"><?php echo $v['trbNamaBuku']; ?></td>
                                    <td class="center blue"><?php echo $v['trbTopikBuku']; ?></td>
                                    <td class="center blue"><?php echo (($v['trbJmlStok']<0)?"":$v['trbJmlStok']); ?></td>
                                    <td class="center blue"><?php echo (($v['trbJmlDiminati']<0)?"":$v['trbJmlDiminati']); ?></td>
                                    <td class="center blue"><?php echo (($v['trbJmlAnggota']<0)?"":$v['trbJmlAnggota']); ?></td>
                                    <td class="center">
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a title="Hapus Data" href="admin.php?modul=buku&item=hapus&id=<?php echo $v['trbID']; ?>" class="blue"  onclick="return confirm('Yakin,Apakah Anda Ingin Menghapus Data Kode Buku <?php echo $v['trbKodeBuku']; ?>..?')"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
