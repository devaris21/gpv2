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
                                <a id="onglet-master" href="<?= $this->url("master", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px; margin-right: 10px;"><i class="fa fa-long-arrow-left"></i> Retour à l'acceuil</a>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper wrapper-content">
                        <div class=" animated fadeInRightBig">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Licence AMB</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <h2 class="no-margins text-uppercase"><?= Native\SHAMMAN::getConfig("metadata", "licence") ?></h2>
                                            <small>Version <?= Native\SHAMMAN::getConfig("metadata", "version") ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Identifiant</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <h2 class="no-margins"><?= $mycompte->identifiant ?></h2>
                                            <small>Votre identifiant unique</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Bugs et Suggestions</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <h2 class="no-margins"><?= start0(count(Home\SUGGESTION::getAll()))  ?></h2>
                                            <small>signalés</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12 cursor" data-toggle="modal" data-target="#modal-abonnement">
                                    <div class="ibox">
                                        <div class="ibox-title">
                                            <h5>Expiration</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <h2 class="no-margins"><?= datecourt($mycompte->expired) ?></h2>
                                            <div class="stat-percent font-bold "><?= start0(round(dateDiffe(Date("Y-m-d"), $mycompte->expired)))  ?> <i class="fa fa-calendar"></i></div>
                                            <small>Nombre de jours restants</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Rapport d'utilisation de la plateforme</h5>
                                            <div class="float-right">
                                                <div class="btn-group">
                                        <!-- <button type="button" class="btn btn-xs btn-white active">Today</button>
                                        <button type="button" class="btn btn-xs btn-white">Monthly</button>
                                        <button type="button" class="btn btn-xs btn-white">Annual</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <ul class="stat-list">
                                            <li>
                                                <h2 class="no-margins"><?= $personnelle ?> Utilisateurs</h2>
                                                <small>Personnes actuellement connectées</small>
                                                <div class="stat-percent"><?= $nbre_connecte ?> <i class="fa fa-level-up text-navy"></i></div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 48%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins "><?= $flux_total ?> Flux Totaux</h2>
                                                <small>Flux journalier de données</small>
                                                <div class="stat-percent"><?= $flux_jour ?> <i class="fa fa-level-down text-navy"></i></div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 60%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">9,180</h2>
                                                <small>Monthly income from orders</small>
                                                <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 22%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">9,180</h2>
                                                <small>Monthly income from orders</small>
                                                <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 22%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <?php include($this->rootPath("webapp/config/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/config/elements/templates/script.php")); ?>

<div class="modal inmodal fade" id="modal-abonnement">
    <div class="modal-dialog modal-xll">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Renouvellement de l'abonnement</h4>
                <small class="font-bold">Plus d'information sur <a href="http://www.devari.com/webservice/">http://www.devari.com/webservice/</a></small>
            </div>
            <div class="modal-body">
                <div class="ibox ">
                    <div class="ibox-content text-center css-animation-box">

                        <div class="row">
                            <div class="col-sm-5 border-right">
                                <h4 class="m-b-lg text-center text-uppercase">Quelques points importants</h4>
                                <div id="animation_box text-left" class="animated">
                                    <dl class="text-left">
                                        <dt>Le code de validation</dt>
                                        <dd>Pour renouveller votre abonnement, il vous faut obligatoirement un code de validation composé de 5 blocs de caractères.<br> Pour vous en procurer, veuillez <a href="">nous contacter</a> !</dd><br>

                                        <dt>Internet est requis</dt>
                                        <dd>La validation du code requiert une connexion à internet. veuillez vous assurer d'en avoir avant de commencer.</dd><br>

                                        <dt>3 tentavives</dt>
                                        <dd>Vous n'aurez droit qu'à un maximum de 4 tentatives pour valider votre code. Si vous échouez 3 fois de suite, l'application se vérouillera automatiquement. Vous devriez alors <a href="">nous contacter</a> pour dévérouillez l'apllication !</dd><br>

                                        <dt>Besoin d'aide ?</dt>
                                        <dd>Si vous ne savez pas comment vous y prendre ou si vous avez besoin d'une aide ou d'une assistance particulière, veuillez <a href="">nous contacter</a> !</dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="col-lg-7 animation-efect-links text-center">
                                <br><br>
                                <div>
                                    <span>Fin d'abonnement le</span>
                                    <h2 class="text-uppercase" style="font-size: 32px"><?= datecourt($mycompte->expired) ?></h2>
                                    <h3 class="text-red"><?= start0(dateDiffe(dateAjoute(), $mycompte->expired)) ?> jours restants</h3>
                                </div><br><br>
                                <h4 class="m-b-lg text-uppercase">
                                    Entrez les 5 blocs de caractères qui composent <br><br>votre code de validation.
                                </h4>
                                <form id="formAbonnement" method="post">
                                    <div class="row">
                                        <div class="col-sm">
                                            <input type="text" name="bloc1" maxlength="5" uppercase autofocus="on" class="text-center gras form-control input-sm" name="">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" name="bloc2" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" name="bloc3" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" name="bloc4" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" name="bloc5" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
                                        </div>
                                    </div><br><hr>
                                    <div>
                                        <button class="btn btn-primary dim"><i class="fa fa-check"></i> Valider le code !</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div><div class="modal fade" id="modal-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                <p>One fine body&hellip;</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>

</html>
