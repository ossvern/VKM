<?

$result = $db->query("SELECT * FROM `cat_department`  ORDER BY `id` ASC");
while ($q = $result->fetch_array()) {
  $ret .= "<a href='$urlGo/department/{$q['url']}' class='-item'><img src='./upload/department/{$q['id']}.png' alt='{$q['title' . $langPrefix]}'>
<b>{$q['title' . $langPrefix]}</b>
<span>Детальніше / квитки</span>
</a>";
}
echo "<div class='pageAbout__departments'>$ret</div>";
unset($ret);

