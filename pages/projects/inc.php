<?

$sql = "SELECT * FROM `cat_projects` ORDER BY `cat_projects`.`added` DESC";
$sql_go = $sql . " LIMIT $page_start,$page_max";

$result = $db->query($sql_go);
while ($q = $result->fetch_assoc()) {
  //  $i++;
  $img = "$url/upload/projects/{$q['id']}.jpg";


  $info = htmlspecialchars_decode($q['info' . $langPrefix]);
  $info = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $info);

  $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);


  $short = CropTxt($info, 300);

  $retNews .= "<a href='$urlGo/about-projects:{$q['url']}' class='-item'><picture><img src='{$url}/upload/projects/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>Детальніше</span>
</div>
</a>";
}

//$paginator = PageIt($sql, $page, $page_max);
//echo "$paginator";
?>
<!--<div class="container">-->
<!--    <h1>ОНЛАЙН МУЗЕЙ</h1>-->
<!--    <div class="pageAbout">-->
<!--        <div class="-nav">-->
<!--            <div class="-links">--><? //= $retCat ?><!--</div>-->
<!--        </div>-->
<!--        <div class='-content'>-->
<div class="pageAbout__departments -wide">
  <?= $retNews ?>
</div>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->