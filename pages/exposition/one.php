<?
if (!$cat) {
  $cat = 'exposition_exhibitions';
}
$arrCat = [
  (object) [
    'name' => 'Все',
    'cat' => 'exposition_exhibitions',
    'link' => $urlGo . '/exposition_exhibitions/',
  ],
  (object) [
    'name' => 'Експозиції',
    'cat' => 'exposition',
    'link' => $urlGo . '/exposition/',
  ],
  (object) [
    'name' => 'Виставки',
    'cat' => 'exhibitions',
    'link' => $urlGo . '/exhibitions/',
  ],
];


$sql = "SELECT * FROM `cat_exposition` WHERE `url` LIKE '$id'";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
  $id = $row['id'];
  $title = $row['title' . $langPrefix];
  //  $added = str_replace('-', '/', $row['addedDate']);

  $info = htmlspecialchars_decode($row['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);
  //  $infoShort = $row[short];

  $added = str_replace('-', ' • ', $row['addedDate']);

  $image = "$url/upload/exposition/{$row['id']}.jpg";

  $cat = $row['cat'];

  //  $next = prevnextNews($id, 'next');
  //  if ($next) {
  //    $nextBtn = $next;
  //  }
  //  $prev = prevnextNews($id, 'prev');
  //  if ($prev) {
  //    $prevBtn = $prev;
  //  }
  //  if (strlen($row['iframe']) > 3) {
  //    $iframe = htmlspecialchars_decode($row['iframe']);
  //  }

  //  if ($row['catId']) {
  //    $catTitle = RETURN_FROM_BD($row['catId'], 'id', 'newscat', 'titleUk');
  //    $catUrl = RETURN_FROM_BD($row['catId'], 'id', 'newscat', 'url');
  //    $breadCat = "<a href='$urlGo/news-$catUrl/'>$catTitle</a> /";
  //    $added .= ' | ' . $catTitle;
  //
  //  }
  //  else {
  //    $breadCat = "<a href='$urlGo/news/'>Новини</a> /";
  //  }

  $next = prevnextNews($id, 'next', 'cat_exposition');
  if ($next) {
    $nextBtn = $next;
  }
  $prev = prevnextNews($id, 'prev', 'cat_exposition');
  if ($prev) {
    $prevBtn = $prev;
  }


}

foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";
    if ($cat != 'news_events') {
      $sql_cat = "`cat` LIKE '$cat'";
    }
  }
  else {
    $retCat .= "<a href='{$item->link}'>" . TranslateMe($item->name) . "</a>";
  }
}


?>

<div class="pageNews container">
    <h1><?= TranslateMe('ЕКСПОЗИЦІЇ ТА ВИСТАВКИ') ?></h1>
    <div class="pageAbout ">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
        </div>
    </div>
    <div class="pageNews__one">
        <div class="-img" data-aos="fade-up" data-aos-delay="900">
            <img src="<?= $image ?>" alt="">
            <div>
                <a href='<?= $urlGo . '/' . $cat . '/' ?>'
                   class='hvr-forward'><img
                            src='<?= $url ?>/img/arrow-l-b.svg'><?= t('До усіх експозицій, виставок') ?>
                </a>
              <?= $nextBtn ?>
              <?= $prevBtn ?>
            </div>
        </div>
        <div class="-info">
            <h2 class="pt-0"><?= $title ?></h2>
            <div class="info-text">
              <?= $iframe . $info ?>
            </div>
        </div>
    </div>
</div>









