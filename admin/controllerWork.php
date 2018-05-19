<?php
    /**
     * sauvegarde ou MAJ
     */
    if(isset($_POST['name']) && isset($_POST['slug']))
    {
        checkCsrf();
        $slug =$_POST['slug'];
        $slug =$db->quote($slug);
        $name =($_POST['name']);
        $name =$db->quote($name);
        $content=($_POST['content']);
        $content= $db->quote($content);
        $category_id= ($_POST['category_id']);
        $category_id= $db->quote($category_id);
        $slug= $_POST['slug'];
        if(preg_match('/^[a-z\0-9]+$/',$slug)){
            $name =$db->quote($name);
            $slug =$db->quote($slug);
            $content= $db->quote($content);
            $category_id= $db->quote($category_id);
            /**
             * s'il s'agit d'une update
             */
            if(isset($_GET['id']))
            {
                $id= $db->quote($_GET['id']);
                if($db->query("UPDATE  works set name=$name, slug=$slug, content =$content, category_id=$category_id WHERE id = $id")){

                    setFlash("la categorie a été bien Modifiée");
                    header('location:work.php');
                }else{
                    setFlash("Erreur Quelque part",'danger');
                    header('location:work.php');
                }
                die();
            }
            else
            {
                $slug =$db->quote($_POST["slug"]);
                $name =$db->quote($_POST["name"]);
                $content= $db->quote($_POST['content']);
                $category_id= $db->quote($_POST['category_id']);
                $db->query("insert into works set name=$name, slug=$slug, content =$content, category_id=$category_id");
                setFlash("la Réalisation été bien inserée");
                /**
                 * j'envoie tous les images a poste pour un evenement donnée
                 */
                $_GET['id']=$db->lastInsertId();
                $work_id=$db->quote($_GET['id']);
                if (!empty($files['image'])) {
                    $files =$_FILES['image'];
                }
                $files =$_FILES['image'];
                $images= array();
                foreach($files['tmp_name'] as $k =>$v)
                {
                    $image =array(
                        'name'=>$files['name'][$k],
                        'tmp_name'=>$files['tmp_name'][$k]
                    );
                    $extension = pathinfo($image['name'],PATHINFO_EXTENSION);
                    if(in_array($extension,array('jpg','pgj'))){
                        $db->query("insert into image set work_id=$work_id");
                        $image_id=$db->lastInsertId();
                        $image_name=$image_id.'.'.$extension;
                        move_uploaded_file($image['tmp_name'],'../img/realisation/'.$image_name);
                        $image_name =$db->quote($image_name);
                        $image_id =$db->quote($image_id);
                        $db->query("UPDATE image SET name= $image_name WHERE id=$image_id");

                    }
                }
                //header('location:work.php');
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
        $select = $db->query("select * from works WHERE  id=$id");
        if($select->rowCount()==0)
        {
            setFlash("Il n'ya pas de Réalisation avec cette ID","Danger");
            header('location:work.php');
            die();
        }else{

            $_POST= $select->fetch();
        }
    }
    /**
     * charge les categories et en voie  dans le menu deroulant vie la methode select()
     */
    $select =$db->query("select id, name from categories ORDER  BY name");
    $categories= $select->fetchAll();
    $categories_list =array();
    foreach($categories as $category){
        $categories_list[$category['id']] =$category['name'];
    }
    /**
     *  charge les les images à coté
     */
    if(isset($_GET['id']))
    {
        $work_id =$db->quote($_GET['id']);
        $selection =$db->query("select id, name from image  WHERE work_id=$work_id");
        $images= $selection->fetchAll();
    }
    else
    {
        $images =array();
    }
    /**
     * supression d'une image
     */
    if(isset($_GET['delete_image']))
    {
        $id= $db->quote($_GET['delete_image']);
        $select =$db->query("SELECT name ,work_id from image id=$id");
        $image =$select->fetchAll();
        unlink('../img/realisation/'.$image['name']);
        $db->query("DELETE name from image WHERE  id=$id");
    }
    ?>