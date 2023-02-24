<?php

//include_once './js/thumb/index.php';
//include_once './js/thumb/control.php';

if ($_GET['del']) {
  unlink('../upload/g/' . $_GET['del']);
}


if ($_POST) {

  $filename = $_FILES['file_img']['name'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  $idimg = date('mdhis') . '.' . $ext;
  if (isset($_FILES['file_img']['tmp_name']) and $_FILES['file_img']['tmp_name'] != '') {
    move_uploaded_file($_FILES['file_img']['tmp_name'], $siteUrllocal . '/upload/g/' . $idimg);
    echo '<div class="alert alert-success text-center">File updated</div>';
  }
}


?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class='container'>
            <fieldset>
                <legend><span class='number'>&nbsp;</span> Файловий сервер
                </legend>
            </fieldset>

            <label for="">
                <input name="file_img" type="file" class="form-control input-lg"
                       placeholder="Файл"></label>

            <input name="add"
                   class="btn btn-primary btn-block text-uppercase  input-lg"
                   role="button"
                   type="submit"
                   value="Завантажити на сервер"/>

        </div>
    </form>


<?php


$directory = "../upload/g/";    // Папка с изображениями
$allowed_types = [
  "jpg",
  'png',
  'jpeg',
  'webp',
  'html',
];  //разрешеные типы изображений
$file_parts = [];
$ext = "";
$title = "";
$i = 0;
//пробуем открыть папку
$dir_handle = @opendir($directory) or die("Ошибка при открытии папки !!!");
while ($file = readdir($dir_handle))    //поиск по файлам
{
  if ($file == "." || $file == "..") {
    continue;
  }  //пропустить ссылки на другие папки
  $file_parts = explode(".", $file);          //разделить имя файла и поместить его в массив
  $ext = strtolower(array_pop($file_parts));   //последний элеменет - это расширение

  if (in_array($ext, $allowed_types)) {

    if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'webp') {
      $image = "$url/img/no-image.png";
    }
    else {
      $image = $directory . $file;
    }

    $ret .= <<<EOF
<div>
    <picture>
        <img src="{$image}" class="img-responsive" title="{$file}" />
    </picture>
    <input type="text" class="form-control input-lg" value="{$siteUrl}/upload/g/{$file}" onclick="this.select()">
    <a href="#" onclick="DoYou('$url/?go=img-all&del=$file')" class="btn btn-danger">видалити</a></div>
EOF;
    $i++;
  }

}
closedir($dir_handle);  //закрыть папку


echo "<div class='container'><div class='pageGallery'>$ret</div></div>";