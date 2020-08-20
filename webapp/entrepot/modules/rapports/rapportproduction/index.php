<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-7">
                <h2 class="text-uppercase">Rapport de production</h2>
                <span>Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></span>
            </div>
            <div class="col-sm-5">

            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="text-center animated fadeInRightBig">

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
                    <div class="ibox-content" id="produits">
                        <div class="tabs-container">

                          <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-0"><i class="fa fa-flask" ></i> Global</a></li>
                            <?php foreach ($produits as $key => $produit) { ?>
                                <li style=" border-bottom: 3px solid <?= $produit->couleur; ?>,"><a class="nav-link" data-toggle="tab" href="#pan-<?= $produit->id ?>"><i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <?= $produit->name() ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" id="pan-0" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 border-right border-left text-center">
                                            <div class="row">
                                                <div class="col-sm-3 border-right">
                                                    <h5 class="text-uppercase">Parfum le plus produit</h5><br>
                                                    <canvas id="myChart1"></canvas>
                                                </div>

                                                <div class="col-sm-6 text-center">
                                                    <div class="flot-chart">
                                                        <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                                    </div><hr>
                                                    <span>Vente directe / vente par prospection</span>
                                                </div>

                                                <div class="col-sm-3 border-left">
                                                    <h5 class="text-uppercase">Emballage le plus produit</h5><br>
                                                    <canvas id="myChart2"></canvas>
                                                </div>
                                            </div><hr> 
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php foreach ($produits as $key => $produit) {
                                $qtetotale = $total = 0; ?>
                                <div role="tabpanel" id="pan-<?= $produit->id ?>" class="tab-pane">
                                    <div class="panel-body"><br>
                                        <div class="row">
                                            <div class="col-md-4 text-left">
                                                <h3 class="text-uppercase">Stock de <?= $produit->name() ?></h3>
                                                <ul class="list-group text-left clear-list m-t">
                                                    <?php foreach ($tableau[$produit->id] as $key => $pdv) { 
                                                        $qtetotale += $produit->quantiteProduite($date1, $date2, $entrepot->id);
                                                        $total += $pdv->pdv->enEntrepot($date2, $entrepot->id) * $pdv->pdv->prix->price ; ?>
                                                        <li class="list-group-item">
                                                            <i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i>&nbsp;&nbsp;&nbsp; <?= $pdv->name ?>                                        
                                                            <span class="float-right">
                                                                <span class="label label-<?= ($pdv->stock>0)?"success":"danger" ?>"><?= money($pdv->stock) ?></span>&nbsp;&nbsp;
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <li class="list-group-item"></li>
                                                </ul>

                                                <div class="ibox">
                                                    <div class="ibox-content">
                                                        <h5>Estimation du stock actuel</h5>
                                                        <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
                                                    </div><br>

                                                    <div class="ibox-content">
                                                        <h5>Quantité produite sur la période</h5>
                                                        <h3 class="no-margins gras" style="color: <?= $produit->couleur ?>"><?= ($qtetotale) ?> litres / <?= $id ?> jours</h3>
                                                    </div><br>

                                                    <div class="ibox-content">
                                                        <h5>Comparaison du stock / commande / prix</h5>
                                                        <div id="ct-chart-<?= $produit->id ?>" style="height: 150px; width:100%"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8 border-right border-left">
                                                <div class="" style="margin-top: 0%">

                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="carre bg-success"></div><span>Quantité produite</span>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="carre bg-green"></div><span>Quantité sortie</span>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="carre bg-dark"></div><span>Stock de fin de journée</span>
                                                        </div>
                                                    </div><hr>

                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" class="border-none"></th>
                                                                <?php 
                                                                $lots = $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI], [], ["quantite_id"=>"ASC"]) ;
                                                                foreach ($lots as $key => $pdv) {
                                                                    $pdv->actualise(); ?>
                                                                    <th><small><?= $pdv->quantite->name() ?></small></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i =0;
                                                            foreach ($productions as $key => $production) { ?>
                                                                <tr>
                                                                    <td><?= datecourt3($production->ladate)  ?></td>
                                                                    <?php
                                                                    $production->fourni("ligneproduction");
                                                                    foreach ($lots as $key => $pdv) {
                                                                        foreach ($production->ligneproductions as $key => $ligne) {
                                                                            if ($pdv->id == $ligne->produit_id) { 
                                                                                ?>
                                                                                <td>
                                                                                    <h4 class="d-inline text-success gras"><?= start0($ligne->production) ?></h4>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                                    <h4 class="d-inline text-green gras"><?= start0($pdv->totalSortieEntrepot($production->ladate, $production->ladate, $entrepot->id)) ?></h4>&nbsp;&nbsp;=>&nbsp;&nbsp;
                                                                                    <h4 class="d-inline text-gray-dark gras"><?= start0($pdv->enEntrepot($production->ladate, $entrepot->id)) ?></h4>
                                                                                </td>
                                                                            <?php }
                                                                        }
                                                                    } ?>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr style="height: 18px;"></tr>
                                                            <tr>
                                                                <td style="width: 30%"><h4 class="text-center gras text-uppercase mp0">En entrepot</h4></td>
                                                                <?php foreach ($lots as $key => $pdv) { ?>
                                                                    <td><h4 class="text-muted gras" ><?= start0($pdv->enEntrepot($date2, $entrepot->id)) ?></h4></td>
                                                                <?php } ?>
                                                            </tr>
                                                        </tbody>
                                                    </table> 

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $tabproduit[$produit->id] = $qtetotale;
                            } ?>

                        </div>


                    </div>
                </div>

            </div>


        </div>
    </div>


    <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>


<script type="text/javascript">
    $(function(){
        <?php foreach ($produits as $key => $produit) { ?>
         new Chartist.Bar('#ct-chart-<?= $produit->id ?>', {
            labels: [<?php foreach ($tableau[$produit->id] as $key => $data){ ?>"<?= $data->prix ?>", " ", " ",<?php } ?>],
            series: [
            [<?php foreach ($tableau[$produit->id] as $key => $data){ ?><?= $data->stock ?>, 0, 0,<?php } ?>],
            ]
        }, {
         stackBars: true,
         axisX: {
            labelInterpolationFnc: function(value) {
                if (value >= 1000) {
                    return (value / 1000) + 'k';            
                }
                return value;
            }
        },
        reverseData:true,
        seriesBarDistance: 10,
        horizontalBars: true,
        axisY: {
            offset: 50
        }
    });
     <?php }  ?>




     var ctx = document.getElementById('myChart1').getContext('2d');
     var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: [<?php foreach ($produits as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
        datasets: [{
            label: 'Parfum le plus vendu',
            data: [<?php foreach ($produits as $key => $prod) { echo "'".ceil($tabproduit[$prod->id])."', "; } ?>],
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



     var ctx = document.getElementById('myChart2').getContext('2d');
     var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: [<?php foreach ($quantites as $key => $prod) { echo "'".$prod->name()."', "; } ?>],
        datasets: [{
            label: 'Emballage le plus produit',
            data: [<?php foreach ($quantites as $key => $prod) { echo "'".ceil($prod->production($date1, $date2))."', "; } ?>],
            backgroundColor: [<?php foreach ($quantites as $key => $prod) { echo "'".$faker->hexColor()."', "; } ?>],
        }]
    },

    // Configuration options go here
    options: {
        legend: false
    }
});


 })
</script>


</body>

</html>
