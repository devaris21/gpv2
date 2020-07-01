
<div role="tabpanel" id="tab-tiers" class="tab-pane">
    <div class="panel-body">

        <div class="row">
            <div class="col-lg-3">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-4 text-center">
                            <i class="fa fa-trophy fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> Masse salariale</span>
                            <h2 class="font-bold">$ 4,232</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-cloud fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> Dette clients </span>
                            <h2 class="font-bold">26'C</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> Dette fournisseurs </span>
                            <h2 class="font-bold">260</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-music fa-5x"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span> New albums </span>
                            <h2 class="font-bold">12</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>

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
                            <?php foreach ($operations as $key => $operation) {  ?>
                                <tr>
                                    <td class="text-center" style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("gestion", "fiches", "boncaisse", $operation->getId())  ?>"><i class="fa fa-file-text-o fa-2x"></i></a> 
                                    </td>
                                    <td>
                                        <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?>  

                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            |
                                            &nbsp;&nbsp;<i onclick="modifierOperation(<?= $operation->getId() ?>)" class="cursor fa fa-pencil text-dark"></i> 
                                            &nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('operation', <?= $operation->getId() ?>)"></i>
                                        <?php } ?>

                                        <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span>
                                    </h6>
                                    <i><?= $operation->comment ?> ## <u style="font-size: 9px; font-style: italic;"><?= $operation->structure ?> - <?= $operation->numero ?></u></i>
                                </td>
                                           <!--  <td width="110" class="text-center" style="padding: 0; border-right: 2px dashed grey">
                                             <?php if ($operation->etat_id == Home\ETAT::ENCOURS) { ?>
                                                 <button style="padding: 2px 6px;" onclick="valider(<?= $operation->getId() ?>)" class="cursor simple_tag"><i class="fa fa-file-text-o"></i> Valider</button><span style="display: none">en attente</span>
                                             <?php } ?>
                                             <br><small style="display: inline-block; font-style: 8px; line-height: 12px;"><?= $operation->structure ?> - <?= $operation->numero ?></small>
                                         </td> -->
                                         <?php if ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE) { ?>
                                            <td class="text-center text-green gras" style="padding-top: 12px;">
                                                <?= money($operation->montant) ?> <?= $params->devise ?>
                                            </td>
                                            <td class="text-center"> - </td>
                                        <?php }elseif ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::SORTIE) { ?>
                                            <td class="text-center"> - </td>
                                            <td class="text-center text-red gras" style="padding-top: 12px;">
                                                <?= money($operation->montant) ?> <?= $params->devise ?>
                                            </td>
                                        <?php } ?>
                                        <?php $last += ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)? $operation->montant : -$operation->montant ; ?>
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

            </div>

        </div>
    </div>