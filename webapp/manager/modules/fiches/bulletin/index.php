<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox"  >
                        <div class="ibox-content"  style="height: 36cm; background-image: url(<?= $this->stockage("images", "societe", "filigrane.png")  ?>) ; background-size: 50%; background-position: center center; background-repeat: no-repeat;">


                           <div>
                              <div class="row">
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-3">
                                            <img style="width: 120%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                        </div>
                                        <div class="col-9">
                                            <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                            <h5 class="mp0"><?= $params->adresse ?></h5>
                                            <h5 class="mp0"><?= $params->postale ?></h5>
                                            <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                            <h5 class="mp0">Email: <?= $params->email ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right">
                                    <h2 class="title text-uppercase gras text-blue">Bulletin de paye</h2>
                                    <h3 class="text-uppercase">N°<?= $paye->reference  ?></h3>
                                    <h5><?= datelong($paye->created)  ?></h5>  
                                    <h4><small>édité par :</small> <span class="text-uppercase"><?= $paye->employe->name() ?></span></h4>                                
                                </div>
                            </div><hr class="mp3">

                            <div class="row">
                                <div class="col-6">
                                    <h5><span>Début de période :</span> <span class="text-uppercase"><?= datecourt($paye->started) ?></span></h5> 
                                    <h5><span>Fin de période :</span> <span class="text-uppercase"><?= datecourt($paye->finished) ?></span></h5>  
                                    <h5><span>Durée de période :</span> <span><?= dateDiffe($paye->started, $paye->finished) ?> jours / Hors dimanches & jours fériés</span></h5>  
                                </div>

                                <div class="col-6 text-right">
                                    <h4><span class="text-uppercase"><?= $paye->commercial->name() ?></span></h4>
                                    <h5><span>Adresse :</span> <span class="text-capitalize"><?= $paye->commercial->adresse ?></span></h5> 
                                    <h5><span>Contact :</span> <span class="text-capitalize"><?= $paye->commercial->contact ?></span></h5> 
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-md-12">
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
                                            $index = $paye->started;
                                            while ($index <= $paye->finished) {
                                                if (!isJourFerie($index)) {
                                                    $nombre++;
                                                }
                                                $datas = $paye->commercial->vendu($index, $index);
                                                if (count($datas) > 0) {
                                                    $vendu = comptage($datas, "vendu", "somme"); ?>
                                                    <tr>
                                                        <td><?= datecourt($index); ?></td>
                                                        <td><?= start0(count($datas)); ?> prospections</td>
                                                        <td><?= money(comptage($datas, "montant", "somme")); ?> <?= $params->devise ?></td>
                                                        <td class="gras"><?= money($vendu); ?> <?= $params->devise ?></td>
                                                        <td>
                                                            <?php if ($paye->commercial->objectif <= $vendu) { ?>
                                                                <i class="fa fa-check text-green"></i>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                $index = dateAjoute1($index, 1);
                                            }  ?>   
                                            <tr style="height: 7px" />
                                            <tr style="height: 5px" />
                                            <tr>
                                                <td colspan="5">
                                                 <div class="row text-center">
                                                    <div class="col">
                                                        <div class="">
                                                            <span class="h6 font-bold block"><?= money(comptage($prospections, "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                                            <small class="text-muted block">Total sortie</small>
                                                        </div>
                                                    </div>
                                                    <div class="col text-green border-right border-left">
                                                        <br>
                                                        <span class="h5 font-bold block"><?= money(comptage($prospections, "vendu", "somme")); ?> <small><?= $params->devise ?></small></span>
                                                        <small class="text-muted block">Total vendu</small>
                                                    </div>
                                                    <div class="col border-right border-left">
                                                        <span class="h5 font-bold block"><?= round(((comptage($prospections, "vendu", "somme") / ($paye->commercial->objectif * $nombre)) * 100), 2) ; ?> %</span>
                                                        <small class="text-muted block">de l'objectif</small>
                                                    </div>
                                                    <div class="col text-blue  border-right">
                                                        <br>
                                                        <span class="h6 font-bold block"><?= money(comptage($prospections, "montant", "somme") / $nombre) ?> <small><?= $params->devise ?></small> / Jour</span>
                                                        <small class="text-muted block">Moyenne de vente</small>
                                                    </div>
                                                    <div class="col">
                                                        <span class="h6 font-bold block"><?= money($paye->commercial->objectif) ?> <small><?= $params->devise ?></small></span>
                                                        <small class="text-muted block">Objectif journalier</small>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                         
                                        <tr style="height: 10px" />
                                        <tr>
                                            <td rowspan="3" colspan="3"> 
                                                <div class="flot-chart">
                                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                                </div>
                                            </td>
                                            <td><h5 class="text-right text-uppercase gras">Salaire brut  </h5></td>
                                            <td><?= money($paye->mouvement->montant - $paye->bonus) ?> <small><?= $params->devise ?></small></td>
                                        </tr>
                                        <tr>
                                            <td><h5 class="text-right text-uppercase gras">Bonus sur la vente  </h5></td>
                                            <td><?= money($paye->bonus) ?> <small><?= $params->devise ?></small></td>
                                        </tr>
                                        <tr>
                                            <td><h3 class="text-right text-uppercase gras">Salaire net à payer </h3></td>
                                            <td><h2 class="gras"><?= money($paye->mouvement->montant) ?> <small><?= $params->devise ?></small></h2></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-7">

                            </div>
                            <div class="col-5">
                                <div class="text-right" style="margin-bottom: 30%">
                                    <span><u>Signature & Cachet</u></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <p class="text-center"><small><i>* Nous vous prions de vérifier l'exactitude de toutes les informations qui ont été mentionnées sur ce bulletin de paye !</i></small></p>

                </div>
            </div>

        </div>
    </div>


</div>


<?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>


</body>

</html>


<script>
    $(document).ready(function() {

        var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->vendu ?>], <?php } ?> ];

        var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $paye->commercial->objectif ?>], <?php } ?> ];


        var dataset = [
        {
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
                tickSize: [3, "day"],
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


<style type="text/css">
    .flot-chart{
        height: 120px;
    }
</style>