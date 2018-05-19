    <?php
    include_once '../lib/include.php';
    include_once '../partials/admin_header.php';
    /**
     * Suppression
     */
    if(isset($_GET['delete'])){
        //checkCsrf();
        $id=$db->quote($_GET['delete']);
        $db->query("Delete From works WHERE  id=$id");
        setFlash("la réalisations a bien été supprimée","danger");
        header("location:work.php");
    }
    $select=$db->query("select * from works");
    $works = $select->fetchAll();
    ?>
    <h1>les Réalisations</h1>
     <p><a href="work_edit.php" class=" btn btn-success">Ajout une nouvelle Réalisation</a> </p>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($works as $work):?>
                <tr>
                    <td><?=$work['id']?></td>
                    <td><?=$work['name']?></td>
                    <td>
                        <a href="work_edit.php?id=<?=$work['id']?>&<?=csrf()?>" class="btn-default">Editer</a>
                        <a href="?delete=<?=$work['id']?>&<?=csrf()?>" class="btn btn-error" onclick="confirm('sûr de sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>


    <?php include_once '../partials/footer.php'?>