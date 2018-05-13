<?php

include_once("config.php");

Logging::l("RELEASE", "release start.");
chdir(APP_PATH);
Logging::l("RELEASE", "now pwd is " . getcwd());


$req = get_request("payload");
$req = json_decode($req);
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
$s = 'aabbcc123';
$hash = "sha1=" . hash_hmac("sha1", file_get_contents("php://input"), $s);

if ($signature !== $hash) {
  Logging::e("RELEASE", "secret is fault.");
  return false;
}

$shell = "git pull";
$out = shell_exec($shell);
Logging::l("RELEASE", $out);


