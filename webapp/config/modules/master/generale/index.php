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

                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Configuration des informations générales de la structure</h5>
                                </div>
                                <div class="ibox-content"><br>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span class="text-muted">Raison sociale ou nom de la société</span>
                                                    <h2 class="gras text-uppercase text-primary"><?= $params->societe ?></h2>
                                                </div>
                                            </div><br><br>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <span class="text-muted">Situation Géographique</span>
                                                    <h4><?= $params->adresse ?></h4>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="text-muted">Contacts</span>
                                                    <h4><?= $params->contact ?></h4>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="text-muted">Email</span>
                                                    <h4><?= $params->email ?></h4>
                                                </div>
                                            </div><br><br>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <span class="text-muted">Boite Postale</span>
                                                    <h4><?= $params->postale ?></h4>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="text-muted">Fax</span>
                                                    <h4><?= $params->fax ?></h4>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="text-muted">Devise</span>
                                                    <h4><?= $params->devise ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 border-left text-center">
                                            <h4 class="text-muted text-uppercase">Votre logo</h4>
                                            <img style="width: 240px" class="img-thumbnail" src="<?= $this->stockage("images", "societe", $params->image)  ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-footer text-right">
                                    <button onclick="modification('params', <?= $params->id ?>)" class="btn btn-primary dim " data-toggle="modal" data-target="#modal-params"><i class="fa fa-pencil"></i> Modifier les informations</button>
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


        </body>



        </html>