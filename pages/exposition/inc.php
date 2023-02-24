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
foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";
    if ($cat != 'exposition_exhibitions') {
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


$sql = "SELECT * FROM `cat_exposition` $sqlWhere $sql_department $sql_cat ORDER BY `cat_exposition`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start, $page_max";
//echo $sql_go;
$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {
  //  $i++;
  $img = "$url/upload/exposition/{$q['id']}.jpg";
  //  $q['addedDate'] = str_replace('-', '', $q['addedDate']);

  $short = htmlspecialchars_decode($q['info' . $langPrefix]);
  $short = CropTxt($short, 450) . '...';

  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);

  $retNews .= "<a href='$urlGo/exposition:{$q['url']}' class='-item'>
<picture><img src='{$url}/upload/exposition/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>" . TranslateMe('Детальніше') . "</span>
</div>
</a>";
}

//$paginator = PageIt($sql, $page, $page_max);

//echo "$paginator";
?>
<div class="container">
    <h1><?= TranslateMe('ЕКСПОЗИЦІЇ ТА ВИСТАВКИ') ?></h1>
    <div class="pageAbout">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
            <div class="-links"><?= $retDepartment ?></div>
        </div>
        <div class='-content'>
            <div class="pageAbout__departments -wide">
              <?= $retNews ?>
            </div>
        </div>
    </div>
</div>