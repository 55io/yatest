<?php
/**
 * Created by PhpStorm.
 * User: 55io
 * Date: 17.02.2019
 * Time: 13:19
 */

//TODO use composer
require_once dirname(__FILE__) . '/src/service/InterfaceGeneratorService.php';
//use src\service\InterfaceGeneratorService;

$output = '';

if (!empty($_FILES) && $_FILES['inputfile']['error'] == 0) {
    $destinationDir = dirname(__FILE__) . '/tmp/' . $_FILES['inputfile']['name'];
    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destinationDir)) {
        $interfaceService = new InterfaceGeneratorService();
        $output = str_replace(PHP_EOL, '<br>', $interfaceService->generateFromFile($destinationDir)->render());
    } else {
        echo 'File not moved';
    }
} else {
    echo 'No File Uploaded';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello Here</title>
</head>
<body>
<div style="display: inline-flex; justify-content: space-around;">
    <div>
        <form method="post" enctype="multipart/form-data">
            <label for="inputfile">Upload File</label>
            <input type="file" id="inputfile" name="inputfile"></br>
            <input type="submit" value="Click To Upload">
        </form>
    </div>
    <div>
        <?= $output ?>
    </div>
</div>
</body>
</html>
