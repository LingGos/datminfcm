<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class database extends PDO{
    public function __construct(){
        $this->dbms     = 'mysql';
        $this->host     = 'localhost';
        $this->database = 'db-datmin';
        $this->user     = 'root';
        $this->pass     = '';
        $dns = $this->dbms.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass );
        
    }
    
    public function query_select_row($query,$data=array()) {
        $query=  parent::prepare($query);
        $query->execute($data);
        $count=$query->rowCount();
        return $count;
    }
    
    public function query_select_rowcol($query,$data=array()) {
        $query=  parent::prepare($query);
        $query->execute($data);
        $sum=$query->fetch(PDO::FETCH_COLUMN)[0][0];
            return $sum;  
    }
    public function query_select_array($query,$data=array()) {
        $query=  parent::prepare($query);
        $query->execute($data);
        $DataArray=array();
            while($data=$query->fetch(PDO::FETCH_ASSOC)){
                $DataArray[]=$data;
            }
            $datajson=json_encode($DataArray);
            return $datajson;    
    }
    public function query_insert($query,$data=array()) {
        $query=  parent::prepare($query);
        $chk=$query->execute($data);
        return $chk;
    }
    public function query_update($query,$data=array()) {
        $query=  parent::prepare($query);
        $chk=$query->execute($data);
        return $chk;
    }
    
    public function query_delete($query,$data=array()) {
        $query=  parent::prepare($query);
        $chk=$query->execute($data);
        return $chk;
    }
    
    public function kda($tabel, $inisial){
        $query=  parent::prepare("select*from $tabel");
        $query->execute();
        $p=$query->getColumnMeta(0);
        $field=$p['name'];
        
        $query1=  parent::prepare("select max(".$field.") from $tabel");
        $query1->execute();        
 	$row=$query1->fetch();
            if ($row[0]=="") {
                    $angka=0;
            }
            else {
                    $angka=substr($row[0], strlen($inisial));
            }
	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
            for($i=1; $i<=($p['len']-strlen($inisial)-strlen($angka)); $i++) {
                    $tmp=$tmp."0";	
            }
 	return $inisial.$tmp.$angka;
         
    }
 
 
       
       
}
 
?>