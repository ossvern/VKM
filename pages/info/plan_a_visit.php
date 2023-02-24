<div class="container">
    <h1><?= TranslateMe('СПЛАНУЙТЕ ВІЗИТ') ?></h1>

    <div class="pagePlanVisit">
        <div>
            <img src="<?= $url ?>/upload/plan_visit.png" alt="">
            <div>
                <h3><?= TranslateMe('ГРАФІК РОБОТИ') ?></h3>
                <div class="-row">
                  <?= htmlspecialchars_decode(RETURN_FROM_BD(7, 'id', 'info', 'info' . $langPrefix)) ?>
                </div>
            </div>
            <div class="pagePlanVisit__list">
              <?
              $sql = "SELECT * FROM `cat_exposition` WHERE `cat` LIKE 'exposition' ORDER BY `cat_exposition`.`added` DESC LIMIT 0, 2";
              $result = $db->query($sql);
              while ($q = $result->fetch_assoc()) {
                $img = "$url/upload/exposition/{$q['id']}.jpg";
                $short = htmlspecialchars_decode($q['info' . $langPrefix]);
                $short = CropTxt($short, 240) . '...';

                $retNews .= "<a href='$urlGo/exposition:{$q['url']}' class='-item'>
<img src='{$url}/upload/exposition/{$q['id']}.jpg' alt='{$q['title' . $langPrefix]}'>
<div>
    <div>
        <b>{$q['title' . $langPrefix]}</b>
        <p>{$short}</p>
    </div>
    <span>" . TranslateMe('Детальніше') . "</span>
</div>
</a>";
              }

              echo $retNews;
              ?>
            </div>

            <a href="https://vkm.event.net.ua/" target="_blank"
               class="-btnGo"><span><?= TranslateMe('КУПИТИ КВИТКИ') ?></span></a>

        </div>

        <div class="info-text">
          <?= htmlspecialchars_decode(RETURN_FROM_BD(6, 'id', 'info', 'info' . $langPrefix)) ?>
        </div>
    </div>

</div>








