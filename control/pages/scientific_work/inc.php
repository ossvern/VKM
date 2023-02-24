<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/scientific_work/';


if (isset($_GET['del'])) {
  $db->query("DELETE FROM `cat_scientific_work`  WHERE `id` = '" . $_GET['del'] . "'");
  unlink("$gpath/{$_GET['del']}.svg");
}

if ($_POST['add']) {

//  if (strlen($_POST['titleUk']) > 0)
  $url_gen = generateUrl($_POST['titleUk']);

  $sql = "INSERT INTO `cat_scientific_work` (`titleUk`, `url`) VALUES ( '{$_POST['titleUk']}','$url_gen');";
  $res = $db->query($sql);

  $id = $db->insert_id;
  if ($res == 1)
    echo '<script>window.location.replace("' . $url . '/?go=scientific_work-edit&id=' . $id . '");</script>';
//    echo "<div class='alert'>Додано!</div>";

}
?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class='container'>
            <fieldset>
                <legend><span class='number'>&nbsp;</span> Програми/екскурсії</legend>
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
                <th>Тип</th>
              <?
              $i = 0;
              $old = 0;


              $sql = "SELECT * FROM `cat_scientific_work` ORDER BY `titleUk` ASC";


              $result = $db->query($sql);
              while ($row = $result->fetch_array()) {
                $id = $row['id'];
                $i++;


                if (strlen($row['url']) == 0) {
                  if (strlen($row['titleUk']) > 0) $newUrl = generateUrl($row['titleUk']); else if (strlen($row['titleRu']) > 0) $newUrl = generateUrl($row['titleRu']); else
                    $db->query("UPDATE `cat_scientific_work` SET `url` = '$newUrl' where `id` = '$id'");
                }

                if ($row['pos'] == '0')
                  $db->query("UPDATE `cat_scientific_work` SET `pos`='$i' WHERE `id` = '$id'");


                ?>
                  <tr>
                      <td>
                          <img src="<?="{$siteUrl}/upload/scientific_work/{$row['id']}.jpg"?>" alt=""
                               width="160">
                      </td>
                      <td>
                          <b>
                            <?= $row['titleUk'] ?>
                          </b>
                      </td>
                      <td>
                            <?= $row['cat'] ?>

                      </td>

                      <td class="-link">
                          <a href="?go=scientific_work-edit&id=<?= $row['id'] ?>"><img
                                      src="<?= $url ?>/img/i-edit.svg"></a>
                      </td>
                      <td class="-link">
                          <a href="#" onclick="DoYou('?go=scientific_work&del=<?= $row['id'] ?>')"><img
                                      src="<?= $url ?>/img/i-trash.svg"></a>
                      </td>

                  </tr>
                <?
                $old = $row['parentId'];

              }
              ?>
            </table>
        </div>
    </form>