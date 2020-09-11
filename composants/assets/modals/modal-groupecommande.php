
<div class="modal inmodal fade" id="modal-groupecommande" style="z-index: -25009">
    <div class="modal-dialog modal-xll">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-3">
                                    <img style="width: 120%" src="<?= $rooter->stockage("images", "societe", $params->image) ?>">
                                </div>
                                <div class="col-9">
                                    <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                    <h5 class="mp0"><?= $params->postale ?></h5>
                                    <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                    <h5 class="mp0">Email: <?= $params->email ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 text-right">
                            <h2 class="title text-uppercase gras">Fiche de commande</h2>
                            <h3 class="text-uppercase"><?= $groupecommande->client->name()  ?> // <span style="font-weight: normal;"><?= $groupecommande->client->typeclient->name()  ?></span></h3>
                            <h5><?= $groupecommande->client->contact  ?> // <?= $groupecommande->client->email  ?></h5>
                        </div>
                    </div><hr>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3"></th>
                                <?php foreach ($datas as $key => $ligne) {
                                    $produit = new Home\PRODUIT;
                                    $produit->id = $ligne->produit_id;
                                    $produit->actualise();

                                    $emballage = new Home\EMBALLAGE;
                                    $emballage->id = $ligne->emballage_id;
                                    $emballage->actualise(); ?>
                                    <th class="text-center" style="padding: 2px"><span class="small"><?= $produit->name() ?></span><br>
                                        <img style="height: 20px" src="<?= $rooter->stockage("images", "emballages", $emballage->image) ?>" >
                                        <small><?= $emballage->name() ?></small>
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $datas1 = $groupecommande->fourni("commande", ["etat_id !="=>Home\ETAT::ANNULEE]);
                            foreach ($datas1 as $key => $ligne) {
                                $ligne->fourni("lignecommande");
                                $ligne->type = "commande";
                            }
                            $datas2 = $groupecommande->fourni("prospection", ["etat_id !="=>Home\ETAT::ANNULEE]);
                            foreach ($datas2 as $key => $ligne) {
                                $ligne->fourni("ligneprospection");
                                $ligne->type= "Livraison";
                            }
                            $lots = array_merge($datas1, $datas2);
                            usort($lots, "comparerDateCreated");

                            foreach ($lots as $key => $ligne) { ?>
                                <tr>
                                    <td data-toggle="tooltip" title="Annuler / Supprimer">
                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            <?php if ($ligne->type == "commande") { ?>
                                                <i class="fa fa-close fa-3x d-block text-red cursor" onclick="annulerCommande(<?= $ligne->id ?>)"></i>
                                            <?php }else if($ligne->type == "prospection" && $ligne->etat_id == Home\ETAT::ENCOURS){ ?> 
                                                <i class="fa fa-close fa-3x d-block text-red cursor" onclick="annulerLivraison(<?= $ligne->id ?>)"></i>
                                            <?php } ?> 
                                        <?php } ?> 
                                    </td>
                                    <td>
                                        <h5 class="text-uppercase mp0"><?= $ligne->type ?> N°<?= $ligne->reference  ?></h5>
                                        <small><?= datelong($ligne->created)  ?></small>
                                    </td>
                                    <td data-toggle="tooltip" title="imprimer le bon de <?= $ligne->type ?>">
                                        <?php if ($ligne->type == "Livraison") { ?>
                                            <a target="_blank" href="<?= $rooter->url("fiches", "master", "bonlivraison", $ligne->id) ?>">
                                                <i class="fa fa-file-text fa-2x d-block"></i></a>
                                            <?php }else{ ?>
                                                <a target="_blank" href="<?= $rooter->url("fiches", "master", "boncommande", $ligne->id) ?>">
                                                    <i class="d-block fa fa-file-text fa-2x"></i></a>
                                                <?php } ?>                                
                                            </td>
                                            <?php 
                                            foreach ($datas as $key => $lig) {
                                                $test = 0;
                                                foreach ($ligne->items as $key => $item) { 
                                                    if ($item->produit_id == $lig->produit_id &&  $item->emballage_id == $lig->emballage_id) { 
                                                        $test = $item->quantite;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <td><h3 class="text-<?= ($ligne->type == "prospection")? "orange":"green" ?> text-center"> <?= $test  ?> </h3></td>
                                                <?php
                                            }
                                            ?>

                                            <?php if ($ligne->type == "commande" && $ligne->reglementclient_id != 0) { ?>
                                                <td>
                                                    <h4 class="mp0 text-uppercase" style="margin-top: -1.5%;">T = <?= money($ligne->montant) ?> <?= $params->devise  ?> </h4>
                                                    <small>Avance <?= money($ligne->avance) ?> <?= $params->devise  ?> <small style="font-weight: normal;;" data-toggle="tooltip" title="Payement par <?= $ligne->reglementclient->modepayement->name();  ?>">(<?= $ligne->reglementclient->modepayement->initial;  ?>)</small></small>
                                                </td>
                                                <td data-toggle="tooltip" title="imprimer le facture">
                                                    <a target="_blank" href="<?= $rooter->url("fiches", "master", "boncaisse", $ligne->reglementclient_id) ?>"><i class="fa fa-file-text fa-2x d-block"></i></a>
                                                </td>

                                            <?php }  ?>
                                            <td>
                                                <?php if (isset($ligne->reste) && $ligne->reste() > 0) { ?>
                                                    <div class=" col-md">
                                                        <button class="btn btn-danger btn-xs dim" data-toggle="modal" data-target="#modal-reglerCommande<?= $ligne->id  ?>" data-dismiss="modal"><i class="fa fa-money"></i> Regler la facture</button>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <?php if ($ligne->type == "vente" && $ligne->etat_id == Home\ETAT::VALIDEE) { ?>
                                                <td>
                                                    <i class="fa fa-check fa-2x text-green"></i>
                                                </td>
                                            <?php }  ?>
                                        </tr>
                                    <?php }
                                    ?>

                                    <tr style="height: 20px;"></tr>

                                    <tr>
                                        <td colspan="3"><h2 class="text-uppercase text-right">Reste à livrer : </h2></td>
                                        <?php foreach ($datas as $key => $lig) { ?>
                                            <td widtd="90" class="text-center"><h2 class="gras"><?= money($groupecommande->reste($lig->produit_id, $lig->emballage_id)) ?></h2></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table><br><hr>

                            <div class="row text-center">
                                <div class="col-md">
                                    <button class="btn btn-primary dim" onclick="fairenewcommande(<?= $groupecommande->id ?>)"><i class="fa fa-cart-plus"></i> Faire nouvelle commande</button>
                                </div>

                                <div class=" col-md">
                                    <button class="btn btn-warning dim" onclick="newlivraison(<?= $groupecommande->id  ?>)"><i class="fa fa-truck"></i> Faire livraison aujourd'hui</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
