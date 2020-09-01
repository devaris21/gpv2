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
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig">

                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <a href="<?= $this->url("config", "master", "generale")  ?>">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <h2 class="text-uppercase gras">Infos générales</h2>
                                                            <h5 class="no-margins text-orange">Nom, adresse, contact, logo de sté </h5>
                                                        </div>
                                                        <div class="col-3 text-right">
                                                            <i class="fa fa-hospital-o fa-5x text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <?php if ($employe->isAutoriser("roles")) { ?>
                                        <div class="col-lg-4">
                                            <a href="<?= $this->url("config", "master", "roles")  ?>">
                                                <div class="ibox">
                                                    <div class="ibox-content">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <h2 class="text-uppercase gras">Roles & accès</h2>
                                                                <h5 class="no-margins text-orange">Définir les droits et les accès</h5>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="fa fa-lock fa-5x text-muted"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <?php if ($employe->isAutoriser("mycompte")) { ?>
                                        <div class="col-lg-4">
                                            <a href="<?= $this->url("manager", "master", "dashboard")  ?>">
                                                <div class="ibox">
                                                    <div class="ibox-content">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <h2 class="text-uppercase gras">Mon compte</h2>
                                                                <h5 class="no-margins text-orange">Info compte, Abonnement, formule</h5>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="fa fa-pied-piper-alt fa-5x text-muted"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div><hr><hr><br>



                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "production")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <h3 class="text-uppercase gras text-navy">Elements de production</h3>
                                                        <h5 class="no-margins text-muted">Produits, ressources, formats d'emballages</h5>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="fa fa-bitbucket fa-5x text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "production2")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <h3 class="text-uppercase gras text-navy">Gestion de production</h3>
                                                        <h5 class="no-margins text-muted">Etablir les normes de production</h5>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="fa fa-fire fa-5x text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "caisse")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <h3 class="text-uppercase gras text-navy">Config de la caisse</h3>
                                                        <h5 class="no-margins text-muted">Compte en banque, caisse, gestion</h5>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="fa fa-dollar fa-5x text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div><br>



                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "production")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <h3 class="text-uppercase gras text-navy">Historiques des actions</h3>
                                                        <h5 class="no-margins text-muted">Toutes les interactions de l'app</h5>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="fa fa-history fa-5x text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("config", "master", "caisse")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <h3 class="text-uppercase gras text-navy">à propos de nous</h3>
                                                        <h5 class="no-margins text-muted">En savoir plus sur Devaris21</h5>
                                                    </div>
                                                    <div class="col-3 text-right">
                                                        <i class="fa fa-info fa-5x text-muted"></i>
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

            <script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
            <script type="text/javascript" src="<?= $this->relativePath("../../production/miseenboutique/script.js") ?>"></script>

            <script>
                $(document).ready(function() {

                    var id = "<?= $this->id;  ?>";
                    if (id == 1) {
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            toastr.success('Content de vous revoir de nouveau!', 'Bonjour <?= $employe->name(); ?>');
                        }, 1300);
                    }



                    var sparklineCharts = function(){

                       $("#sparkline2").sparkline([24, 43, 43, 55, 44, 62, 44, 72], {
                           type: 'line',
                           width: '100%',
                           height: '60',
                           lineColor: '#1ab394',
                           fillColor: "#ffffff"
                       });

                   };

                   var sparkResize;

                   $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineCharts, 500);
                });

                   sparklineCharts();




                   var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->direct ?>], <?php } ?> ];

                   var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->prospection ?>], <?php } ?> ];

                   var data3 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->cave ?>], <?php } ?> ];

                   var dataset = [
                   {
                    label: "Vente directe",
                    data: data1,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "left",
                        barWidth: 12 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Vente par prospection",
                    data: data2,
                    color: "#cc0000",
                    bars: {
                        show: true,
                        align: "right",
                        barWidth: 12 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Vente en cave",
                    data: data3,
                    color: "#0088cc",
                    bars: {
                        show: true,
                        align: "right",
                        barWidth: 12 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }
                ];


                var options = {
                    xaxis: {
                        mode: "time",
                        tickSize: [2, "day"],
                        tickLength: 0,
                        axisLabel: "Date",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 10,
                        color: "#d5d5d5"
                    },
                    yaxes: [{
                        position: "left",
                        color: "#d5d5d5",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 3
                    }
                    ],
                    legend: {
                        noColumns: 1,
                        labelBoxBorderColor: "#000000",
                        position: "nw"
                    },
                    grid: {
                        hoverable: false,
                        borderWidth: 0
                    }
                };

                function gd(year, month, day) {
                    return new Date(year, month - 1, day).getTime();
                }

                var previousPoint = null, previousLabel = null;

                $.plot($("#flot-dashboard-chart"), dataset, options);



            });
        </script>

    </body>



    </html>