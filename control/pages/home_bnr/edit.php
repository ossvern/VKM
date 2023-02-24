<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Банери</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/home/';

      if ($_POST['add']) {


        $sql = "UPDATE `home_bnr` SET 
        `titleUk` = '{$_POST['titleUk']}', `titleEn` = '{$_POST['titleEn']}', `titlePl` = '{$_POST['titlePl']}',  
         `infoUk` = '{$_POST['infoUk']}', `infoEn` = '{$_POST['infoEn']}', `infoPl` = '{$_POST['infoPl']}', `url` = '{$_POST['url']}', `show` = '{$_POST['show']}'
                  
                  
                  WHERE `id` = '$id'";


        $res = $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.jpg');

          $options = [
            'request' => 'get',
            'method' => 1,
            'width' => 435,
            'height' => 500,
          ];
          Thumbnail::output($gpath . '/' . $id . '.jpg', $gpath . '/' . $id . '.jpg', $options);
        }


        if ($res == 1) {
          echo '<script>window.location.replace("' . $url . '/?go=home_bnr#' . $id . '");</script>';
        }
        else {
          echo $sql;
        }
      }

      $sql = "SELECT * FROM `home_bnr` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {

        if ($q->show == 1) {
          $showSelect = "<option value='1'>Показати</option><option value='0'>Приховати</option>";
        }
        else {
          $showSelect = "<option value='0'>Приховати</option><option value='1'>Показати</option>";
        }
        $showSelect = "<label>Відображення<select name='show'>$showSelect</select></label>";


        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>					
			<div class="row2">
			               
                <label for="">Картинка прев'ю *.jpg < 1mb 435x550px
				    <input name="fileThumb" type="file">
				</label>
				
				$showSelect
				
				<label for="">Посилання
      				<input type="text" name="url" value="$q->url" >
      			</label>
			
				<label for="">Назва Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			
      			<label for="">Назва En
      				<input type="text" name="titleEn" value="$q->titleEn" >
      			</label>
      			
      			<label for="">Назва Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
      			</label>
                 
			</div>
		<label for="">Опис Укр
      	    <textarea name="infoUk" class="ckeditor">$q->infoUk</textarea>     
      	</label>
      	<label for="">Опис En
      	    <textarea name="infoEn" class="ckeditor">$q->infoEn</textarea>      		
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