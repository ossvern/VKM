<div class="pageAbout__contact">
  <?php
  $result = $db->query("SELECT * FROM `info` where `url` LIKE 'contacts'");
  while ($q = $result->fetch_array()) {
    $title = htmlspecialchars_decode($q['title' . $langPrefix]);
    $info = htmlspecialchars_decode($q['info' . $langPrefix]);

  }
  ?>
    <h2><?= $title ?></h2>
  <?= $info ?>


</div>


