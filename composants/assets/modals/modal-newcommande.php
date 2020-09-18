
<div class="modal inmodal fade" id="modal-newcommande" style="z-index: 9999999999">
    <div class="modal-dialog modal-xll">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nouvelle commande de produits</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer la commande</small>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="text-uppercase">Les produits de la commande</h5>
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
                                            <button class="btn btn-white btn-xs newproduit2 btn-block cursor" data-id="<?= $pro->id ?>"><?= $pro->name(); ?></button>
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
                            <h5 class="text-uppercase">Finaliser la commande</h5>
                        </div>
                        <div class="ibox-content"  style="background-color: #fafafa">
                            <form id="formCommande">
                                <div>
                                    <label>Type de commande <span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <?php Native\BINDING::html("select", "typecommande"); ?>
                                    </div>
                                </div><br>
                                <div class="code">
                                    <label>Saisir le code correspondant <span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="text" name="code" class="form-control" uppercase>
                                    </div>
                                </div><br>


                            <div>
                                <label>Barème de prix (Seulement commande noramle) <span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <?php Native\BINDING::html("select", "typebareme"); ?>
                                </div>
                            </div><br>
                            <div>
                                <label>Date prévue pour livraison <span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" name="datelivraison" value="<?= dateAjoute(2) ?>" class="form-control">
                                </div>
                            </div><br>
                            <div>
                                <label>zone de livraison <span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <?php Native\BINDING::html("select", "zonedevente"); ?>
                                </div>
                            </div><br>
                            <div>
                                <label>Lieu de livraison <span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-markep"></i></span>
                                    <input type="text" name="lieu" class="form-control" required>
                                </div>
                            </div><br>
                            <div>
                                <label>Mode de payement <span style="color: red">*</span> </label>                                
                                <div class="input-group">
                                    <?php Native\BINDING::html("select", "modepayement"); ?>
                                </div>
                            </div><br>
                            <div class="no_modepayement_facultatif">
                                <div>
                                    <label>Montant avancé<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span><input type="text" value="0" min="0" name="avance" class="form-control">
                                    </div>
                                </div>
                            </div><br>
                            <div class="modepayement_facultatif">
                                <div>
                                    <label>Structure d'encaissement<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-bank"></i></span><input type="text" name="structure" class="form-control">
                                    </div>
                                </div><br>
                                <div>
                                    <label>N° numero dédié<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" name="numero" class="form-control">
                                    </div>
                                </div>
                            </div><br>
                            <div>
                                <label>Ajouter une note </label>
                                <textarea class="form-control" rows="4" name="comment"></textarea>
                            </div>

                            <input type="hidden" name="client_id" value="<?= getSession("client_id") ?>">
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
                        <h2 class="font-bold total text-right total">0 Fcfa</h2>
                        <hr/>
                        <button onclick="validerCommande()" class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Valider la commande</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>


