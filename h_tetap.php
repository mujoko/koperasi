<?php include "auth.php";include 'constants.php';include 'tabel_file.php';require_once 'class/MySQL.php';$t=date_sql($tanggal);$hari=date('l', microtime($tanggal));$hari_indonesia = array('Monday'  => 'Senin','Tuesday'  => 'Selasa','Wednesday' => 'Rabu','Thursday' => 'Kamis','Friday' => 'Jumat', 'Saturday' => 'Sabtu','Sunday' => 'Minggu'); ?>