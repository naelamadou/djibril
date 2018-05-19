<?php
    include_once '../lib/include.php';
    include_once '../partials/admin_header.php';
    include_once 'controllerWork.php'; ?>
    <h1>Editer Réalisation</h1>
        <div class="row">
            <div class="col-sm-8"> 
                <form action="#"  method="post" ENCTYPE="multipart/form-data">

                    <div class="form-group">
                        <label for="name">Nom de la Réalisation</label>
                        <?=input("name"); ?>
                    </div>

                    <div class="form-group">
                        <label for="slug">URL de la Réalisation</label>
                        <?=input("slug"); ?>
                    </div>
                    <div class="form-group">
                        <label for="content">Contenue de la Réalisation</label>
                        <?=textarea("content"); ?>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Categorie associé</label>
                        <?php if(isset($_GET['id'])) {
                            echo select("category_id",$categories_list);
                        }
                        else{ echo selectAll("category_id",$categories_list) ;}
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image[]" >
                        <input type="file" name="image[]" class="hidden" id="duplicate">
                        <P>
                            <a href="#" class="btn btn-success" id="duplicatebtn">Ajouter une image</a>
                        </P>
                    </div>
                    <button type="submit" class="btn btn-default">Enregistrer</button>
                    <?=csrfInput(); ?>
                </form>
            </div>
            <div class="col-sm-4">
                <h2></h2>
                <?php foreach($images as $img):?>
                   <a href="?delete_image=<?=$img['id']  ?>&<?=csrf()?>" onclick="confirm('Sûr de Sûr')" >
                       <img src="../img/realisation/<?=$img['name'] ?>" width="100">
                   </a>
                <?php endforeach?>

            </div>
        </div>
    <?php ob_start();?>
        <script src="../JS/tinymce/js/tinymce/tinymce.min.js">
        </script>

            <script>
                // ce script permet de faire un choix multiple d'image
                (function ($) {
                    $('#duplicatebtn').click(function(e)
                    {
                         e.preventDefault();
                        var $clone= $('#duplicate').clone().attr('id','').removeClass('hidden');
                        $('#duplicate').before($clone);
                    })
                })(jQuery);
                // celui-ci genère la partie de mise en forme de text
                tinymce.init({
                    selector: 'textarea',
                    mode:'textarea',
                    theme:'advanced',
                    height: 300,
                    theme: 'modern',
                    image_advtab: true,
                    templates: [
                        { title: 'Test template 1', content: 'Test 1' },
                        { title: 'Test template 2', content: 'Test 2' }
                    ]

                });
            </script>
    <?php $script= ob_get_clean(); ?>
    <?php include_once '../partials/footer.php'?>