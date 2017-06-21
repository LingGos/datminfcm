<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class security {
    //put your code here
    function decryptStringArray($stringArray) {
        $s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5('SiSpEngUkt123'), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5('SiSpEngUkt123'))), "\0"));
        return $s;
    }

    function encryptStringArray($stringArray) {
        $s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5('SiSpEngUkt123'), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5('SiSpEngUkt123')))), '+/=', '-_,');
        return $s;
    }
    
}
