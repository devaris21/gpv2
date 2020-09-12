<div role="tabpanel" id="pan-rapport" class="tab-pane">

    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12 border-right border-left">
                    <div class="row">
                        <div class="col-sm-3 border-right">
                            <h5 class="text-uppercase gras text-center">Production par parfum</h5>
                            <ul class="list-group clear-list m-t">
                                <?php foreach ($parfums as $key => $item) {  ?>
                                    <li class="list-group-item">
                                        <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                        <i class=" float-right"><?= money($item->vendu) ?> Uni</i>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="flot-chart" style="height: 220px">
                                <div class="flot-chart-content" id="flot-dashboard-chart2" ></div>
                            </div><br><br>
                            <hr class="mp3">
                            <h2 class="mp0 gras"><?= money(comptage($typeproduits, "vendu", "somme"));  ?></h2>
                            <span class="small">unités de mésure produites</span>
                            <hr class="mp3">
                        </div>
                        <div class="col-sm-3 border-left">
                            <h5 class="text-uppercase gras text-center">Production par type de produit</h5>
                            <ul class="list-group clear-list m-t">
                                <?php foreach ($typeproduits as $key => $item) {  ?>
                                    <li class="list-group-item">
                                        <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                        <i class=" float-right"><?= money($item->vendu) ?> <?= $item->abbr ?></i>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                    </div><hr style="border: dashed 1px orangered"> 
                </div>
            </div>


            <div class="row">
                <?php foreach ($parfums as $key => $parfum) { ?>
                  <div class="col-md border-right">
                    <h6 class="text-uppercase text-center gras" style="color: "><?= $parfum->name();  ?></h6>
                    <ul class="list-group clear-list m-t">
                        <?php foreach ($parfum->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $type) { ?>
                            <li class="list-group-item" style="padding-bottom: 5px">
                                <small><?= $type->name();  ?></small>          
                                <small class="gras float-right"><?= money(Home\PRODUIT::totalProduit($date1, $date2, $entrepot->id, $type->typeproduit_id, $parfum->id)) ?></small>
                            </li>
                        <?php } ?>
                        <li class="list-group-item"></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>



<div class="ibox ">
    <div class="ibox-title">
        <h5 class="float-left text-uppercase">Rapport de conditionnement sur la même période</h5>
        <div class="ibox-tools">

        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <?php foreach ($typeproduits as $key => $type) { ?>
                <div class="col-md border-right">
                    <h6 class="text-uppercase text-center gras" style="color: "><?= $type->name();  ?></h6>
                    <ul class="list-group clear-list m-t">
                        <?php foreach ($type->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
                            $pro->actualise(); ?>
                            <li class="list-group-item" style="padding-bottom: 5px">
                                <small><?= $pro->name();  ?></small>          
                                <small class="float-right">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <?php foreach ($quantites as $key => $qua) {
                                                    $produit = new Home\PRODUIT();
                                                    $datas = Home\PRODUIT::findBy(["isActive="=>Home\TABLE::OUI, "typeproduit_parfum_id="=>$pro->id,"quantite_id="=> $qua->id]);
                                                    if (count($datas) > 0) { $produit = $datas[0]; } ?>
                                                    <td style="padding: 4px; width: 50px;" class="text-center"><span class="gras"><?= $produit->conditionnement($date1, $date2, Home\EMBALLAGE::PRIMAIRE, $entrepot->id) ?></span><br><span><?= $qua->name() ?></span></td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </small>
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





<script>
    $(document).ready(function() {

        var data1 = [<?php foreach ($stats2 as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->total ?>], <?php } ?> ];

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

        $.plot($("#flot-dashboard-chart2"), dataset, options);


    });
</script>
