<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Музеї</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/department/';

      if ($_POST['add']) {

        $sql = "UPDATE `cat_department` SET 
                            `titleUk` = '{$_POST['titleUk']}', `titlePl` = '{$_POST['titlePl']}',
                         `infoUk` = '{$_POST['infoUk']}', `infoPl` = '{$_POST['infoPl']}'
                        
                        WHERE `id` = '$id'";

        $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.png');
        }


        echo '<script>window.location.replace("' . $url . '/?go=department#' . $id . '");</script>';
      }
      $sql = "SELECT * FROM `cat_department` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {


        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>	
			
				<div class="row2">
				
	
							
				<label for="">Назва Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			<label for="">Назва Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
      			</label>
      					      
										<label for="">Картинка прев'ю *.jpg < 1mb
				    <input name="fileThumb2" type="file">
				</label>
				
			</div>
				<div class="row2">

<label for="">Опис Укр
      	    <textarea name="infoUk" class="ckeditor">$q->infoUk</textarea>     
      	</label></div>
      		<div class="row2">
      	<label for="">Опис Pl
      	    <textarea name="infoPl" class="ckeditor">$q->infoPl</textarea>      		
        </label>
	</div> 	

EOF;
      }

      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>
