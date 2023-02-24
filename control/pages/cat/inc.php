<?
//If_Not_Admin_Exit();
$gpath = $urlImg . '/cat/';

//if ($_GET['up'] >= 1) {
//  $id = $_GET['up'];
//  $parentId = RETURN_FROM_BD($id, 'id', 'cat_category', 'parentId');
//  $oldPos = RETURN_FROM_BD($id, 'id', 'cat_category', 'pos');
//  $newPos = $oldPos - 1;
//  if ($newPos > 0) {
//
//    $success = $res = $db->query("UPDATE `cat_category` SET `pos` = '$oldPos' WHERE  `cat_category`.`pos` = '$newPos';");
//    if ($success == 1)
//
//      $res = $db->query("UPDATE `cat_category` SET `pos` = '$newPos' WHERE   `cat_category`.`id` = '$id';");
//  }
//
////	echo "$id - $oldPos ->$newPos";
//  echo "<script>window.location.replace('/?go=catalog-cat&cat=$parentId')</script>";
//}
//if ($_GET['down'] >= 1) {
//  $id = $_GET['down'];
//  $parentId = RETURN_FROM_BD($id, 'id', 'cat_category', 'parentId');
//  $oldPos = RETURN_FROM_BD($id, 'id', 'cat_category', 'pos');
//  $newPos = $oldPos + 1;
//  if (RETURN_FROM_BD($newPos, 'pos', 'cat_category', 'id') > 0) {
//    $sql = "UPDATE `cat_category` SET `pos` = '$oldPos' WHERE `cat_category`.`pos` = '$newPos';";
//    $res = $db->query($sql);
//    $sql = "UPDATE `cat_category` SET `pos` = '$newPos' WHERE `cat_category`.`id` = '$id';";
//    $res = $db->query($sql);
//  }
//  echo "<script>window.location.replace('/?go=catalog-cat&cat=$parentId')</script>";
//}


if (isset($_GET['del'])) {
  $db->query("DELETE FROM `cat_category`  WHERE `id` = '" . $_GET['del'] . "'");
  unlink("$gpath/{$_GET['del']}.svg");
}

if ($_POST['add']) {

//  if (strlen($_POST['titleUk']) > 0)
    $url_gen = generateUrl($_POST['titleUk']);


  $sql = "INSERT INTO `cat_category` ( `parentId`,  `titleUk`, `titleHomeUk`, `url`) VALUES ( '{$_POST['parentId']}', '{$_POST['titleUk']}','{$_POST['titleUk']}', '$url_gen');";


  $res = $db->query($sql);

  if ($res == 1)
    echo "<div class='alert'>Додано!</div>";

}
?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class='container'>
            <fieldset>
                <legend><span class='number'>&nbsp;</span> Категорії, підкатегорії</legend>
            </fieldset>


<!--                          --><?// //
//                        $resultCat = $db->query("SELECT * FROM `cat_category`  where  `parentId`=0   ORDER BY  `cat_category`.`parentId` ASC");
//                        while ($rowCat = $resultCat->fetch_array()) {
//                          $catParent .= "<option value='{$rowCat['id']}'>{$rowCat['titleUk']} / {$rowCat['titleRu']}</option>";
//                        }
//                        echo "<label>Виша категорія<select name='parentId'><option value='0'></option>$catParent</select></label>";
//                        ?>


            <label>Назва категорії, Укр
                <input name="titleUk" type="text" required>
            </label>

            <input name="add" role="button" type="submit" value="Додати"/>

            <br>
            <br>
            <br>

            <a href="#updown<?= $rr ?>"></a>
            <table>
                <th>#</th>
                <th>Іконка</th>
                <th>Головна сторінка - назва</th>
                <th>Назва</th>
                <th></th>
                <th></th>


              <?
              $i = 0;
              $old = 0;


              $sql = "SELECT * FROM `cat_category` ORDER BY `titleUk` ASC";


              $result = $db->query($sql);
              while ($row = $result->fetch_array()) {
                $id = $row['id'];
                $i++;


                if (strlen($row['url']) == 0) {
                  if (strlen($row['titleUk']) > 0) $newUrl = generateUrl($row['titleUk']); else if (strlen($row['titleRu']) > 0) $newUrl = generateUrl($row['titleRu']); else
                    $db->query("UPDATE `cat_category` SET `url` = '$newUrl' where `id` = '$id'");
                }

                if ($row['pos'] == '0')
                  $db->query("UPDATE `cat_category` SET `pos`='$i' WHERE `id` = '$id'");


                ?>
                  <tr>
                      <td>
                        <?= $row['pos'] ?>
                      </td>
                      <td>
                          <img src="<?="{$siteUrl}/upload/cat/{$row['id']}"?>.svg" alt=""
                               width="100">
                      </td>
                      <td>

                            <?= $row['titleHomeUk'] ?>
                        <br>  <?= $row['titleHomeEn'] ?>
                      </td>
                      <td>
                        <?= $row['titleUk'] ?> <br> <?= $row['titleEn'] ?>
                      </td>


                      <!--                      <td class="-link">-->
                      <!--                          <a href="--><?//= $url ?><!--?go=catalog-cat&cat=-->
                    <?//= $row['parentId'] ?><!--&up=--><?//= $row['id'] ?><!--#updown--><?//= $rr ?><!--">Вверх</a>-->
                      <!--                      </td>-->
                      <!--                      <td class="-link">-->
                      <!--                          <a href="--><?//= $url ?><!--?go=catalog-cat&cat=-->
                    <?//= $row['parentId'] ?><!--&down=--><?//= $row['id'] ?><!--#updown--><?//= $rr ?><!--">Вниз</a>-->
                      <!--                      </td>-->


                      <td class="-link">
                          <a href="?go=cat-edit&id=<?= $row['id'] ?>"><img
                                      src="<?= $url ?>/img/i-edit.svg"></a>
                      </td>
                      <td class="-link">
                          <a href="#" onclick="DoYou('?go=cat&del=<?= $row['id'] ?>')"><img
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

<?php
//include "pages/catalog/submenu_generate.php";