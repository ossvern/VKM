<?


$corrent_url = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];


if ($go == '/sale/one' && $go == '/news/one') {

  $sql = ("SELECT * FROM seo_header WHERE url LIKE '$corrent_url' LIMIT 1");
  $result = $db->query($sql);
  if (mysqli_num_rows($result) == 1) {
    while ($row = $result->fetch_array()) {
      $ret_title = $row['title'];
      $ret_description = strip_tags($row['description']);
      $ret_keywords = strip_tags($row['keywords']);
    }
  } else {
    if (strpos($corrent_url, '?') == 0) {
      $sql = "INSERT INTO `seo_header` (`added`, `lang`, `url`) VALUES
('" . date('Y-m-d H:i:s') . "', '$lang', '" . $corrent_url . "');";
      $db->query($sql);
    }
  }
}


switch ($go) {
  case '-':
    $ret_title = "«Волинський краєзнавчий музей» ";
    break;
//  case '/docs':
//    $ret_title = "Дозвільна документація - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/about':
//    $ret_title = "Про нас - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/news/inc':
//    $ret_title = "Новини - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/apartments':
//    $ret_title = "Обирай простір для нового життя - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/installments':
//    $ret_title = "Лояльна програма розтермінування - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/vacancies':
//    $ret_title = "Вакансії - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/orenda':
//    $ret_title = "Оренда - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/contact':
//    $ret_title = "Контакти - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/commerce':
//    $ret_title = "Комерція - «EuroHolding» Квартири від забудовника";
//    break;
//  case '/video':
//    $ret_title = "Відео - «EuroHolding» Квартири від забудовника";
//    break;
}

//
//
//

if ($go == '/news/one') {
  $sql = "SELECT * FROM `cat_events` where `id` like '$id' limit 1";
  $result = $db->query($sql);
  while ($row = $result->fetch_array()) {
    $ret_title = $row['title'] . ' - новини  - «EuroHolding»';
    $ret_description = $row['info'];
    $ret_description = htmlspecialchars_decode($ret_description);
    $ret_description = strip_tags($ret_description);
    $ret_description = str_replace('&nbsp;', '', $ret_description);

    $ret_description = str_replace("\r\n", "", $ret_description);

    $ret_description = CropTxt($ret_description, 350);
    $ogImage = "$url/upload/news/{$row['id']}.jpg";
  }
}

if ($go == '/commerce/one') {
  $sql = "SELECT * FROM `cat_products` where `id` like '$id' limit 1";
  $result = $db->query($sql);
  while ($row = $result->fetch_array()) {
    $ret_title = $row['titleUk'] . ' - комерція  - «EuroHolding»';
    $ret_description = $row['infoUk'];
    $ret_description = htmlspecialchars_decode($ret_description);
    $ret_description = strip_tags($ret_description);
    $ret_description = str_replace('&nbsp;', '', $ret_description);

    $ret_description = str_replace("\r\n", "", $ret_description);


    $ret_description = CropTxt($ret_description, 350);
    $ogImage = "$url/upload/commerce/th/{$row['id']}.jpg";
  }
}




if(!$ogImage) $ogImage = "$url/img/og.jpg";

if (strlen($ret_description) < 10) {
  $ret_description = ' ';
}

if (strlen($ret_title) < 10) {
  $ret_title = ('Волинський краєзнавчий музей');
}


?>
<title><?= $ret_title ?></title>
<meta name="description" content="<?= $ret_description ?>">
<meta name="keywords" content="квартира в новобудова, забудовник ">
<link rel="canonical" href="<?= canonical_URL() ?>"/>

<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta charset="utf-8">

<meta property=og:image content="<?=$ogImage?>"/>
<meta property=og:type content=website />
<meta property=og:title content="<?= $ret_title ?>"/>
<meta property=og:description content="<?= $ret_description ?>"/>
<meta property=og:site_name content="euroholding.net.ua"/>
<meta property=og:locale content="ua_UA"/>
<meta property=og:url content="<?= canonical_URL() ?>"/>

<link rel="apple-touch-icon" sizes="57x57" href="<?= $url ?>/img/fav/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?= $url ?>/img/fav/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?= $url ?>/img/fav/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?= $url ?>/img/fav/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?= $url ?>/img/fav/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?= $url ?>/img/fav/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?= $url ?>/img/fav/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?= $url ?>/img/fav/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= $url ?>/img/fav/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= $url ?>/img/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= $url ?>/img/fav/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= $url ?>/img/fav/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?= $url ?>/img/fav/ms-icon-144x144.png">
<meta name="theme-color" content="#F9EBE0">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">