<?php
/**
 * Created by PhpStorm.
 * User: 55io
 * Date: 17.02.2019
 * Time: 13:19
 */

//TODO use composer
include 'src/service/InterfaceGeneratorService.php';
//use src\service\InterfaceGeneratorService;

if (!empty($_FILES) && $_FILES['inputfile']['error'] == 0) {
    $destinationDir = dirname(__FILE__) . '/tmp/' . $_FILES['inputfile']['name'];
    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destinationDir)) {
        $interfaceService = new InterfaceGeneratorService();
        echo $interfaceService->generateFromFile($destinationDir)->render();
        echo 'File Uploaded';
    } else {
        echo 'File not moved';
    }
} else {
    echo 'No File Uploaded'; // Оповещаем пользователя о том, что файл не был загружен
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello Here</title>
</head>
<body>

<div>
    <form method="post" enctype="multipart/form-data">
        <label for="inputfile">Upload File</label>
        <input type="file" id="inputfile" name="inputfile"></br>
        <input type="submit" value="Click To Upload">
    </form>
</div>
</body>
</html>