<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-9">
                    <h1 class="text-uppercase gras">Les boutiques de ventes</h1>
                    <div class="container">
                        <div class="row">

                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div style="margin-top: 3%">
                        <label>Selectionner la boutique en question</label>
                        <?php Native\BINDING::html("select", "boutique", $boutique, "id") ?>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                <div class="animated fadeInRightBig">

                    <div class=" border-bottom white-bg dashboard-header">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 60px;" alt=""><br>
                                <h2 class="text-uppercase"><?= $boutique->name() ?></h2>
                                <small><?= $boutique->lieu ?> </small>
                                <ul class="list-group clear-list m-t">
                                    <li class="list-group-item fist-item">
                                        Commandes en cours <span class="label label-success float-right"><?= start0(count($groupes__)); ?></span> 
                                    </li>
                                    <li class="list-group-item">
                                        Livraisons en cours <span class="label label-success float-right"><?= start0(count(Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "boutique_id ="=>$boutique->getId(), "typeprospection_id ="=>Home\TYPEPROSPECTION::LIVRAISON]))); ?></span> 
                                    </li>
                                    <li class="list-group-item">
                                        Prospections en cours <span class="label label-success float-right"><?= start0(count(Home\PROSPECTION::findBy(["etat_id ="=>Home\ETAT::ENCOURS, "boutique_id ="=>$boutique->getId(), "typeprospection_id ="=>Home\TYPEPROSPECTION::PROSPECTION]))); ?></span> 
                                    </li>
                                    <li class="list-group-item"></li>
                                </ul>
                                <button data-toggle=modal data-target="#modal-vente" class="btn btn-warning dim btn-block"> <i class="fa fa-long-arrow-right"></i> Nouvelle vente directe</button>

                                <button data-toggle="modal" data-target="#modal-prospection" class="btn btn-primary dim btn-block"><i class="fa fa-bicycle"></i> Nouvelle prospection</button>

                                <button data-toggle="modal" data-target="#modal-ventecave" class="btn btn-success dim btn-block"><i class="fa fa-home"></i> Nouvelle vente en cave</button>
                            </div>
                            <div class="col-md-6">
                                <div class="flot-chart" style="height: 250px">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div><hr>
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="">
                                            <span class="h5 font-bold block"><?= money(comptage(Home\VENTE::todayDirect($boutique->getId()), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Ventes directes</small>
                                        </div>
                                    </div>
                                    <div class="col border-right border-left">
                                        <span class="h5 font-bold block"><?= money(comptage(Home\PROSPECTION::effectuee(dateAjoute(), $boutique->getId()), "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                        <small class="text-muted block">Ventes par prospection</small>
                                    </div>
                                    <div class="col text-danger">
                                        <span class="h5 font-bold block"><?= money(Home\OPERATION::sortie(dateAjoute() , dateAjoute(+1), $boutique->getId())) ?> <small><?= $params->devise ?></small></span>
                                        <small class="text-muted block">Dépense du jour</small>
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
                        <hr><hr class="mp0"><br>

                        <div class="row">
                            <?php foreach ($produits as $key => $produit) { ?>
                                <div class="col-md border-right">
                                    <h6 class="text-uppercase text-center gras" style="color: <?= $produit->couleur; ?>">Stock de <?= $produit->name() ?></h6>
                                    <ul class="list-group clear-list m-t">
                                        <?php foreach ($tableau[$produit->getId()] as $key => $pdv) { ?>
                                            <li class="list-group-item <?= (!$pdv->rupture)?"rupture":""  ?>" >
                                                <i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <small><?= $pdv->quantite ?></small>          
                                                <span class="float-right">
                                                    <span title="en boutique" class="gras text-<?= ($pdv->boutique > 0)?"green":"danger" ?>"><?= money($pdv->boutique) ?></span>
                                                </span>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <br>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Programme de prospection du jour</h5>
                                    <div class="ibox-tools">
                                        <a href="<?= $this->url("gestion", "production", "programmes") ?>" data-toggle="tooltip" title="Modifier le programme">
                                            <i class="fa fa-calendar"></i> Modifier le programme
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content table-responsive">
                                    <table class="table table-hover no-margins">
                                        <thead>
                                            <tr>
                                                <th>Commercial</th>
                                                <th class="">Heure de sortie</th>
                                                <th class="">Total</th>
                                                <th class="">vendu</th>
                                                <th class="">heure de retour</th>
                                                <th class="">statut</th>
                                                <th class="">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (Home\PROSPECTION::programmee(dateAjoute()) as $key => $prospection) {
                                                $prospection->actualise(); ?>
                                                <tr>
                                                    <td><?= $prospection->commercial->name()  ?></td>
                                                    <td><?= heurecourt($prospection->created)  ?></td>
                                                    <td><?= money($prospection->montant) ?> <?= $params->devise ?></td>
                                                    <td class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise ?></td>
                                                    <td><?= heurecourt($prospection->dateretour)  ?></td>
                                                    <td class="text-center"><span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span> </td>
                                                    <td class="text-center">
                                                        <?php if ($prospection->etat_id == Home\ETAT::PARTIEL) { ?>
                                                            <button onclick="validerProg(<?= $prospection->getId() ?>)" class="cursor simple_tag pull-right"><i class="fa fa-file-text-o"></i> Faire la prospection</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <br>

                <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>

                <?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-ventecave.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-miseenboutique.php")); ?> 

            </div>
        </div>


        <?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

        <script type="text/javascript" src="<?= $this->relativePath("../../production/programmes/script.js") ?>"></script>
        <script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
        <script type="text/javascript" src="<?= $this->relativePath("../../production/miseenboutique/script.js") ?>"></script>

        <script>
            $(document).ready(function() {

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

                var dataset = [
                {
                    label: "Vente directe",
                    data: data1,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "left",
                        barWidth: 25 * 60 * 60 * 600,
                        lineWidth:0
                    }
                }, {
                    label: "Vente par prospection",
                    data: data2,
                    color: "#cc0000",
                    bars: {
                        show: true,
                        align: "right",
                        barWidth: 25 * 60 * 60 * 600,
                        lineWidth:0
                    }
                }
                ];


                var options = {
                    xaxis: {
                        mode: "time",
                        tickSize: [<?= $lot->nb  ?>, "day"],
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
                        position: "ne"
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

        <style type="text/css">
            @-webkit-keyframes clignoter {
                0%{background-color: rgba(255, 0, 0, 0.09)}
                50%{background-color: rgba(255, 0, 0, 0.09)}
            }

            .rupture{
                animation: clignoter 1s infinite;
            }
        </style>
    </body>

    </html>