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

if (!$department) {
  $department = '';
  $retDepartment = "<a href='$urlGo/$cat/' class='-act'>" . TranslateMe('Усі музеї') . "</a>";
}
else {
  $retDepartment = "<a href='$urlGo/$cat/'>" . TranslateMe('Усі музеї') . "</a>";
}
$result = $db->query("SELECT * FROM `cat_department`");
while ($q = $result->fetch_array()) {
  if ($department == $q['url']) {
    $retDepartment .= "<a href='$urlGo/$cat/{$q['url']}/' class='-act'>{$q['title'.$langPrefix]}</a>";
    $sql_department = "`departmentId` LIKE '{$q['id']}'";
  }
  else {
    $retDepartment .= "<a href='$urlGo/$cat/{$q['url']}'>{$q['title'.$langPrefix]}</a>";
  }
}
if ($sql_department || $sql_cat) {
  $sqlWhere = 'WHERE';
}
if ($sql_department && $sql_cat) {
  $sql_department .= ' AND ';
}


$sql = "SELECT * FROM `cat_events` $sqlWhere $sql_department $sql_cat ORDER BY `cat_events`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {

  $img = "$url/upload/events/{$q['id']}.jpg";
  if (strpos($q['imageName'], 'background-image: url(') > 0) {
    $q['imageName'] = str_replace("background-image: url('", '', $q['imageName']);
    $q['imageName'] = str_replace("';", '', $q['imageName']);
  }
  if (strlen($q['imageName']) and !file_exists("./upload/events/{$q['id']}.jpg")) {
    $res = file_put_contents("./upload/events/{$q['id']}.jpg", file_get_contents(preg_replace('/\s/i', '%20', $q['imageName'])));
  }
  $width = 0;
  [
    $width,
    $height,
    $type,
    $attr,
  ] = getimagesize("./upload/events/{$q['id']}.jpg");
  if ($width == 0 || !$width) {
    $img = "$url/img/img.svg";
    unlink("./upload/events/{$q['id']}.jpg");
  }

  $urlTrue = generateUrl($q['titleUk']);
  if ($q['url'] != $urlTrue) {
    $db->query("UPDATE `cat_events` SET `url` = '{$urlTrue}' WHERE `id`='{$q['id']}'");
  }

  $retNews .= "<a href='$urlGo/news:{$q['url']}' class='-item'>
<picture>
<img src='$img' alt='{$q['id']} - $width - {$q['title' . $langPrefix]}'>
</picture>
<i>{$q['addedDate']}</i>
<b>{$q['title' . $langPrefix]}</b>
<span>" . t('Детальніше') . "</span>
</a>";

}
if (!$retNews) {
  $retNews = "<div class='info'>" . t('Інформація не додана') . "</div>";
}


$paginator = PageIt($sql, $page, $page_max);
//echo "$paginator";
?>
<div class="container">
    <h1><?= t('НОВИНИ ТА ПОДІЇ') ?></h1>
    <div class="pageAbout ">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
            <div class="-links"><?= $retDepartment ?></div>
        </div>
        <div class='-content'>
            <div class="pageAbout__departments">
              <?= $retNews ?>
            </div>
          <?= $paginator ?>
        </div>
    </div>
</div>