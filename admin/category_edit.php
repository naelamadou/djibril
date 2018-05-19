    <?php
    include_once '../lib/include.php';
    include_once '../partials/admin_header.php';

    /**
     *
     */
    if(isset($_POST['name']) && isset($_POST['slug']))
    {
        checkCsrf();
        $slug= $_POST['slug'];
        if(preg_match('/^[a-z\0-9]+$/',$slug)){
            $slug =$db->quote($_POST["slug"]);
            $name =$db->quote($_POST["name"]);
            /**
             * s'il s'agit d'une update
             */
            if(isset($_GET['id']))
            {
                $id= $db->quote($_GET['id']);
                $db->query("UPDATE  categories set name=$name, slug=$slug WHERE id=$id");
                setFlash("la categorie a été bien Modifiée");
                header('location:category.php');
                die();
            }
            else
            {

                $db->query("insert into categories set name=$name, slug=$slug");
                setFlash("la categorie a été bien inserée");
                header('location:category.php');
                die();
            }

        }
        else{
            setFlash("le Slug n'est pas Valid","danger");
        }
    }
    /***
     * Moidification d'une categorie
     */
    if(isset($_GET['id']))
    {
        $id= $db->quote($_GET['id']);
        $select = $db->query("select * from categories WHERE  id=$id");
        if($select->rowCount()==0)
        {
            setFlash("Il n'ya pas de categorie avec cette ID","Danger");
            header('location:category.php');
            die();
        }else{

           $_POST= $select->fetch();
        }
    }

    ?>
    <h1>Editer categories</h1>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name">Nom de la categorie</label>
                <?=input("name"); ?>
            </div>

                <div class="form-group">
                    <label for="slug">URL de la categorie</label>
                    <?=input("slug"); ?>
                </div>
            <?=csrfInput(); ?>
            <button type="submit" class="btn btn-default">Enregistrer</button>
        </form>
    <?php include_once '../partials/footer.php'?>