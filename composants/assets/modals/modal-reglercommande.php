<div class="modal inmodal fade" id="modal-reglerCommande<?= $commande->id  ?>">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-red">Recouvrement</h4>
            </div>
            <form method="POST" class="formShamman" classname="reglementclient">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Montant reçu <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" number class="form-control" name="montant" value="<?= $commande->reste()  ?>" min=0 max="<?= $commande->reste()  ?>" required>
                            </div>
                        </div>   
                        <div class="col-sm-6">
                            <label>Mode de remboursement <span style="color: red">*</span> </label>                                
                            <div class="input-group">
                                <?php Native\BINDING::html("select", "modepayement"); ?>
                            </div>
                        </div>
                    </div><br>
                    <div class="row modepayement_facultatif">
                        <div class="col-sm-6">
                            <label>Structure d'encaissement<span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span><input type="text" name="structure" class="form-control">
                            </div>
                        </div><br>
                        <div class="col-sm-6">
                            <label>N° numero dédié<span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>             
                </div><hr>
                <div class="container">
                    <input type="hidden" name="commande_id" value="<?= $commande->id ?>">
                    <input type="hidden" name="client_id" value="<?= $commande->groupecommande->client->id ?>">
                    <input type="hidden" name="recouvrement" value="<?= Home\TABLE::OUI ?>">
                    <input type="hidden" name="comment" value="Recouvrement de commande N°<?= $commande->reference ?>">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm dim btn-success pull-right"><i class="fa fa-check"></i> Valider le payement</button>
                </div>
            </form>
        </div>
    </div>
</div>
