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
                                <a id="onglet-master" href="<?= $this->url("config", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px; margin-right: 10px;"><i class="fa fa-long-arrow-left"></i> Retour à l'acceuil</a>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig text-center container-fluid">
                            <img src="http://dummyimage.com/150x150/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image"><br>
                            <h1 class="display-4 gras">PAYIEL <small class="small text-uppercase" style="font-size: 28px;">Ingenieries</small></h1>
                            <h2><i>Vous allez maintenant aimer votre gestion !</i></h2>
                            <hr>
                            <h3 class="container">Dévéloppement informatique - Maintenance des systèmes informatiques & réseaux - Déploiement réseaux <br>
                             Assistance & Conseils - Intégrateur de solutions</h3>

                            <br><br><br>

                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "about")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-3 text-left">
                                                        <i class="fa fa-map-marker fa-5x text-muted"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <h4 class="text-uppercase gras text-orange">Situation géographique</h4>
                                                        <h5 class="no-margins text-muted">Rue Congo, Grand Bassam</h5>
                                                        <h5 class="no-margins text-muted">Côte d'Ivoire</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "about")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-3 text-left">
                                                        <i class="fa fa-clock-o fa-5x text-muted"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <h4 class="text-uppercase gras text-orange">Horaires de travail</h4>
                                                        <h5 class="no-margins text-muted">Lundi au Vendredi de 08h à 19h</h5>
                                                        <h5 class="no-margins text-muted">Samedi de 08h à 12h</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "about")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-3 text-left">
                                                        <i class="fa fa-phone fa-5x text-muted"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <h4 class="text-uppercase gras text-orange">Contacts Téléphoniques</h4>
                                                        <h5 class="no-margins text-muted">+225 01 79 30 00</h5>
                                                        <h5 class="no-margins text-muted">+225 59 57 33 07</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "about")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-3 text-left">
                                                        <i class="fa fa-envelope fa-5x text-muted"></i>
                                                    </div>
                                                    <div class="col-9">
                                                        <h4 class="text-uppercase gras text-orange">Courrier électronique</h4>
                                                        <h5 class="no-margins text-muted">info@payiel.com</h5>
                                                        <h5 class="no-margins text-muted">sav@payiel.com</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <?php include($this->rootPath("webapp/config/elements/templates/footer.php")); ?>


                </div>
            </div>


            <?php include($this->rootPath("webapp/config/elements/templates/script.php")); ?>

        </body>



        </html>