<?php


function redirectMe($link) {
  global $urlGo;
  echo "<script>parent.location.replace('{$urlGo}/{$link}')</script>";
  return;
}


function PageIt($sql, $page, $max, $pageLink = FALSE) {
  global $url, $cat, $department;
  $kvo = GetKvo($sql);
  $i = 0; //<p>Сторінка:</p>
  $visible_p = 10; // видно сторінок
  $ret = '';
  if ($pageLink) {
    $pageLink .= '/';
  }
  $urlpage = "$url/{$pageLink}$cat/"; //. $link_no_page;
  if ($department) {
    $urlpage = "$url/{$pageLink}$cat/$department/";
  } //. $link_no_page;


  //  if ($cat != 'news') $urlpage .= 'actions/'; else $urlpage .= 'news/';
  if ($max < $kvo) {


    $f = 1;
    $l = $f + $max;
    $mp = 0;
    while ($i++ <= $kvo) {
      if (($i - $page) < $visible_p and $i > ($page - $visible_p)) {
        if ($i != $page) {
          if ($l - $f <= $max && $l - $f >= 1) {

            if ($i != 1) {
              $ret .= '<a href="' . $urlpage . 'page:' . $i . '/" title="' . $i . '">' . $i . '</a>';
            }
            else {
              $ret .= '<a href="' . $urlpage . '" title=" ' . $i . '">' . $i . '</a>';
            }


            $mp = $mp + 1;
          }
        }
        else {
          $ret .= "<a href='#' class='-act'>$i</a>";
        }
      }
      $f = $f + $max;
      if ($l + $max <= $kvo) {
        $l = $l + $max;
      }
      else {
        $l = $kvo + 1;
      }
    }
    $end_page = ($kvo / $max);
    if (fmod($kvo, $max) > 0) {
      $end_page = $end_page + 1;
    }
    $end_page = floor($end_page);
    return '<nav class="--pagination">' . $ret . "</nav>";
  }
}


function GetKvo($sqlkvo) {
  global $db;
  $result = $db->query($sqlkvo);
  $maxrows = mysqli_num_rows($result);
  return $maxrows;
}


function getRealIpAddr() { //===================================  тирим іп для визначення країни
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}


function prevnextNews($id, $type, $table) {
  global $db, $langPrefix, $url, $urlGo;
  $next = 0;

  if ($type == 'prev') {
    $sqlOrder = 'DESC';
  }
  if ($type == 'next') {
    $sqlOrder = 'ASC';
  }
  // where `lang` LIKE '$lang'
  $sql = "SELECT id, url, title$langPrefix FROM `$table` ORDER BY  `$table`.`added` $sqlOrder ";

  //	echo "<strong>$sql</strong>";

  if ($table == 'cat_events') {
    $actPage = 'news';
  }
  if ($table == 'cat_exposition') {
    $actPage = 'news';
  }


  $result = $db->query($sql);
  while ($row = $result->fetch_array()) {
    if ($next == 1 && $type == 'prev') {
      return "<a href='$urlGo/$actPage:{$row['url']}' class='hvr-forward -back'><span></span>" . TranslateMe('Попередня новина') . "</a>";
    }
    if ($next == 1 && $type == 'next') {
      return "<a href='$urlGo/$actPage:{$row['url']}' class='hvr-forward -next'><span></span>" . TranslateMe('Наступна новина') . "</a>";
    }
    if ($id == $row['id']) {
      $next = 1;
    }

  }


}


function t($inword, $lang_origin = FALSE) { // сторінки // BEGIN function
  global $lang, $db;

  if (strlen($inword) > 0) {
    if ($lang != 'uk') {
      $sql = "SELECT * FROM `lang` WHERE `uk` LIKE '$inword' LIMIT 1";
      $result = $db->query($sql);
      $kvo = mysqli_num_rows($result);
      if ($kvo == 0) {
        $db->query("INSERT INTO `lang` (`pl`, `uk`) VALUES ('0', '$inword');");
        return $inword;
      }
      else {
        if ($kvo == 1) {
          while ($row = $result->fetch_array()) {
            if ($row['pl'] != '0') {
              return htmlspecialchars_decode($row['pl']);
            }
            else {
              return $inword;
            }

          }
        }
      }
    }
    else {
      return $inword;
    }
  }
}

function TranslateMe($inword, $lang_origin = FALSE) { // сторінки // BEGIN function
  return t($inword, $lang_origin);
}

function del_from_array($needle, &$array, $all = TRUE) {
  if (!$all) {
    if (FALSE !== $key = array_search($needle, $array)) {
      unset($array[$key]);
    }
    return;
  }
  foreach (array_keys($array, $needle) as $key) {
    unset($array[$key]);
  }
}


