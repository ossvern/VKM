<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Партнери</legend>
        </fieldset>
      <?php
      $cTable = 'partners';
      $gpath = $urlImg . '/'.$cTable.'/';




      if ($_POST['add']) {

        $sql = "UPDATE `cat_$cTable` SET `titleUk` = '{$_POST['titleUk']}', `titlePl` = '{$_POST['titlePl']}', 
                       `titleEn` = '{$_POST['titleEn']}',
                   `linkSite` = '{$_POST['linkSite']}'
WHERE `id` = '$id'";

        $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.png');

          $options = array('request' => 'get', 'method' => 3, 'width' => 170, 'height' => 170);
          Thumbnail::output( $gpath . '/' . $id . '.png',$gpath . '/' . $id . '.png', $options);
        }
        echo '<script>window.location.replace("' . $url . '/?go='.$cTable.'#' . $id . '");</script>';
      }

      $sql = "SELECT * FROM `cat_$cTable` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {

        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>	
				
				<div class="row2">
				
				<label for="">Назва компанії Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			<label for="">Назва компанії En
      				<input type="text" name="titleEn" value="$q->titleEn" >
      			</label> 		
      			<label for="">Назва компанії Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
      			</label> 
      			
				<label for="">Сайт
      				<input type="text" name="linkSite" value="$q->linkSite" >
      			</label>      
      					    
				<label for="">Логотип *.jpg, *.png < 1mb
				    <input name="fileThumb" type="file">
				</label>				
			</div>
EOF;
      }

      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>
