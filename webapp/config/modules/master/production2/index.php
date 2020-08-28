<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/master/elements/templates/head.php")); ?>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">
                    <!--<div class="navbar-header">-->
                        <!--<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">-->
                            <!--<i class="fa fa-reorder"></i>-->
                            <!--</button>-->

                            <a href="#" class="navbar-brand " style="padding: 3px 15px;"><h1 class="mp0 gras" style="font-size: 45px">GPV</h1></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-reorder"></i>
                            </button>

                            <!--</div>-->
                            <div class="navbar-collapse collapse" id="navbar">
                                <ul class="nav navbar-nav mr-auto">
                                    <li class="gras <?= (isJourFerie(dateAjoute(1)))?"text-red":"text-muted" ?>">
                                        <span class="m-r-sm welcome-message text-uppercase" id="date_actu"></span> 
                                        <span class="m-r-sm welcome-message gras" id="heure_actu"></span> 
                                    </li>

                                </ul>
                                <ul class="nav navbar-top-links navbar-right">
                                    <li id="btn-deconnexion" class="text-red cursor">
                                        <a href="<?= $this->url("config", "master", "dashboard"); ?>" class="btn_modal btn btn-xs btn-white" >
                                            << Retour à la vue générale
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig container-fluid">

                            <div class="row">

                                <div class="col-md-12 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Ceux que vous produisez</h5>
                                            <div class="ibox-tools">

                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <?php foreach ($parfums as $key => $type) {  ?>
                                                            <td class="gras text-center"> <?= $type->name(); ?></td>
                                                        <?php } ?>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($types as $key => $prod) { ?> 
                                                        <tr>
                                                            <td style="width: 250px" class="gras text-uppercase"> <?= $prod->name(); ?></td>

                                                            <?php 
                                                            foreach ($parfums as $key => $parfum) {
                                                                $item = Home\TYPEPRODUIT_PARFUM::findBy(["typeproduit_id ="=>$prod->id, "parfum_id ="=>$parfum->id])[0]; $item->actualise(); ?>
                                                                <td class="text-center">
                                                                    <span><?= $item->name();  ?></span><br>
                                                                    <div class="switch" style="display: inline-block;">
                                                                        <div class="onoffswitch">
                                                                            <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("typeproduit_parfum", <?= $item->id ?>)' class="onoffswitch-checkbox" id="typeproduit_parfum<?= $item->id ?>">
                                                                            <label class="onoffswitch-label" for="typeproduit_parfum<?= $item->id ?>">
                                                                                <span class="onoffswitch-inner"></span>
                                                                                <span class="onoffswitch-switch"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-12 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Exigence de production par ressource</h5>
                                            <div class="ibox-tools">

                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <?php foreach ($ressources as $key => $ressource) {  ?>
                                                            <td class="gras text-center"> <?= $ressource->name(); ?></td>
                                                        <?php } ?>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($types_parfums as $key => $prod) {
                                                        $lots = $prod->fourni('exigenceproduction');
                                                        if (count($lots) > 0) {
                                                            $exi = $lots[0];
                                                            $exi->actualise();
                                                            $lots = $exi->fourni('ligneexigenceproduction');   ?> 
                                                            <tr>
                                                                <td style="width: 250px" class="gras text-uppercase"> <?= $prod->name(); ?></td>
                                                                <td>Pour <b><?= $exi->quantite  ?></b> <?= $prod->typeproduit->abbr ?></td>
                                                                <?php foreach ($ressources as $key => $ressource) {
                                                                    $item = Home\LIGNEEXIGENCEPRODUCTION::findBy(["exigenceproduction_id ="=>$exi->id, "ressource_id ="=>$ressource->id])[0]; 
                                                                    if ($item->quantite > 0) {
                                                                        $item->actualise(); ?>
                                                                        <td class="text-center"><?= money($item->quantite); ?> <?= $item->ressource->abbr ?></td>
                                                                    <?php  }else{ ?>
                                                                        <td></td>
                                                                    <?php }
                                                                } ?>
                                                                <td><i class="fa fa-pencil cursor" data-toggle="modal" data-target="#modal-exigence<?= $prod->id ?>"> </i></td>
                                                            </tr>
                                                        <?php } 
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>





                                <div class="col-md-12 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Tranche des prix par produit et par emballage dans vos boutiques</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="row">
                                                <?php $i =0; foreach ($types_parfums as $key => $type) { ?>
                                                    <div class="col-md-6" style="margin-bottom: 3%">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2" class="text-uppercase text-center"><?= $type->name(); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; 
                                                                foreach ($type->fourni("produit") as $key => $produit) {
                                                                    $produit->actualise(); ?>
                                                                    <tr>
                                                                        <td class="" style="width: 30%">
                                                                            <?= $produit->name(); ?> 
                                                                            <div class="row produits">
                                                                                <div class="col-sm-6">
                                                                                    <div class="onoffswitch">
                                                                                        <input type="checkbox" <?= ($produit->isActive())?"checked":""  ?> onchange='changeActive("produit", <?= $produit->id ?>)' class="onoffswitch-checkbox" id="produit<?= $produit->id ?>">
                                                                                        <label class="onoffswitch-label" for="produit<?= $produit->id ?>">
                                                                                            <span class="onoffswitch-inner"></span>
                                                                                            <span class="onoffswitch-switch"></span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php if ($produit->isActive()) { ?>
                                                                                    <div class="col-sm-6">
                                                                                        <small>Stock initial</small>
                                                                                        <input type="text" style="font-size: 10px; padding: 5px" number class="form-control input-xs text-center initial gras" value="<?= $produit->initial ?>" name="initial" id="<?= $produit->id ?>">
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php if ($produit->isActive()) {
                                                                               foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
                                                                                $prix = $produit->fourni("price", ["emballage_id ="=>$emballage->id])[0] ?>
                                                                                <div class="" style="color: blue">
                                                                                    <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $emballage->image)  ?>"> <small><?= $emballage->name(); ?></small>
                                                                                </div><hr class="mp3">
                                                                                <div class="row produits">
                                                                                    <div class="col-sm-6">
                                                                                        <input type="text" title="Prix Unitaire normal" style="font-size: 10px; padding: 3px" number class="form-control input-xs text-center prix" value="<?= $prix->prix ?>" name="prix" id="<?= $prix->id ?>">
                                                                                    </div>
                                                                                    <div class="col-sm-6" style=" color: orangered">
                                                                                        <input type="text" title="Prix unitaire de gros" style="font-size: 10px; padding: 3px" number class="form-control input-xs text-center prix_gros" value="<?= $prix->prix_gros ?>" name="prix_gros" id="<?= $prix->id ?>">
                                                                                    </div>
                                                                                </div>
                                                                            <?php }
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <br>

                <?php include($this->rootPath("webapp/master/elements/templates/footer.php")); ?>


            </div>
        </div>


        <?php include($this->rootPath("webapp/master/elements/templates/script.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-params.php") );  ?>
        <?php include($this->relativePath("modals.php")); ?>


    </body>



    </html>