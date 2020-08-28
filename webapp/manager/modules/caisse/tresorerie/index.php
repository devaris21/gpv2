<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  


            <div class="wrapper wrapper-content">

                <div class="">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-global"><i class="fa fa-globe"></i> Global</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-capitaux"><i class="fa fa-home"></i> Capitaux & Immobilisation</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-stock"><i class="fa fa-cubes"></i> Stock & en-cours</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-banques"><i class="fa fa-money"></i> Comptes & Banques</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-recettes"><i class="fa fa-charts-line"></i> Recettes & charges</a></li>
                        </ul>

                        <div class="tab-content">

                            <?php include($this->relativePath("partiels/tab-global.php")) ?>
                            <?php include($this->relativePath("partiels/tab-capitaux.php")) ?>
                            <?php include($this->relativePath("partiels/tab-stock.php")) ?>
                            <?php include($this->relativePath("partiels/tab-banques.php")) ?>
                            <?php include($this->relativePath("partiels/tab-recettes.php")) ?>

                        </div>
                    </div>
                </div>
                <br><br>



                <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

                <?php include($this->rootPath("composants/assets/modals/modal-entree.php")); ?>  
                <?php include($this->rootPath("composants/assets/modals/modal-depense.php")); ?>  
                <?php include($this->rootPath("composants/assets/modals/modal-operation.php")); ?>  

            </div>
        </div>


        <div class="modal inmodal fade" id="modal-attente">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Liste des versements en attentes</h4>
                        <div class="offset-md-4 col-md-4">
                           <input type="text" id="search" class="form-control text-center" placeholder="Rechercher un versements"> 
                       </div>
                   </div>
                   <div class="modal-body">
                    <table class="table table-bordered table-hover table-operation">
                        <tbody class="tableau-attente">
                            <?php foreach (Home\OPERATION::enAttente() as $key => $operation) {
                                $operation->actualise(); ?>
                                <tr>
                                    <td style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("fiches", "master", "boncaisse", $operation->id)  ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                    <td>
                                        <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?> <span><?= ($operation->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span></h6>
                                        <i><?= $operation->comment ?></i>
                                    </td>
                                    <td class="text-center gras" style="padding-top: 12px;">
                                        <?= money($operation->montant) ?> <?= $params->devise ?>
                                    </td>
                                    <td width="110" class="text-center" >
                                        <small><?= $operation->structure ?></small><br>
                                        <small><?= $operation->numero ?></small>
                                    </td>
                                    <td class="text-center">
                                        <button onclick="valider(<?= $operation->id ?>)" class="cursor simple_tag"><i class="fa fa-file-text-o"></i> Valider</button><span style="display: none">en attente</span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><hr><br>
            </div>
        </div>
    </div>



    <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>
    <script>
        $(document).ready(function() {


            var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->ca ?>], <?php } ?> ];

            var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->sortie ?>], <?php } ?> ];

            var data3 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->marge ?>], <?php } ?> ];

            var dataset = [
            {
                label: "Chiffre d'affaire",
                data: data1,
                color: "#1ab394",
                bars: {
                    show: true,
                    align: "left",
                    barWidth: 25 * 60 * 60 * 600,
                    lineWidth:0
                }

            }, {
                label: "Charges",
                data: data2,
                color: "#cc0000",
                bars: {
                    show: true,
                    align: "right",
                    barWidth: 25 * 60 * 60 * 600,
                    lineWidth:0
                }

            }, {
                label: "Marge brute",
                data: data3,
                yaxis: 2,
                color: "#1C84C6",
                lines: {
                    lineWidth:1,
                    show: true,
                    fill: false,
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
                }, {
                    max: 100,
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

            $.plot($("#flot-dashboard-chart-2"), dataset, options);
        });
    </script>



    <script>
        $(document).ready(function() {

            var data2 = [
            [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
            [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
            [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
            [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
            [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
            [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
            [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
            [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var data3 = [
            [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
            [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
            [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
            [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
            [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
            [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
            [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
            [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
            ];


            var dataset = [
            {
                label: "Number of orders",
                data: data3,
                color: "#1ab394",
                bars: {
                    show: true,
                    align: "center",
                    barWidth: 24 * 60 * 60 * 600,
                    lineWidth:0
                }

            }, {
                label: "Payments",
                data: data2,
                yaxis: 2,
                color: "#1C84C6",
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
                    max: 1070,
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






<?php include($this->rootPath("composants/assets/modals/modal-capital.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-immobilisation.php")); ?>
<?php include($this->rootPath("composants/assets/modals/modal-cloture.php")); ?>

<?php foreach (Home\IMMOBILISATION::getAll() as $key => $immobilisation) {
    $immobilisation->actualise();
    include($this->rootPath("composants/assets/modals/modal-immobilisation2.php")); 
}
?>  

<?php include($this->rootPath("composants/assets/modals/modal-comptebanque.php")); ?>  
<?php foreach (Home\COMPTEBANQUE::getAll() as $key => $banque) {
    $banque->actualise();
    include($this->rootPath("composants/assets/modals/modal-optioncompte.php")); 
}
?>  
<?php include($this->rootPath("composants/assets/modals/modal-retrait.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-depot.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-fraiscompte.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-transfertfond.php")); ?>  

</body>

</html>
