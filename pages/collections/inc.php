<?

if (!$department) {
  $department = '';
  $retDepartment = "<a href='$urlGo/collections/' class='-act'>" . TranslateMe('Усі музеї') . "</a>";
}
else {
  $retDepartment = "<a href='$urlGo/collections/'>" . TranslateMe('Усі музеї') . "</a>";
}
$result = $db->query("SELECT * FROM `cat_department`");
while ($q = $result->fetch_array()) {
  if ($department == $q['url']) {
    $retDepartment .= "<a href='$urlGo/collections/{$q['url']}/' class='-act'>{$q['title'.$langPrefix]}</a>";
    $sql_department = "`departmentId` LIKE '{$q['id']}'";
  }
  else {
    $retDepartment .= "<a href='$urlGo/collections/{$q['url']}'>{$q['title'.$langPrefix]}</a>";
  }
}
if ($sql_department || $sql_cat) {
  $sqlWhere = 'WHERE';
}
if ($sql_department && $sql_cat) {
  $sql_department .= ' AND ';
}


$sql = "SELECT * FROM `cat_collections` $sqlWhere $sql_department $sql_cat ORDER BY `cat_collections`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {
  //  $i++;
  $img = "$url/upload/collections/{$q['id']}.jpg";
  //  $q['addedDate'] = str_replace('-', '', $q['addedDate']);

  $info = htmlspecialchars_decode($q['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);

  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);


  $short = CropTxt($info, 450);

  $retNews .= "<a href='$urlGo/collections:{$q['url']}' class='-item'>
<picture><img src='{$url}/upload/collections/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
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
    <h1><?= TranslateMe('КОЛЕКЦІЇ') ?></h1>
    <div class="pageAbout ">
        <div class="-nav">
            <div class="-cat"><?= $retCat ?></div>
            <div class="-links"><?= $retDepartment ?></div>
        </div>
        <div class='-content'>
            <div class="pageAbout__departments -wide">
                <!--          --><? //= $sql_go ?>
              <?= $retNews ?>
            </div>
        </div>
    </div>
</div>