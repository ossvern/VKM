<?php
include_once "./vendor/simplehtmldom_2_0-RC2/simple_html_dom.php";


//$catTitle = 'Публікації';
//$maxPages = 16;
//
//$catTitle = 'Анонси';
//$maxPages = 12;

//$catTitle = 'Конференції';
//$maxPages = 2;

$catTitle = 'Видання';
$maxPages = 11;
//
//$catTitle = 'Статті';
//$maxPages = 3;

if (!$page) {
  $page = 1;
}

// список новин по категоріях
$pageLink = "https://vkm.org.ua/$catTitle/?bpage=$page";
echo "<h1>$pageLink</h1>";

$res = curlsci($pageLink);
$html = str_get_html($res);


if (!is_null($html)) {
  foreach ($html->find('.wb-blog-list > div a') as $el) {

    $sci_title = $el->find('.title', 0)->innertext;
    $sci_title = str_replace("'", "\'", $sci_title);


    $sci_date = $el->find('.date', 0)->innertext;
    $sci_date = substr($sci_date, 0, 10);

    $sci_short = $el->find('.description', 0)->innertext;
    $sci_short = str_replace("'", "\'", $sci_short);

    $sci_link = 'https://vkm.org.ua' . urldecode($el->getAttribute('href'));
    $sci_link = str_replace("'", "\'", $sci_link);
    $sci_link = substr($sci_link, 0, strpos($sci_link, '#wbb'));
    $sci_link .= '/';
    $sci_link = str_replace('https://vkm.org.ua/', 'https://vkm.org.ua/sci/', $sci_link);


    $sci_img = 'https://vkm.org.ua/' . $el->find('.blog-item-thumbnail', 0)
        ->getAttribute('style');
    $sci_img = str_replace('background-image:url(', '', $sci_img);
    $sci_img = str_replace("background-image: url('", '', $sci_img);
    $sci_img = str_replace('background-image: url(', '', $sci_img);
    $sci_img = str_replace("');", '', $sci_img);
    $sci_img = str_replace(')', '', $sci_img);
    $sci_img = str_replace("'", "\'", $sci_img);
    //    if (strpos($sci_img, '.pagespeed') > 0) {
    //      $sci_img = substr($sci_img, 0, strpos($sci_img, '.pagespeed'));
    //    }


    $sci_linkNew = generateUrl($sci_title);

    $sql = "INSERT INTO `parse_sci` ( `link_from`, `url`, `title`, `short`, `full`, `thumb`,`catTitle`,`added`) VALUES ('$sci_link', '$sci_linkNew', '$sci_title', '$sci_short', '0', '$sci_img','$catTitle','$sci_date');";


    // TODO cheick if in DB
    $res = $db->query($sql);
    if ($res == 1) {
      echo "<li><img src='$sci_img' alt='$sci_img' width='100'><b>$sci_title</b> - $sci_link - $sci_date</li>";

    }
    else {
      echo "<li><b>$sci_title - $sci_date</b></li><textarea>$sql</textarea>";
    }
  }
}


if ($page < $maxPages and $res == 1) {
  $page++;
  echo "<script>
  window.setTimeout(function() {
      window.location.href = 'https://volynmuseum.com/control/?go=parse-sci&page=$page';
  }, 5000);
  </script>";
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

