<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/home/';




if ($_GET['up'] >= 1) {
  $id = $_GET['up'];
//  $parentId = RETURN_FROM_BD($id, 'id', 'home_bnr', 'parentId');
  $oldPos = RETURN_FROM_BD($id, 'id', 'home_bnr', 'pos');
  $newPos = $oldPos - 1;
  if ($newPos > 0) {

    $success = $res = $db->query("UPDATE `home_bnr` SET `pos` = '$oldPos' WHERE  `home_bnr`.`pos` = '$newPos';");
    if ($success == 1)

      $res = $db->query("UPDATE `home_bnr` SET `pos` = '$newPos' WHERE   `home_bnr`.`id` = '$id';");
  }

//	echo "$id - $oldPos ->$newPos";
  echo "<script>window.location.replace('{$url}/?go=home_bnr')</script>";
}
if ($_GET['down'] >= 1) {
  $id = $_GET['down'];
//  $parentId = RETURN_FROM_BD($id, 'id', 'home_bnr', 'parentId');
  $oldPos = RETURN_FROM_BD($id, 'id', 'home_bnr', 'pos');
  $newPos = $oldPos + 1;
  if (RETURN_FROM_BD($newPos, 'pos', 'home_bnr', 'id') > 0) {
    $sql = "UPDATE `home_bnr` SET `pos` = '$oldPos' WHERE `home_bnr`.`pos` = '$newPos';";
    $res = $db->query($sql);
    $sql = "UPDATE `home_bnr` SET `pos` = '$newPos' WHERE `home_bnr`.`id` = '$id';";
    $res = $db->query($sql);
  }
  echo "<script>window.location.replace('{$url}/?go=home_bnr')</script>";
}



















if (isset($_GET['del'])) {
  $db->query("DELETE FROM `home_bnr`  WHERE `id` = '" . $_GET['del'] . "'");
  unlink("$gpath/{$_GET['del']}.jpg");
  unlink("$gpath/{$_GET['del']}.png");
}

if ($_POST['add']) {

  //  if (strlen($_POST['titleUk']) > 0)
  $url_gen = generateUrl($_POST['titleUk']);

  $sql = "INSERT INTO `home_bnr` (`titleUk`, `url`) VALUES ( '{$_POST['titleUk']}','$url_gen');";
  $res = $db->query($sql);

  $id = $db->insert_id;
  if ($res == 1) {
    echo '<script>window.location.replace("' . $url . '/?go=home_bnr-edit&id=' . $id . '");</script>';
  }
  //    echo "<div class='alert'>Додано!</div>";

}
?>
<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Банери</legend>
        </fieldset>


        <label>Назва, Укр
            <input name="titleUk" type="text" required>
        </label>

        <input name="add" role="button" type="submit" value="Додати"/>

        <br>
        <br>
        <br>

        <a href="#updown<?= $rr ?>"></a>
        <table>
            <th>Прев'ю</th>
            <th>Назва Укр</th>
          <?
          $i = 0;
          $old = 0;

          $sql = "SELECT * FROM `home_bnr` ORDER BY `pos` ASC";
          $result = $db->query($sql);
          while ($row = $result->fetch_array()) {
            $id = $row['id'];
            $i++;


            //                if (strlen($row['url']) == 0) {
            //                  if (strlen($row['titleUk']) > 0) $newUrl = generateUrl($row['titleUk']); else if (strlen($row['titleRu']) > 0) $newUrl = generateUrl($row['titleRu']); else
            //                    $db->query("UPDATE `home_bnr` SET `url` = '$newUrl' where `id` = '$id'");
            //                }
            //
            if ($row['pos'] == '0') {
              $db->query("UPDATE `home_bnr` SET `pos`='$i' WHERE `id` = '$id'");
            }


            ?>
              <tr>
                  <td>
                      <img src="<?= "{$siteUrl}/upload/home/{$row['id']}.jpg" ?>"
                           alt=""
                           width="160">
                  </td>
                  <td>
                      <b>
                        <?= $row['titleUk'] ?>
                      </b>
                  </td>

                  <td class="-link">
                      <a href="<?= $url ?>/?go=home_bnr&up=<?= $row['id'] ?>#updown<?= $rr ?>">Вверх</a>
                  </td>
                  <td class="-link">
                      <a href="<?= $url ?>/?go=home_bnr&down=<?= $row['id'] ?>#updown<?= $rr ?>">Вниз</a>
                  </td>


                  <td class="-link">
                      <a href="?go=home_bnr-edit&id=<?= $row['id'] ?>"><img
                                  src="<?= $url ?>/img/i-edit.svg"></a>
                  </td>
                  <td class="-link">
                      <a href="#"
                         onclick="DoYou('?go=home_bnr&del=<?= $row['id'] ?>')"><img
                                  src="<?= $url ?>/img/i-trash.svg"></a>
                  </td>

              </tr>
            <?
          }
          ?>
        </table>
    </div>
</form>