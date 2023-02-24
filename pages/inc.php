<div class="pageHome container">
    <div class="pageHome__about">
      <?
      $result = $db->query("SELECT * FROM `home_bnr` WHERE `show` = 1 ORDER BY `pos` DESC");
      while ($q = $result->fetch_array()) {
        $title = str_replace(' ', '<br>', $q['title' . $langPrefix]);
        $info = htmlspecialchars_decode($q['info' . $langPrefix]);

        $ret .= <<<EOF
<div class="-item"><img src="{$url}/upload/home/{$q['id']}.jpg" alt="{$title}"><div><h1>$title<a href="{$q['url']}"></a></h1><div class="content">{$info}</div><div class="nav"><a href="#" class="js-prev"></a><a href="#" class="js-next"></a></div></div></div>
EOF;
      }
      echo $ret;
      unset($ret);
      ?>
    </div>

    <div class="pageHome__sections">
        <div class="-info">
            <h3><?= t('ВІДДІЛИ') ?><br>
              <?= t('ТА ФІЛІЇ') ?><br> <?= t('МУЗЕЮ') ?>
                <a href="/about-departments_and_branches"></a>
            </h3>
          <?= htmlspecialchars_decode(RETURN_FROM_BD(8, 'id', 'info', 'info' . $langPrefix)) ?>
        </div>
 

        <div class="-list">
          <?
          $result = $db->query("SELECT * FROM `cat_department` WHERE `id`>1 ORDER BY `id` ASC");
          while ($q = $result->fetch_array()) {
            $ret .= "<a href='$urlGo/department/{$q['url']}' class='-item'><img src='$url/upload/department/{$q['id']}.png' alt='{$q['title' . $langPrefix]}'>{$q['title' . $langPrefix]}</a>";
          }
          echo $ret;
          unset($ret);
          ?>
        </div>


    </div>


    <div class="pageHome__events">
        <h3><?= t('Новини та події') ?> <a href="/news/">more</a></h3>
        <div class="-list">
          <?
          $result = $db->query("SELECT * FROM `cat_events` ORDER BY `cat_events`.`added` DESC LIMIT 0, 8");
          while ($q = $result->fetch_array()) {

            $img = "$url/upload/events/{$q['id']}.jpg";
            if (strpos($q['imageName'], 'background-image: url(') > 0) {
              $q['imageName'] = str_replace("background-image: url('", '', $q['imageName']);
              $q['imageName'] = str_replace("';", '', $q['imageName']);
            }
            if (strlen($q['imageName']) and !file_exists("./upload/events/{$q['id']}.jpg")) {
              $res = file_put_contents("./upload/events/{$q['id']}.jpg", file_get_contents(preg_replace('/\s/i', '%20', $q['imageName'])));
            }
            $width = 0;
            [
              $width,
              $height,
              $type,
              $attr,
            ] = getimagesize("./upload/events/{$q['id']}.jpg");
            if ($width == 0 || !$width) {
              $img = "$url/img/img.svg";
              unlink("./upload/events/{$q['id']}.jpg");
            }


            $q['addedDate'] = str_replace('-', ' • ', $q['addedDate']);

            $ret .= "<article class='-item'><a href='$urlGo/news:{$q['url']}'><picture><img src='{$img}' alt='{$q['title' . $langPrefix]}'></picture><small>{$q['addedDate']}</small><b>{$q['title' . $langPrefix]}</b><span>" . t('Детальніше') . "</span></a></article>";
          }
          echo $ret;
          unset($ret);
          ?>
        </div>
    </div>
    <div class="pageHome__partners">
        <h3><?= t('Партнери') ?></h3>
        <div class="pageHome__partnersList">
            <div class="owl-partners owl-carousel">
              <?
              $result = $db->query("SELECT * FROM `cat_partners` ORDER BY `titleUk` ASC");
              while ($q = $result->fetch_array()) {
                $ret .= "<a href='{$q['linkSite']}' class='-item'><img src='$url/upload/partners/{$q['id']}.png' alt='{$q['title' . $langPrefix]}'>{$q['title' . $langPrefix]}</a>";
              }
              echo $ret;
              unset($ret);
              ?>
            </div>
        </div>
    </div>
</div>
