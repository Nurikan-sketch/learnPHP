<?php
class Message{
    public static function set($content, $type='success'){
        $_SESSION['message'] = [$content, $type];
    }

    public static function get(){
        if(isset($_SESSION['message'])) {
            list($context, $type) = $_SESSION['message'];

            $context = is_array($context) ? implode('<br>', $context) :$context;

            echo "<div style='margin-top: 20px' class='alert alert-{$type}'>$context</div>";

            unset($_SESSION['message']);
        }
    }
}
