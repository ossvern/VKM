<div class="pageError">
    <h3>Дякуємо!</h3>
    <h1>Незабаром ми Вам зателефонуємо</h1>
    <a href="<?= $urlGo ?>"><?= t('повернутись на головну сторінку') ?></a>
</div>

<?
$ipAddr = getRealIpAddr();
if ($_POST) {
  //		if (isset($_POST)) {
  //			foreach ($_POST as $key => $value) {
  //				$data[htmlspecialchars($key)] = htmlspecialchars($value);
  ////				$arr0 = ['/fType1/', '/fType2/', '/fType3/', '/fType4/', ];
  ////				$arr1 = ['Цікавлять', 'Цікавлять', 'Цікавлять', 'Цікавлять',];
  ////				$key2 = preg_replace($arr0, $arr1, $key);
  //
  //
  //			}
  //		}
  $msg = "<li>Ім’я: <b>{$_POST['uName']}</b></li><li>Номер телефону: <b>{$_POST['uPhone']}</b></li><li>IP: <b>{$ipAddr}</b></li>";


  if (strlen($_POST[uPhone]) > 3) {
    $msg = "<ul>$msg</ul>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail('oss.studio@gmail.com', 'Заявка з сайту euroholding', $msg, $headers);


    //            print_r($msg);

  }
}