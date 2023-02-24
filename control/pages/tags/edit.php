<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Теги</legend>
        </fieldset>
      <?php

      if ($_POST['add']) {

        $sql = "UPDATE `cat_tags` SET `titleUk` = '{$_POST['titleUk']}',`titleEn` = '{$_POST['titleEn']}' WHERE `id` = '$id'";
        $db->query($sql);


        echo '<script>window.location.replace("' . $url . '/?go=tags#' . $id . '");</script>';
      }

      $sql = "SELECT * FROM `cat_tags` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {

        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>				
				<label for="">Тег Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>	
      			<label for="">Тег En
      				<input type="text" name="titleEn" value="$q->titleEn" >
      			</label>				
EOF;
      }

      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>
