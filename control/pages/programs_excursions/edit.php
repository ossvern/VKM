<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> Програми та екскурсії
            </legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/programs_excursions/';

      if ($_POST['add']) {

        $sql = "UPDATE `cat_programs_excursions` SET 
        `titleUk` = '{$_POST['titleUk']}', `titleEn` = '{$_POST['titleEn']}', 
         `infoUk` = '{$_POST['infoUk']}', `infoEn` = '{$_POST['infoEn']}', 

        `departmentId` = '{$_POST['departmentId']}' WHERE `id` = '$id'";

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
          echo '<script>window.location.replace("' . $url . '/?go=programs_excursions#' . $id . '");</script>';
        }
        else {
          echo $sql;
        }
      }


      $categoryLink = [
        'excursions',
        'programs',
      ];
      $categoryTitle = [
        'Екскурсії',
        'Програми',
      ];


      $i = -1;
      $retCat = '';


      $sql = "SELECT * FROM `cat_programs_excursions` where `id`='$id'";
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


        while ($i++ < count($categoryLink) - 1) {
          if ($q->cat == $categoryLink[$i]) {
            $catSelect .= "<option value='{$categoryLink[$i]}' SELECTED>$categoryTitle[$i]</option>";
          }
          else {
            $catSelect .= "<option value='{$categoryLink[$i]}'>$categoryTitle[$i]</option>";
          }
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
      		
                $catSelect
                $depSelect
	
                		<label for="">iframe
      				<input type="text" name="iframe" value="$q->iframe" >
      			</label>
      			      		
                <label for="">Картинка прев'ю *.jpg < 1mb
				    <input name="fileThumb" type="file">
				</label>
			
			</div>

		<label for="">Опис Укр
      	    <textarea name="infoUk" class="ckeditor">$q->infoUk</textarea>     
      	</label>
      	<label for="">Опис En
      	    <textarea name="infoEn" class="ckeditor">$q->infoEn</textarea>      		
        </label>

EOF;
      }
      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>


<?php
//include 'pages/img/all.php';
