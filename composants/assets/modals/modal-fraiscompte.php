<div class="modal inmodal fade" id="modal-fraiscompte">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-warning">Frais de compte</h4>
                <small class="font-bold text-warning">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="mouvement">
                <div class="modal-body">
                    <div class="">
                        <label>Montant des frais <span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="montant" required>
                        </div>
                    </div>   
                    <div class="">
                        <label>Détails des frais <span1>*</span1></label>
                        <div class="form-group">
                            <textarea class="form-control" rows="4" name="comment"></textarea>
                        </div>
                    </div> 
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <input type="hidden" name="typemouvement_id" value="<?= home\TYPEMOUVEMENT::RETRAIT  ?>">
                    <button class="btn dim btn-warning pull-right"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>