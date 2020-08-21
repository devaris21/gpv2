<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  


            <div class="wrapper-content">
                <div class="animated fadeInRightBig">

                    <?php foreach ($typeproduits as $key => $type) { ?>
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Stock de <?= $type->name() ?></h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <?php foreach ($type->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
                                        $pro->actualise(); ?>
                                        <div class="col-md border-right">
                                            <h6 class="text-uppercase text-center gras" style="color: <?= $pro->couleur; ?>"><?= $pro->name() ?></h6>
                                            <ul class="list-group clear-list m-t">
                                                <?php foreach ($pro->fourni("produit", ["isActive ="=>Home\TABLE::OUI]) as $key => $produit) {
                                                    $produit->actualise();
                                                    $bout = $produit->enBoutique($date2, $boutique->id); ?>
                                                    <li class="list-group-item">
                                                        <i class="fa fa-flask" style="color: <?= $pro->couleur; ?>"></i> <small><?= $produit->quantite->name() ?></small>                                                                  <span class="float-right">
                                                            <span title="en boutique" class="gras <?= ($bout > $params->ruptureStock)?"text-green":"clignote text-danger" ?>"><?= start0($bout) ?></span>
                                                        </span>
                                                    </li>
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


            <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>


        </div>
    </div>


    <?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
