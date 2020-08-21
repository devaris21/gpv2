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
                                        <i class="fa fa-sign-out"></i> Déconnexion
                                    </li>
                                </ul>
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
                                                <td class="" width="400px">
                                                    <?php $datas = $item->fourni("role_employe");
                                                    $lots = [];
                                                    foreach ($datas as $key => $rem) {
                                                        $rem->actualise();
                                                        $lots[] = $rem->role->id; ?>
                                                        <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $rem->role_id ?>" class="btn btn-primary btn-xs refuser"><?= $rem->role->name() ?></button>
                                                        <?php } ?><hr class="mp3">

                                                        <?php foreach (Home\ROLE::getAll() as $key => $role) {
                                                            if (!in_array($role->id, $lots)) { ?>
                                                             <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $role->id ?>" class="btn btn-white btn-xs autoriser"><?= $role->name() ?></button>
                                                         <?php } } ?>                
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

                    <?php include($this->rootPath("webapp/master/elements/templates/footer.php")); ?>


                </div>
            </div>


            <?php include($this->rootPath("webapp/master/elements/templates/script.php")); ?>

            <?php include($this->rootPath("composants/assets/modals/modal-params.php") );  ?>


        </body>



        </html>