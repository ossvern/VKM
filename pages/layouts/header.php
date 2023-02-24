<div class="panelVision">
    <div class="container">
        <div class="-colors">
            <b><?= t('Кольорова схема') ?>:</b>
            <a href="#" class="-wb"
               data-theme="-dark"><?= t('Біле на чорному') ?></a>
            <a href="#" class="-bw"
               data-theme="-light"><?= t('Чорне на білому') ?></a>
            <a href="#" class="-by"
               data-theme="-yellow"><?= t('Чорне на жовтому') ?></a>
            <a href="#" class="-sep"
               data-theme="-sepia"><?= t('Сепія') ?></a>
        </div>
        <div class="-custom">
            <b><?= t('Задати колір') ?>:</b>
            <input type="color" value="#ffffff" class="js-bgColor"
                   title="<?= t('Колір фону') ?>">
            <input type="color" value="#000000" class="js-textColor"
                   title="<?= t('Колір тексту') ?>">
        </div>
        <div class="-fonts">
            <b><?= t('Розмір шрифтів') ?>:</b>
            <ul>
                <li><a href="#" data-size="-m"></a></li>
                <li><a href="#" data-size="-l"></a></li>
                <li><a href="#" data-size="-xl"></a></li>
                <li><a href="#" data-size="-xxl" class="hiddenXs"></a></li>
            </ul>
        </div>
        <div class="-nav">
            <a href="#" class="-reset"></a>
            <a href="#" class="-close"></a>
        </div>
    </div>

</div>
<div class="container -topMenu">
    <a href="<?= $urlGo ?>" class="-logo"></a>
    <form action="<?= $urlGo ?>/search" method="get">
        <input type="text" name="search"
               placeholder="<?= t('Приклад пошукового запиту') ?>"
               value="<?= $search ?>">
        <button type="submit"></button>
    </form>
    <div class="-lang">
      <?= $langOther ?>
    </div>
    <a href="#" class="-vision"></a>
    <a href="#" class="-search"></a>
    <a href="https://vkm.event.net.ua/" target="_blank"
       class="-buyTicket"><span><?= t('КУПИТИ КВИТКИ') ?></span></a>
    <div class="-eu-flag">
        <img src="<?= $url ?>/img/header-1.svg" alt="">
    </div>
    <a href="#" class="-bars"></a>
</div>
<div class="container -mainMenu">
    <nav>
      <?
      $menuHeader = '';
      $menuBottom = '';
      $arrLink = [
        'news_events/',
        'plan_a_visit',
        'exposition_exhibitions/',
        'collections/',
        'programs_excursions',
        'scientific_work',
        'online_museum',
        '/about',
      ];
      $arrTitle = [
        'Новини/події',
        'Сплануйте візит',
        'Експозиції/виставки',
        'Колекції',
        'Програми/екскурсії',
        'Наукова робота',
        'Онлайн музей',
        'Про музей',
      ];
      $i = -1;
      $marker = 9;
      if ($go == '/exposition_exhibitions/inc' || $go == '/exposition/inc' || $go == '/exhibitions/inc' || $go == '/exposition/one' || $go == '/exhibitions/one') {
        $marker = 'exposition_exhibitions/';
      }

      if ($go == '/projects/inc' || $go == '/projects/one' || $go == '/about/') {
        $marker = '/about';
      }

      while ($i++ < count($arrTitle) - 1) {

        $menuTitle = t($arrTitle[$i]);


        if ($go == $arrLink[$i] || strpos($go, $arrLink[$i]) > 0 || $go == '/' . $arrLink[$i] || $go == '/' . $arrLink[$i] . '/inc' || $go == $arrLink[$i] . '/inc' || $go == $arrLink[$i] . 'inc' || $go == '/' . $arrLink[$i] . 'inc' || $go == '/' . $arrLink[$i] . '/one' || $go == '/' . $arrLink[$i] . 'one' || $marker == $arrLink[$i]) {
          $menuHeader .= "<a class='-act' href='$urlGo/$arrLink[$i]'>$menuTitle</a>";
          // $menuBottom .= "<a class='-act' href='$urlGo/$arrLink[$i]'>$menuTitle</a>";
        }
        else {
          $menuHeader .= "<a href='$urlGo/$arrLink[$i]'>$menuTitle</a>";
          // $menuBottom .= "<a href='$urlGo/$arrLink[$i]'>$menuTitle</a>";
        }
      }
      echo $menuHeader;
      $menuBottom = $menuHeader;
      unset($arrTitle, $arrLink, $i);
      ?>
        <a href="#" class="-close"></a>
    </nav>
</div>