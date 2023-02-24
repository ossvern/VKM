<?
session_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

$siteUrllocal = '..';
define('ROOT', $siteUrllocal);
$urlImg = '../upload';

require_once($siteUrllocal . '/pages/inc/components/Db.php');
$db = Db::getConnection();

require_once "pages/inc/option.php";
require_once $siteUrllocal . "/pages/inc/func.php";


$url = 'https://volynmuseum.com/control';
$siteUrl = 'https://volynmuseum.com';

//$url = 'http://vkm.docksal/control';
//$siteUrl = 'http://vkm.docksal';


$a_login = 'adminVolGreat';
$a_pass = 'd3ewr$ttt#sfdff';

$lang_arr = ['uk', 'pl'];
$title_lang_arr = ['Українська', 'Польська'];
$lang_arrPrefix = ['Uk', 'Pl'];
$selectLang = " <label>Мова<select name='lang'><option value='{$lang_arr[0]}'>{$title_lang_arr[0]}</option></select></label>";

include_once './js/thumb/index.php';
include_once './js/thumb/control.php';


foreach ($_POST as $key => $value) {
  $value = str_replace('  ', ' ', $value);
  $value = str_replace("'", "\'", $value);
  $value = str_replace('"', "\"", $value);
  $value = trim($value);
  $_POST[$key] = htmlspecialchars($value);
  //	echo "$key".'='."$value".'&';
}


//$files1 = scandir($urlImg, 1);
//echo '<pre>';
//print_r($files1);
//echo '</pre>';


$result = $db->query("SELECT * FROM `cat_department`");
while ($q = $result->fetch_array()) {
  if ($department == $q['url']) {
    $retDepartment .= "<a href='?cat={$q['url']}' class='-act'>{$q['titleUk']}</a>";
    $sql_department = "AND `departmentId` LIKE '{$q['id']}'";
  }
  else {
    $retDepartment .= "<a href='?cat={$q['url']}'>{$q['titleUk']}</a>";
  }
}


?>
<!DOCTYPE html>
<head>
    <title>Admin</title>
    <meta name="author" content="oss-studio.com">
    <meta name="robots" content="noindex">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet"
          href="<?= $url ?>/css/style.css?<?= filemtime('./css/style.css') ?>">
</head>
<body>
<header>
    <div class="container">
      <?
      if (If_Admin() == 1) {
        include 'pages/inc/top.menu.php';
      } ?>
    </div>
</header>

<main>
  <?php
  if (If_Admin() != 1) {
    include "login.php";
  }
  else {
    If_Not_Admin_Exit();
    include($l);
  }
  ?>
</main>

<script src="<?= $url ?>/js/bundle.js?<?= filemtime('./js/bundle.js') ?>"></script>
<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>


<script>
  function GoTo(vol) {
    location = vol
  }

  function DoYou(vol) {
    var ok = confirm("Ви точно Бажаєте видалити?")
    if (ok) {
      location = vol
    }
  }
</script>
</body>
</html>
