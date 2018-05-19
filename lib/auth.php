    <?php
    session_start();
    if(!isset($auth)){

        if(!$_SESSION['Auth']['id']){
           header('location:login.php');
            die();
        }
    }
    /*
     * génère moi
     */
    if(!isset($_SESSION['csrf'])){
        $_SESSION['csrf']=md5(time()+rand());
    }

    /*
     *  pour masquer les variables passées en parm
     * @return mixed
     */
    function csrf(){
        return $_SESSION['csrf'] ;
    }
    function csrfInput(){
        return ' <input type="hidden" value="'.$_SESSION['csrf'].'"  name="csrf"> ';
    }
    function checkCsrf(){
        if(
            ($_GET['csrf']=$_SESSION['csrf'] || isset($_GET['csrf'])) ||
            $_POST['csrf']=$_SESSION['csrf'] || isset($_POST['csrf'])
        ){
            return true;
        }
        header('location:'.WEBROOT.'csrf.php');
        die();
    }
