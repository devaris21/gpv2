
<div class="modal inmodal fade" id="modal-miseenboutique-demande" style="z-index: 1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="text-center">
                        <h2 class="title text-uppercase gras text-center">Nouvelle mise en boutique </h2>
                        <small>Veuillez renseigner la quantité de chaque type de produit que vous voulez mettre en boutique !</small>
                    </div><hr>

                    <form id="formMiseenboutique" classname="miseenboutique">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <label>Entrepot de la demande</label>
                                <?php Native\BINDING::html("select", "entrepot") ?>
                            </div>
                        </div><hr><br>
                        <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                            <div class="row">
                                <div class="col-md-3 col-md text-center" style="color: <?= $produit->couleur ?>">
                                    <i class="fa fa-flask fa-3x"></i><br>
                                    <label>Quantité de <b><?= $produit->name() ?></b></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <?php $produit->fourni("prixdevente", ["isActive ="=>Home\TABLE::OUI]);
                                        foreach ($produit->prixdeventes as $key => $prixdv) { 
                                            $prixdv->actualise(); ?>
                                            <div class="col-sm-3 text-center">
                                                <label class="text-muted"><?= $prixdv->quantite->name() ?> </label>
                                                <input type="text" min=0 number class="gras form-control text-green text-center" name="mise-<?= $prixdv->getId() ?>">
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div><hr>
                        <?php } ?>

                        <hr>
                        <div class="">
                            <input type="hidden" name="boutique_id" value="<?= $boutique->getId() ?>">
                            <input type="hidden" name="etat_id" value="<?= Home\ETAT::PARTIEL ?>">
                            <button class="btn pull-right dim btn-primary" ><i class="fa fa-check"></i> Valider la demande de mise en boutique</button>
                        </div><br>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
