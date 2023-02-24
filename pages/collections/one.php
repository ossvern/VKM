<?
$sql = "SELECT * FROM `cat_collections` WHERE `url` LIKE '$id' ";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
  $id = $row['id'];
  $title = $row['title' . $langPrefix];
  //  $added = str_replace('-', '/', $row['addedDate']);

  $info = htmlspecialchars_decode($row['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);
  $infoShort = $row[short];

  $added = str_replace('-', ' • ', $row['addedDate']);

  $image = "$url/upload/collections/{$row['id']}.jpg";

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
}

?>

<div class="pageNews container">
    <h1><?= TranslateMe('КОЛЕКЦІЇ') ?></h1>
    <div class="pageAbout ">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
        </div>
    </div>
    <div class="pageNews__one">
        <div class="-img" data-aos="fade-up" data-aos-delay="900">
            <img src="<?= $image ?>" alt="">
            <div>
              <?= $nextBtn ?>
              <?= $prevBtn ?>
            </div>
        </div>
        <div class="-info">
            <!--            <div class="-added">--><? //= $added ?><!--</div>-->
            <h2><?= $title ?></h2>
            <div class="info-text">
              <?= $iframe . $info ?>
            </div>
        </div>
    </div>
</div>









