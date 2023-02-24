<?php

if (!$cat) {
  $cat = 'all';
}


$urlClear = 'https://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
if (strpos($urlClear, '&cat=') > 0) {
  $urlClear = substr($urlClear, 0, strpos($urlClear, '&cat='));
}

$arrCat = [
  (object) [
    name => 'Усe',
    cat => 'all',
    link => $urlClear . '&cat=all',
  ],
  (object) [
    name => 'Новини/події',
    cat => 'events',
    link => $urlClear . '&cat=events',
  ],
  (object) [
    name => 'Експозиції/виставки',
    cat => 'exposition',
    link => $urlClear . '&cat=exposition_exhibitions',
  ],
  (object) [
    name => 'Колекції',
    cat => 'collections',
    link => $urlClear . '&cat=collections',
  ],
  (object) [
    name => 'Програми/екскурсії',
    cat => 'programs_excursions',
    link => $urlClear . '&cat=programs_excursions',
  ],
  (object) [
    name => 'Наукова робота',
    cat => 'scientific_work',
    link => $urlClear . '&cat=scientific_work',
  ],
  (object) [
    name => 'Онлайн музей',
    cat => 'online_museum',
    link => $urlClear . '&cat=online_museum',
  ],
];

$kvo = 0;
$retCat = '';
foreach ($arrCat as $item) {
  $i++;
  if ($cat == $item->cat) {
    $retCat .= "<a href='{$item->link}' class='-act'>" . TranslateMe($item->name) . "</a>";

    if ($cat != 'all') {
      $ret .= searchIt($search, $item->cat);
      $retAll .= searchIt($search, $item->cat);
    }

  }
  else {
    $retCat .= "<a href='{$item->link}'>" . TranslateMe($item->name) . "</a>";
    //   $retAll .= searchIt($search,  $item->cat);
  }


  if ($item->cat != 'all') {
    $retAll .= searchIt($search, $item->cat);
  }

}


?>


    <div class="container pageSearch">
        <h1><?= TranslateMe('Пошук') ?> <b><?= $search ?></b></h1>

        <div class="pageSearch__cat">
          <?= $retCat ?>
        </div>

        <div class="pageSearch__list">
          <?
          if ($cat == 'all') {
            echo $retAll;
          }
          else {
            echo $ret;
          }
          if ($retAll == '' or $ret == '') {
            //            echo '<div class="alert">Не знайдено записів</div>';
          }
          ?>
        </div>
    </div>

<?php

function searchIt($search, $table) {

  global $langPrefix, $db, $urlGo, $url;

  $sql = "SELECT * FROM `cat_{$table}` WHERE
                          `title{$langPrefix}` LIKE '$search' OR
                          `title{$langPrefix}` LIKE '$search%' OR
                          `title{$langPrefix}` LIKE '%$search%' OR
                          `title{$langPrefix}` LIKE '%$search' OR
  
                          `info{$langPrefix}` LIKE '%$search' OR
                          `info{$langPrefix}` LIKE '$search%' OR
                          `info{$langPrefix}` LIKE '%$search%'                
         
         ORDER BY `cat_{$table}`.`added` DESC";

  //  echo $sql;

  $result = $db->query($sql);
  while ($q = $result->fetch_assoc()) {

    $img = "$url/upload/exposition/{$q['id']}.jpg";

    $short = htmlspecialchars_decode($q['info' . $langPrefix]);
    $short = CropTxt($short, 450) . '...';
    $short = str_replace('< Назад', '', $short);

    $retNews .= "<a href='$urlGo/$table:{$q['url']}' class='-item'>
<picture><img src='{$url}/upload/$table/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'></picture>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>" . TranslateMe('Детальніше') . "</span>
</div>
</a>";

  }
  return $retNews;

}