<?php



$go = $_GET['go'];
$cat = $_GET['cat'];
$urlgo = $_GET['urlgo'];
$tag = $_GET['tag'];
$id = $_GET['id'];
$msg = $_GET['msg'];
$page = $_GET['page'];
$a_pass = 'sd@asd@@!ds';



//===========================================
$cntext = '.php';
$cntdir = '.-pages-';
if (!$go) {
    $go = '-';
}
$l = $cntdir . preg_replace('/-$/', '-include', $go) . $cntext;
$l = str_replace('-', '/', $l);

$pos = substr($go, 1, strlen($go) - 2);
$l = addslashes($l);

if (file_exists($l) != 1) {
    $l = $cntdir . $go . '/inc' . $cntext;
    $l = str_replace('-', '/', $l);
}
if (file_exists($l) != 1) {
  //  header('Location: ' . $url . '/error/404');
}
//===========================================



