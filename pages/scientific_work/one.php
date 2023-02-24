<?

$sql = "SELECT * FROM `cat_scientific_work` WHERE `url` LIKE '$id' ";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
  $id = $row['id'];
  $title = $row['title' . $langPrefix];
  //  $added = str_replace('-', '/', $row['addedDate']);

  $info = htmlspecialchars_decode($row['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);
  $info = str_replace('gallery_gen', 'https://vkm.org.ua/gallery_gen', $info);

  $info = str_replace('<a name="wbb4" class="wb_anchor"></a>', '', $info);
  $info = str_replace('height=', 'data-h=', $info);
  $info = str_replace('data-h=', 'style="height:100vh"', $info);

  $iframe = $row['iframe'];
  if ($iframe) {
    $iframe = "<iframe src='$iframe'></iframe>";
  }


  $infoShort = $row[short];

  $added = str_replace('-', ' • ', $row['addedDate']);

  $image = "$url/upload/online_museum/{$row[id]}.jpg";

  $cat = $row['cat'];

}

foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";
    if ($cat != 'news_online_museum') {
      $sql_cat = "`cat` LIKE '$cat'";
    }
  }
  else {
    $retCat .= "<a href='{$item->link}'>" . TranslateMe($item->name) . "</a>";
  }
}


?>

<div class="pageNews container">
    <h1><?= TranslateMe('НАУКОВА РОБОТА') ?></h1>
    <div class="pageNews__one -wide">
        <div class="-info">
            <h2><a href="<?= $urlGo ?>/scientific_work/<?= $cat ?>"
                   class="-back"><?= TranslateMe('Назад') ?></a><span><?= $title ?></span>
            </h2>
            <div class="info-text">
              <?= $iframe . $info ?>
            </div>
        </div>
    </div>
</div>









