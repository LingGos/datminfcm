<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class fcm {

    //put your code here
    private $cValue;
    private $mValue;
    private $tValue;
    private $eValue;
    public  $pValue;
    public  $uValue;
    public  $vValue; //pusat cluster 
    private $nData;
    public  $iterasi;
                function __construct($attr = array()) {
        $this->uValue = array(array());
        $this->vValue = array(array());
        $this->cValue = $attr['nc'];
        $this->mValue = 2;
        $this->tValue = intval($attr['mi']);
        $this->eValue = doubleval(intval($attr['fo'])); //0.0001 => 10 pangkat -4
        $this->pValue = 1000;//awalnya 0
        $this->nData = intval($attr['n']); //banyak data
        //Bila wxh sama pada setiap gambar
        if (!isset($_SESSION['UvalueAcak']) && !isset($_SESSION['UvalueAcakX'])) {
            //set nilai awal partisi uij secara acak
            $_SESSION['UvalueAcak'] = $this->SetUAcak();
        } else if (isset($_SESSION['UvalueAcak']) && isset($_SESSION['UvalueAcakX'])) {
            if (count($_SESSION['UvalueAcak']) == ($this->nData) && count($_SESSION['UvalueAcak'][0]) == $this->cValue && count($_SESSION['UvalueAcakX']) == ($this->nData) && count($_SESSION['UvalueAcakX'][0]) == $this->cValue) {
                $this->uValue = $_SESSION['UvalueAcak'];
            } else {
                //set nilai awal partisi uij secara acak
                $_SESSION['UvalueAcak'] = $this->SetUAcak();
            }
        }
    }

    private function SetUAcak() {
        //set UAcak Dan Normalisasi
        //set UAcak + Siqma 
        $sigmaQ = array();
        for ($b = 0; $b < $this->cValue; $b++) {
            $sigmaQ[$b] = 0;
        }
        for ($a = 0; $a < $this->nData; $a++) {
            for ($b = 0; $b < $this->cValue; $b++) {
                $this->uValue[$a][$b] = number_format((rand() / getrandmax()), 3);
                $sigmaQ[$b] = $sigmaQ[$b] + $this->uValue[$a][$b];
            }
        }
        $_SESSION['UvalueAcakX'] = $this->uValue;
        //Normalisasi
        for ($a = 0; $a < $this->nData; $a++) {
            for ($b = 0; $b < $this->cValue; $b++) {
                $this->uValue[$a][$b] = $this->uValue[$a][$b] / $sigmaQ[$b];
            }
        }
        return $this->uValue;
    }

    private function pusatCluster($dataX = array(array())) {
        //rumusgambar=office=lap
        //untuk pusat cluster 1 , 2...C
        //k=1,2,..c
        for ($k = 0; $k < $this->cValue; $k++) {
            //j=1,2,..m
            for ($j = 0; $j < count($dataX[0]); $j++) {
                $sigmaAtas = 0; //lihat rumus vi
                $sigmaBawah = 0; //lihat rumus vi
                //i=1,2,..n
                for ($i = 0; $i < $this->nData; $i++) {
                    $sigmaAtas = $sigmaAtas + ((pow($this->uValue[$i][$k], $this->mValue)) * $dataX[$i][$j]);
                    $sigmaBawah = $sigmaBawah + (pow($this->uValue[$i][$k], $this->mValue));
                }
                //Vkj->k=clster,j=banyak atribut data
                $this->vValue[$k][$j] = ($sigmaAtas / $sigmaBawah);
            }
        }
//        return $this->vValue;
    }

    private function ubahPartisiU($dataX) {
        $pangkat = (-2 / ($this->mValue - 1));
        //i=1,2..n
        for ($i = 0; $i < count($this->uValue); $i++) {
            //pencaharian rumus bawah
            $rumusBawah = 0;
            //k=1,2,..c
            for ($k = 0; $k < count($this->uValue[0]); $k++) {
                $rumusSubM = 0;
                //j=1,2,..m
                for ($j = 0; $j < count($dataX[0]); $j++) {
                    $rumusSubM = $rumusSubM + (pow(($dataX[$i][$j] - $this->vValue[$k][$j]), 2));
                }
                $rumusBawah = $rumusBawah + (pow($rumusSubM, $pangkat));
            }
            //end pencaharian rumus bawah
            //updete partisi Uik
            //k=1,2,..c
            for ($k = 0; $k < count($this->uValue[0]); $k++) {
                $rumusSubM2 = 0;
                //j=1,2,..m
                for ($j = 0; $j < count($dataX[0]); $j++) {
                    $rumusSubM2 = $rumusSubM2 + (pow(($dataX[$i][$j] - $this->vValue[$k][$j]), 2));
                }
                //$rumusAtas=(pow($rumusSubM2,$pangkat));
                //Uik baru
                $this->uValue[$i][$k] = ((pow($rumusSubM2, $pangkat)) / $rumusBawah);
            }
            //end updete partisi Uik
        }
//        return $this->uValue;
    }

    private function setDerajaKeangotaanCluster() {
        $setCluster = array(array());
        //cek banyak cluster =1,2,3,4,5
        for ($a = 0; $a < $this->nData; $a++) {
            $setCluster[$a][0] = (intval($this->max_key($this->uValue[$a])) + 1);
        }
        return $setCluster;
    }

    public function max_key($array) {
        $max = max($array);
        foreach ($array as $key => $val) {
            if ($val == $max)
                return $key;
        }
    }

    private function fungsiObjektif($dataX = array(array())){
        //rumus foto=office
        //a=1,2..n
        $sigmaP_N = 0;
        for ($a = 0; $a < count($this->uValue); $a++) {
            $sigmaP_C = 0;
            //b=1,2,..c
            for ($b = 0; $b < count($this->uValue[0]); $b++) {
                $sigmaP_M = 0;
                //c=1,2,..m
                for ($c = 0; $c < count($dataX[0]); $c++) {
                    $sigmaP_M = $sigmaP_M + ((pow(($dataX[$a][$c] - $this->vValue[$b][$c]), 2)));
                }
                $sigmaP_C = $sigmaP_C + ($sigmaP_M * (pow($this->uValue[$a][$b], $this->mValue)));
            }
            $sigmaP_N = $sigmaP_N + $sigmaP_C;
        }
//        return $sigmaP_N;
        $pCek = 0;
        if ($this->pValue > $sigmaP_N) {
            $pCek = $this->pValue - $sigmaP_N;
            //echo $this->pValue.' - '.$sigmaP_N.' = '.$pCek;
        } else if ($this->pValue < $sigmaP_N) {
            $pCek = $sigmaP_N - $this->pValue;
            //echo $sigmaP_N.' - '.$this->pValue.' = '.$pCek;
        } else {
            $pCek = $this->pValue - $sigmaP_N;
            //echo $this->pValue.' - '.$sigmaP_N.' = '.$pCek;
        }
        //update nilai p lama dengan p baru
        $this->pValue = $sigmaP_N;
        //kembalikan nilai selisih p baru - p lama
        return $pCek;
    }

    public function fcm($datax) {
//        $this->iterasi=0;
        for ($a = 1; $a <= $this->tValue; $a++) {
            //titik pusat clustering    
            $this->pusatCluster($datax);
            //Update partisi Uik baru
            $this->ubahPartisiU($datax);
            //Fungsi obyektif + cek fungsi obyektif untuk akhiri iterasi
            if ($this->fungsiObjektif($datax) < $this->eValue) {
                 $this->iterasi=$this->fungsiObjektif($datax);
                break;
            }
//            else{
//                $this->iterasi=$this->iterasi+1;
//            }
        }

        return $this->setDerajaKeangotaanCluster();
    }

}
