<?php
include_once "./vendor/simplehtmldom_2_0-RC2/simple_html_dom.php";

$sql = "SELECT * FROM `parse_sci` WHERE `full` = '0' LIMIT 1";
$result = $db->query($sql);
while ($row = $result->fetch_array()) {

  // список новин по категоріях
  $pageLink = urldecode($row['link_from']);
  $pageLink = str_replace('sci/', '', $pageLink);
  //  $pageLink = substr($pageLink, 0, strpos($pageLink, '#wbb'));
  //  $pageLink .= '/';
  //  $pageLink = str_replace('https://vkm.org.ua/', 'https://vkm.org.ua/sci/', $pageLink);

  $id = $row['id'];


  echo "<li>$id ";

  $res = curlsci($pageLink);
  $html = str_get_html($res);


  if (!is_null($html)) {
    //    $sci_full = $html->find('.wb_cont_inner .wb-blog', 0)->innertext;
    $sci_full = $html->find('.wb-blog', 0)->innertext;

    $sci_full = htmlspecialchars($sci_full);
    $sci_full = str_replace("'", '`', $sci_full);
    $sci_full = str_replace("< Назад", '', $sci_full);

    if (strlen($sci_full) > 20) {
      $sql = "UPDATE `parse_sci` SET `full` = '$sci_full' WHERE `parse_sci`.`id` = '$id';";
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
    window.location.href = 'https://volynmuseum.com/control/?go=parse-sci.one';
}, 1200);
</script>";
}
else {
  echo $sql;
}


// всі новини


function curlsci($url) {

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

