<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> ОНЛАЙН МУЗЕЙ</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/scientific_work/';

      if ($_POST['add']) {

        //        $_POST['eventDate'] = substr($_POST['eventDateStart'], 0, strpos($_POST['eventDateStart'], 'T'));
        //        $_POST['eventDateStart'] = str_replace('T', ' ', $_POST['eventDateStart']);
        //
        //        $sqlDate = '';
        //        if (strlen($_POST['eventDate']) > 3) {
        //          $sqlDate = "` eventDate` = '{$_POST['eventDate']}', `eventDateStart` = '{$_POST['eventDateStart']}',
        //        `eventDateEnd` = '{$_POST['eventDateEnd']}', ";
        //        }
        //        $sqlDate

        $sql = "UPDATE `cat_scientific_work` SET 
        `titleUk` = '{$_POST['titleUk']}', `titleEn` = '{$_POST['titleEn']}', 
         `infoUk` = '{$_POST['infoUk']}', `infoEn` = '{$_POST['infoEn']}', 

        `cat` = '{$_POST['cat']}',

        
                        `topFixed` = '{$_POST['topFixed']}' WHERE `id` = '$id'";
//                echo $sql;
        $db->query($sql);


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
        echo '<script>window.location.replace("' . $url . '/?go=scientific_work#' . $id . '");</script>';
      }


      $categoryLink = [
        'study',
        'conferences',
        'publication',
        'publications_library',
      ];
      $categoryTitle = [
        'Навчання',
        'Конференції',
        'Видання музею',
        'Наукові публікації/Бібліотека',
      ];


      $i = -1;
      $retCat = '';


      $sql = "SELECT * FROM `cat_scientific_work` where `id`='$id'";
      $result = $db->query($sql);
      while ($q = $result->fetch_object()) {


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
