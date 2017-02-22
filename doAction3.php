<?php
require_once 'upload.class.php';
$fileLine = "fileLine.con";
$mode = "a";
$upload = new upload();
$dest = $upload->uploadFile();

$fp = fopen($fileLine, $mode);
fwrite($fp, $dest);

echo  $dest;