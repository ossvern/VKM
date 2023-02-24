<form enctype="multipart/form-data" action="" method="POST">
	<div class='container'>
		<fieldset>
			<legend><span class='number'>&nbsp;</span>   SEO заголовки</legend>
		</fieldset>

		<?php


		if (isset($_POST['title'])) {

			$sql = "UPDATE `seo_header` SET
  `title`= '" . htmlspecialchars($_POST[title]) . "',
  `description`= '" . htmlspecialchars($_POST[description]) . "',
   `keywords`= '" . ($_POST[keywords]) . "'
   WHERE `seo_header`.`id` = '{$id}';";

			$db->query($sql);
//echo $sql;


			echo '<div class="alert alert-success" role="alert">' . $_POST['title'] . ' збережено!</div>';
		}


		$sql = "SELECT * FROM `seo_header` WHERE `id`='{$id}' LIMIT 0,1";
		$result = $db->query($sql);
		while ($row = $result->fetch_array()) {
			?>
			<p><label>Title</label>
				<input name="title" type="text" class="form-control input-lg" value="<?php echo $row['title'] ?>"/>


			<p><label>Description</label>
				<textarea name="description" type="textarea"
				          class="form-control input-lg"><?php echo $row['description'] ?></textarea>


			<p><label>Keywords</label>
				<textarea name="keywords" type="textarea"
				          class="form-control input-lg"><?php echo $row['keywords'] ?></textarea>


			<p>
				<input name="add" class="btn btn-primary" role="button" type="submit" value="Зберегти"/>
			</p>


		<?php } ?>

</form></div>