<?php

include '../config/database.php';
error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set('post_max_size', -1);
date_default_timezone_set('Asia/Jakarta');
include("fcm.php");
include("../config/config_inc.php");
$db = new database();

$task = $_GET['task'];
session_start();
$hasil = array(array());
switch ($task) {
    case 'cleaning':
        $json = $db->query_select_array("SELECT * FROM transaksi_buku WHERE trbKodeBuku IS NOT NULL AND trbNamaBuku IS NOT NULL AND trbTopikBuku IS NOT NULL AND trbPenulisBuku IS NOT NULL AND trbJmlStok IS NOT NULL AND trbJmlDiminati IS NOT NULL AND trbJmlAnggota IS NOT NULL");
        $hasil = json_decode($json, true);
        echo json_encode($hasil);
        break;
    case 'normalisasi':
        $json = $db->query_select_array("SELECT sum(trbJmlStok) AS jmlstok,sum(trbJmlDiminati) AS jmldiminati,sum(trbJmlAnggota) AS jmlanggota FROM transaksi_buku WHERE trbKodeBuku IS NOT NULL AND trbNamaBuku IS NOT NULL AND trbTopikBuku IS NOT NULL AND trbPenulisBuku IS NOT NULL AND trbJmlStok IS NOT NULL AND trbJmlDiminati IS NOT NULL AND trbJmlAnggota IS NOT NULL");
        $data = json_decode($json, true);
        $jmlstok = $data[0]['jmlstok'];
        $jmldiminati = $data[0]['jmldiminati'];
        $jmlanggota = $data[0]['jmlanggota'];

        $json = $db->query_select_array("SELECT * FROM transaksi_buku WHERE trbKodeBuku >=? AND trbNamaBuku IS NOT NULL AND trbTopikBuku IS NOT NULL AND trbPenulisBuku IS NOT NULL AND trbJmlStok >=? AND trbJmlDiminati >=? AND trbJmlAnggota >=?",array(0,0,0,0));
        $data = json_decode($json, true);
        $a = 0;
        $hasildata = array(array());
        foreach ($data as $v) {
            $hasil[$a]['ID'] = $v['trbID'];
            $hasil[$a]['KODE'] = $v['trbKodeBuku'];
            $hasil[$a]['X1'] = (intval($v['trbJmlStok']) / $jmlstok);
            $hasil[$a]['X2'] = (intval($v['trbJmlDiminati']) / $jmldiminati);
            $hasil[$a]['X3'] = (intval($v['trbJmlAnggota']) / $jmlanggota);

            $hasildata[$a][0] = (intval($v['trbJmlStok']) / $jmlstok);
            $hasildata[$a][1] = (intval($v['trbJmlDiminati']) / $jmldiminati);
            $hasildata[$a][2] = (intval($v['trbJmlAnggota']) / $jmlanggota);

            $a++;
        }
        $_SESSION['DataNormal'] = $hasil;
        $_SESSION['DataNormalData'] = $hasildata;
        unset($hasildata);
        echo json_encode($hasil);
        break;
    case 'fcm':
        $hasil=array();
        $json = $db->query_select_array("SELECT * FROM kriteria_claster WHERE krcID=?", array($_POST['nc']));
        $data = json_decode($json, true);
        $data_id = $_SESSION['DataNormal'];
        $data_normal = $_SESSION['DataNormalData'];

        $atribut = array('nc' => intval($data[0]['krcNCluster']), 'fo' => pow(10,  intval($_POST['fo'])), 'mi' => intval($_POST['mi']), 'n' => count($data_normal));
        
        $fcm = new fcm($atribut);
        $cluster = $fcm->fcm($data_normal);
        
        
        $simpan = true;
        $datee = date('Y-m-d H:i:s');
        $_SESSION['tgl'] = $datee;
        $id=null;
        for ($i = 0; $i < count($cluster); $i++) {
            $json = $db->query_select_array("SELECT * FROM kriteria_claster WHERE krcNCluster=?", array(intval($cluster[$i][0])));
            $datax = json_decode($json, true);
            $id = uniqid();
            $krc = $datax[0]['krcID'];
            $trb = $data_id[$i]['ID'];
            
            $save = $db->query_insert("INSERT INTO transaksi_buku_cluster VALUES(?,?,?,?)",array($id,$krc,$trb,$datee));
            if (!$save) {
                $simpan = false;
            }
        }
        unset($_SESSION['DataNormal']);
        unset($_SESSION['DataNormalData']);
        $hasilattrfcm=array('iterasi'=>$fcm->iterasi,'fo'=>$fcm->pValue);
        $hasil['status']=$simpan;
        $hasil['atribut_awal']=$atribut;
        $hasil['atribut_fcm']=$hasilattrfcm;
        unset($hasilattrfcm);
        unset($atribut);
        $hasil['partisi_awal']=$_SESSION['UvalueAcakX'];
        $hasil['partisi_awal_normal']=$_SESSION['UvalueAcak'];
        $hasil['pc']=$fcm->vValue;
        unset($fcm->vValue);
        $hasil['partisi']=$fcm->uValue;
        unset($fcm->uValue);
        $hasil['data_normal']=$data_id;
        unset($data_id);
        unset($data_normal);
        echo json_encode($hasil);
        break;
    case 'hasil':
        $json = $db->query_select_array("SELECT * FROM transaksi_buku_cluster WHERE tbcTglCluster=?", array($_SESSION['tgl']));
        $dataxy = json_decode($json, true);
        $id = $dataxy[0]['tbcTglCluster'];
        $hasil=array();
        $json = $db->query_select_array("SELECT tbcKrcID,COUNT(*) AS jmlpercluster FROM transaksi_buku tb,transaksi_buku_cluster tbc, kriteria_claster kc WHERE tb.trbID=tbc.tbcTrbID AND tbc.tbcKrcID=kc.krcID AND tbcTglCluster=? group by tbcKrcID order by tbcTglCluster ASC", array($id));
        $datax = json_decode($json, true);
        $hasil['datax']=$datax;
        $hasil['hjml_cls']=count($datax);
        $datakode=array();
        $i=0;
        foreach ($datax as $v) {
            $json = $db->query_select_array("SELECT * FROM kriteria_claster WHERE krcID=?", array($v['tbcKrcID']));
            $dataxx = json_decode($json, true);
            $datakode[$i]=$dataxx[0]['krcKode'];
            $i++;
        }
        $hasil['kode']=$datakode;
        //query untuk dibawaah
        $json = $db->query_select_array("SELECT * FROM transaksi_buku tb,transaksi_buku_cluster tbc, kriteria_claster kc WHERE tb.trbID=tbc.tbcTrbID AND tbc.tbcKrcID=kc.krcID AND tbcTglCluster=? order by tbcTglCluster ASC", array($id));
        $data = json_decode($json, true);
        $datajml=array();
        $i=0;
        foreach ($datax as $v) {
            $datajml[$i]=$v['jmlpercluster'];
            $i++;
        }
        $hasil['datajml']=$datajml;
        $hasil['htot_cls']=count($data);
        $datatampil=array(array());
        $i=0;
        foreach ($data as $v) {
            $datatampil[$i]['trbKodeBuku']=$v['trbKodeBuku'];
            $datatampil[$i]['trbNamaBuku']=$v['trbNamaBuku'];
            $datatampil[$i]['trbTopikBuku']=$v['trbTopikBuku'];
            $datatampil[$i]['krcKode']=$v['krcKode'];
            $datatampil[$i]['krcLama']=$v['krcLama'] . ' Hari';
            $datatampil[$i]['krcNama']=$v['krcNama'];
            $i++;
        }
        $hasil['datatampil']=$datatampil;
        $hasil['hwkt_cls']=$_SESSION['tgl'];
        echo json_encode($hasil);
        break;
    default:
        break;
}
