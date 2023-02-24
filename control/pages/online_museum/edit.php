<form enctype="multipart/form-data" action="" method="POST">
    <div class='container'>
        <fieldset>
            <legend><span class='number'>&nbsp;</span> ОНЛАЙН МУЗЕЙ</legend>
        </fieldset>
      <?php
      $gpath = $urlImg . '/online_museum/';

      if ($_POST['add']) {


        $sql = "UPDATE `cat_online_museum` SET 
        `titleUk` = '{$_POST['titleUk']}', `titleEn` = '{$_POST['titleEn']}',  `titlePl` = '{$_POST['titlePl']}', 
         `infoUk` = '{$_POST['infoUk']}', `infoEn` = '{$_POST['infoEn']}', `infoPl` = '{$_POST['infoPl']}',
        `cat` = '{$_POST['cat']}',
        `iframe` = '{$_POST['iframe']}' WHERE `id` = '$id'";
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


        if ($res==1){
          echo '<script>window.location.replace("' . $url . '/?go=online_museum#' . $id . '");</script>';

        }else{
          echo $sql;
        }

      }



      $categoryLink = [
        'exhibitions',
        'tests',
        'puzzles',
        '3d_models',
      ];
      $categoryTitle = [
        'ОНЛАЙН-виставки',
        'ОНЛАЙН-ТЕСТИ',
        'ОНЛАЙН-ПАЗЛИ',
        '3D МОДЕЛІ',
      ];


      $i = -1;
      $retCat = '';


      $sql = "SELECT * FROM `cat_online_museum` where `id`='$id'";
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
      			<label for="">Назва Pl
      				<input type="text" name="titlePl" value="$q->titlePl" >
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
        <label for="">Опис PL
      	    <textarea name="infoPl" class="ckeditor">$q->infoPl</textarea>      		</label>

EOF;
      }
      ?>
        <input name="add" type="submit" value="Зберегти"/>
</form>
</div>


<?php
//include 'pages/img/all.php';
