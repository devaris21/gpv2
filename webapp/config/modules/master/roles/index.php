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

                           <div class="ibox border">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Personnes ayant accès et leur roles</h5>
                                <div class="ibox-tools">
                                    <a class="btn_modal" data-toggle="modal" data-target="#modal-employe">
                                        <i class="fa fa-plus"></i> Ajouter
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Utilisateur</th>
                                            <th>Identifiants</th>
                                            <th style="width: 40%">Accès et rôles</th>
                                            <th>Affiliation</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =0; foreach (Home\EMPLOYE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                            $item->actualise();  ?>
                                            <tr>
                                                <td>
                                                    <?php if ($item->is_allowed == 1) { ?>
                                                        <span class="label label-success">Actif</span>
                                                    <?php }else{ ?>
                                                        <span class="label label-danger">Bloqué</span>
                                                    <?php } ?>
                                                </td>
                                                <td >
                                                    <span class="gras text-uppercase"><?= $item->name() ?></span><br>
                                                    <span> <?= $item->email ?></span><br>
                                                    <span> <?= $item->adresse ?></span><br>
                                                    <span> <?= $item->contact ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($item->is_new == 1) { ?>
                                                        <span class="">Login: <?= $item->login ?></span><br>
                                                        <span class="">Pass: <?= $item->pass ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td class="" >
                                                    <div class="row">
                                                        <?php $datas = $item->fourni("role_employe");
                                                        $lots = [];
                                                        foreach ($datas as $key => $rem) {
                                                            $rem->actualise();
                                                            $lots[] = $rem->role->id; ?>
                                                            <div class="col-6 col-sm-4">
                                                                <label class="cursor"><input type="checkbox" class="i-checks" employe_id="<?= $rem->employe_id ?>" role_id="<?= $role->id ?>" checked name="<?= $rem->role->name() ?>"> <?= $rem->role->name() ?></label>
                                                            </div>
                                                        <?php } ?>
                                                        <?php foreach (Home\ROLE::getAll() as $key => $role) {
                                                            if (!in_array($role->id, $lots)) {
                                                                ?>
                                                                <div class="col-6 col-sm-4">
                                                                    <label class="cursor"><input type="checkbox" class="i-checks" employe_id="<?= $item->id ?>" role_id="<?= $role->id ?>" name="<?= $role->name() ?>"> <?= $role->name() ?></label>
                                                                </div>
                                                            <?php } 
                                                        } ?>  
                                                    </div>              
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <small>Selectionner la Boutique</small>
                                                        <select class="form-control select2" employe_id="<?= $rem->employe_id ?>" name="boutique_id" style="width: 100%">
                                                            <option value="">Aucune boutique</option>
                                                            <?php foreach (Home\BOUTIQUE::getAll() as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= ($rem->employe->boutique_id == $value->id)?"selected":"" ?>><?= $value->name() ?></option>
                                                            <?php } ?>
                                                        </select>                                       
                                                    </div>
                                                    <div class="form-group">
                                                        <small>Selectionner l'Entrepot</small>
                                                        <select class="form-control select2" employe_id="<?= $rem->employe_id ?>" name="entrepot_id" style="width: 100%">
                                                            <option value="">Aucun entrepot</option>
                                                            <?php foreach (Home\ENTREPOT::getAll() as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= ($rem->employe->entrepot_id == $value->id)?"selected":"" ?>><?= $value->name() ?></option>
                                                            <?php } ?>
                                                        </select>                                       
                                                    </div>
                                                </td>
                                                <td class="text-right">          
                                                    <button onclick="resetPassword('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-refresh text-blue"></i> Init. mot de passe</button><br>

                                                    <?php if ($item->is_allowed == 1) { ?>
                                                        <button onclick="lock('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-lock text-orange"></i> Bloquer</button>
                                                    <?php }else{ ?>
                                                        <button onclick="unlock('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-unlock text-green"></i> Débloquer</button>
                                                    <?php } ?>
                                                    <button data-toggle="modal" data-target="#modal-employe" class="btn btn-white btn-xs" onclick="modification('employe', <?= $item->id ?>)"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-white btn-xs" onclick="suppressionWithPassword('employe', <?= $item->id ?>)"><i class="fa fa-close text-red"></i></button>
                                                </td>
                                            </tr>
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

        <?php include($this->rootPath("composants/assets/modals/modal-employe.php") );  ?>


    </body>



    </html>