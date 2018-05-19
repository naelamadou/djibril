<?php

    function flash(){
        if(isset($_SESSION['flash'])){
            extract($_SESSION['flash']);
            unset($_SESSION['flash']);
            return "<div class='alert-{$type}'>$message</div>";
        }
    }
    function setFlash($message,$type="success"){
        $_SESSION['flash']['message']=$message;
        $_SESSION['flash']['type']= $type;
    }