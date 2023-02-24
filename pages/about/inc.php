<?
if (!$id) {
  $id = 'departments_and_branches';
}
$arrNav__title = [
  'відділи та філії',
  'історія музею',
  'співпраця та грантові проекти',

  'контакти',
  'платні послуги',
];
$arrNav__links = [
  'departments_and_branches',
  'history_of_the_museum',
  'cooperation',

  'contacts',
  'paid_services',
];

for ($i = 0; $i < count($arrNav__links); $i++) {
  if ($id == $arrNav__links[$i]) {
    $nav .= "<a href='$urlGo/about-$arrNav__links[$i]' class='-act'>" . TranslateMe($arrNav__title[$i]) . "</a>";
  }
  else {
    $nav .= "<a href='$urlGo/about-$arrNav__links[$i]'>" . TranslateMe($arrNav__title[$i]) . "</a>";
  }
}


?>

<div class="container">
    <div class="pageAbout">
        <h1><?= TranslateMe('ПРО МУЗЕЙ') ?></h1>
    </div>

    <div class="pageAbout">
        <div class="-nav">
            <div class="-links">
              <?= $nav ?>
                <a href="https://prozorro.gov.ua/search/tender?text=%D0%92%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D1%8C%D0%BA%D0%B8%D0%B9%20%D0%BA%D1%80%D0%B0%D1%94%D0%B7%D0%BD%D0%B0%D0%B2%D1%87%D0%B8%D0%B9%20%D0%BC%D1%83%D0%B7%D0%B5%D0%B9"
                   target="_blank">Закупівлі</a>
            </div>
        </div>
        <div class="-content">
          <?
          include 'pages/about/' . $id . '.php';
          if ($id == 'projects' && !$one) {
            include 'pages/projects/inc.php';
          }
          else {
            if ($id == 'projects' && $one) {
              include 'pages/projects/one.php';
            }
          }
          ?>
        </div>
    </div>
</div>


