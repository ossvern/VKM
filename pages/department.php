<?php
$result = $db->query("SELECT * FROM `cat_department` WHERE `url` like '$id'");
while ($q = $result->fetch_array()) {
  $info = htmlspecialchars_decode($q['info' . $langPrefix]);
  $title = htmlspecialchars_decode($q['title' . $langPrefix]);
  $img .= "<img src='/upload/department/{$q['id']}.png' alt='{$q['title' . $langPrefix]}'>";
}
?>
<div class="pageDepartment container">
    <h1><?= TranslateMe('Про музей') ?></h1>
    <div class="pageDepartment__content">
        <div class="-img">
            <div class="-fix">
              <?= $img ?>
                <div class="-nav">
                    <a href="<?= $urlGo ?>/about-departments_and_branches"><span></span><?= TranslateMe('До усіх музеїв') ?>
                    </a>
                </div>
                <a href="https://vkm.event.net.ua/" target="_blank"
                   class="-btnGo"><span><?= TranslateMe('КУПИТИ КВИТКИ') ?></span></a>
            </div>
        </div>
        <div class="-info">
            <h2><?= $title ?></h2>
          <?= $info ?>
        </div>
    </div>
</div>