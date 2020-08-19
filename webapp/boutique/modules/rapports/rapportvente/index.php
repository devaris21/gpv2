<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="animated fadeInRightBig">

            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="float-left">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
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
                    <div class="row">
                        <div class="col-md-12 border-right border-left">
                            <div class="row">
                                <div class="col-sm-3 border-right">
                                    <h5 class="text-uppercase gras text-center">C.A. par parfum</h5>
                                    <ul class="list-group clear-list m-t">
                                        <?php foreach ($parfums as $key => $item) {  ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                                <i class=" float-right"><?= money($item->vendu) ?> <?= $params->devise ?></i>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <div class="flot-chart" style="height: 240px">
                                        <div class="flot-chart-content" id="flot-dashboard-chart" ></div>
                                    </div><hr class="mp3">
                                    <h2 class="mp0 gras"><?= money(comptage($quantites, "vendu", "somme"));  ?> <?= $params->devise ?> </h2>
                                    <span class="small">de Chiffre d'Affaire</span>
                                    <hr class="mp3">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="">
                                                <span class="h6 mp0 font-bold block text-primary"><?= money(comptage(Home\VENTE::direct($date1, $date2, $boutique->id), "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                                <small class="text-muted block">Ventes directes</small>
                                            </div>
                                        </div>
                                        <div class="col border-right border-left text-danger">
                                            <span class="h6 mp0 font-bold block"><?= money(comptage(Home\VENTE::prospection($date1, $date2, $boutique->id), "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Ventes par prospection</small>
                                        </div>
                                        <div class="col text-blue border-right">
                                            <span class="h6 mp0 font-bold block"><?= money(comptage(Home\VENTE::cave($date1, $date2, $boutique->id), "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Ventes en cave</small>
                                        </div>
                                        <div class="col text-warning">
                                            <span class="h6 mp0 font-bold block"><?= money(comptage(Home\VENTE::commande($date1, $date2, $boutique->id), "montant", "somme")); ?> <small><?= $params->devise ?></small></span>
                                            <small class="text-muted block">Commandes</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-left">
                                    <h5 class="text-uppercase gras text-center">C.A. par type de produit</h5>
                                    <ul class="list-group clear-list m-t">
                                        <?php foreach ($typeproduits as $key => $item) {  ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                                <i class=" float-right"><?= money($item->vendu) ?> <?= $params->devise ?></i>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>

                                    <ul class="list-group clear-list">
                                        <h5 class="text-uppercase gras text-center">C.A. par emballage</h5>
                                        <?php foreach ($quantites as $key => $item) {  ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                                <i class=" float-right"><?= money($item->vendu) ?> <?= $params->devise ?></i>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                            </div><hr style="border: dashed 1px orangered"> 
                        </div>
                    </div>
                    <div class="row text-center">
                     <div class="col-sm-3 col-md">
                        <canvas id="doughnutChart" width="150" height="150" style="margin: 18px auto 0"></canvas>
                        <h5 >Par parfum</h5>
                    </div>
                    <div class="col-sm-3 col-md">
                        <canvas id="doughnutChart1" width="150" height="150" style="margin: 18px auto 0"></canvas>
                        <h5 >Par type de produit</h5>
                    </div>
                    <div class="col-sm-3 col-md">
                        <canvas id="doughnutChart2" width="150" height="150" style="margin: 18px auto 0"></canvas>
                        <h5 >par emballage</h5>
                    </div>
                    <div class="col-sm-3 col-md">
                        <canvas id="doughnutChart3" width="150" height="150" style="margin: 18px auto 0"></canvas>
                        <h5 >par type de vente</h5>
                    </div>
                </div><hr style="border: dashed 1px green">

                <div class="row">
                    <?php foreach ($parfums as $key => $parfum) { ?>
                        <div class="col-md border-right">
                            <h6 class="text-uppercase text-center gras" style="color: "><?= $parfum->name();  ?></h6>
                            <ul class="list-group clear-list m-t">
                                <?php foreach ($typeproduits as $key => $type) { ?>
                                    <li class="list-group-item" style="padding-bottom: 5px">
                                        <small><?= $type->name();  ?></small>          
                                        <small class="gras float-right"><?= money(Home\PRODUIT::totalVendu($date1, $date2, $boutique->id, $parfum->id, $type->id)) ?></small>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


    </div>

    <br><br>
    <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>



<script>
    $(document).ready(function() {

        var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->total ?>], <?php } ?> ];

        var dataset = [
        {
            label: "Evolution du chiffre d'affaire",
            data: data1,
            color: "#1ab394",
            lines: {
                lineWidth:1,
                show: true,
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

        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var doughnutData = {
            labels: [<?php foreach ($parfums as $key => $item) { echo "'".$item->name()."', "; } ?>],
            datasets: [{
                data: [<?php foreach ($parfums as $key => $item) { echo "'".$item->vendu."', "; } ?>],
                backgroundColor: [<?php foreach ($parfums as $key => $item) { echo "'".$faker->hexColor()."', "; } ?>],
            }]
        } ;

        var doughnutData1 = {
            labels: [<?php foreach ($typeproduits as $key => $item) { echo "'".$item->name()."', "; } ?>],
            datasets: [{
                data: [<?php foreach ($typeproduits as $key => $item) { echo "'".$item->vendu."', "; } ?>],
                backgroundColor: [<?php foreach ($typeproduits as $key => $item) { echo "'".$faker->hexColor()."', "; } ?>],
            }]
        } ;


        var doughnutData2 = {
            labels: [<?php foreach ($quantites as $key => $item) { echo "'".$item->name()."', "; } ?>],
            datasets: [{
                data: [<?php foreach ($quantites as $key => $item) { echo "'".$item->vendu."', "; } ?>],
                backgroundColor: [<?php foreach ($quantites as $key => $item) { echo "'".$faker->hexColor()."', "; } ?>],
            }]
        } ;


        var doughnutData3 = {
            labels: ["Vente Directe", "Prospection", "Vente Cave", "Commandes"],
            datasets: [{
                data: [<?= comptage(Home\VENTE::direct($date1, $date2, $boutique->id), "montant", "somme")?>, <?= comptage(Home\VENTE::prospection($date1, $date2, $boutique->id), "montant", "somme")?>, <?= comptage(Home\VENTE::cave($date1, $date2, $boutique->id), "montant", "somme")?>, <?= comptage(Home\VENTE::commande($date1, $date2, $boutique->id), "montant", "somme")?>],
                backgroundColor: [<?php for ($i =0; $i < 4; $i++) { echo "'".$faker->hexColor()."', "; } ?>],
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


        var ctx4 = document.getElementById("doughnutChart1").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData1, options:doughnutOptions});


        var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData2, options:doughnutOptions});

        var ctx4 = document.getElementById("doughnutChart3").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData3, options:doughnutOptions});

    });
</script>



</body>

</html>
