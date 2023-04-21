<h1>Gallery</h1>

<?php Message::get() ?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="filename" multiple> <br>

    <input type="text" name="phone[]" placeholder="Phone"> <br>
    <input type="text" name="phone[]" placeholder="Phone"> <br>

    <button name="action" value="sendFile">Send</button>
</form>

<?php

/*$files = scandir('uploads');
foreach ($files as $file){
    if($file !== '.' && $file !== '..' && !is_dir('uploads/'.$file)){
        echo "<img src='uploads/$file'>";
    }
}*/

//$files = glob('uploads/*.');

$files = [];
$handle = opendir('uploads');
while($f = readdir($handle)){
    $files[] = $f;
}
closedir($handle);

$files = array_diff($files, ['.', '..'])
?>

