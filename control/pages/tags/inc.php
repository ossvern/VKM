<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/cat/';


if (isset($_GET['del'])) {
  $db->query("DELETE FROM `cat_tags`  WHERE `id` = '" . $_GET['del'] . "'");

}

if ($_POST['add']) {

  $url_gen = generateUrl($_POST['titleUk']);


  $sql = "INSERT INTO `cat_tags` ( `titleUk`,`titleEn`, `url`) VALUES ('{$_POST['titleUk']}','{$_POST['titleEn']}', '$url_gen');";
  $res = $db->query($sql);

  if ($res == 1)
    echo "<div class='alert'>Додано!</div>";

}
?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class='container'>
            <fieldset>
                <legend><span class='number'>&nbsp;</span> Теги</legend>
            </fieldset>

            <label>Тег, Укр
                <input name="titleUk" type="text" required>
            </label>

            <label>Тег, En
                <input name="titleEn" type="text">
            </label>

            <input name="add" role="button" type="submit" value="Додати"/>

            <br>
            <br>
            <br>

            <a href="#updown<?= $rr ?>"></a>
            <table>

                <th>Тег Укр</th>
                <th>Тег Англ</th>
                <th></th>
                <th></th>


              <?
              $i = 0;
              $old = 0;

              $sql = "SELECT * FROM `cat_tags` ORDER BY `titleUk` ASC";
              $result = $db->query($sql);
              while ($row = $result->fetch_array()) {
                $id = $row['id'];
                $i++;


                ?>
                  <tr>
                      <td>
                        <?= $row['titleUk'] ?>
                      </td>
                      <td>
                        <?= $row['titleEn'] ?>
                      </td>

                      <td class="-link">
                          <a href="?go=tags-edit&id=<?= $row['id'] ?>"><img
                                      src="<?= $url ?>/img/i-edit.svg"></a>
                      </td>
                      <td class="-link">
                          <a href="#" onclick="DoYou('?go=tags&del=<?= $row['id'] ?>')"><img
                                      src="<?= $url ?>/img/i-trash.svg"></a>
                      </td>

                  </tr>
                <?
              }
              ?>
            </table>
        </div>
    </form>
<?php
//include "pages/catalog/submenu_generate.php";