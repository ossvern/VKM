<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Категорії, підкатегорії</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/cat/';

      if ($_POST['add']) {

        $sql = "UPDATE `cat_category` SET 
                          `titleUk` = '{$_POST['titleUk']}', `titleHomeUk` = '{$_POST['titleHomeUk']}', 
                          `titleEn` = '{$_POST['titleEn']}', `titleHomeEn` = '{$_POST['titleHomeEn']}' 

WHERE `id` = '$id'";

        $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.svg');

//          $options = array('request' => 'get', 'method' => 3, 'width' => 380, 'height' => 300);
//          Thumbnail::output($siteUrllocal . '/upload/cat/' . $idimg, $siteUrllocal . '/upload/cat/' . $idimg, $options);

        }


        echo '<script>window.location.replace("' . $url . '/?go=cat#' . $id . '");</script>';
      }

      $sql = "SELECT * FROM `cat_category` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {

        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>		
						
				<label for="">Назва Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			<label for="">Назва En
      				<input type="text" name="titleEn" value="$q->titleEn" >
      			</label>
				      
      			<label for="">Головна сторінка - назва Укр
      				<input type="text" name="titleHomeUk" value="$q->titleHomeUk" >
      			</label>
      			<label for="">Головна сторінка - назва En
      				<input type="text" name="titleHomeEn" value="$q->titleHomeEn" >
      			</label>
      		
				<label for="">Іконка - буде відображатися на карті *.SVG</label>
				<input name="fileThumb" type="file">
EOF;
      }

      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>
