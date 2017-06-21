<?php

class fungsi {
    
    public function MSQLDateToNormal($tgl,$return="") {
        $bulan=null;
        switch(intval(substr($tgl,5,2))){
            case '1':$bulan='Januari';break;
            case '2':$bulan='Februari';break;
            case '3':$bulan='Maret';break;
            case '4':$bulan='April';break;
            case '5':$bulan='Mei';break;
            case '6':$bulan='Juni';break;
            case '7':$bulan='Juli';break;
            case '8':$bulan='Agustus';break;
            case '9':$bulan='September';break;
            case '10':$bulan='Oktober';break;
            case '11':$bulan='November';break;
            case '12':$bulan='Desember';break;
        }
        if($bulan!="" || $bulan!=null){
            return (substr($tgl,8,9).' '.$bulan.' '.substr($tgl, 0,4));
        }else{
            return $return;
        }
    }
    
    public function MSQLDateToNormalInUnix($tgl,$return="") {
        $bulan=null;
        switch(intval(substr($tgl,5,2))){
            case '1':$bulan='Jan';break;
            case '2':$bulan='Feb';break;
            case '3':$bulan='Mar';break;
            case '4':$bulan='Apr';break;
            case '5':$bulan='Mei';break;
            case '6':$bulan='Jun';break;
            case '7':$bulan='Jul';break;
            case '8':$bulan='Aug';break;
            case '9':$bulan='Sep';break;
            case '10':$bulan='Okt';break;
            case '11':$bulan='Nov';break;
            case '12':$bulan='Des';break;
        }
        if($bulan!="" || $bulan!=null){
            return (substr($tgl,8,9).' '.$bulan.' '.substr($tgl, 0,4));
        }else{
            return $return;
        }
    }
}
