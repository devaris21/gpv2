<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">

                <div class=" border-bottom white-bg dashboard-header">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 60px;" alt=""><br>
                            <h2 class="text-uppercase"><?= $boutique->name() ?></h2>
                            <small><?= $boutique->lieu  ?> </small>
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
                            

                            <ul class="list-group clear-list">
                                <li class="list-group-item fist-item">
                                    Dettes de clients <span class=" float-right"><?= money(Home\CLIENT::Dettes()); ?> <?= $params->devise  ?></span> 
                                </li>
                                <li class="list-group-item">
                                    En rupture de stock <span class="float-right"><?= start0(count(Home\PRODUIT::ruptureBoutique($boutique->id))) ?> produit(s)</span> 
                                </li>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <div class="flot-chart" style="height: 240px">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div><hr>
                                <span>Vente directe / vente par prospection</span>
                            </div>
                        </div>
                        <div class="col-md-3 border-left">
                            <div class="statistic-box" style="margin-top: 0%">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Ventes directes du jour</h5>
                                        <h3 class="no-margins"><?= money(comptage(Home\VENTE::direct(dateAjoute(), dateAjoute(1), $boutique->id), "vendu", "somme")); ?> <?= $params->devise  ?></h3>
                                    </div>
                                    <div class="ibox-content text-green">
                                        <h5>Ventes par prospection du jour</h5>
                                        <h3 class="no-margins"><?= money(comptage(Home\VENTE::direct(dateAjoute(), dateAjoute(1), $boutique->id), "vendu", "somme")); ?> <?= $params->devise  ?></h3>
                                    </div>
                                    <div class="ibox-content text-blue">
                                        <h5>Ventes en cave du jour</h5>
                                        <h3 class="no-margins"><?= money(comptage(Home\VENTE::direct(dateAjoute(), dateAjoute(1), $boutique->id), "vendu", "somme")); ?> <?= $params->devise  ?></h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><hr>

                    <div class="text-center">
                        <button data-toggle=modal data-target="#modal-vente" class="btn btn-warning dim"> <i class="fa fa-long-arrow-right"></i> Nouvelle vente directe</button>

                        <button data-toggle="modal" data-target="#modal-prospection" class="btn btn-primary dim"><i class="fa fa-bicycle"></i> Nouvelle prospection</button> 

                        <button data-toggle="modal" data-target="#modal-ventecave" class="btn btn-success dim"><i class="fa fa-home"></i> Nouvelle vente en cave</button>
                    </div>
                    <br>
                </div>


            </div>
        </div>
        <br>

        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
        <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 
        <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 
        <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 
        <?php include($this->rootPath("composants/assets/modals/modal-ventecave.php")); ?> 

    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>

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
        color: "#0044cc",
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