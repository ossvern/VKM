<form enctype="multipart/form-data" action="" method="POST">
	<div class='container'>
		<fieldset>
			<legend><span class='number'>&nbsp;</span>  SEO заголовки
			</legend>
		</fieldset>


		<?php


if (isset($_POST['title']) and $_POST['add']) {

//    $_POST[lang] = 'ua';
//    $url = generateUrl(trim($_POST['title']));


    $sql = "INSERT INTO `$dbb`.`seo_header` (`added`, `lang`, `url`, `title`, `description`, `keywords`) VALUES
('" . date('Y-m-d H:i:s') . "', 'uk', '" . htmlspecialchars($_POST[url]) . "', '" . htmlspecialchars($_POST[title]) . "', '$_POST[description]', '$_POST[keywords]');";
    $db->query($sql);

    echo '<div class="alert alert-success" role="alert">' . $_POST['title'] . ' додано!</div>';
}
?>





<!--    --><?php//
//    $d = -1;
//    while ($d++ < count($lang_arr)-1) {
//        $lang_ret .= '<option value="' . $lang_arr[$d] . '">' . $title_lang_arr[$d] . '</option>';
//    }
//    echo '<p><label>Мова</label><select name="lang" class="form-control input-lg">' . $lang_ret . '</select>';
//    ?>


    <p><label>URL</label>
        <input name="url" type="text" class="form-control input-lg"/>


    <p><label>Title</label>
        <input name="title" type="text" class="form-control input-lg"/>


    <p><label>Description</label>
        <textarea name="description" type="textarea" class="form-control input-lg"></textarea>


    <p><label>Keywords</label>
        <textarea name="keywords"  type="textarea" class="form-control input-lg"></textarea>


    <p>
        <input name="add" class="btn btn-primary" role="button" type="submit" value="Додати"/>
		</p>
	</div>
</form>