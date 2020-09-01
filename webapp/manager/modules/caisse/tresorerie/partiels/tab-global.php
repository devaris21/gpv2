  
<div role="tabpanel" id="tab-global" class="tab-pane active">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">
                <h1 class="mp0 d-inline">Trésorerie générale</h1> <span> /// <?= datecourt($exercice->created) ?> - <?= datecourt($exercice->datefin) ?></span>
            </div>

            <div class="offset-4 col-sm-3 text-center">
                <div class="form-group">
                    <?php Native\BINDING::html("select-tableau", Home\EXERCICECOMPTABLE::findBy([], [], ["created"=>"DESC"]), null, "exercicecomptable_id"); ?>
                </div>
            </div>
        </div>
        

        <div class="row ">
            <div class="col-md-3 white-bg dashboard-header" style="font-size: 12px">
                <br><br>
                <button class="btn btn-primary dim btn-block"><i class="fa fa-truck"></i> Bilan comptable </button>
                <button class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Voir le budget prévisionnel </button>
                <button class="btn btn-warning dim btn-block"><i class="fa fa-truck"></i> Documents de synthèse </button>
                <button data-toggle="modal" data-target="#modal-cloture" class="btn btn-success dim btn-block"><i class="fa fa-truck"></i> Cloture de l'exercice </button>
            </div>
            <div class="col-md-9">
               <div class="row">
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>Income</h5>
                            <h1 class="no-margins">886,200</h1>
                            <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                            <small>Total income</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>