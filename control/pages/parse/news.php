<?php
include_once "./vendor/simplehtmldom_2_0-RC2/simple_html_dom.php";


$catTitle = 'Публікації';
$maxPages = 16;

$catTitle = 'Анонси';
$maxPages = 12;

$catTitle = 'Конференції';
$maxPages = 2;

$catTitle = 'Видання';
$maxPages = 11;

$catTitle = 'Статті';
$maxPages = 3;

if (!$page) {
  $page = 1;
}

// список новин по категоріях
$pageLink = "https://vkm.org.ua/$catTitle/?bpage=$page";
echo "<h1>$pageLink</h1>";

$res = curlNews($pageLink);
$html = str_get_html($res);


if (!is_null($html)) {
  foreach ($html->find('.wb-blog-list > div a') as $el) {

    $news_title = $el->find('.title', 0)->innertext;
    $news_title = str_replace("'", "\'", $news_title);


    $news_date = $el->find('.date', 0)->innertext;
    $news_date = substr($news_date, 0, 10);

    $news_short = $el->find('.description', 0)->innertext;
    $news_short = str_replace("'", "\'", $news_short);

    $news_link = 'https://vkm.org.ua' . urldecode($el->getAttribute('href'));
    $news_link = str_replace("'", "\'", $news_link);
    $news_link = substr($news_link, 0, strpos($news_link, '#wbb'));
    $news_link .= '/';
    $news_link = str_replace('https://vkm.org.ua/', 'https://vkm.org.ua/news/', $news_link);


    $news_img = 'https://vkm.org.ua/' . $el->find('.blog-item-thumbnail', 0)
        ->getAttribute('style');
    $news_img = str_replace('background-image:url(', '', $news_img);
    $news_img = str_replace("background-image: url('", '', $news_img);
    $news_img = str_replace('background-image: url(', '', $news_img);
    $news_img = str_replace("');", '', $news_img);
    $news_img = str_replace(')', '', $news_img);
    $news_img = str_replace("'", "\'", $news_img);
    //    if (strpos($news_img, '.pagespeed') > 0) {
    //      $news_img = substr($news_img, 0, strpos($news_img, '.pagespeed'));
    //    }


    $news_linkNew = generateUrl($news_title);

    $sql = "INSERT INTO `parse_news` ( `link_from`, `url`, `title`, `short`, `full`, `thumb`,`catTitle`,`added`) VALUES ('$news_link', '$news_linkNew', '$news_title', '$news_short', '0', '$news_img','$catTitle','$news_date');";


    // TODO cheick if in DB
    $res = $db->query($sql);
    if ($res == 1) {
      echo "<li><img src='$news_img' alt='$news_img' width='100'><b>$news_title</b> - $news_link - $news_date</li>";

    }
    else {
      echo "<li><b>$news_title - $news_date</b></li><textarea>$sql</textarea>";
    }
  }
}


if ($page < $maxPages and $res == 1) {
  $page++;
  echo "<script>
  window.setTimeout(function() {
      window.location.href = 'https://volynmuseum.com/control/?go=parse-news&page=$page';
  }, 5000);
  </script>";
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

