<?php
require_once './functions/message.php';
require_once './functions/oldInputs.php';
ini_set('max_file_uploads', '5');
session_start();

function redirect($page){
    header('Location: index.php?page='.$page);
    exit();
}

$action = $_POST['action'] ?? null;
if(!empty($action)){
    $action();
}

function dump($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function sendMail(){
    //$name = strip_tags($_POST['name'] ?? '');
    $name = trim(htmlentities($_POST['name'] ?? ''));
    $email = $_POST['email'] ?? null;
    $message = $_POST['message'] ?? null;

    $errors = [];

    if(empty($name)){
        $errors[] = 'Name is required';
    }
    if(empty($email)){
        $errors[] = 'Email is required';
    }
    if(empty($message)){
        $errors[] = 'Message is required';
    }
    if(count($errors)){
        Message::set($errors,'danger');
        OldInputs::set($_POST);
        redirect('contacts');
    }else {
        mail('yanbokshan8@gmail.com', 'Mail from site', "Name: $name <br> Email: $email <br> Message: $message");
        Message::set('Arigato!');
    }


    //$_COOKIE['test'] = 'asd-as';
}

function sendRegisterInfo(){
    $name = trim(htmlentities($_POST['name'] ?? ''));
    $email = $_POST['email'] ?? null;
    $password = $_POST['message'] ?? null;

    echo "User named {$name} successfully registered";
}

function sendLoginInfo(){
    $email = $_POST['email'] ?? null;
    $password = $_POST['message'] ?? null;

    //echo "You are logged in as {$name}";
}

function sendFile(){
    //dump($_FILES['filename']);
    extract($_FILES['filename']);
    if($error === 4){
        Message::set('File is required', 'danger');
        redirect('gallery');
    }
    if($error !== 0) {
        Message::set('File is not upload! Try again later', 'danger');
        redirect('gallery');
    }

    $allowedExtention = ['image/gif','image/jpg','image/jpeg'];
    if(!in_array($type, $allowedExtention)){
        Message::set('File is not image', 'danger');
        redirect('gallery');
    }

    $fileNameArr = explode(".", $name);
    $fileExtention = end($fileNameArr);
    array_pop($fileNameArr);
    $fileName = implode('.', $fileNameArr);

    $fname = $fileName . '_' . time() . '.' . $fileExtention;

    //$fname = md5(time() . $name) . '.' . $fileExtention;

   if(!file_exists('uploads')) {
        mkdir('uploads');
    }

    if(!move_uploaded_file($tmp_name, 'uploads/'. $fname)){
        Message::set('File is not uploaded', 'danger');
        redirect('gallery');
    }

    resizeImage('uploads/' . $fname, 600, true);
    resizeImage('uploads/' . $fname, 1920, false);

    $phone = $_POST['phone'];
    Message::set('File is uploaded', 'success');
    redirect('gallery');
}

function resizeImage($filePath, $size, $crop){
    list($src_width, $src_height) = getimagesize($filePath);
    extract(pathinfo($filePath));

    $extension = (strtolower($extension) === 'jpg' ? 'jpeg' : strtolower($extension));
    $functionCreate = 'imageCreateFrom' . $extension;
    $src = $functionCreate($filePath);

    if($crop){
        $dest = imagecreatetruecolor($size,$size);
        if ($src_width > $src_height) {
            imagecopyresized($dest, $src, 0, 0, $src_width / 2 - $src_height / 2, 0, $size, $size, $src_height, $src_height);
        } else{
            imagecopyresized($dest, $src, 0, 0, 0, $src_height / 2 - $src_width / 2, $size, $size, $src_width, $src_width);
        }
        $filename.= '_' . $size . 'x' . $size;
    } else{
        $dest_width = $size;
        $dest_height = round($size / ($src_width / $src_height));
        $dest = imagecreatetruecolor($dest_width, $dest_height);

        imagecopyresized($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);

        $filename.= '_' . $dest_width . 'x' . $dest_height;
    }
    $functionSave = 'image' . $extension;
    $functionSave($dest,"$dirname/$filename.$extension", 100);
}


function sendReview(){
    $fName = 'reviews.txt';
    $name = $_POST['name'];
    $review = $_POST['review'];
    $time = time();

    $reviews = [];
    if(file_exists($fName)){
        $reviews = json_decode(file_get_contents($fName));
    }

    $reviews[] = compact('name', 'review', 'time');

    $f = fopen('reviews.txt', 'w');
    fwrite($f, json_encode($reviews));
    fclose($f);
    redirect('reviews');
}
