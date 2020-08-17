<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
                                </div>
                                <div class="col-8">
                                    <form id="formFiltrer" method="POST">
                                        <div class="row" style="margin-top: -1%">
                                            <div class="col-5">
                                                <input type="date" value="<?= $date1 ?>" class="form-control input-sm" name="date1">
                                            </div>
                                            <div class="col-5">
                                                <input type="date" value="<?= $date2 ?>" class="form-control input-sm" name="date2">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" onclick="filtrer()" class="btn btn-sm btn-white"><i class="fa fa-search"></i> Filtrer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-dashboard-chart" height="700px"></div>
                            </div><hr>
                            <div class="row text-center">
                                <div class="col">
                                    <div class="">
                                        <span class="h6 font-bold block"><?= money(comptage($lesprospections, "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                        <small class="text-muted block">Total sortie</small>
                                    </div>
                                </div>
                                <div class="col text-green border-right border-left">
                                    <br>
                                    <span class="h5 font-bold block"><?= money(comptage($lesprospections, "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                    <small class="text-muted block">Total vendu</small>
                                </div>
                                <div class="col border-right border-left">
                                    <span class="h3 font-bold block"><?= ($commercial->objectif == 0) ? 0 : round(((comptage($lesprospections, "vendu", "somme") / ($commercial->objectif * $nombre)) * 100), 2) ; ?> %</span>
                                    <small class="text-muted block">de l'objectif</small>
                                </div>
                                <div class="col text-blue  border-right">
                                    <br>
                                    <span class="h6 font-bold block"><?= (dateDiffe($date1, $date2) > 0)?money(comptage($lesprospections, "vendu", "somme") / dateDiffe($date1, $date2)):0 ?> <small><?= $params->devise ?></small> / Jour</span>
                                    <small class="text-muted block">Moyenne de vente</small>
                                </div>
                                <div class="col text-danger">
                                    <span class="h6 font-bold block"><?= money(comptage($lesprospections, "transport", "somme")) ?> <small><?= $params->devise ?></small></span>
                                    <small class="text-muted block">Frais de Transport</small>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="ibox">
                       <div class="ibox-content">
                        <p></p>
                        <div class="">                                
                           <ul class="nav nav-tabs text-uppercase">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Toutes les prospections</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-file-text"></i> Rapports journaliers</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-money"></i> Payement de salaire</a></li>
                        </ul>
                        <div class="tab-content" style="min-height: 300px;">

                            <?php if ($employe->isAutoriser("production")) { ?>
                                <div id="tab-1" class="tab-pane active"><br>                                    
                                    <div class="row container-fluid">
                                        <button type="button" data-toggle=modal data-target='#modal-prospection_' class="btn btn-warning btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvel prospection </button>
                                        <button type="button" data-toggle=modal data-target='#modal-ventecave_' class="btn btn-success btn-sm dim float-right"><i class="fa fa-plus"></i> Vente en cave </button>
                                    </div><hr>
                                    <div class="">
                                        <?php if (count($prospections) > 0) { ?>

                                            <table class="table table-hover table-vente">
                                                <thead>
                                                    <tr>
                                                        <th class="">statut</th>
                                                        <th>Reference</th>
                                                        <th class="">Départ</th>
                                                        <th class="">Total</th>
                                                        <th class="">vendu</th>
                                                        <th class="">Arrivée</th>
                                                        <th class="">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($prospections as $key => $prospection) {
                                                        $prospection->actualise(); 
                                                        $prospection->fourni("ligneprospection");
                                                        ?>
                                                        <tr class="<?= ($prospection->etat_id != Home\ETAT::ENCOURS)?'fini':'' ?> border-bottom" style="border-bottom: 2px solid black">
                                                            <td>
                                                                <span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span>
                                                            </td>
                                                            <td class="project-title">
                                                                <h4 class="text-uppercase">N°<?= $prospection->reference ?></h4>
                                                                <h6 class="text-uppercase text-muted"> <?= $prospection->zonedevente->name() ?></h6>
                                                            </td>
                                                            <td><?= depuis($prospection->created) ?></td>
                                                            <td><?= depuis($prospection->dateretour) ?></td>
                                                            <td><?= money($prospection->montant) ?> <?= $params->devise ?></td>
                                                            <td class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise ?></td>
                                                            <td style="width: 12%">
                                                                <div class="btn-group">
                                                                    <a href="<?= $this->url("gestion", "fiches", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-xs btn-white cursor"><i class="fa fa-file-text text-blue"></i></a>
                                                                    <button type="button" onclick="terminer(<?= $prospection->id ?>)" class="btn btn-xs btn-white cursor"><i class="fa fa-check"></i></button>

                                                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                                        <button type="button" onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-xs btn-white cursor"><i class="fa fa-close text-red"></i></button>
                                                                    <?php } ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php  } ?>
                                                </tbody>
                                            </table><hr>
                                        <?php  }else{ ?>
                                            <h2 style="margin-top: 15% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune prospection encore pour ce commercial !</h2>
                                        <?php } ?>

                                    </div>
                                </div>

                            <?php } ?>


                            <div id="tab-2" class="tab-pane"><br>
                              <table class="table table-bordered table-striped text-center">
                                <thead class="text-capitalize" style="background-color: #dfdfdf">
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th>Nbr prospections</th>
                                        <th class="">Total</th>
                                        <th class="" colspan="2">vendu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $nombre = 0;
                                    $index = $date1;
                                    while ($index <= $date2) {
                                        if (!isJourFerie($index)) {
                                            $nombre++;
                                        }
                                        $datas = $commercial->vendu($index, $index);
                                        if (count($datas) > 0) {
                                            $vendu = comptage($datas, "vendu", "somme"); ?>
                                            <tr>
                                                <td><?= datecourt($index); ?></td>
                                                <td><?= start0(count($datas)); ?> prospections</td>
                                                <td><?= money(comptage($datas, "montant", "somme")); ?> <?= $params->devise ?></td>
                                                <td class="gras"><?= money($vendu); ?> <?= $params->devise ?></td>
                                                <td>
                                                    <?php if ($commercial->objectif <= $vendu) { ?>
                                                        <i class="fa fa-check text-green"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php }
                                        $index = dateAjoute1($index, 1);
                                    }  ?>              
                                </tbody>
                            </table>                
                        </div>



                        <?php if ($employe->isAutoriser("caisse")) { ?>
                            <div id="tab-3" class="tab-pane"><br>
                                <?php foreach ($payes as $key => $transaction) {
                                    $transaction->actualise(); ?>
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                                                <i data-toggle="tooltip" tiitle="Imprimer le bon" class="fa fa-file-text"></i>
                                                <?= heurecourt($transaction->created) ?>
                                                <br/>
                                                <small class="text-navy"><?= datecourt($transaction->created) ?></small>
                                            </div>
                                            <div class="col-10 content">
                                                <p>
                                                    <span class="">Paye de commercial N°<strong><?= $transaction->reference ?></strong></span>
                                                    <span class="pull-right text-right">
                                                        <span class="gras" style="font-size: 16px"><?= money($transaction->mouvement->montant) ?> <?= $params->devise ?></span><br>
                                                        <small>Par <?= $transaction->modepayement->name() ?></small><br>
                                                        <a href="<?= $this->url("gestion", "fiches", "bulletin", $transaction->id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Voir bulletin</a>
                                                    </span>
                                                </p>
                                                <p class="m-b-xs"><?= $transaction->comment ?> </p>
                                                <p class="m-b-xs"><?= $transaction->structure ?> - <?= $transaction->numero ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>                 
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-4">
        <div class="ibox selected">
            <div class="ibox-content">
                <div>
                    <?php Native\BINDING::html("select", "commercial", $commercial, "id") ?>
                </div><hr>

                <div id="contact-1" class="tab-pane active">
                    <h2><?= $commercial->name() ?> 

                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                        <i onclick="modification('commercial', <?= $commercial->id ?>)" data-toggle="modal" data-target="#modal-commercial" class="pull-right fa fa-pencil cursor"></i>
                    <?php } ?>
                </h2>
                <address>
                    <i class="fa fa-phone"></i>&nbsp; <?= $commercial->contact ?><br>
                    <i class="fa fa-map-marker"></i>&nbsp; <?= $commercial->adresse ?><br>
                </address><hr>

                <div class="m-b-lg">
                    <span>Salaire mensuel fixe si objectif atteint</span><br>
                    <h2 class="font-bold d-inline"><?= money($commercial->salaire) ?> <?= $params->devise  ?></h2> 
                    <i onclick="modification('commercial', <?= $commercial->id ?>)" data-toggle="modal" data-target="#modal-salaire" class="fa fa-pencil fa-2x pull-right cursor"></i>
                    <br><br>

                    <span>Objectif journalier</span><br>
                    <h3 class="font-bold text-muted"><?= money($commercial->objectif) ?> <?= $params->devise  ?></h3>     
                </div>
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-6 text-left">
                    <span>Arriérés de salaire</span><br>
                    <h2 class="font-bold text-warning"><?= money($commercial->arrieres()) ?> <?= $params->devise  ?></h2>
                </div>
            </div> <br>

            <div class="row">
                <div class="col-6 text-left">
                    <span>Salaire à payer ce mois</span><br>
                    <h3 class="font-bold text-blue"><?= money($commercial->salaireDuMois()) ?> <?= $params->devise  ?></h3>
                </div>
                <div class="col-6 text-right">
                    <span>Bonus du mois</span><br>
                    <h3 class="font-bold text-primary"><?= money($commercial->bonus()) ?> <?= $params->devise  ?></h3>
                </div>
            </div> <hr>

            <div class="row">
                <div class="col-7 text-left">
                    <span>Salaire net à payer</span><br>
                    <h2 class="font-bold text-blue"><?= money($commercial->salaireNet()) ?> <?= $params->devise  ?></h2>
                </div>
                <div class="col-5 text-right">
                    <?php if ($commercial->salaireNet() > 0) { ?>
                        <button style="font-size: 11px" type="button" data-toggle="modal" data-target="#modal-commercial-paye" class="btn btn-success dim btn-block"><i
                            class="fa fa-money"></i> Payer le salaire
                        </button>
                    <?php } ?>  
                </div>
            </div> <br>


        </div>
    </div>
</div>
</div>
</div>



<?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

<?php include($this->rootPath("composants/assets/modals/modal-commercial.php")); ?>   
<?php include($this->rootPath("composants/assets/modals/modal-commercial-paye.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-prospection_.php")); ?>  

<?php 
foreach ($prospections as $key => $prospection) {
   $prospection->actualise();
   $prospection->fourni("ligneprospection");
   include($this->rootPath("composants/assets/modals/modal-prospection2.php"));
} 
?>

</div>
</div>


<div class="modal inmodal fade" id="modal-salaire">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Salaire</h4>
            </div>
            <form method="POST" class="formShamman" classname="commercial">
                <div class="modal-body">
                    <div class="">
                        <label>Nouveau salaire <span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="salaire" required>
                        </div>
                    </div><br>
                    <div class="">
                        <label>Objectif journalier <span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="objectif" required>
                        </div>
                    </div>                  
                </div><hr>

                <div class="container">
                    <input type="hidden" name="id">
                    <button class="btn btn-sm dim btn-success pull-right"><i class="fa fa-check"></i> Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
<script type="text/javascript" src="<?= $this->relativePath("../../ventes/prospections/script.js") ?>"></script>


<script>
    $(document).ready(function() {

        var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->vendu ?>], <?php } ?> ];

        var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $commercial->objectif ?>], <?php } ?> ];


        var dataset = [
        {
            label: "Vente par prospection",
            data: data1,
            color: "#1ab394",
            bars: {
                show: true,
                align: "center",
                barWidth: 24 * 60 * 60 * 600,
                lineWidth:0
            }

        }, {
            label: "",
            data: data2,
            yaxis: 1,
            color: "#cc0000",
            lines: {
                lineWidth:1,
                show: true,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.4
                    }]
                }
            },
            splines: {
                show: false,
                tension: 0.6,
                lineWidth: 1,
                fill: 0.1
            },
        }
        ];


        var options = {
            xaxis: {
                mode: "time",
                tickSize: [1, "day"],
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
            }, {
                position: "right",
                clolor: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: ' Arial',
                axisLabelPadding: 67
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
