<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Інформація</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/info';

      if ($_POST['add']) {


        if (isset($_FILES['fileName']['tmp_name']) and $_FILES['fileName']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileName']['tmp_name'], $gpath . '/doc/' . $_FILES['fileName']['name']);

          $sqlUp = "`fileName` = '{$_FILES['fileName']['name']}',";

        }


        $sql = "UPDATE `info` SET
        `titleUk` = '{$_POST['titleUk']}', `titlePl` = '{$_POST['titlePl']}', 
         `infoUk` = '{$_POST['infoUk']}', `infoPl` = '{$_POST['infoPl']}',
        $sqlUp
        `linkSite` = '{$_POST['linkSite']}'
              






WHERE `id` = '$id'";

        $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.jpg');
          $options = [
            'request' => 'get',
            'method' => 3,
            'width' => 400,
            'height' => 400,
          ];
          Thumbnail::output($gpath . '/' . $id . '.jpg', $gpath . '/' . $id . '.jpg', $options);
        }


        echo '<script>window.location.replace("' . $url . '/?go=info#' . $id . '");</script>';
      }

      $sql = "SELECT * FROM `info` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {


        $catTitle = RETURN_FROM_BD($q->catId, 'id', 'info_cat', 'titleUk');

        echo <<<EOF

				<h1>$catTitle / $q->titleUk</h1>
				<br>	
				
				<div class="row2">
							
				<label for="">Назва Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			<label for="">Назва Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
      			</label>
				            			      
<!--//				<label for="">посилання на зовнішній ресурс / відео youtube-->
<!--//      				<input type="text" name="linkSite" value="$q->linkSite" >-->
<!--//      			</label>      			     	-->
      		
<!--			    <label for="">Файл звіту, *.pdf-->
<!--				    <input name="fileName" type="file">-->
<!--				</label>-->
<!--				-->
<!--				<label for="">Картинка прев'ю *.jpg < 1mb-->
<!--				    <input name="fileThumb" type="file">-->
<!--				</label>-->
			</div>

		<label for="" >Опис Укр
      	    <textarea name="infoUk" class="ckeditor">$q->infoUk</textarea>     
      	</label>
      	<label for="">Опис Pl
      	    <textarea name="infoPl" class="ckeditor">$q->infoPl</textarea>      		
        </label>

EOF;
      }

      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>
