<?php

include '../config/database.php';
$db = new database();
$task = @$_GET['task'];
switch ($task) {
    case 'simpan':
        $json = $db->query_select_array("SELECT krcKode FROM kriteria_claster");
        $datax = json_decode($json, true);
        $num = count($datax) + 1;
        $id = uniqid();
        $kode = $_POST['krcKode'];
        $nama = $_POST['krcNama'];
        $lama = $_POST['krcLama'];
        
        $save = $db->query_insert("INSERT INTO kriteria_claster VALUES(?,?,?,?,?)", array($id, $kode, $nama, $lama,$num));
        if ($save) {
            echo "<script>
                        alert('Data Berhasil Disimpan..');
                        window.location.href='../admin.php?modul=kriteria';
                      </script>";
        }else{
            echo "<script>
                        alert('Data Gagal Disimpan..');
                        window.location.href='../admin.php?modul=kriteria';
                      </script>";
        }
        break;
    case 'ubah':
        $id = $_POST['krcID'];
        $kode = $_POST['krcKode'];
        $nama = $_POST['krcNama'];
        $lama = $_POST['krcLama'];
        
        $save = $db->query_insert("UPDATE kriteria_claster SET krcNama=?,krcLama=? WHERE krcID=?", array($nama, $lama,$id));
        if ($save) {
            echo "<script>
                        alert('Data Berhasil Diubah..');
                        window.location.href='../admin.php?modul=kriteria';
                      </script>";
        }else{
            echo "<script>
                        alert('Data Gagal Diubah..');
                        window.location.href='../admin.php?modul=kriteria';
                      </script>";
        }
        break;    
}
