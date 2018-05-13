<?php
/**
 * User: chenyu_wang
 * Date: 2018/5/6
 * Time: 10:15
 */

//$_FILES 文件上传变量
echo "<pre>";
print_r($_FILES);
echo "<pre/>";
//结果
/*
Array
(
    [myfile] => Array
    (
        [name] => vu;tr.txt
        [type] => text/plain
        [tmp_name] => G:\Progranmming\wamp64\tmp\php780F.tmp
        [error] => 0
        [size] => 769
    )

)
 */
$tep_name = $_FILES["myfile"]["tmp_name"];
$file_name =  $_FILES["myfile"]["name"];
//移动临时文件到指定文件夹

move_uploaded_file($tep_name,"upload/".$file_name);