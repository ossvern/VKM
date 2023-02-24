<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/info';


if (isset($_GET['del'])) {

  $fileName = RETURN_FROM_BD($_GET['del'], 'id', 'info', 'fileName');

  $db->query("DELETE FROM `info`  WHERE `id` = '" . $_GET['del'] . "'");
  unlink("$gpath/{$_GET['del']}.jpg");
  unlink("$gpath/doc/{$fileName}");
}

if ($_POST['add']) {

  //  if (strlen($_POST['titleUk']) > 0)
  $url_gen = generateUrl($_POST['titleUk']);

  $sql = "INSERT INTO `info` (`titleUk`, `catId`, `url`) VALUES ( '{$_POST['titleUk']}', '{$_POST['catId']}','$url_gen');";
  $res = $db->query($sql);

  $id = $db->insert_id;
//  if ($res == 1) {
//    echo '<script>window.location.replace("' . $url . '/?go=info-edit&id=' . $id . '");</script>';
//  }
  //    echo "<div class='alert'>Додано!</div>";
echo $sql;
}
?>
<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Інформація</legend>
        </fieldset>

        <label>Категорія
          <? //
          $resultloc = $db->query("SELECT * FROM `info_cat`");
          while ($rowloc = $resultloc->fetch_array()) {
            $locParent .= "<option value='{$rowloc['id']}'>{$rowloc['titleUk']}</option>";
          }
          echo "<select name='catId'>$locParent</select>";
          ?>
        </label>

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
            <th>Категорія</th>
            <th>Назва Укр</th>
            <th>Посилання</th>
            <th>Файл звіту, *.pdf</th>
            <th></th>
            <th></th>


          <?
          $i = 0;
          $old = 0;


          $sql = "SELECT * FROM `info`";
          $result = $db->query($sql);
          while ($row = $result->fetch_array()) {
            $id = $row['id'];
            $i++;


            //            if (strlen($row['url']) == 0) {
            //              if (strlen($row['titleUk']) > 0) {
            //                $newUrl = generateUrl($row['titleUk']);
            //              }
            //              else {
            ////                if (strlen($row['titleRu']) > 0) {
            ////                  $newUrl = generateUrl($row['titleRu']);
            ////                }
            //                else {
            //                  $db->query("UPDATE `info` SET `url` = '$newUrl' where `id` = '$id'");
            //                }
            //              }
            //            }

            if ($row['pos'] == '0') {
              $db->query("UPDATE `info` SET `pos`='$i' WHERE `id` = '$id'");
            }


            ?>
              <tr>
                  <td>
                      <img src="<?= "{$siteUrl}/upload/info/{$row['id']}.jpg?v=" . rand(0, 99) ?>"
                           alt=""
                           width="160">
                  </td>
                  <td>
                    <?= RETURN_FROM_BD($row['catId'], 'id', 'info_cat', 'titleUk') ?>
                  </td>
                  <td>
                      <b>
                        <?= $row['titleUk'] ?>
                      </b>
                  </td>

                  <td>
                      <small><?= $row['linkSite'] ?></small>

                  </td>

                  <td>
                      <a href="<?= "{$siteUrlUpload}/info/doc/{$row['fileName']}" ?>"
                         target="_blank"><?= $row['fileName'] ?></a>


                  </td>

                  <td class="-link">
                      <a href="?go=info-edit&id=<?= $row['id'] ?>"><img
                                  src="<?= $url ?>/img/i-edit.svg"></a>
                  </td>
                  <td class="-link">
                      <a href="#"
                         onclick="DoYou('?go=info&del=<?= $row['id'] ?>')"><img
                                  src="<?= $url ?>/img/i-trash.svg"></a>
                  </td>

              </tr>
            <?
          }
          ?>
        </table>
    </div>
</form>