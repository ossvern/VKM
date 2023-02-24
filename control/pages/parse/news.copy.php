<?php


$sql = "SELECT * FROM `parse_news`";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {
  $cat = 'news';
//  if ($row['catTitle'] == 'Видання') {
//    $cat = 'publication';
//  }
//  if ($row['catTitle'] == 'Статті') {
//    $cat = 'publications_library';
//  }
//  if ($row['catTitle'] == 'Конференції') {
//    $cat = 'conferences';
//  }
  if ($row['catTitle'] == 'Анонси') {
    $cat = 'events';
  }
  $row['thumb'] = str_replace("background-image: url('", '', $row['thumb']);
  $row['thumb'] = str_replace("');", '', $row['thumb']);
  $row['thumb'] = str_replace("';", '', $row['thumb']);

  if ($cat) {
    $sql = "INSERT INTO `cat_events` (`addedDate`, `added`, `url`, `departmentId`, `cat`, `imageName`, `titleUk`, `infoUk`) VALUES ('{$row['added']}','{$row['added']}', '{$row['url']}', '1', '$cat', '{$row['thumb']}', '{$row['title']}', '{$row['full']}');";
  }

  $res = $db->query($sql);

  if ($res == 0) {
    echo "<textarea>$sql</textarea>";
  }
  else {
    echo "<h2>{$row['title']}</h2>$sql";
  }


}