function generateUrl($str) {

  $str = trim($str);
  $str = urldecode($str);
  $str = stripslashes($str);


  $translit = [
    "А" => "A",
    "Б" => "B",
    "В" => "V",
    "Г" => "G",
    "Д" => "D",
    "Е" => "E",
    "Ж" => "J",
    "З" => "Z",
    "И" => "I",
    "Й" => "Y",
    "К" => "K",
    "Л" => "L",
    "М" => "M",
    "Н" => "N",
    "О" => "O",
    "П" => "P",
    "Р" => "R",
    "С" => "S",
    "Т" => "T",
    "У" => "U",
    "Ф" => "F",
    "Х" => "H",
    "Ц" => "TS",
    "Ч" => "CH",
    "Ш" => "SH",
    "Щ" => "SCH",
    "Ъ" => "",
    "Ы" => "YI",
    "Ь" => "",
    "Э" => "E",
    "Ю" => "YU",
    "Я" => "YA",
    "а" => "a",
    "б" => "b",
    "в" => "v",
    "г" => "g",
    "д" => "d",
    "е" => "e",
    "ж" => "j",
    "з" => "z",
    "и" => "i",
    "й" => "y",
    "к" => "k",
    "л" => "l",
    "м" => "m",
    "н" => "n",
    "о" => "o",
    "п" => "p",
    "р" => "r",
    "с" => "s",
    "т" => "t",
    "у" => "u",
    "ф" => "f",
    "х" => "h",
    "ц" => "ts",
    "ч" => "ch",
    "ш" => "sh",
    "щ" => "sch",
    "ъ" => "y",
    "ы" => "yi",
    "ь" => "",
    "э" => "e",
    "ю" => "yu",
    "я" => "ya",
    " " => "_",
    '/' => '_',
    "Є" => "e",
    "є" => "e",
    "І" => "I",
    "і" => "i",
    "&" => "",
    "(" => "",
    ")" => "",
    "+" => "",
    "." => "",
    "," => "",
    ";" => "",
    "'" => "",
    "`" => "",
    "*" => "",
    "%" => "",
    "№" => "",
    '"' => "",
    'ё' => "e",
    '#' => "",
    'ї' => "",
    '-' => "_",
    '�' => "",
    '?' => "",
    '!' => "",
    '»' => "",
    '«' => "",
    ':' => "",
    '®' => '',
    '’' => '',
    '%E2%80%93' => '',
    '—' => "_",
    'Ї' => "i",
    '–' => "_",
    '&nbsp;' => "",
    '%C2%A0' => "",
    '_____' => "",
    '____' => "",
    '___' => "",
    '__' => "",
    '_-_' => "",
  ];
  $ret = strtr($str, $translit);
  //  $ret = str_replace('_____', '_', $ret);
  //  $ret = str_replace('____', '_', $ret);
  //  $ret = str_replace('___', '_', $ret);
  //  $ret = str_replace('__', '_', $ret);
  //  $ret = str_replace('_-_', '_', $ret);
  $ret = strtolower($ret);

  if (strlen($ret) >= 80) {
    //    $str = substr($str, 0, 60);
    $ret = ProtectStr($ret, 80);
  }
  $str = trim($ret);
  return ($ret);
}


function ProtectStr($str, $length = FALSE, $default = FALSE) {
  $str = htmlspecialchars(trim($str));
  $str = str_replace("'", "\'", $str);
  if ($length != '') {
    $str = substr($str, 0, $length);
  }
  if (strlen($str) == 0) {
    $str = '';
    if (strlen($default) > 0) {
      $str = $default;
    }
  }
  return $str;
}


function RETURN_FROM_BD($id, $row, $mtable, $mrow) {
  global $db;
  $result = $db->query("SELECT $mrow FROM `$mtable` WHERE `$row` = '$id'");
  while ($row = $result->fetch_array()) {
    return $row[$mrow];
  }

  //  return "SELECT $mrow FROM `$mtable` WHERE `$row` = '$id'";

}

function RETURN_FROM_BD_SQL($sql, $go) {
  global $db;
  $ret = 0;
  $result = $db->query($sql);
  while ($row = $result->fetch_array()) {
    $ret = $row[$go];
  }
  return $ret;
}


function If_Admin() {
  global $a_pass;
  if ($a_pass == $_SESSION['admin']) {
    return 1;
  }
  else {
    return 0;
  }
}

function If_Not_Admin_Exit() {
  global $a_pass;
  if (If_Admin() != 1) {
    //   echo'<script type="text/javascript">window.location = "http://dson.com.ua/"</script>';
    // break;
    die();

    //  header('Location: http://dson.com.ua/');
    //  sleep(5555555);
    //  echo'<script type="text/javascript">window.location = "?go=/"</script>';
  }
}

function CropTxt($text, $kvo) {

  $text = htmlspecialchars_decode($text);
  $text = strip_tags($text, '');
  if (strlen($text) > $kvo) {
    $end = strpos($text, " ", $kvo);
    $n_text = substr($text, 0, $end);
    if ($n_text == '...') {
      $n_text = $text;
    }
  }
  else {
    $n_text = $text;
  }
  return $n_text;
}

function canonical_URL() {
  $url = @($_SERVER["HTTPS"] != 'on') ? 'https://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
  $url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return strtolower($url);
}

function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 95) {
  if (!file_exists($src)) {
    return FALSE;
  }

  $size = getimagesize($src);

  if ($size === FALSE) {
    return FALSE;
  }

  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) {
    return FALSE;
  }

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
  $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
  $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return TRUE;
}
