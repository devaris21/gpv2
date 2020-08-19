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
                                <div class="row">
                                    <?php foreach ($parfums as $key =>$parfum) { ?>
                                        <div class="col-md border-right">
                                            <h6 class="text-uppercase text-center gras" style="color: <?=$parfum->couleur; ?>">Stock de <?=$parfum->name() ?></h6>
                                            <ul class="list-group clear-list m-t">
                                                <?php foreach ($quantites as $key => $qua) {
                                                    foreach ($produits as $key => $pro) {
                                                        if ($pro->parfum_id == $parfum->id && $pro->typeproduit_id == $type->id && $pro->quantite_id == $qua->id) {
                                                            $bout = $pro->enBoutique($date2);
                                                            $entr = $pro->enEntrepot($date2); ?>
                                                            <li class="list-group-item">
                                                                <i class="fa fa-flask" style="color: <?=$parfum->couleur; ?>"></i> <small><?= $qua->name() ?></small>          
                                                                <span class="float-right">
                                                                    <span title="en entrepôt" class="<?= ($entr > $params->ruptureStock)?"text-green":"clignote text-danger" ?>"><?= start0($entr) ?></span>
                                                                </span>
                                                            </li>
                                                        <?php }
                                                    } ?>
                                                <?php } ?>
                                                <li class="list-group-item"></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
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
