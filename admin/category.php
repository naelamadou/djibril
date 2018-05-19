    <?php
    include_once '../lib/include.php';
    include_once '../partials/admin_header.php';
    /**
     * Suppression
     */
    if(isset($_GET['delete'])){
        //checkCsrf();
        $id=$db->quote($_GET['delete']);
        $db->query("Delete From categories WHERE  id=$id");
        setFlash("la categories a bien été supprimée","danger");
        header("location:category.php");
    }
    $select=$db->query("select * from categories");
    $categories = $select->fetchAll();
    ?>
    <h1>les categories</h1>
     <p><a href="category_edit.php" class=" btn btn-success">Ajout une nouvelle Categorie</a> </p>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category):?>
                <tr>
                    <td><?=$category['id']?></td>
                    <td><?=$category['name']?></td>
                    <td>
                        <a href="category_edit.php?id=<?=$category['id']?>" class="btn-default">Editer</a>
                        <a href="?delete=<?=$category['id']?>&<?=csrf()?>" class="btn btn-error" onclick="confirm('sûr de sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>


    <?php include_once '../partials/footer.php'?>