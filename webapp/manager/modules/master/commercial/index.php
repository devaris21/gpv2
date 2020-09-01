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
                            <h5 class="">Du <?= datecourt2($date1) ?> au <?= datecourt2($date2) ?></h5>
                            <div class="ibox-tools">
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
                                <div id="tab-1" class="tab-pane active">
                                    <br>
                                    <div class="">
                                     <?php if (count($prospections + $encours) > 0) { ?>
                                        <table class="footable table table-stripped toggle-arrow-tiny">
                                            <thead>
                                                <tr>
                                                    <th data-toggle="true">Status</th>
                                                    <th>Reference</th>
                                                    <th></th>
                                                    <th>Montant</th>
                                                    <th data-hide="all"></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($encours as $key => $prospection) {
                                                    $prospection->actualise(); 
                                                    $prospection->fourni("ligneprospection");
                                                    ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Prospection</span><br>
                                                            <span><?= $prospection->reference ?></span>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-uppercase text-muted" style="margin: 0">Zone de prospection :  <?= $prospection->zonedevente->name() ?></h6>
                                                            <small><?= depuis($prospection->created) ?></small>
                                                        </td>
                                                        <td>
                                                            <h3 class="gras text-orange"><?= money($prospection->montant) ?> <?= $params->devise  ?></h3>
                                                        </td>
                                                        <td class="border-right">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="no">
                                                                        <th></th>
                                                                        <?php foreach ($prospection->ligneprospections as $key => $ligne) {
                                                                            $ligne->actualise(); ?>
                                                                            <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                                                <small><?= $ligne->emballage->name() ?></small>
                                                                            </th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="no">
                                                                        <td><h4 class="mp0">Qté : </h4></td>
                                                                        <?php foreach ($prospection->ligneprospections as $key => $ligne) { ?>
                                                                            <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                                        <?php   } ?>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $this->url("fiches", "master", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>                                        
                                                            <?php if ($prospection->etat_id == Home\ETAT::ENCOURS) { ?>
                                                                <button onclick="terminer(<?= $prospection->id ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>
                                                            <?php } ?>
                                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                                <button onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>

                                                <tr />

                                                <?php foreach ($prospections as $key => $prospection) {
                                                    $prospection->actualise(); 
                                                    $prospection->fourni("ligneprospection");
                                                    ?>
                                                    <tr style="border-bottom: 2px solid black">
                                                        <td class="project-status">
                                                            <span class="label label-<?= $prospection->etat->class ?>"><?= $prospection->etat->name ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-uppercase gras">Prospection</span><br>
                                                            <span><?= $prospection->reference ?></span>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-uppercase text-muted">Zone de prospection :  <?= $prospection->zonedevente->name() ?></h6>
                                                            <small>Validé <?= depuis($prospection->dateretour) ?></small>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                <span class="gras text-orange"><?= money($prospection->montant) ?> <?= $params->devise  ?></span> -
                                                                <span class="gras text-green"><?= money($prospection->vendu) ?> <?= $params->devise  ?></span>
                                                            </h4>
                                                        </td>
                                                        <td class="border-right">
                                                           <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="no">
                                                                    <th></th>
                                                                    <?php foreach ($prospection->ligneprospections as $key => $ligne) {
                                                                        $ligne->actualise(); ?>
                                                                        <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                                            <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                                            <small><?= $ligne->emballage->name() ?></small>
                                                                        </th>
                                                                    <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="no">
                                                                    <td><h4 class="mp0">Qté : </h4></td>
                                                                    <?php foreach ($prospection->ligneprospections as $key => $ligne) { ?>
                                                                        <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                                    <?php   } ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $this->url("fiches", "master", "bonsortie", $prospection->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                            <button onclick="annulerProspection(<?= $prospection->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php }else{ ?>
                                    <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune prospection en cours pour le moment !</h1>
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
                                                <a href="<?= $this->url("fiches", "master", "bulletin", $transaction->id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Voir bulletin</a>
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
