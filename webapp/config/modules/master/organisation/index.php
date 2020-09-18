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
                                <div class="col-sm-6 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Liste de vos boutiques</h5>
                                            <div class="ibox-tools">
                                                <a class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-boutique">
                                                    <i class="fa fa-plus"></i> Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Lieu</th>
                                                         <th>Compte attribué</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i =0; foreach (Home\BOUTIQUE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                        $item->actualise(); ?>
                                                        <tr>
                                                            <td class="gras"><?= $item->name(); ?></td>
                                                            <td><?= $item->lieu; ?></td>
                                                            <td class="gras"><?= $item->comptebanque->name(); ?></td>
                                                            <td>
                                                                <a href="<?= $this->url("config", "master", "adminboutique", $item->id)  ?>" class="btn_modal btn btn-xs btn-white">
                                                                    <i class="fa fa-wrench"></i> Admin
                                                                </a>
                                                            </td>
                                                            <td data-toggle="modal" data-target="#modal-boutique" title="modifier la categorie" onclick="modification('boutique', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer la categorie" onclick="suppressionWithPassword('boutique', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Liste de vos entrepôts</h5>
                                            <div class="ibox-tools">
                                                <a class="btn_modal btn btn-xs btn-white" data-toggle="modal" data-target="#modal-entrepot">
                                                    <i class="fa fa-plus"></i> Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Lieu</th>
                                                        <th>Compte attribué</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i =0; foreach (Home\ENTREPOT::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                        $item->actualise(); ?>
                                                        <tr>
                                                            <td class="gras"><?= $item->name(); ?></td>
                                                            <td><?= $item->lieu; ?></td>
                                                            <td class="gras"><?= $item->comptebanque->name(); ?></td>
                                                            <td>
                                                                <a href="<?= $this->url("config", "master", "adminentrepot", $item->id)  ?>" class="btn_modal btn btn-xs btn-white">
                                                                    <i class="fa fa-wrench"></i> Admin
                                                                </a>
                                                            </td>
                                                            <td data-toggle="modal" data-target="#modal-entrepot" title="modifier la categorie" onclick="modification('entrepot', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer la categorie" onclick="suppressionWithPassword('entrepot', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="ibox border">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Attribution des accès des boutiques et des usines</h5>
                                    <div class="ibox-tools">
                                       
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Utilisateur</th>
                                                <th style="width: 80%">Accès et rôles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =0; foreach (Home\EMPLOYE::findBy([], [], ["name"=>"ASC", "is_new"=>"ASC",]) as $key => $item) {
                                                $item->actualise();  ?>
                                                <tr>
                                                    <td >
                                                        <span class="gras text-uppercase"><?= $item->name() ?></span><br>
                                                        <span> <?= $item->email ?></span><br>
                                                        <span> <?= $item->adresse ?></span><br>
                                                        <span> <?= $item->contact ?></span>
                                                    </td>
                                                    <td class="" >
                                                        <div class="row">
                                                            <?php $datas = $item->fourni("acces_boutique");
                                                            $lots = [];
                                                            foreach ($datas as $key => $rem) {
                                                                $rem->actualise();
                                                                $lots[] = $rem->boutique->id; ?>
                                                                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                                    <label class="cursor"><input type="checkbox" class="i-checks boutique" employe_id="<?= $rem->employe_id ?>" boutique_id="<?= $rem->boutique->id ?>" checked name="<?= $rem->boutique->name() ?>"> <?= $rem->boutique->name() ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <?php foreach (Home\BOUTIQUE::getAll() as $key => $boutique) {
                                                                if (!in_array($boutique->id, $lots)) {
                                                                    ?>
                                                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                                        <label class="cursor"><input type="checkbox" class="i-checks boutique" employe_id="<?= $item->id ?>" boutique_id="<?= $boutique->id ?>" name="<?= $boutique->name() ?>"> <?= $boutique->name() ?></label>
                                                                    </div>
                                                                <?php } 
                                                            } ?>  
                                                        </div> <hr class="mp3"><hr class="mp3"> 

                                                        <div class="row">
                                                            <?php $datas = $item->fourni("acces_entrepot");
                                                            $lots = [];
                                                            foreach ($datas as $key => $rem) {
                                                                $rem->actualise();
                                                                $lots[] = $rem->entrepot->id; ?>
                                                                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                                    <label class="cursor"><input type="checkbox" class="i-checks entrepot" employe_id="<?= $rem->employe_id ?>" entrepot_id="<?= $rem->entrepot->id ?>" checked name="<?= $rem->entrepot->name() ?>"> <?= $rem->entrepot->name() ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <?php foreach (Home\ENTREPOT::getAll() as $key => $entrepot) {
                                                                if (!in_array($entrepot->id, $lots)) {
                                                                    ?>
                                                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                                        <label class="cursor"><input type="checkbox" class="i-checks entrepot" employe_id="<?= $item->id ?>" entrepot_id="<?= $entrepot->id ?>" name="<?= $entrepot->name() ?>"> <?= $entrepot->name() ?></label>
                                                                    </div>
                                                                <?php } 
                                                            } ?>  
                                                        </div>           
                                                    </td>
                                                </tr>
                                                <tr style="height: 20px"></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <br>

                    <?php include($this->rootPath("webapp/config/elements/templates/footer.php")); ?>


                </div>
            </div>


            <?php include($this->rootPath("webapp/config/elements/templates/script.php")); ?>

            <?php include($this->rootPath("composants/assets/modals/modal-params.php") );  ?>
            <?php include($this->rootPath("composants/assets/modals/modal-boutique.php") );  ?>
            <?php include($this->rootPath("composants/assets/modals/modal-entrepot.php") );  ?>


        </body>



        </html>