<?
if (!$cat) {
  $cat = 'news_events';
}
$arrCat = [
  (object) [
    name => 'Навчання',
    cat => 'study',
    link => $urlGo . '/scientific_work/study',
  ],
  (object) [
    name => 'Конференції',
    cat => 'conferences',
    link => $urlGo . '/scientific_work/conferences',
  ],
  (object) [
    name => 'Видання музею',
    cat => 'publication',
    link => $urlGo . '/scientific_work/publication',
  ],
  (object) [
    name => 'Наукові публікації/Бібліотека',
    cat => 'publications_library',
    link => $urlGo . '/scientific_work/publications_library',
  ],
];


$retCat = '';
foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";
    $sql_cat = "`cat` LIKE '$cat' ";
  }
  else {
    $retCat .= "<a href='{$item->link}'>" . TranslateMe($item->name) . "</a>";
  }
}

if ($sql_cat) {
  $sqlWhere = 'WHERE';
}
$page_max = 12;

$sql = "SELECT * FROM `cat_scientific_work` $sqlWhere $sql_cat ORDER BY `cat_scientific_work`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

//echo $sql_go;

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {

  if (strlen($q['imageName']) and !file_exists("./upload/scientific_work/{$q['id']}.jpg")) {
    $res = copy($q['imageName'], "./upload/scientific_work/{$q['id']}.jpg");
  }

  $img = "$url/upload/scientific_work/{$q['id']}.jpg";
  if (!file_exists("./upload/scientific_work/{$q['id']}.jpg")) {
    $img = $q['imageName'];
  }


  if (!file_exists("./upload/scientific_work/{$q['id']}.jpg")) {
    $picture = '';
  }
  else {
    $picture = "<picture><img src='{$img}' alt='{$q['title' . $langPrefix]}'></picture>";
  }


  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);
  //        <small>{$q['addedDate']}</small>

  $retNews .= "<a href='$urlGo/scientific_work:{$q['url']}' class='-item'>
$picture
<div>
    <div>

        <b>{$q['title' . $langPrefix]}</b>
    </div>
    <span>" . TranslateMe('Детальніше') . "</span>
</div>
</a>";
}

$paginator = PageIt($sql, $page, $page_max, 'scientific_work');

?>
<div class="container">
    <h1><?= TranslateMe('НАУКОВА РОБОТА') ?></h1>
    <div class="pageMasonry">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
        </div>
        <div class='-content'>
          <?= $retNews ?>
        </div>
        <br>
        <br>
      <?= $paginator ?>
    </div>
</div>