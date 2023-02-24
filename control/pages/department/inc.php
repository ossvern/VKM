<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/tour3d/';


if (isset($_GET['del'])) {
  $db->query("DELETE FROM `cat_department`  WHERE `id` = '" . $_GET['del'] . "'");
  unlink("$gpath/{$_GET['del']}.svg");
}

if ($_POST['add']) {

  //  if (strlen($_POST['titleUk']) > 0)
  $url_gen = generateUrl($_POST['titleUk']);

  $sql = "INSERT INTO `cat_department` (`titleUk`, `url`) VALUES ( '{$_POST['titleUk']}','$url_gen');";
  $res = $db->query($sql);

  $id = $db->insert_id;
  if ($res == 1) {
    echo '<script>window.location.replace("' . $url . '/?go=department-edit&id=' . $id . '");</script>';
  }
  //    echo "<div class='alert'>Додано!</div>";

}
?>
<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Музеї</legend>
        </fieldset>
        <!---->
        <!--        <label>Назва, Укр-->
        <!--            <input name="titleUk" type="text" required>-->
        <!--        </label>-->
        <!---->
        <!--        <input name="add" role="button" type="submit" value="Додати"/>-->
        <!---->
        <!--        <br>-->
        <!--        <br>-->
        <!--        <br>-->

        <a href="#updown<?= $rr ?>"></a>
        <table>
            <th>Прев'ю</th>
            <th>Назва Укр</th>
            <th>Назва Pl</th>

            <th></th>
            <th></th>


          <?
          $i = 0;
          $old = 0;


          $sql = "SELECT * FROM `cat_department` ORDER BY `titleUk` ASC";
          $result = $db->query($sql);
          while ($row = $result->fetch_array()) {
            $id = $row['id'];
            $i++;


            if (strlen($row['url']) == 0) {
              if (strlen($row['titleUk']) > 0) {
                $newUrl = generateUrl($row['titleUk']);
              }
              else {
                if (strlen($row['titleRu']) > 0) {
                  $newUrl = generateUrl($row['titleRu']);
                }
                else {
                  $db->query("UPDATE `cat_department` SET `url` = '$newUrl' where `id` = '$id'");
                }
              }
            }

            //            if ($row['pos'] == '0')
            //              $db->query("UPDATE `cat_department` SET `pos`='$i' WHERE `id` = '$id'");


            ?>
              <tr>
                  <td>
                      <img src="<?= "{$siteUrl}/upload/department/{$row['id']}.png" ?>"
                           alt=""
                           width="60">
                  </td>
                  <td>
                      <b>
                        <?= $row['titleUk'] ?>
                      </b>
                  </td>
                  <td>
                      <b>
                        <?= $row['titlePl'] ?>
                      </b>
                  </td>
                  <td class="-link">
                      <a href="?go=department-edit&id=<?= $row['id'] ?>"><img
                                  src="<?= $url ?>/img/i-edit.svg"></a>
                  </td>
              </tr>
            <?
          }
          ?>
        </table>
    </div>
</form>
