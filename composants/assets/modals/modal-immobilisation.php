<div class="modal inmodal fade" id="modal-immobilisation">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire des immobilisations</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="immobilisation">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <dl>
                                <dt>Immobilisation != charges</dt>
                                <dd>Les immobilisations correspondent aux biens destinés à servir <b>de façon durable</b> pour l'activité de l'entreprise. Leur prix d'achat est supérieur à <?= money($params->minImmobilisation) ?> <?= $params->devise  ?>. Ils sont amortis sur une certaine durée (selon la nature du bien). Les immobilisation financières ne sont pas amortissables</dd>
                            </dl>
                        </div>
                        <div class="col-sm-4">
                            <dl>
                                <dt>Les types d'amortissement</dt>
                                <dd>Dans le cas de l'amortissement linéaire, l'annuité (le montant de la dépréciation de la valeur) du immobilisé ne change pas d'un exercice comptable à un autre, et le taux d'amortissement ne change pas d'une année à l'autre, tout le contraire du dégressif. Mais l'avantage de ce dernier, est qu'il permet d'amortir les biens plus vite.</dd>
                            </dl>
                        </div>
                        <div class="col-sm-4">
                            <dl>
                                <dt>Bon à savoir</dt>
                                <dd>L'amortissement des biens se fera automatiquement à la fin de chaque exercice comptable pendant toute la durée de la période d'ammortissement que vous aurez spécifier.</dd>
                            </dl>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Type d'immobilisation <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "typeimmobilisation")  ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Nature du bien <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "typebien")  ?>
                            </div>
                        </div> 
                        <div class="col-sm-4">
                            <label>Libéllé(Nom) du bien <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Prix de revient du bien <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="montant" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Type d'amortissement <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "typeamortissement")  ?>
                            </div>
                        </div>  
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-7">
                                    <label>Mise en utilisation <span1>*</span1></label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="started" required>
                                    </div>
                                </div> 
                                <div class="col-sm-5">
                                    <label>Durée d'amortissement</label>
                                    <div class="form-group">
                                        <input type="number" number class="form-control" name="duree" required>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                    </div><hr>

                    <div class="row">
                        <div class="col-sm-4">
                            <label>Compte débité pour le reglement <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "comptebanque")  ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Ajouter un commentaire </label>
                            <textarea class="form-control" name="comment" rows="4"></textarea>
                        </div>                     
                    </div><hr>

                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider le formulaire</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>