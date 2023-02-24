<div class='container'>

    <form enctype="multipart/form-data" action="" method="POST">


      <?php
      //        If_Not_Admin_Exit();
      if ($_POST['add']) {

        //            $inp_ru = trim(str_replace("'", '`', $_POST['inp_pl']));
        $inp_uk = trim(str_replace("'", '`', $_POST['inp_uk']));
        //            $inp_ua = trim(str_replace("'", '`', $_POST['inp_ua']));
        //            $inp_en = trim(str_replace("'", '`', $_POST['inp_en']));
        $inp_pl = trim(str_replace("'", '`', $_POST['inp_pl']));


        //            $inp_ru = trim(str_replace("</ ", '</', $inp_ru));
        $inp_uk = trim(str_replace("</ ", '</', $inp_uk));
        //            $inp_en = trim(str_replace("</ ", '</', $inp_en));
        $inp_pl = trim(str_replace("</ ", '</', $_POST['inp_pl']));


        $sql = " UPDATE `lang` SET `pl` = '$inp_pl' WHERE `id` = '$id'";
        $db->query($sql);

        //            echo $sql;
        echo '<script>window.location.replace("' . $url . '?go=lang-all");</script>';


      }


      $sql = "SELECT * FROM `lang` WHERE `id` = '$_GET[id]'";
      $result = $db->query($sql);
      while ($row = $result->fetch_array()) {
        //            echo '<div class="col-md-6"><br><label>' . $title_lang_arr[0] . '</label>
        //        <input type="text" name="inp_ua" class="form-control"  value="' .  $row[$lang_arr[$d]]  . '"/></div>';
        $d = -1;
        while ($d++ < count($lang_arr) - 1) {

          if ($lang_arr[$d] == 'uk') {
            echo '<label>' . $title_lang_arr[$d] . '</label>
        <textarea readonly name="inp_' . $lang_arr[$d] . '" class="form-control"/>' . $row[$lang_arr[$d]] . '</textarea>';
          }
          else {
            echo '<label>' . $title_lang_arr[$d] . '</label>
        <textarea name="inp_' . $lang_arr[$d] . '" class="form-control"/>' . $row[$lang_arr[$d]] . '</textarea>';
          }
        }
      }
      ?>

        <br>
        <input name="add" class="btn btn-danger" type="submit"
               value="Зберегти"/>
    </form>
</div>
