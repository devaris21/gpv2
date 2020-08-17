<div class="modal inmodal fade" id="modal-transfertfond2">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-warning">Transfert fond</h4>
                <small class="font-bold text-warning">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="transfertfond">
                <div class="modal-body">
                    <div>
                        <label>Compte de destination <i class="fa fa-long-arrow-right fa-2x"></i><span1>*</span1></label>
                        <div class="form-group">
                            <?php Native\BINDING::html("select", "comptebanque", null, "comptebanque_id_destination"); ?>
                        </div>
                    </div>
                    <div>
                        <label>Montant à transferer <span style="color: red">*</span> </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            <input type="text" name="montant" class="form-control">
                        </div>
                    </div><br>
                    <div>
                        <label>Ajouter une note</label>
                        <div class="">
                            <textarea class="form-control" name="comment" rows="4"></textarea>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <input type="hidden" name="comptebanque_id_source" value="<?= $comptebanque->id  ?>">
                    <button class="btn dim btn-warning btn-block"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>