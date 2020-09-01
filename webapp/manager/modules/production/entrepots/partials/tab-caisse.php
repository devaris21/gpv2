<div role="tabpanel" id="pan-caisse" class="tab-pane">
	<div class=" border-bottom white-bg dashboard-header">
	<br>	
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="text-uppercase">Chiffre d'affaire</h5>
                                <h2 class="no-margins"><?= money(Home\TRESORERIE::chiffreAffaire($date1, $date2))  ?> </h2>
                            </div>
                            <div class="col-5 text-right">
                                <i class="fa fa-dollar fa-5x" style="color: #ddd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="text-uppercase">Résultat brut</h5>
                                <h2 class="no-margins"><?= money($comptebanque->getIn($date1, $date2) - $comptebanque->getOut($date1, $date2)) ?></h2>
                            </div>
                            <div class="col-5 text-right">
                                <i class="fa fa-money fa-5x" style="color: #ddd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content bg-navy">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="text-uppercase">Dette clientèle</h5>
                                <h2 class="no-margins"><?= money(Home\CLIENT::dettes()) ?></h2>
                            </div>
                            <div class="col-5 text-right">
                                <i class="fa fa-users fa-5x" style="color: #ddd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="text-uppercase">Dette Fournisseur</h5>
                                <h2 class="no-margins"><?= money(Home\FOURNISSEUR::dettes()) ?></h2>
                            </div>
                            <div class="col-5 text-right">
                                <i class="fa fa-truck fa-5x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<br>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart3"></div>
                                </div><br>
                                <div class="row stat-list text-center">
                                    <div class="col-4 ">
                                        <h3 class="no-margins text-green"><?= money($comptebanque->getIn(dateAjoute(), dateAjoute(1))) ?> <small><?= $params->devise ?></small></h3>
                                        <small>Entrées du jour</small>
                                    </div>
                                    <div class="col-4 border-left border-right">
                                        <h2 class="no-margins gras"><?= money($comptebanque->solde()) ?> <small><?= $params->devise ?></small></h2>
                                        <small>En caisse actuellement</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="no-margins text-red"><?= money($comptebanque->getOut(dateAjoute(), dateAjoute(1))) ?> <small><?= $params->devise ?></small></h3>
                                        <small>Dépenses du jour</small>
                                    </div>
                                </div><hr>
                            </div>
                            <div class="col-lg-3">
                                <ul class="stat-list">
                                    <li>
                                        <h2 class="no-margins"><?= money(Home\REGLEMENTCLIENT::total($date1 , $date2, $entrepot->id)) ?> <small><?= $params->devise ?></small></h2>
                                        <small>Total reglements clients</small>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins "><?= money(Home\OPERATION::entree($date1 , $date2, $entrepot->id)) ?> <small><?= $params->devise ?></small></h2>
                                        <small>Autres entrées en caisse</small>
                                        <div class="progress progress-mini">
                                            <div style="width: 60%;" class="progress-bar"></div>
                                        </div>
                                    </li><br>
                                    <li>
                                        <h2 class="no-margins text-danger "><?= money($comptebanque->getOut(dateAjoute(), dateAjoute(1))) ?> <small><?= $params->devise ?></small></h2>
                                        <small>Total Charges de fonctionnement</small>
                                        <div class="progress progress-mini">
                                            <div style="width: 22%;" class="progress-bar progress-bar-animated progress-bar-danger"></div>
                                        </div>
                                    </li>
                                        <!--     <li>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3 class="no-margins text-danger "><?= money(0) ?> <small><?= $params->devise ?></small></h3>
                                                        <small>Paye </small>
                                                        <div class="progress progress-mini">
                                                            <div style="width: 22%;" class="progress-bar progress-bar-animated progress-bar-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h3 class="no-margins text-danger "><?= money(Home\REGLEMENTFOURNISSEUR::total($date1 , $date2, $entrepot->id)) ?> <small><?= $params->devise ?></small></h3>
                                                        <small>Fourniture</small>
                                                        <div class="progress progress-mini">
                                                            <div style="width: 22%;" class="progress-bar progress-bar-animated progress-bar-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li><br> -->
                                            <li>
                                                <h2 class="no-margins text-warning"><?= money(comptage($transferts , "montant", "somme")) ?> <small><?= $params->devise ?></small></h2>
                                                <small>Transferts vers autre compte</small>
                                                <div class="progress progress-mini">
                                                    <div style="width: 22%;" class="progress-bar progress-bar-animated progress-bar-warning"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Tableau des compte</h5>
                                <div class="ibox-tools">
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-operation">
                                                <thead>
                                                    <tr class="text-center text-uppercase">
                                                        <th colspan="2" style="visibility: hidden; width: 65%"></th>
                                                        <th>Entrée</th>
                                                        <th>Sortie</th>
                                                        <th>Résultats</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableau">
                                                    <tr>
                                                        <td colspan="2">Repport du solde de la veille (<?= datecourt(dateAjoute(-8)) ?>) </td>
                                                        <td class="text-center">-</td>
                                                        <td class="text-center">-</td>
                                                        <td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , dateAjoute(-8))) ?> <?= $params->devise ?></td>
                                                    </tr>
                                                    <?php foreach ($mouvements as $key => $mouvement) {  ?>
                                                        <tr>
                                                            <td class="text-center" width="15"><a target="_blank" href="<?= $this->url("fiches", "master", "boncaisse", $mouvement->id)  ?>"><i class="fa fa-file-text-o fa-2x"></i></a> 
                                                            </td>
                                                            <td>
                                                                <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)?"text-green":"text-red" ?>"><?= $mouvement->name() ?>  

                                                                <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                                    |
                                                                    &nbsp;&nbsp;<i onclick="modifierOperation(<?= $mouvement->id ?>)" class="cursor fa fa-pencil text-dark"></i> 
                                                                    &nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('operation', <?= $mouvement->id ?>)"></i>
                                                                <?php } ?>

                                                                <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($mouvement->created) ?></span>
                                                            </h6>
                                                            <i><?= $mouvement->comment ?> ## <u style="font-size: 9px; font-style: italic;"><?= $mouvement->structure ?> - <?= $mouvement->numero ?></u></i>
                                                        </td>
                                           <!--  <td width="110" class="text-center" style="padding: 0; border-right: 2px dashed grey">
                                             <?php if ($mouvement->etat_id == Home\ETAT::ENCOURS) { ?>
                                                 <button style="padding: 2px 6px;" onclick="valider(<?= $mouvement->id ?>)" class="cursor simple_tag"><i class="fa fa-file-text-o"></i> Valider</button><span style="display: none">en attente</span>
                                             <?php } ?>
                                             <br><small style="display: inline-block; font-style: 8px; line-height: 12px;"><?= $mouvement->structure ?> - <?= $mouvement->numero ?></small>
                                         </td> -->
                                         <?php if ($mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT) { ?>
                                            <td class="text-center text-green gras" style="padding-top: 12px;">
                                                <?= money($mouvement->montant) ?> <?= $params->devise ?>
                                            </td>
                                            <td class="text-center"> - </td>
                                        <?php }elseif ($mouvement->typemouvement_id == Home\TYPEMOUVEMENT::RETRAIT) { ?>
                                            <td class="text-center"> - </td>
                                            <td class="text-center text-red gras" style="padding-top: 12px;">
                                                <?= money($mouvement->montant) ?> <?= $params->devise ?>
                                            </td>
                                        <?php } ?>
                                        <?php $last += ($mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)? $mouvement->montant : -$mouvement->montant ; ?>
                                        <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                                    </tr>
                                <?php } ?>
                                <tr style="height: 15px;"></tr>
                                <tr>
                                    <td style="border-right: 2px dashed grey" colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes au <?= datecourt(dateAjoute()) ?></h4></td>
                                    <td><h3 class="text-center text-green"><?= money(comptage($entrees, "montant", "somme") + $repport) ?> <?= $params->devise ?></h3></td>
                                    <td><h3 class="text-center text-red"><?= money(comptage($depenses, "montant", "somme")) ?> <?= $params->devise ?></h3></td>
                                    <td style="background-color: #fafafa"><h3 class="text-center text-blue gras"><?= money($last) ?> <?= $params->devise ?></h3></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

</div>


</div>

</div>
</div>





<script type="text/javascript">
    $(document).ready(function() {

       var data1 = [<?php foreach ($stats3 as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->entree ?>], <?php } ?> ];

       var data2 = [<?php foreach ($stats3 as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->sortie ?>], <?php } ?> ];
       var data3 = [<?php foreach ($stats3 as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->solde ?>], <?php } ?> ];
       var dataset = [
       {
        label: "Recettes",
        data: data1,
        color: "#1ab394",
        bars: {
            show: true,
            align: "left",
            barWidth: 12 * 60 * 60 * 600,
            lineWidth:0
        }

    }, {
        label: "Charges",
        data: data2,
        color: "#cc0000",
        bars: {
            show: true,
            align: "right",
            barWidth: 12 * 60 * 60 * 600,
            lineWidth:0
        }

    },  {
        label: "Chiffre d'Affaire",
        data: data3,
        yaxis: 2,
        color: "#1C84C6",
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

    $.plot($("#flot-dashboard-chart3"), dataset, options);

});
</script>
