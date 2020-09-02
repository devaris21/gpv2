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
                                <a id="onglet-master" href="<?= $this->url("config", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px; margin-right: 10px;"><i class="fa fa-long-arrow-left"></i> Retour au tableau de bord</a>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig container-fluid">

                          <div class="row">

                            <div class="col-sm-4 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les types de produits</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-white btn-xs" data-toggle="modal" data-target="#modal-typeproduit">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Libéllé</th>
                                                    <th>Unité</th>
                                                    <th></th>
                                                    <th>Activé ?</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\TYPEPRODUIT::findBy([], [], ["isActive"=>"DESC", "name"=>"ASC"]) as $key => $item) {
                                                    $i++; ?>
                                                    <tr>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td><?= $item->unite; ?></td>
                                                        <td><?= $item->abbr; ?></td>
                                                        <td>
                                                            <div class="switch">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("typeproduit", <?= $item->id ?>)' class="onoffswitch-checkbox" id="typeproduit<?= $item->id ?>">
                                                                    <label class="onoffswitch-label" for="typeproduit<?= $item->id ?>">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td data-toggle="modal" data-target="#modal-typeproduit" title="modifier le produit" onclick="modification('typeproduit', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td data-toggle="tooltip" title="modifier le produit" onclick="suppressionWithPassword('typeproduit', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les parfums</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-white btn-xs" data-toggle="modal" data-target="#modal-parfum">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Libéllé</th>
                                                    <th>Activé ?</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\PARFUM::findBy([], [], ["isActive"=>"DESC", "name"=>"ASC"]) as $key => $item) {
                                                    $i++; ?>
                                                    <tr>
                                                        <td><div class="border" style="width: 20px; height: 20px; background-color: <?= $item->couleur ?>"></div></td>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td>
                                                            <div class="switch">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("parfum", <?= $item->id ?>)' class="onoffswitch-checkbox" id="parfum<?= $item->id ?>">
                                                                    <label class="onoffswitch-label" for="parfum<?= $item->id ?>">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td data-toggle="modal" data-target="#modal-parfum" title="modifier le parfum" onclick="modification('parfum', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td data-toggle="tooltip" title="modifier le parfum" onclick="suppressionWithPassword('parfum', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les quantités d'emballage</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-white btn-xs" data-toggle="modal" data-target="#modal-quantite">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Libéllé</th>
                                                    <th>Activé ?</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\QUANTITE::findBy([], [], ["isActive"=>"DESC", "name"=>"ASC"]) as $key => $item) {
                                                    $i++; ?>
                                                    <tr>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td>
                                                            <div class="switch">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("quantite", <?= $item->id ?>)' class="onoffswitch-checkbox" id="quantite<?= $item->id ?>">
                                                                    <label class="onoffswitch-label" for="quantite<?= $item->id ?>">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td data-toggle="modal" data-target="#modal-quantite" title="modifier la quantite" onclick="modification('quantite', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td data-toggle="tooltip" title="modifier la quantite" onclick="suppressionWithPassword('quantite', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-5 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les types d'emballage</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-emballage">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nom</th>
                                                    <th>Composé de </th>
                                                    <th>Qté initial</th>
                                                    <th>Stk. init</th>
                                                    <th>Prix fixe</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\EMBALLAGE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                    $item->actualise();  ?>
                                                    <tr>
                                                        <td ><img style="height: 25px" src="<?= $this->stockage("images", "emballages", $item->image); ?>"></td>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td class="text-center"><?= $item->quantite; ?> <b><?= $item->emballage->name(); ?></b></td>
                                                        <td class="text-center"><?= $item->initial; ?> unités</td>
                                                        <td width="90px">
                                                            <input type="text" title="Stock initial" number class="form-control input-xs text-center emballage" step="0.1" value="<?= $item->initial ?>" name="initial" id="<?= $item->id ?>" >
                                                        </td>
                                                        <td width="90px">
                                                            <input type="text" title="Prix Unitaire normal" number class="form-control input-xs text-center emballage" value="<?= $item->price ?>" name="price" id="<?= $item->id ?>">
                                                        </td>
                                                        <td data-toggle="modal" data-target="#modal-emballage" title="modifier l'élément" onclick="modification('emballage', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td title="supprimer la format d'emballage" onclick="suppressionWithPassword('emballage', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-7 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les caractéristiques des emballage</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-caracteristiqueemballage">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>type de produit</th>
                                                    <th>Parfum</th>
                                                    <th>Quantité</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\CARACTERISTIQUEEMBALLAGE::findBy([], [], []) as $key => $item) {
                                                    $item->actualise();  ?>
                                                    <tr>
                                                        <td ><img style="height: 25px" src="<?= $this->stockage("images", "emballages", $item->emballage->image); ?>"></td>
                                                        <td class="gras"><small><?= $item->emballage->name(); ?></small></td>
                                                        <td>peut contenir</td>
                                                        <td class="gras"><?= $item->typeproduit(); ?></td>
                                                        <td class="gras"><?= $item->parfum(); ?></td>
                                                        <td class="gras"><?= $item->quantite(); ?></td>
                                                        <td data-toggle="modal" data-target="#modal-caracteristiqueemballage" title="modifier l'élément" onclick="modification('caracteristiqueemballage', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td title="supprimer l'element'" onclick="suppressionWithPassword('caracteristiqueemballage', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les matières premières</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-ressource">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Libéllé</th>
                                                    <th>Unité</th>
                                                    <th>Abbr</th>
                                                    <th>stockable ?</th>
                                                    <th>Stock initial</th>
                                                    <th>Prix fixe</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                    $item->actualise(); ?>
                                                    <tr>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td><?= $item->unite; ?></td>
                                                        <td><?= $item->abbr; ?></td>
                                                        <td>
                                                            <div class="switch">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("ressource", <?= $item->id ?>)' class="onoffswitch-checkbox" id="ressource<?= $item->id ?>">
                                                                    <label class="onoffswitch-label" for="ressource<?= $item->id ?>">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="110px">
                                                            <?php if ($item->isActive()) { ?>
                                                                <input type="text" title="Stock initial" number class="form-control input-xs text-center ressource" value="<?= $item->initial ?>" name="initial" id="<?= $item->id ?>">
                                                            <?php }  ?>
                                                        </td>
                                                        <td width="110px">
                                                            <input type="text" title="Prix Unitaire normal" number class="form-control input-xs text-center ressource" step="0.1" value="<?= $item->price ?>" name="price" id="<?= $item->id ?>" >
                                                        </td>
                                                        <td data-toggle="modal" data-target="#modal-ressource" title="modifier l'élément" onclick="modification('ressource', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td title="supprimer la ressource" onclick="suppressionWithPassword('ressource', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-5 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les types d'etiquette</h5>
                                        <div class="ibox-tools">
                                          
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Qté initial</th>
                                                    <th>Stk. init</th>
                                                    <th>Prix fixe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\ETIQUETTE::findBy([]) as $key => $item) {
                                                    $item->actualise();  ?>
                                                    <tr>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td class="text-center"><?= $item->initial; ?> unités</td>
                                                        <td width="90px">
                                                            <input type="text" title="Stock initial" number class="form-control input-xs text-center etiquette" step="0.1" value="<?= $item->initial ?>" name="initial" id="<?= $item->id ?>" >
                                                        </td>
                                                        <td width="90px">
                                                            <input type="text" title="Prix Unitaire normal" number class="form-control input-xs text-center etiquette" value="<?= $item->price ?>" name="price" id="<?= $item->id ?>">
                                                        </td>
                                                        <td title="supprimer la format d'etiquette" onclick="suppressionWithPassword('etiquette', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-4 bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Les zones de vente</h5>
                                        <div class="ibox-tools">
                                            <button class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-zonedevente">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Libéllé</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0; foreach (Home\ZONEDEVENTE::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                    <tr>
                                                        <td class="gras"><?= $item->name(); ?></td>
                                                        <td data-toggle="modal" data-target="#modal-zonedevente" title="modifier la zone de livraison" onclick="modification('zonedevente', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                        <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('zonedevente', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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