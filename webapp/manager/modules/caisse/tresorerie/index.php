<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Trésorerie générale</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Tous vos comptes & banques</a>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <div class="wrapper wrapper-content">

                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary dim btn-block"><i class="fa fa-truck"></i> Bilan comptable </button>
                        <button class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Voir le budget prévisionnel </button>
                        <button class="btn btn-warning dim btn-block"><i class="fa fa-truck"></i> Documents de synthèse </button>
                        <button data-toggle="modal" data-target="#modal-cloture" class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Cloture de l'exercice </button>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <?php foreach (Home\COMPTEBANQUE::getAll() as $key => $banque) { ?>
                                <div class="col-lg-4">
                                    <a href="<?= $this->url("manager", "caisse", "caisse", $banque->id)  ?>" class="text-dark">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <h5><?= $banque->name() ?></h5>
                                                <h1 class="no-margins"><?= money($banque->solde(Home\PARAMS::DATE_DEFAULT, dateAjoute(1))) ?> <?= $params->devise ?></h1>
                                                <small><i class="fa fa-bank"></i> <?= $banque->etablissement ?> </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>




        <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>
        
    </body>

    </html>
