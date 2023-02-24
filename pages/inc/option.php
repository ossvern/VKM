<?php
require_once(ROOT . "/pages/inc/func.php");


foreach ($_POST as $key => $value) {
  $_POST[$key] = htmlspecialchars($value);
}
foreach ($_GET as $key => $value) {
  $_GET[$key] = htmlspecialchars($value);
}

$go = ProtectStr($_GET['go'], 30);
$id = ProtectStr($_GET['id'], 120, '');
$page = ProtectStr($_GET['page'], 2, 1);
$cat = ProtectStr($_GET['cat'], 30);
$one = ProtectStr($_GET['one'], 120);
$type = ProtectStr($_GET['type'], 30);
$department = ProtectStr($_GET['department'], 100);

$search = ProtectStr($_GET['search'], 150);
if (strlen($search) <= 3 and strlen($search) > 0) {
  header("Location: $urlGo");
}


$page = ProtectStr($_GET['page'], 2, 1);
if (isset($_GET['page'])) {
  $page = htmlspecialchars($_GET['page']);
}
else {
  $page = 1;
}
$page_max = 6;
$page_start = $page * $page_max - $page_max;
if ($page_start <= 0) {
  $page_start = 0;
}


//===========================================
$cntext = '.php';
$cntdir = '.-pages-';
if (!$_GET['go']) {
  $go = '-';
}

$arrBad = ['/////', '////', '///', '//'];
$go = str_replace($arrBad, '/', $go);
//echo $go;


$l = $cntdir . preg_replace('/-$/', '-include', $go) . $cntext;
$l = str_replace('-', '/', $l);


$pos = substr($go, 1, strlen($go) - 2);
$l = addslashes($l);
$l = str_replace('//', '/', $l);

if (file_exists($l) != 1) {
  $l = $cntdir . $go . '/inc' . $cntext;
  $l = str_replace('-', '/', $l);
}
if (file_exists($l) != 1) {
  //  header('Location: ' . $url . '/error/404');
}
//===========================================


//===========================================

$arrLang = ['uk', 'pl']; // 'en','de', 'ru',
//$langOtherName = array('PL', 'RU', 'EN');


if (isset($_GET['lang']) and strlen($_GET['lang']) == 2) {
  $lang = $_GET['lang'];
}
else {
  $lang = 'uk';
}

$_SESSION['lang'] = $lang;


if (!$_SESSION['lang']) {
  $_SESSION['lang'] = $lang;
}
//$lang = $_SESSION['lang'];


$i = -1;
$langOther = '';
while ($i++ < count($arrLang) - 1) {
  if ($arrLang[$i] != $lang) {

    $req = $url . $_SERVER['REQUEST_URI'];

    if ($lang == 'uk') {

      if ($go != '-') {
        $urlNew = str_replace($url, "{$url}/pl", $req);
      }
      else {
        $urlNew = $url . "/pl";
      }
    }
    else {
      if ($go != '-') {
        $urlNew = str_replace("{$url}/pl", $url, $req);
      }
      else {
        $urlNew = $url;
      }

    }
    $langOther .= '<a href="' . $urlNew . '" class="">' . $arrLang[$i] . '</a>';
  }
}
unset($i);
$langOther = '<span>' . $lang . '</span>' . $langOther;
if ($lang == 'uk') {
  $langOtherName = 'UK';
  $langPrefix = 'Uk';
  $urlGo = $url;
}

if ($lang == 'pl') {
  $langOtherName = 'PL';
  $langPrefix = 'Pl';
  $urlGo = "{$url}/{$lang}";
}


//if ( $_SERVER['REQUEST_URI'] != strtolower( $_SERVER['REQUEST_URI']) ) {
//	header('Location: https://'.$_SERVER['HTTP_HOST'] .
//		strtolower($_SERVER['REQUEST_URI']), true, 301);
//	exit();
//}


if ($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html' || $_SERVER['REQUEST_URI'] == '/index.htm') {
  header('Location: ' . $url, 301);
}

if (substr_count($_SERVER['REQUEST_URI'], '//') > 0) {
  $arrBad = ['/////', '////', '///', '//'];
  header('Location: ' . str_replace($arrBad, '/', $_SERVER['REQUEST_URI']), 301);
}


foreach ($_POST as $key => $value) {
  $value = str_replace('  ', ' ', $value);
  $value = trim($value);
  $_POST[$key] = htmlspecialchars($value);
}