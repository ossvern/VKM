<div class='container'>

  <?php
  //If_Not_Admin_Exit();


  if (isset($_GET['del'])) {
    $db->query("DELETE FROM `lang`  WHERE `id` = '" . $_GET['del'] . "'");
  }


  ?>

    <table class="table table-bordered table-hover table-striped">
        <th></th>
      <?php

      $d = -1;
      while ($d++ < count($lang_arr) - 1) {
        echo '<th>' . $title_lang_arr[$d] . '</th>';
      }
      echo '<th></th>';


      $i = 0;
      $sql = "SELECT * FROM `lang` ORDER BY `lang`.`uk` ASC";
      $result = $db->query($sql);
      while ($row = $result->fetch_array()) {
        $i++;
        $addred = '';
        if ($row['uk'] == '0') {
          $addred = 'style="background:#F1F1F1;"';
        }

        ?>
          <tr <?php echo $addred ?> >
              <td><a href="?go=/lang/edit&id=<?php echo $row['id'] ?>">Редагувати</a>
              </td>

            <?php
            $d = -1;
            while ($d++ < count($lang_arr) - 1) {
              echo '<td>' . $row[$lang_arr[$d]] . '</td>';
            }
            ?>

              <td><a href="?go=/lang/all&del=<?= $row['id'] ?>">Видалити</a>
              </td>
          </tr>
        <?php


        if (strlen($row[uk]) > 2 and strlen($row[ru]) > 2 and is_numeric($row[uk]) == FALSE and is_numeric($row[ru]) == FALSE and $old != $row[uk] and $row[ru] != 'Nan') {


          //            if (strlen($row[uk]) < 100) {
          //                $out .= ('"' . $row[uk] . '":"' . $row[ru] . '",');
          //            }


        }
        $old = $row[uk];

      }


      //
      //    $out = substr($out, 0, strlen($out) - 1);
      //    $myFile = '../www/js/lang.json';
      //    unlink($myFile);
      //    $fh = fopen($myFile, 'w');
      //    fwrite($fh, '{' . $out . '}');
      //    fclose($fh);


      ?>
    </table>
</div>