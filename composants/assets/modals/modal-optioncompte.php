
<div class="modal inmodal fade" id="modal-optioncompte-<?= $banque->id ?>">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Fiche comptes & banques</h4>
                <span class="font-bold">Renseigner ces champs pour enregistrer les informations</span>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="" style="margin-top: 0"><?= $banque->name() ?> <i style="font-size: 15px" class="fa fa-pencil pull-right cursor" data-toggle="modal" data-target="#modal-comptebanque ?>" onclick="modification('comptebanque', <?= $banque->id ?>)"></i></h1>
                        <span class="font-bold"><?= $banque->etablissement ?> // N°<?= $banque->numero ?></span>
                    </div>
                    <div class="col-sm-5 text-right">
                        <h5>Solde du compte</h5>
                        <h1 class="mp0"><?= money($banque->solde(Home\PARAMS::DATE_DEFAULT, dateAjoute())) ?> <?= $params->devise  ?> </h1>
                    </div>
                </div><hr>
                <div class="row text-center" style="font-size: 11px">
                    <div class="col-md">
                        <button data-toggle="modal" data-target="#modal-depot" class="btn btn-primary dim"><i class="fa fa-plus"></i> Dépôt sur le compte</button>
                    </div>
                    <div class="col-md">
                        <button data-toggle="modal" data-target="#modal-fraiscompte" class="btn btn-warning dim"><i class="fa fa-cc"></i> Enregistrer Frais de compte </button>
                    </div>
                    <div class="col-md">
                        <button data-toggle="modal" data-target="#modal-retrait" class="btn btn-danger dim"><i class="fa fa-minus"></i> Retrait sur le compte </button>
                    </div>
                </div><hr>

                <div>
                    <h3>10 dernieres transactions sur le compte </h3>
                    <table class="table table-striped table-hover">
                        <thead class="bg-navy">
                            <tr>
                                <th>Descriptif</th>
                                <th class="text-center">crédit</th>
                                <th class="text-center">débit</th>
                                <th class="text-center">Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banque->fourni("mouvement", [], [], ["created"=>"DESC"], 10) as $key => $mvt) {
                                $mvt->actualise(); ?>
                                <tr>
                                    <td>
                                        <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($mvt->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)?"text-green":"text-red" ?>"><?= $mvt->typemouvement->name() ?>  

                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            |
                                            &nbsp;&nbsp;<i onclick="modifierOperation(<?= $mvt->id ?>)" class="cursor fa fa-pencil text-dark"></i> 
                                            &nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('mouvement', <?= $mvt->id ?>)"></i>
                                        <?php } ?>
                                        <span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($mvt->created) ?></span>
                                    </h6>
                                    <i><?= $mvt->comment ?></i>
                                </td>
                                <?php if ($mvt->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT) { ?>
                                    <td class="text-center text-green gras" style="padding-top: 12px;">
                                        <?= money($mvt->montant) ?> <?= $params->devise ?>
                                    </td>
                                    <td class="text-center"> - </td>
                                <?php }elseif ($mvt->typemouvement_id == Home\TYPEMOUVEMENT::RETRAIT) { ?>
                                    <td class="text-center"> - </td>
                                    <td class="text-center text-red gras" style="padding-top: 12px;">
                                        <?= money($mvt->montant) ?> <?= $params->devise ?>
                                    </td>
                                <?php } ?>
                                <?php $last += ($mvt->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)? $mvt->montant : -$mvt->montant ; ?>
                                <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div><hr>
    </div>
</div>
</div>

