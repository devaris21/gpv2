<div role="tabpanel" id="tab-recettes" class="tab-pane">
    <div class="panel-body">

        <div class="row">
            <div class="col-lg-8">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="m-t-sm">
                            <div class="border-right">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart-2" height="700px"></div>
                                </div>
                            </div><hr>
                            <div class="row stat-list text-center">
                                <div class="col-4">
                                    <h3 class="no-margins text-green"><?= money($ca) ?> <?= $params->devise ?> </h3>
                                    <small>Chiffres d'affaires</small>

                                    <div class="progress progress-mini" style="margin-top: 5%;">
                                        <div class="progress-bar" style="width: 100%; background-color: #dedede"></div>
                                    </div><br>
                                    <h3 class="no-margins text-red"><?= money($payements) ?> <?= $params->devise ?> </h3>
                                    <small>Payes des commerciaux</small>
                                </div>
                                <div class="col-4">
                                    <br>
                                    <h2 class="no-margins gras"><?= money($marges) ?> <small><?= $params->devise ?></small></h2>
                                    <small>Marge brute</small>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h3 class="no-margins text-red"><?= money($charges) ?> <?= $params->devise ?> </h3>
                                    <small>Charges directes totales</small>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar" style="width: 100%;"></div>
                                    </div><br>
                                    <h3 class="no-margins text-red"><?= money($appros) ?> <?= $params->devise ?> </h3>
                                    <small>Approvisionnement</small>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="widget navy-bg p-lg text-center">
                            <div class="m-b-md">
                                <h3 class="font-bold no-margins">10 000 000 Fcfa</h3><br>

                                <h4 class="font-bold no-margins">Chiffre d'Affaire</h4>
                                <h1 class="m-xs">45%</h1>

                                <small>des prévisions atteintes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget red-bg p-lg text-center">
                            <div class="m-b-md">
                             <h3 class="font-bold no-margins">10 000 000 Fcfa</h3><br>

                             <h4 class="font-bold no-margins">Dépenses</h4>
                             <h1 class="m-xs">45%</h1>

                             <small>des prévisions atteintes</small>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="ibox">
                <div class="ibox-content" style="padding-bottom: 0;">
                    <button data-toggle="modal" data-target="#modal-entree" class="btn btn-sm btn-primary dim"><i class="fa fa-check"></i> Nouvelle entrée</button>
                    <button data-toggle="modal" data-target="#modal-depense" class="btn btn-sm btn-danger dim pull-right"><i class="fa fa-check"></i> Nouvelle dépense</button><hr class="mp3">
                </div>
            </div>
        </div>

    </div><hr>


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
                            <td colspan="2">Repport du solde </td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , dateAjoute(-8))) ?> <?= $params->devise ?></td>
                        </tr>
                        <?php foreach ($tableau as $key => $operation) {  ?>
                            <tr>
                                <td class="text-center" style="background-color: rgba(<?= (isset($operation->categorieoperation))?hex2rgb($operation->categorieoperation->color):"255, 255, 255"; ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("fiches", "master", $operation->fiche, $operation->id)  ?>"><i class="fa fa-file-text-o fa-2x"></i></a> 
                                </td>
                                <td>
                                    <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)?"text-green":"text-red" ?>"><?= $operation->type ?>  

                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                        |
                                        &nbsp;&nbsp;<i onclick="modifierOperation(<?= $operation->id ?>)" class="cursor fa fa-pencil text-dark"></i> 
                                        &nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('operation', <?= $operation->id ?>)"></i>
                                    <?php } ?>

                                    <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span>
                                </h6>
                                <i><?= $operation->comment ?> ## <u style="font-size: 9px; font-style: italic;"><?= $operation->structure ?> - <?= $operation->numero ?></u></i>
                            </td>
                            <?php if ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT) { ?>
                                <td class="text-center text-green gras" style="padding-top: 12px;">
                                    <?= money($operation->mouvement->montant) ?> <?= $params->devise ?>
                                </td>
                                <td class="text-center"> - </td>
                            <?php }elseif ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::RETRAIT) { ?>
                                <td class="text-center"> - </td>
                                <td class="text-center text-red gras" style="padding-top: 12px;">
                                    <?= money($operation->mouvement->montant) ?> <?= $params->devise ?>
                                </td>
                            <?php } ?>
                            <?php $last += ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)? $operation->mouvement->montant : -$operation->mouvement->montant ; ?>
                            <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                        </tr>
                    <?php } ?>
                    <tr style="height: 15px;"></tr>
                    <tr>
                        <td style="border-right: 2px dashed grey" colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes au <?= datecourt(dateAjoute()) ?></h4></td>
                        <td><h3 class="text-center text-green"><?= money($entrees + $repport) ?> <?= $params->devise ?></h3></td>
                        <td><h3 class="text-center text-red"><?= money($depenses) ?> <?= $params->devise ?></h3></td>
                        <td style="background-color: #fafafa"><h3 class="text-center text-blue gras"><?= money($last) ?> <?= $params->devise ?></h3></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</div>
</div><br>

