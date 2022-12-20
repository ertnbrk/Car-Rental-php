<?php

try{
  $conn = new PDO("mysql:host=127.0.0.1;dbname=ip-güz-final;charset=utf8", 'root', '123456');
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}
$GLOBALS['admins'] = 0; 
?>