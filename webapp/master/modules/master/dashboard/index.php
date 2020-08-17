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
                      <div class="animated fadeInRightBig">

                        <div class=" border-bottom white-bg dashboard-header">
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 60px;" alt=""><br>
                                    <h2 class="text-uppercase"><?= $params->societe ?></h2>
                                    <small>Tableau de bord général </small>
                                    <ul class="list-group clear-list m-t">
                                        <li class="list-group-item fist-item">
                                            Commandes en cours <span class="label label-success float-right"><?= start0(count($groupes__)); ?></span> 
                                        </li>
                                        <li class="list-group-item">
                                            Livraisons en cours <span class="label label-success float-right"><?= start0(count(Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "typeprospection_id ="=>Home\TYPEPROSPECTION::LIVRAISON]))); ?></span> 
                                        </li>
                                        <li class="list-group-item">
                                            Prospections en cours <span class="label label-success float-right"><?= start0(count($prospections__)); ?></span> 
                                        </li>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                                <div class="col-md-6 border-left">
                                    <div class="text-center">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                        </div><hr>
                                        <span>Vente directe / vente par prospection</span>
                                    </div><hr>
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="">
                                                <span class="h5 font-bold block text-primary"><?= money(comptage(Home\VENTE::direct(dateAjoute(), dateAjoute()), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                                <small class="text-muted block">Ventes directes</small>
                                            </div>
                                        </div>
                                        <div class="col border-right border-left text-danger">
                                            <span class="h5 font-bold block"><?= money(comptage(Home\VENTE::prospection(dateAjoute(), dateAjoute()), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Ventes par prospection</small>
                                        </div>
                                        <div class="col text-blue">
                                            <span class="h5 font-bold block"><?= money(comptage(Home\VENTE::cave(dateAjoute(), dateAjoute()), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Ventes en cave</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 border-left">
                                    <div class="statistic-box" style="margin-top: 0%">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <h5>Courbe des ventes</h5>
                                                <div id="sparkline2"></div>
                                            </div>

                                            <div class="ibox-content">
                                                <h5>Dette chez les clients</h5>
                                                <h2 class="no-margins"><?= money(Home\CLIENT::Dettes()); ?> <?= $params->devise  ?></h2>
                                            </div>

                                            <div class="ibox-content">
                                                <h5>En rupture de Stock</h5>
                                                <h2 class="no-margins"><?= start0($rupture) ?> produit(s)</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div><br>


                        <div class="row justify-content-center">
                            <?php  if ($employe->boutique_id != null) { ?>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("boutique", "master", "dashboard")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h5 class="text-uppercase">Aller à ma boutique</h5>
                                                        <h3 class="no-margins text-orange"><?= $maBoutique->name() ?></h3>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <i class="fa fa-hospital-o fa-5x text-green"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($employe->entrepot_id != null) { ?>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("entrepot", "master", "dashboard")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h5 class="text-uppercase">Aller à mon entrepôt</h5>
                                                        <h3 class="no-margins text-orange"><?= $monEntrepot->name() ?></h3>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <i class="fa fa-bank fa-5x text-green"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($employe->isManager == Home\TABLE::OUI) { ?>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("manager", "master", "dashboard")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h5 class="text-uppercase">Aller à l'Espace Manager</h5>
                                                        <h3 class="no-margins text-dark">Admin générale</h3>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <i class="fa fa-pied-piper-alt fa-5x text-warning"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($employe->isAdmin == Home\TABLE::OUI) { ?>
                                <div class="col-lg-3">
                                    <a href="<?= $this->url("admin", "master", "dashboard")  ?>">
                                        <div class="ibox">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h5 class="text-uppercase">Espace Admin & Config</h5>
                                                        <h3 class="no-margins text-dark">Config technique</h3>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <i class="fa fa-gears fa-5x text-danger" style="color: #ddd"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                        </div>

                    </div>
                </div>

                <br>

                <?php include($this->rootPath("webapp/master/elements/templates/footer.php")); ?>


            </div>
        </div>


        <?php include($this->rootPath("webapp/master/elements/templates/script.php")); ?>

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