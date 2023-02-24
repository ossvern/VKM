<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> ЕКСПОЗИЦІЇ ТА ВИСТАВКИ
            </legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/exposition/';

      if ($_POST['add']) {


        $sql = "UPDATE `cat_exposition` SET 
        `titleUk` = '{$_POST['titleUk']}', `titleEn` = '{$_POST['titleEn']}', `titlePl` = '{$_POST['titlePl']}',  
         `infoUk` = '{$_POST['infoUk']}', `infoEn` = '{$_POST['infoEn']}', `infoPl` = '{$_POST['infoPl']}', 
        
        `cat` = '{$_POST['cat']}' WHERE `id` = '$id'";
        //        echo $sql;
        $res = $db->query($sql);


        if (isset($_FILES['fileThumb']['tmp_name']) and $_FILES['fileThumb']['tmp_name'] != '') {
          move_uploaded_file($_FILES['fileThumb']['tmp_name'], $gpath . '/' . $id . '.jpg');

          $options = [
            'request' => 'get',
            'method' => 1,
            'width' => 600,
            'height' => 600,
          ];
          Thumbnail::output($gpath . '/' . $id . '.jpg', $gpath . '/' . $id . '.jpg', $options);
        }
        if ($res == 1) {
          echo '<script>window.location.replace("' . $url . '/?go=exposition#' . $id . '");</script>';

        }
        else {
          echo $sql;
        }


      }

      $sql = "SELECT * FROM `cat_exposition` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {

        $resultDep = $db->query("SELECT * FROM `cat_department` ORDER BY `titleUk` ASC");
        while ($rowDep = $resultDep->fetch_array()) {
          if ($q->departmentId == $rowDep['id']) {
            $retDep .= "<option value='{$rowDep['id']}' selected>{$rowDep['titleUk']}</option>";
          }
          else {
            $retDep .= "<option value='{$rowDep['id']}'>{$rowDep['titleUk']}</option>";
          }
        }
        $depSelect = "<label>Музей<select name='departmentId'>$retDep</select></label>";


        if ($q->cat == 'exhibitions') {
          $catSelect = "<option value='exhibitions'>Виставки</option><option value='exposition'>Експозиції
</option>";
        }
        else {
          $catSelect = "<option value='exposition'>Експозиції
</option><option value='exhibitions'>Виставки</option>";
        }
        $catSelect = "<label>Тип<select name='cat'>$catSelect</select></label>";


        if ($q->topFixed == 1) {
          $topSelect = "<option value='1'>Зафіксовано</option><option value='0'>Не зафіксовано</option>";
        }
        else {
          $topSelect = "<option value='0'>Не зафіксовано</option><option value='1'>Зафіксовано</option>";
        }

        $topSelect = "<label>Зафіксувати зверху<select name='topFixed'>$topSelect</select></label>";

        $eventDateStart__F = str_replace(' ', 'T', $q->eventDateStart);

        echo <<<EOF

				<h1>$q->titleUk</h1>
				<br>					
				<div class="row2">

			
				<label for="">Назва Укр
      				<input type="text" name="titleUk" value="$q->titleUk" >
      			</label>
      			<label for="">Назва En
      				<input type="text" name="titleEn" value="$q->titleEn" >
      			</label>
      			<label for="">Назва Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
      			</label>
      		
                $depSelect
                $catSelect

                
                <label for="">Картинка прев'ю *.jpg < 1mb
				    <input name="fileThumb" type="file">
				</label>
					
      				<label for="">Дата / Час початку події
      				<input type="datetime-local" name="eventDateStart" value="$eventDateStart__F" >
          			</label>	
      							
				<label for="">Дата завершення події
      				<input type="date" name="eventDateEnd" value="$q->eventDateEnd" >
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
