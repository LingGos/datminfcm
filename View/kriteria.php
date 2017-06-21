<?php
$item = @$_GET['item'];
$db = new database();
$fu = new fungsi();
switch ($item) {
    case 'tambah':
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
                    <a href="?modul=latih">Kelola Data Kriteria</a>
                </li>
                <li>
                    <a href="?modul=latih&item=tambah">Tambah</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Form Tambah Data Kriteria</b></h3>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-12">
                <div  class="row">
                    <div class="col-xs-12">
                        <form class="form-horizontal" role="form" action="Controller/Kriteria.php?task=simpan" method="POST">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Kode Kriteria : </label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="krcKode" required="">

                                        <?php
                                        $json = $db->query_select_array("SELECT krcKode FROM kriteria_claster");
                                        $datax = json_decode($json, true);
                                        $num = count($datax) + 1;
                                        ?>
                                        <option value="">Pilih Kode Cluster</option>
                                        <option value="C<?php echo $num; ?>">C<?php echo $num; ?></option>;
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Nama Kriteria : </label>
                                <div class="col-sm-6">
                                    <input type="text" name="krcNama" class="col-xs-12 col-sm-12" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Lama Peminjaman (Hari) : </label>
                                <div class="col-sm-6">
                                    <input type="number" name="krcLama" class="col-xs-12 col-sm-2" required/>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="submit">
                                        <i class="ace-icon fa fa-check bigger-110" ></i>
                                        Simpan
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <a href="?modul=kriteria" class="btn btn-danger">
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
    case 'ubah':
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
                    <a href="?modul=latih">Kelola Data Kriteria</a>
                </li>
                <li>
                    <a >Ubah</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Form Ubah Data Kriteria</b></h3>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-12">
                <div  class="row">
                    <?php
                    $id = @$_GET['id'];
                    $json = $db->query_select_array("SELECT * FROM kriteria_claster WHERE krcID=?", array($id));
                    $data = json_decode($json, true);
                    ?>
                    <div class="col-xs-12">
                        <form class="form-horizontal" role="form" action="Controller/Kriteria.php?task=ubah" method="POST">
                            <input type="hidden" value="<?php echo $data[0]['krcID'] ?>" name="krcID" />
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Kode Kriteria : </label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="krcKode" required="">
                                        <option value="<?php echo $data[0]['krcKode']; ?>" selected><?php echo $data[0]['krcKode']; ?></option>;
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Nama Kriteria : </label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $data[0]['krcNama'] ?>" name="krcNama" class="col-xs-12 col-sm-12" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue bigger" for="form-field-1"> Lama Peminjaman (Hari) : </label>
                                <div class="col-sm-6">
                                    <input type="number" value="<?php echo $data[0]['krcLama'] ?>" name="krcLama" class="col-xs-12 col-sm-2" required/>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="submit">
                                        <i class="ace-icon fa fa-check bigger-110" ></i>
                                        Simpan
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <a href="?modul=kriteria" class="btn btn-danger">
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
                    <a href="?modul=latih">Kelola Data Kriteria</a>
                </li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><b>Kelola Data Kriteria</b></h3>
                <div class="clearfix">
                    <div class="pull-right">
                        <p>
                            <a href="?modul=kriteria&item=tambah" class="btn btn-white btn-info btn-bold">
                                <i class="ace-icon fa  fa-plus bigger-120 blue"></i>
                                Tambah Data </a>
                        </p>
                    </div>
                </div>
                <div class="table-header"><i class="ace-icon fa fa-th-large"></i>
                    List Kriteria
                </div>
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th class="blue center">No</th>
                                <th class="blue center">Kode Kriteria</th>
                                <th class="blue center">Nama</th>
                                <th class="blue center">Lama Peminjaman (Hari)</th>
                                <th class="blue center" colspan="3"><center>Aksi</center></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $json = $db->query_select_array("SELECT * FROM kriteria_claster order by krcKode DESC");
                            $data = json_decode($json, true);
                            $a = 1;
                            foreach ($data as $v) {
                                ?>
                                <tr>
                                    <td class="center blue"><?php echo $a; ?></td>
                                    <td class="center blue"><?php echo $v['krcKode']; ?></td>
                                    <td class="center blue"><?php echo $v['krcNama']; ?></td>
                                    <td class="center blue"><?php echo $v['krcLama']; ?></td>
                                    <td class="center">
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a title="Uba Data" href="admin.php?modul=kriteria&item=ubah&id=<?php echo $v['krcID']; ?>" class="blue"><i class="ace-icon fa fa-edit bigger-130"></i></a>
                                        </div>
                                    </td>
                                    <td class="center" hidden></td>
                                    <td class="center">
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a title="Hapus Data" href="admin.php?modul=kriteria&item=hapus&id=<?php echo $v['krcID']; ?>" class="blue"  onclick="return confirm('Yakin,Apakah Anda Ingin Menghapus Data Ini..?')"><i class="ace-icon fa fa-trash-o bigger-130 btn-hapus-kriteria"></i></a>
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
        case 'hapus':
        $id = @$_GET['id'];
        $json = $db->query_select_array("SELECT * FROM transaksi_buku_cluster WHERE tbcKrcID=?", array($id));
        $data = json_decode($json, true);
        if(count($data)>0){
            echo "<script>
                        alert('Data Gagal Dihapus,Karena Ada Relasi');
                        window.location.href='admin.php?modul=kriteria';
                      </script>";
        }
        $delete = $db->query_delete("DELETE FROM kriteria_claster WHERE krcID=?", array($id));
        if ($delete) {
            echo "<script>
                        alert('Data Berhasil Dihapus..');
                        window.location.href='admin.php?modul=kriteria';
                      </script>";
        }else{
            echo "<script>
                        alert('Data Gagal Dihapus..');
                        window.location.href='admin.php?modul=kriteria';
                      </script>";
        }
        break;
}
?>
