
<div class="modal inmodal fade" id="modal-prospection_" style="z-index: 9999999999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nouvelle prospection directe</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer la prospection</small>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="text-uppercase">Les produits de la prospection</h5>
                        </div>
                        <div class="ibox-content"><br>
                            <div class="table-responsive">
                                <table class="table  table-striped">
                                    <tbody class="commande">
                                        <!-- rempli en Ajax -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <?php foreach (Home\TYPEPRODUIT::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $type) { ?>
                                    <div class="col text-center border-right">
                                        <h5 class="text-uppercase gras text-center"><?= $type->name()  ?></h5>
                                        <?php foreach ($type->fourni("typeproduit_parfum", ["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
                                            $pro->actualise(); ?>
                                            <button class="btn btn-white btn-xs newproduit btn-block cursor" data-id="<?= $pro->id ?>"><?= $pro->name(); ?></button>
                                        <?php }  ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="ibox"  style="background-color: #eee">
                        <div class="ibox-title" style="padding-right: 2%; padding-left: 3%; ">
                            <h5 class="text-uppercase">Finaliser la prospection</h5>
                        </div>
                        <div class="ibox-content"  style="background-color: #fafafa">
                            <form id="formProspection">
                                <input type="hidden" name="commercial_id" value="<?= $commercial->id ?>">
                                <div>
                                    <label>Barème de prix <span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <?php Native\BINDING::html("select", "typebareme"); ?>
                                    </div>
                                </div><br>

                                <div>
                                    <label>Zone de vente <span style="color: red">*</span> </label>                                
                                    <div class="input-group">
                                        <?php Native\BINDING::html("select", "zonedevente"); ?>
                                    </div>
                                </div><br>

                                <div>
                                    <label>Transport pour la prospection </label>                           
                                    <div class="input-group">
                                        <input value="0" type="number" class="form-control" number name="transport">
                                    </div>
                                </div><br>

                                <div>
                                    <label>Monnaie pour la prospection </label>                           
                                    <div class="input-group">
                                        <input value="0" type="number" class="form-control" number name="monnaie">
                                    </div>
                                </div><br>

                                <input type="hidden" name="client_id" value="<?= Home\CLIENT::ANONYME ?>">
                            </form><br>
                            <h2 class="font-bold total text-right total">0 Fcfa</h2>
                            <hr/>
                            <button onclick="validerPropection()" class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Valider la commande</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


