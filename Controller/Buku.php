<?php
error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', -1);
ini_set('post_max_size', -1);
require_once '../assets/PHPExcel/PHPExcel.php';
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');
$db = new database();
$task = @$_GET['task'];
switch ($task) {
    case 'import':
        $tanya = ((isset($_POST['resetdata'])) ? $_POST['resetdata'] : '');
        $nameFileNew = uniqid().'_'.$_FILES['file_data_transaksi']['name'];
        $dest = $_SERVER['DOCUMENT_ROOT'] . "/datminfcm/tmp/";
        move_uploaded_file($_FILES['file_data_transaksi']['tmp_name'], $dest . $_FILES['file_data_transaksi']['name']);
        rename($dest . $_FILES['file_data_transaksi']['name'], $dest . $nameFileNew);
        
        $excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('../tmp/'.$nameFileNew); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        if($tanya=='Y'){
            $delete1 = $db->query_delete("DELETE FROM transaksi_buku");
            $delete2 = $db->query_delete("DELETE FROM transaksi_buku_cluster");
        }
        $status=true;
        $numrow = 1;
        $dataarray=array();
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
//                $kode = (($row['A']==NULL || $row['A']=="")?-1:intval($row['A'])); // Ambil data stok
//		$nama = (($row['B']==NULL || $row['B']=="")?NULL:$row['B']); // Ambil data dminati
//		$penulis = (($row['C']==NULL || $row['C']=="")?NULL:$row['C']); // Ambil data anggota
//                $topik = (($row['D']==NULL || $row['D']=="")?NULL:$row['D']); // Ambil data anggota
//		$stok = (($row['E']==NULL || $row['E']=="")?-1:intval($row['E'])); // Ambil data stok
//		$diminati = (($row['F']==NULL || $row['F']=="")?-1:intval($row['F'])); // Ambil data dminati
//		$anggota = (($row['G']==NULL || $row['G']=="")?-1:intval($row['G'])); // Ambil data anggota
//             
//		$kode = (($row['A']==NULL || $row['A']=="")?NULL:$row['A']); // Ambil data stok
//		$nama = (($row['B']==NULL || $row['B']=="")?NULL:$row['B']); // Ambil data dminati
//		$penulis = (($row['C']==NULL || $row['C']=="")?NULL:$row['C']); // Ambil data anggota
//                $topik = (($row['D']==NULL || $row['D']=="")?NULL:$row['D']); // Ambil data anggota
//		$stok = (($row['E']==NULL || $row['E']=="")?NULL:$row['E']); // Ambil data stok
//		$diminati = (($row['F']==NULL || $row['F']=="")?NULL:$row['F']); // Ambil data dminati
//		$anggota = (($row['G']==NULL || $row['G']=="")?NULL:$row['G']); // Ambil data anggota
            
                $kode =$row['A']; // Ambil data stok
		$nama = $row['B']; // Ambil data dminati
		$penulis = $row['C']; // Ambil data anggota
                $topik = $row['D']; // Ambil data anggota
		$stok = $row['E']; // Ambil data stok
		$diminati = $row['F']; // Ambil data dminati
		$anggota = $row['G']; // Ambil data anggota
             
		// Cek jika semua data tidak diisi
//		if(empty($nis) && empty($nama) && empty($jenis_kelamin) && empty($telp) && empty($alamat))
//			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
		
		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
                
		if($numrow > 1){
                    if(!empty($kode) || !empty($nama) || !empty($penulis) || !empty($topik)|| !empty($stok)|| !empty($diminati)|| !empty($anggota)){
                    $id=  uniqid();
                    $date=date('Y-m-d H:i:s');
                    
                   $json=$db->query_select_array("SELECT * FROM transaksi_buku WHERE trbKodeBuku=?", array($kode));
                    $datacek=  json_decode($json, true);
                    if(count($datacek)>0){
//                        array_push($dataarray,$datacek[0]['trbKodeBuku']);
                        $delete = $db->query_delete("DELETE FROM transaksi_buku WHERE trbID=?",array($datacek[0]['trbID']));
                    }
			// Proses simpan ke Database
                    $save=$db->query_insert("INSERT INTO transaksi_buku VALUES(?,?,?,?,?,?,?,?,?)", array($id, $kode, $nama, $topik,$penulis,$stok,$diminati,$anggota,$date));
		    if(!$save){
                        $status=false;
                    }
                }
                }
		$numrow++; // Tambah 1 setiap kali looping
	}
        
        if($status){
//            echo "<script>
//                        alert('Semua Data Berhasil Diimport ke Database..". $dataarray[0]."/".$dataarray[1]."/".$dataarray[2]."/".$dataarray[3]."/".$dataarray[4]."/"."');
//                        window.location.href='../admin.php?modul=buku';
//                      </script>";
            echo "<script>
                        alert('Semua Data Berhasil Diimport ke Database..');
                        window.location.href='../admin.php?modul=buku';
                      </script>";
        }else{
            $delete1 = $db->query_delete("DELETE FROM transaksi_buku");
            echo "<script>
                        alert('Semua Data Gagal Diimport ke Database..');
                        window.location.href='../admin.php?modul=buku';
                      </script>";
            
        }
        
        break;
}
