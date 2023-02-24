<?php
if (!$cat) {
  redirectMe('online_museum/exhibitions');
}


//if (!$category) {
//  $category = '';
//  $retCat = "<a href='$urlGo/$cat/' class='-act'>Усі музеї</a>";
//}
//else {
//  $retCat = "<a href='$urlGo/$cat/'>Усі музеї</a>";
//}

$categoryLink = [
  'exhibitions',
  'tests',
  'puzzles',
  '3d_models',
];
$categoryTitle = [
  'ОНЛАЙН-виставки',
  'ОНЛАЙН-ТЕСТИ',
  'ОНЛАЙН-ПАЗЛИ',
  '3D МОДЕЛІ',
];
$i = -1;
$retCat = '';
while ($i++ < count($categoryLink) - 1) {

  if ($cat == $categoryLink[$i]) {
    $retCat .= "<a href='$urlGo/online_museum/$categoryLink[$i]' class='-act'>{$categoryTitle[$i]}</a>";
    $sql_cat = "`cat` LIKE '{$cat}'";
  }
  else {
    $retCat .= "<a href='$urlGo/online_museum/$categoryLink[$i]'>{$categoryTitle[$i]}</a>";
  }
}

if ($sql_cat) {
  $sqlWhere = 'WHERE';
}
$page_max = 99;
$sql = "SELECT * FROM `cat_online_museum` $sqlWhere $sql_cat ORDER BY `cat_online_museum`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {
  //  $i++;
  $img = "$url/upload/collections/{$q['id']}.jpg";
  //  $q['addedDate'] = str_replace('-', '', $q['addedDate']);

  $info = htmlspecialchars_decode($q['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);

  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);


  $short = CropTxt($info, 300);


  if ($cat == 'puzzles') {

    $retNews .= "<a href='$urlGo/online_museum:{$q['url']}' class='-item'><picture><img src='{$url}/upload/online_museum/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
    </div>
</div>
</a>";

  }
  else {

    $retNews .= "<a href='$urlGo/online_museum:{$q['url']}' class='-item'><picture><img src='{$url}/upload/online_museum/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>Детальніше</span>
</div>
</a>";
  }
}

//$paginator = PageIt($sql, $page, $page_max);

?>
<div class="container">
    <h1>ОНЛАЙН МУЗЕЙ</h1>
    <div class="pageAbout">
        <div class="-nav">
            <div class="-links"><?= $retCat ?></div>
        </div>
        <div class='-content'>
            <div class="pageAbout__departments <?= ($cat != 'puzzles') ? '-wide' : '' ?>">
              <?= $retNews ?>
            </div>
          <?= $paginator ?>
        </div>
    </div>
</div>