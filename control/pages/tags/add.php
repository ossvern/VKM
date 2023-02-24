<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/cat/';


if (isset($_GET['del'])) {
  $db->query("DELETE FROM `cat_tags_inc`  WHERE `id` = '" . $_GET['del'] . "'");

}

if ($_POST['add']) {

  $sql = "INSERT INTO `cat_tags_inc` ( `locId`,`tagId`) VALUES ('{$id}','{$_POST['tagId']}');";
  $res = $db->query($sql);

  if ($res == 1)
    echo "<div class='alert'>Додано!</div>";

}
?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class='container'>
            <fieldset>
                <legend><span class='number'>&nbsp;</span> Теги до <b><?=RETURN_FROM_BD($id,'id','cat_loc','titleUk')?></b></legend>
            </fieldset>


            <?
            $resultCat = $db->query("SELECT * FROM `cat_tags` ORDER BY `cat_tags`.`titleUk` ASC");
            while ($rowCat = $resultCat->fetch_array()) {
                $catSelect .= "<option value='{$rowCat['id']}'>{$rowCat['titleUk']}</option>";
            }
            $catSelect = "<label>Тег<select name='tagId'><option value='0'></option>$catSelect</select></label>";
echo $catSelect;
            ?>


            <input name="add" role="button" type="submit" value="Додати"/>

            <br>
            <br>
            <br>

            <a href="#updown<?= $rr ?>"></a>
            <table>
                <th>Тег</th>
                <th></th>

              <?
              $i = 0;
              $old = 0;

              $sql = "SELECT * FROM `cat_tags_inc` WHERE `locId` = '$id'";
              $result = $db->query($sql);
              while ($row = $result->fetch_array()) {
                ?>
                  <tr>
                      <td>
                        <?= RETURN_FROM_BD($row['tagId'],'id','cat_tags','titleUk') ?>
                      </td>
                      <td class="-link">
                          <a href="#" onclick="DoYou('?go=tags-add&id=<?= $id ?>&del=<?= $row['id'] ?>')"><img
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