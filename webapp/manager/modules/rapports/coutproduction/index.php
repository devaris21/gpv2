<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

            <div class="animated fadeInRightBig">

                <div class="ibox ">
                    <form id="formFiltrer" method="POST">
                        <div class="ibox-title">
                            <h5 class="float-left">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
                            <div class="ibox-tools">
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
                            </div>
                        </div><br>
                        <div class="ibox-title">
                            <div class="">
                                <div class="row">
                                    <div class="col-2">
                                        <br>
                                        <h5 class="text-uppercase">Coût de production</h5>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control select2 input-sm" name="typeproduit_id" style="width: 100%">
                                                <?php foreach (Home\TYPEPRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
                                                    <option value="<?= $item->id ?>"><?= $item->name() ?></option>
                                                <?php } ?>
                                            </select>                                       
                                        </div>
                                    </div>  
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control select2 input-sm" name="parfum_id" style="width: 100%">
                                                <?php foreach (Home\PARFUM::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $item) { ?>
                                                    <option value="<?= $item->id ?>">de <?= $item->name() ?></option>
                                                <?php } ?>
                                            </select>                                       
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" onclick="filtrer()" class="btn btn-sm btn-white"><i class="fa fa-search"></i> Calculer les coûts</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <div class="ibox-content ajax">
                        <!-- rempli en ajax -->
                    </div>
                </div>

            </div>

            <br><br>
            <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>


        </div>
    </div>


    <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>



    <script>
        $(document).ready(function() {

            var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->total ?>], <?php } ?> ];

            var dataset = [
            {
                label: "Evolution de la production",
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


        });
    </script>



</body>

</html>
