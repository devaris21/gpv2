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
                    <div class="float-right">
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
                                    <ul class="list-group clear-list m-t">
                                        <?php for($i = 0; $i < 4; $i++) { ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span>Confiture</span>          
                                                <span class="gras float-right"><?= money(458000) ?></span>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <div class="flot-chart">
                                        <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                    </div><hr>
                                    <h1>458000 <sup>Fcaf</sup> <span>de C.A</span></h1>
                                </div>
                                <div class="col-sm-3 border-left">
                                    <ul class="list-group clear-list m-t">
                                        <?php for($i = 0; $i < 6; $i++) { ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span>Confiture</span>          
                                                <span class="gras float-right"><?= money(458000) ?></span>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                            </div><hr> 
                        </div>
                    </div>
                      <div class="row text-center">
                         <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart2" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Kolter</h5>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Maxtor</h5>
                                </div>
                                 <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart3" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Kolter</h5>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart4" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Maxtor</h5>
                                </div>
                                 <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart5" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Kolter</h5>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-2">
                                    <canvas id="doughnutChart6" width="100" height="100" style="margin: 18px auto 0"></canvas>
                                    <h5 >Maxtor</h5>
                                </div>
                    </div><hr>
                    
                    <div class="row">
                        <?php for($i = 0; $i < 7; $i++) { ?>
                            <div class="col-md border-right">
                                <h6 class="text-uppercase text-center gras" style="color: ">Stock de vmkernge</h6>
                                <ul class="list-group clear-list m-t">
                                    <li class="list-group-item">
                                        <small>Confiture</small>          
                                        <span class="gras float-right"><?= money(458000) ?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <small>Jus sans Sucre</small>          
                                        <span class="gras float-right"><?= money(458000) ?></span>
                                    </li>
                                    <li class="list-group-item"></li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="ibox ">
                <div class="ibox-content">
                  
                </div>
            </div>
            


            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container" id="produits">
                        <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <?php foreach ($produits as $key => $produit) { ?>
                                <li style=" border-bottom: 3px solid <?= $produit->couleur; ?>,"><a class="nav-link" data-toggle="tab" href="#pan-<?= $produit->id ?>"><i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <?= $produit->name() ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($produits as $key => $produit) {
                                $total = 0; ?>
                                <div role="tabpanel" id="pan-<?= $produit->id ?>" class="tab-pane">
                                    <div class="panel-body"><br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h3 class="text-uppercase">Stock de <?= $produit->name() ?></h3>
                                                <ul class="list-group text-left clear-list m-t">
                                                    <?php foreach ($tableau[$produit->id] as $key => $pdv) { 
                                                        $total += $pdv->pdv->montantVendu($date1, $date2, $boutique->id); ?>
                                                        <li class="list-group-item">
                                                            <i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i>&nbsp;&nbsp;&nbsp; <?= $pdv->name ?>                                        
                                                            <span class="float-right">
                                                                <span class="label label-<?= ($pdv->boutique>0)?"success":"danger" ?>"><?= money($pdv->boutique) ?></span>&nbsp;&nbsp;
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <li class="list-group-item"></li>
                                                </ul>

                                                <div class="ibox">
                                                    <div class="ibox-content">
                                                        <h5>Estimation des ventes sur la période</h5>
                                                        <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
                                                    </div><br>
                                                </div>
                                            </div>

                                            <div class="col-md-7 border-right border-left">
                                                <div class="" style="margin-top: 0%">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="carre bg-primary"></div><span>Quantité vendue</span>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="carre bg-success"></div><span>Quantité livrée</span>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="carre bg-danger"></div><span>Quantité perdue</span>
                                                        </div>
                                                    </div><hr class="mp3">
                                                    <table class="table table-bordered table-hover text-center">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" class="border-none"></th>
                                                                <?php 
                                                                $lots = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI], [], ["quantite_id"=>"ASC"]) ;
                                                                foreach ($tableau[$produit->id] as $key => $pdv) { ?>
                                                                    <th><small><?= $pdv->prix ?> <?= $params->devise ?></small></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0;
                                                            foreach ($productionjours as $key => $production) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= datecourt($production->ladate)  ?></td>
                                                                    <?php foreach ($tableau[$produit->id] as $key => $pdv) {
                                                                        $pdv->tab[] = $pdv->pdv->montantVendu($production->ladate, $production->ladate, $boutique->id);
                                                                        ?>
                                                                        <td>
                                                                            <h5 class="d-inline text-green"><?= start0($pdv->pdv->vendu($production->ladate, $production->ladate, $boutique->id)); ?></h5> &nbsp;&nbsp;|&nbsp;&nbsp;

                                                                            <h5 class="d-inline text-success"><?= start0($pdv->pdv->livree($production->ladate, $production->ladate, $boutique->id)) ?></h5> &nbsp;&nbsp;|&nbsp;&nbsp;

                                                                            <h5 class="d-inline text-danger"><?= start0($pdv->pdv->perteProspection($production->ladate, $production->ladate, $boutique->id)); ?></h5>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr style="height: 18px;"></tr>
                                                            <tr>
                                                                <td class="text-center"><h4 class="text-center gras text-uppercase mp0">Vente totale</h4></td>
                                                                <?php foreach ($tableau[$produit->id] as $key => $pdv) { ?>
                                                                    <td><h3 class="text-green gras" ><?= money($pdv->pdv->montantVendu($date1, $date2, $boutique->id)) ?> <?= $params->devise ?></h3></td>
                                                                <?php } ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>   
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <?php foreach ($tableau[$produit->id] as $key => $pdv) { ?>
                                                    <div class="ibox">
                                                        <div class="ibox-content">
                                                            <h5>Courbe des ventes de <?= $pdv->pdv->quantite->name() ?></h5>
                                                            <div id="sparkline-<?= $pdv->id ?>"></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $tabvendu[$produit->id] = $total;
                            } ?>

                        </div>

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

        <?php foreach ($produits as $key => $produit) { 
            foreach ($tableau[$produit->id] as $key => $pdv) { ?>
                var sparklineCharts = function(){
                    $("#sparkline-<?= $pdv->id ?>").sparkline([<?php foreach ($pdv->tab as $i){ echo $i.", "; } ?>], {
                        type: 'line',
                        width: '100%',
                        height: '60',
                        lineColor: '<?= $pdv->pdv->produit->couleur ?>',
                        fillColor: "#ffffff"
                    });
                };


                var sparkResize;
                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineCharts, 500);
                });
                sparklineCharts();
            <?php }

        } ?>





//         var ctx = document.getElementById('myChart1').getContext('2d');
//         var chart = new Chart(ctx, {
//     // The type of chart we want to create
//     type: 'doughnut',

//     // The data for our dataset
//     data: {
//         labels: [<?php foreach ($produits as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
//         datasets: [{
//             label: 'Parfum le plus vendu',
//             data: [<?php foreach ($produits as $key => $prod) { echo "'".$tabvendu[$prod->id]."', "; } ?>],
//             backgroundColor: [<?php foreach ($produits as $key => $prod) { echo "'".$prod->couleur."', "; } ?>],
//         }]
//     },

//     // Configuration options go here
//     options: {
//         legend: {
//             display: false,
//             align: "left",
//             position: "bottom",
//             fullWidth: true,
//         }
//     }
// });



//         var ctx = document.getElementById('myChart2').getContext('2d');
//         var chart = new Chart(ctx, {
//     // The type of chart we want to create
//     type: 'doughnut',

//     // The data for our dataset
//     data: {
//         labels: [<?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
//         datasets: [{
//             label: 'Emballage le plus vendu',
//             data: [<?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $prod) { echo "'".$prod->vendu($date1, $date2, $boutique->id)."', "; } ?>],
//             backgroundColor: [<?php foreach (Home\QUANTITE::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $prod) { echo "'".$faker->hexColor()."', "; } ?>],
//         }]
//     },

//     // Configuration options go here
//     options: {
//         legend: false
//     }
// });


        
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



            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [300,50,100],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
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

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [70,27,85],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            } ;


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


             var ctx4 = document.getElementById("doughnutChart3").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


             var ctx4 = document.getElementById("doughnutChart4").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


             var ctx4 = document.getElementById("doughnutChart5").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

 var ctx4 = document.getElementById("doughnutChart6").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    });
</script>



</body>

</html>
