<form enctype="multipart/form-data" action="" method="POST">
	<div class='container'>
		<fieldset>
			<legend><span class='number'>&nbsp;</span>SEO заголовки   </small>
			</legend>
		</fieldset>

		<?php
		if (isset($_GET['del'])) {
			$db->query("DELETE FROM `seo_header`  WHERE `id` = '" . $_GET['del'] . "'");
		}


		$sql = "SELECT * FROM `seo_header` ORDER BY `seo_header`.`url` ASC "; // LIMIT $start,$max
		$result = $db->query($sql);
		while ($row = $result->fetch_array()) {

			$ret .= '
    <tr>    
    <td><a href="' . $row['url'] . '" target="_blank" class="btn btn-small btn-primary">' . $row['url'] . '</a></td>
    <td style="text-align: left"><h4>' . $row['title'] . '</h4>' . $row['description'] . '<br><small>' . $row['keywords'] . '</small></td>
    <td><a href="?go=/seo_header/edit&id=' . $row['id'] . '" class="btn btn-primary">Редагувати</a></td>
    <td>
    <a href="?go=/seo_header/all&del=' . $row['id'] . '">Видалити</a></td>
    </tr>';


		}

		echo '<table class="table table-responsive table-striped table-hover">' . $ret . '</table>';
		unset($ret);
		?>
	</div>
</form>
