<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  


            <div class="wrapper wrapper-content">
                <div class="animated fadeInRightBig">

                    <div class="tabs-container produits">
                        <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-global"><i class="fa fa-globe" ></i> Global</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-ventes"><i class="fa fa-handshake-o" ></i> Ventes des <?= dateDiffe($date1, $date2)  ?> derniers  jours</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-rapport"><i class="fa fa-money" ></i> Rapport de vente</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-caisse"><i class="fa fa-money" ></i> La caisse</a></li>
                            <li style="width: 270px; position: absolute; right: 0;"><?php Native\BINDING::html("select", "boutique", $boutique, "id") ?></li>
                        </ul>
                        <div class="tab-content loading-data">

                            <?php include($this->relativePath("partials/tab-global.php")); ?>
                            <?php include($this->relativePath("partials/tab-ventes.php")); ?>
                            <?php include($this->relativePath("partials/tab-rapport.php")); ?>
                            <?php include($this->relativePath("partials/tab-caisse.php")); ?>

                        </div>
                    </div>


                </div>

                <br>
                <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>

                <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-ventecave.php")); ?> 

                <?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>
                
            </div>
        </div>

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

                var data3 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->cave ?>], <?php } ?> ];

                var dataset = [
                {
                    label: "Vente directe",
                    data: data1,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "left",
                        barWidth: 20 * 60 * 60 * 600,
                        lineWidth:0
                    }
                }, {
                    label: "Vente par prospection",
                    data: data2,
                    color: "#cc0000",
                    bars: {
                        show: true,
                        align: "right",
                        barWidth: 20 * 60 * 60 * 600,
                        lineWidth:0
                    }
                }, {
                    label: "Vente par cave",
                    data: data3,
                    color: "#0088cc",
                    bars: {
                        show: true,
                        align: "right",
                        barWidth: 20 * 60 * 60 * 600,
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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


<?php foreach ($produits as $key => $produit) { 
    foreach ($tableaux[$produit->id] as $key => $pdv) { ?>
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

var ctx = document.getElementById('myChart1').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: [<?php foreach ($produits as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
        datasets: [{
            label: 'Parfum le plus vendu',
            data: [<?php foreach ($produits as $key => $prod) { echo "'".$tabvendu[$prod->id]."', "; } ?>],
            backgroundColor: [<?php foreach ($produits as $key => $prod) { echo "'".$prod->couleur."', "; } ?>],
        }]
    },

    // Configuration options go here
    options: {
        legend: {
            display: false,
            align: "left",
            position: "bottom",
            fullWidth: true,
        }
    }
});



var ctx = document.getElementById('myChart3').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: [<?php foreach ($quantites as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
        datasets: [{
            label: 'Emballage le plus vendu',
            data: [<?php foreach ($quantites as $key => $prod) { echo "'".$prod->vendu($date1, $date2, $boutique->id)."', "; } ?>],
            backgroundColor: [<?php foreach ($quantites as $key => $prod) { echo "'".$faker->hexColor()."', "; } ?>],
        }]
    },

    // Configuration options go here
    options: {
        legend: false
    }
});



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
        barWidth: 20 * 60 * 60 * 600,
        lineWidth:0
    }

}, {
    label: "Vente par prospection",
    data: data2,
    color: "#cc0000",
    bars: {
        show: true,
        align: "right",
        barWidth: 20 * 60 * 60 * 600,
        lineWidth:0
    }
}, {
    label: "Vente par cave",
    data: data3,
    color: "#0088cc",
    bars: {
        show: true,
        align: "right",
        barWidth: 20 * 60 * 60 * 600,
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

$.plot($("#flot-dashboard-chart1"), dataset, options);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var lineData = {
    labels: [<?php foreach ($statistiques as $key => $data) { ?>"<?= $data->name ?>", <?php } ?>],
    datasets: [
    {
        label: "Entrées",
        borderColor: "rgba(26,179,148,0.7)",
        pointBackgroundColor: "rgba(26,179,148,1)",
        pointBorderColor: "#fff",
        data: [<?php foreach ($statistiques as $key => $data) { ?>"<?= $data->entree ?>", <?php } ?>]
    },
    {
        label: "Dépenses",
        borderColor: "rgba(220,0,0,1)",
        pointBackgroundColor: "rgba(220,0,0,1)",
        pointBorderColor: "#fff",
        data: [<?php foreach ($statistiques as $key => $data) { ?>"<?= $data->sortie ?>", <?php } ?>]
    }
    ]
};

var lineOptions = {
    responsive: true
};

var ctx = document.getElementById("lineChart").getContext("2d");
new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

});


</script>


</body>


</html>