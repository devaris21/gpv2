
<div class="modal inmodal fade" id="modal-prospection" style="z-index: 9999999999">
    <div class="modal-dialog modal-xll">
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
                            </div><hr>

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
                                <div>
                                    <label>Barème de prix <span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <?php Native\BINDING::html("select", "typebareme"); ?>
                                    </div>
                                </div><br>
                                <div>
                                    <label>Choisissez le commercial <span style="color: red">*</span> </label>                               
                                    <div class="input-group">
                                        <?php Native\BINDING::html("select", "commercial"); ?>
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

                                <input type="hidden" name="typeprospection_id" value="<?= Home\TYPEPROSPECTION::PROSPECTION ?>">

                            </form><br>
                            <h5><span>TVA (<?= $params->tva ?> %)</span> <span class="pull-right tva">0 Fcfa </span></h5>
                            <div class="text-right">
                                <label class="mp0">Montant total</label>
                                <h4 class="mp0 gras text-right montant">0 Fcfa</h4>
                            </div><br>
                            <div class="text-right">
                                <label class="mp0">Réduction</label>
                                <h4 class="mp0 gras text-green text-right reduction">0 Fcfa</h4>
                            </div><br>
                            <div class="text-right">
                                <label class="mp0">Total à payer</label>
                                <h2 class="mp0 gras text-danger text-right total">0 Fcfa</h2>
                            </div><br>
                            <hr/>
                            <button onclick="validerPropection()" class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Valider la prospection</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


