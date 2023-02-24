<?

if (!$cat) {
  $cat = 'news_events';
}
$arrCat = [
  (object) [
    name => 'Все',
    cat => 'news_events',
    link => $urlGo . '/news_events/',
  ],
  (object) [
    name => 'Новини',
    cat => 'news',
    link => $urlGo . '/news/',
  ],
  (object) [
    name => 'Події',
    cat => 'events',
    link => $urlGo . '/events/',
  ],
];


$sql = "SELECT * FROM `cat_events` WHERE `url` LIKE '$id' ";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
  $id = $row['id'];
  $title = $row['title' . $langPrefix];


  $info = htmlspecialchars_decode($row['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);
  $info = str_replace('gallery_gen', 'https://vkm.org.ua/gallery_gen', $info);

  $info = str_replace('<a name="wbb4" class="wb_anchor"></a>', '', $info);


  $infoShort = $row['short'];

  $added = str_replace('-', ' • ', $row['addedDate']);

  $image = "{$url}/upload/events/{$row['id']}.jpg";

  $cat = $row['cat'];

  $next = prevnextNews($id, 'next', 'cat_events');
  if ($next) {
    $nextBtn = $next;
  }
  $prev = prevnextNews($id, 'prev', 'cat_events');
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
    <h1><?= TranslateMe('НОВИНИ ТА ПОДІЇ') ?></h1>
    <div class="pageAbout ">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
        </div>
    </div>
    <div class="pageNews__one">
        <div class="-img" data-aos="fade-up" data-aos-delay="900">
            <picture><img src="<?= $image ?>" alt=""></picture>
            <div>
                <a href='<?= $urlGo ?>/news_events/'
                   class='hvr-forward -back'><span></span><?= t('До усіх Новин, подій') ?>
                </a>
              <?= $nextBtn ?>
              <?= $prevBtn ?>
            </div>
        </div>
        <div class="-info">
            <div class="-added"><?= $added ?></div>
            <h2><?= $title ?></h2>
            <div class="info-text">
              <?= $iframe . $info ?>
            </div>
        </div>
    </div>
</div>









