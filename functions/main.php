<?php
require_once './functions/message.php';
require_once './functions/oldInputs.php';
session_start();

function redirect($page){
    header('Location: index.php?page='.$page);
    exit();
}

$action = $_POST['action'] ?? null;
if(!empty($action)){
    $action();
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
