
    <?php $auth=0;
     include_once 'lib/include.php';
    /**
     * Traitement sur le formulaire
     */

     if(isset($_POST['username']) && isset($_POST['password'])){
        $username= $db->quote($_POST['username']);
        $password= sha1($_POST['password']);
        //$sql= "select * from users WHERE username={$username} AND password='$password'";
        $select=$db->query("select * from users WHERE username={$username} AND password='$password'");
        if($select->rowCount()){
          $_SESSION['Auth']=($select->fetch()) ;
            setFlash('vous êtes bien Connection');
            header('location:'.WEBROOT.'admin/index.php');
            die();
        }else{

        }
    }
    /**
     * inclusion de l'entete de page
     */
     include_once 'partials/header.php'; ?>

    <form action="#" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <?=input("username"); ?>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Se connecter</button>
             </div>
        </form>
    <?php include_once 'partials/footer.php'; ?>
    <?php include_once 'lib/debug.php'; ?>