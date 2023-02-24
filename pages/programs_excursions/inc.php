<?
if (!$cat) {
  $cat = 'programs_excursions';
}
$arrCat = [
  (object) [
    'name' => 'Все',
    'cat' => 'programs_excursions',
    'link' => $urlGo . '/programs_excursions/',
  ],
  (object) [
    'name' => 'Екскурсії',
    'cat' => 'excursions',
    'link' => $urlGo . '/excursions/',
  ],
  (object) [
    'name' => 'Програми',
    'cat' => 'programs',
    'link' => $urlGo . '/programs/',
  ],
];
$retCat = '';
foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";
    if ($cat != 'programs_excursions') {
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


$sql = "SELECT * FROM `cat_programs_excursions` $sqlWhere $sql_department $sql_cat ORDER BY `cat_programs_excursions`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {
  //  $i++;
  $img = "$url/upload/programs_excursions/{$q['id']}.jpg";
  //  $q['addedDate'] = str_replace('-', '', $q['addedDate']);

  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);

  $info = htmlspecialchars_decode($q['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);
  $short = CropTxt($info, 450);

  if (strlen($q['imageName']) and !file_exists("./upload/programs_excursions/{$q['id']}.jpg")) {
    copy($q['imageName'], "./upload/programs_excursions/{$q['id']}.jpg");
  }
  $retNews .= "<a href='$urlGo/programs_excursions:{$q['url']}' class='-item'>
<picture><img src='{$url}/upload/programs_excursions/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>" . TranslateMe('Детальніше') . "</span>
</div>
</a>";
}
$paginator = PageIt($sql, $page, $page_max);
?>
<div class="container">
    <h1><?= TranslateMe('Програми/екскурсії') ?></h1>
    <div class="pageAbout -wide">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
            <div class="-links"><?= $retDepartment ?></div>
        </div>
        <div class='-content'>
            <div class="pageAbout__departments -wide">
              <?= $retNews . $paginator ?>
            </div>
        </div>
    </div>
</div>