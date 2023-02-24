<?
session_start();
ini_set('display_errors', 1);
//error_reporting(E_ALL && E_NOTICE);
define('ROOT', dirname(__FILE__));

$url = 'https://volynmuseum.com';
$urlGo = $url;

require_once(ROOT . '/pages/inc/components/Db.php');
$db = Db::getConnection();
//○○
require_once(ROOT . "/pages/inc/option.php");
require_once(ROOT . "/pages/inc/func.php");

//include_once './ad/js/thumb/index.php';
//include_once './ad/js/thumb/control.php';

?>
<!doctype html>
<html lang="<?= $lang ?>">
<head>
  <?
  include 'pages/layouts/seo.php';
  ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="<?= $url ?>/css/style.css?vs=<?= filemtime(ROOT . '/css/style.css') ?>">

</head>
<body>
<div id="preloader"><img src="<?= $url ?>/img/logo.svg" alt=""></div>
<a class="el-gotop hidden"></a>
<header>
  <?
  include 'pages/layouts/header.php';
  ?>
</header>
<main>
  <?
  include $l;
  ?>
</main>
<?
include 'pages/layouts/footer.php';
?>

<script async
        src="<?= $url ?>/js/bundle.js?vf=<?= filemtime(ROOT . '/js/bundle.js') ?>"></script>
</body>
</html>

