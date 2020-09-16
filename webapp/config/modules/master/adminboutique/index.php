<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/config/elements/templates/head.php")); ?>

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
                                <a id="onglet-master" href="<?= $this->url("config", "master", "organisation") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px; margin-right: 10px;"><i class="fa fa-long-arrow-left"></i> Retour </a>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig container-fluid">

                            <h1 class="text-center display-4 text-uppercase"><?= $boutique->name()  ?></h1><br>

                            <div class="row">

                                <div class="col-md-12 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Stock initial par produit et par emballage dans vos boutiques</h5>
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
                                                                        </td>
                                                                        <td class="">
                                                                            <div class="row">
                                                                                <?php if ($produit->isActive()) {
                                                                                   foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
                                                                                    $item = $produit->fourni("initialproduitboutique", ["emballage_id ="=>$emballage->id, "boutique_id ="=>$boutique->id])[0];
                                                                                    $item->actualise(); ?>
                                                                                    <div class="col-md-4 border-right border-bottom">
                                                                                        <div class="">
                                                                                            <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $emballage->image)  ?>"> <small><?= $emballage->name(); ?></small><br>
                                                                                            <div >
                                                                                                <input type="text" title="Stock initial" style="font-size: 10px; padding: 3px" number class="form-control input-xs text-center maj" value="<?= $item->quantite ?>" name="initialproduitboutique" id="<?= $item->id ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php }
                                                                            } ?>
                                                                        </div>
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

                <?php include($this->rootPath("webapp/config/elements/templates/footer.php")); ?>


            </div>
        </div>


        <?php include($this->rootPath("webapp/config/elements/templates/script.php")); ?>
        <?php include($this->relativePath("modals.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-params.php") );  ?>


    </body>



    </html>