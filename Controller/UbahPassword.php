<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../config/database.php';
include '../config/security.php';
$db=new database();
$secur=new security(); 

$id=$_POST['id'];
$passbaru=$_POST['passbaru'];
$passbaru_encrip=$secur->encryptStringArray($passbaru);

$update=$db->query_update("UPDATE pengguna SET penPassword=? WHERE penID=?",array($passbaru_encrip,$id));
if($update){

$data_json=$db->query_select_array("SELECT * FROM pengguna WHERE penID=?",array($id));
$data=json_decode($data_json,true);
//    session_destroy();
    session_start();
    $_SESSION['ID'] = $data[0]['penID'];
    $_SESSION['USER'] = $data[0]['penUsername'];
    $_SESSION['PASSWORD_ENCRIP'] = $passbaru_encrip;
    $_SESSION['PASSWORD'] = $passbaru;
}
echo json_encode($update);