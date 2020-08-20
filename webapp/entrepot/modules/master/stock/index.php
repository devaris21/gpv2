<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  


            <div class="wrapper-content">
                <div class="animated fadeInRightBig">

                    <?php foreach ($typeproduits as $key => $type) { ?>
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Stock de <?= $type->name() ?></h5>
                            </div>
                            <div class="ibox-content">
                                    <?php foreach ($parfums as $key =>$parfum) {
                                        $datas = Home\PRODUIT::findBy(["parfum_id ="=> $parfum->id, "typeproduit_id ="=> $type->id, "isActive = "=> Home\TABLE::OUI]);
                                        ?>
                                        <table class="table table-stripped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <?php foreach ($formats as $key => $format) { ?>
                                                        <th class="text-center">
                                                            <img src="http://dummyimage.com/50x50/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image"><br>
                                                            <small><?= $format->name() ?></small>
                                                        </th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($datas as $key => $produit) {
                                                    $produit->actualise(); ?>
                                                    <tr>
                                                        <td><h5 class="gras text-uppercase"><?= $produit->name() ?></h5></td>
                                                        <?php foreach ($formats as $key => $format) { 
                                                            $a = $produit->enEntrepot(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $format->id, $entrepot->id); ?>
                                                            <td class="text-center <?= ($a * $format->nombre() > $params->ruptureStock)?"":"text-red clignote" ?>"><h4><?= ($a > 0)?start0($a):" "; ?></h4></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table><hr style="border: 1px dotted orangered">
                                    <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>


            <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?>


        </div>
    </div>


    <?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>


</body>

</html>
