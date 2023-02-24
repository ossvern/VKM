<?php
include_once "./vendor/simplehtmldom_2_0-RC2/simple_html_dom.php";

$sql = "SELECT * FROM `parse_news` WHERE `full` = '0' LIMIT 1";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {

  // список новин по категоріях
  $pageLink = urldecode($row['link_from']);
  //  $pageLink = substr($pageLink, 0, strpos($pageLink, '#wbb'));
  //  $pageLink .= '/';
  //  $pageLink = str_replace('https://vkm.org.ua/', 'https://vkm.org.ua/news/', $pageLink);

  $id = $row['id'];


  echo "<li>$id ";

  $res = curlNews($pageLink);
  $html = str_get_html($res);


  if (!is_null($html)) {
    //    $news_full = $html->find('.wb_cont_inner .wb-blog', 0)->innertext;
    $news_full = $html->find('.wb-blog', 0)->innertext;

    $news_full = htmlspecialchars($news_full);
    $news_full = str_replace("'", '`', $news_full);
    $news_full = str_replace("< Назад", '', $news_full);

    if (strlen($news_full) > 20) {
      $sql = "UPDATE `parse_news` SET `full` = '$news_full' WHERE `parse_news`.`id` = '$id';";
      $res = $db->query($sql);

      if ($res == 1) {
        echo "<strong>ok</strong> - $pageLink";
      }
      else {
        echo "<strong>bad</strong> - $pageLink";
      }

    }
  }
}


if ($res == 1) {
  $page++;
  echo "<script>
window.setTimeout(function() {
    window.location.href = 'https://volynmuseum.com/control/?go=parse-news.one';
}, 1200);
</script>";
}
else {
  echo $sql;
}


// всі новини


function curlNews($url) {

  $ch = curl_init();


  // set url
  curl_setopt($ch, CURLOPT_URL, $url);

  //return the transfer as a string
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // $output contains the output string
  $output = curl_exec($ch);

  // close curl resource to free up system resources
  curl_close($ch);
  return $output;
}

