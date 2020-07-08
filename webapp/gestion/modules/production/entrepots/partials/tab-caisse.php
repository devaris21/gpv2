<div role="tabpanel" id="pan-caisse" class="tab-pane">
	<div class=" border-bottom white-bg dashboard-header">
		<div class="row">
			<div class="col-md-3">
                   <!--  <div class="ibox ">
                        <div class="ibox-title border">
                            <span class="label label-success float-right">An</span>
                            <h5 class="d-inline text-uppercase">Chif. affaire</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins"><?= money(Home\COMMANDE::CA(date("Y")."-01-01" , dateAjoute())) ?></h1>
                            <div class="stat-percent font-bold text-warning"><?= money(Home\CLIENT::dettes()) ?></div>
                            <small>Dette des clients</small>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-3">
                	<div class="ibox ">
                		<div class="ibox-title">
                			<h5 class="text-uppercase text-green">Recettes</h5>
                		</div>
                		<div class="ibox-content">
                			<h1 class="no-margins text-green"><?= money($comptecourant->depots($date1 , $date2)) ?></h1>
                			<div class="stat-percent font-bold text-green"><?= money(Home\REGLEMENTCLIENT::total($date1 , $date2, $entrepot->id)) ?></div>
                			<small>Reglements de clients</small>
                		</div>
                	</div>
                </div>

                <div class="col-md-3">
                	<div class="ibox ">
                		<div class="ibox-title">
                			<h5 class="text-uppercase text-red">Dépenses</h5>
                		</div>
                		<div class="ibox-content">
                			<h1 class="no-margins text-red"><?= money($comptecourant->retraits($date1 , $date2)) ?></h1>
                		</div>
                	</div>
                </div>
                <div class="col-md-3">
                	<div class="ibox ">
                		<div class="ibox-title">
                			<h5 class="text-uppercase">Résultats</h5>
                		</div>
                		<div class="ibox-content">
                			<h1 class="no-margins"><?= money($comptecourant->solde($date1 , $date2)) ?></h1>
                			<div class="stat-percent font-bold text-info"></div>
                			<small>...</small>
                		</div>
                	</div>
                </div>
            </div>
            <div class="row">
            	<div class="col-lg-8">
            		<div class="ibox ">
            			<div class="ibox-content">
            				<div class="m-t-sm">
            					<div class="border-right">
            						<div>
            							<canvas id="lineChart" height="110"></canvas>
            						</div>
            					</div><hr>
            					<div class="row stat-list text-center">
            						<div class="col-4">
            							<h3 class="no-margins text-green"><?= money($comptecourant->depots(dateAjoute() , dateAjoute(+1))) ?> <?= $params->devise ?> </h3>
            							<small>Recette totale du jour</small>

            							<div class="progress progress-mini" style="margin-top: 5%;">
            								<div class="progress-bar" style="width: 100%; background-color: #dedede"></div>
            							</div><br>

            							<div class="cursor" data-toggle="modal" data-target="#modal-attente">
            								<h3 class="no-margins text-blue"><?= money(comptage(Home\OPERATION::enAttente($entrepot->id), "montant", "somme")) ?> <?= $params->devise ?> *</h3>
            								<small>Versement en attente</small>
            							</div>
            						</div>
            						<div class="col-4">
            							<br>
            							<h2 class="no-margins gras"><?= money($comptecourant->solde(null , dateAjoute())) ?> <small><?= $params->devise ?></small></h2>
            							<small>En caisse actuellement</small>
            							<div class="progress progress-mini">
            								<div class="progress-bar" style="width: 100%;"></div>
            							</div>
            						</div>
            						<div class="col-4">
            							<h3 class="no-margins text-red"><?= money($comptecourant->retraits(dateAjoute() , dateAjoute(+1))) ?> <?= $params->devise ?> </h3>
            							<small>Dépenses totales du jour</small>

            							<div class="progress progress-mini" style="margin-top: 5%;">
            								<div class="progress-bar" style="width: 100%; background-color: #dedede"></div>
            							</div><br>


            						</div>
            					</div>                                
            				</div>
            			</div>
            		</div>
            	</div>
            	<div class="col-lg-4">
            		<div class="ibox">
            			<div class="ibox-title">
            				<h5 class="text-uppercase">Solde des 3 derniers jours</h5>
            			</div>
            			<?php $i = -2;  while ($i <= 0) {
            				$datea = dateAjoute($i-1);
            				$dateb = dateAjoute($i);
            				$ouv = $comptecourant->solde(null , $datea);
            				$ferm = $comptecourant->solde(null , $dateb);

            				$taux = 0;
            				if ($ouv > 0) {
            					$taux = (($ferm - $ouv) / $ouv);
            				}
            				?>
            				<div class="ibox-content text-center">
            					<div class="row">
            						<div class="col-4">
            							<small class="stats-label">Ouverture <?= datecourt2($dateb)  ?></small>
            							<h4><?= money($ouv) ?> <small><?= $params->devise ?></small></h4>
            						</div>
            						<div class="col-4">
            							<small class="stats-label ">Progession</small>
            							<h4 class="text-<?= ($taux > 0)?"green":"red"  ?>"><?= round(($taux * 100), 2) ?>%</h4>
            						</div>
            						<div class="col-4">
            							<small class="stats-label">Cloture <?= datecourt2($dateb)  ?></small>
            							<h4><?= money($ferm) ?> <small><?= $params->devise ?></small></h4>
            						</div>
            					</div>
            				</div>
            				<?php
            				$i++;
            			} ?>
            		</div>
            	</div>

            </div>

            <div class="row">

            	<div class="col-lg-12">
            		<div class="ibox ">
            			<div class="ibox-title">
            				<h5 class="text-uppercase">Tableau des compte</h5>
            				<div class="ibox-tools">

            				</div>
            			</div>
            			<div class="ibox-content">
            				<div class="row">
            					<div class="col-md-12">
            						<div class="table-responsive">
            							<table class="table table-bordered table-hover table-operation">
            								<thead>
            									<tr class="text-center text-uppercase">
            										<th colspan="2" style="visibility: hidden; width: 65%"></th>
            										<th>Entrée</th>
            										<th>Sortie</th>
            										<th>Résultats</th>
            									</tr>
            								</thead>
            								<tbody class="tableau">
            									<tr>
            										<td colspan="2">Repport du solde (<?= datecourt($date1) ?>) </td>
            										<td class="text-center">-</td>
            										<td class="text-center">-</td>
            										<td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = $comptecourant->solde(null , dateAjoute1($date1, -1))) ?> <?= $params->devise ?></td>
            									</tr>
            									<?php foreach ($tableau as $key => $operation) {  ?>
            										<tr>
            											<td class="text-center" style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("gestion", $operation->fiche, "boncaisse", $operation->id)  ?>"><i class="fa fa-file-text-o fa-2x"></i></a> 
            											</td>
            											<td>
            												<h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)?"text-green":"text-red" ?>"><?= $operation->type ?>  

            												<?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
            													|
            													&nbsp;&nbsp;<i onclick="modifierOperation(<?= $operation->id ?>)" class="cursor fa fa-pencil text-dark"></i> 
            													&nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('operation', <?= $operation->id ?>)"></i>
            												<?php } ?>

            												<span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span>
            											</h6>
            											<i><?= $operation->comment ?> ## <u style="font-size: 9px; font-style: italic;"><?= $operation->structure ?> - <?= $operation->numero ?></u></i>
            										</td>
                                           <!--  <td width="110" class="text-center" style="padding: 0; border-right: 2px dashed grey">
                                             <?php if ($operation->etat_id == Home\ETAT::ENCOURS) { ?>
                                                 <button style="padding: 2px 6px;" onclick="valider(<?= $operation->id ?>)" class="cursor simple_tag"><i class="fa fa-file-text-o"></i> Valider</button><span style="display: none">en attente</span>
                                             <?php } ?>
                                             <br><small style="display: inline-block; font-style: 8px; line-height: 12px;"><?= $operation->structure ?> - <?= $operation->numero ?></small>
                                         </td> -->
                                         <?php if ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT) { ?>
                                         	<td class="text-center text-green gras" style="padding-top: 12px;">
                                         		<?= money($operation->mouvement->montant) ?> <?= $params->devise ?>
                                         	</td>
                                         	<td class="text-center"> - </td>
                                         <?php }elseif ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::RETRAIT) { ?>
                                         	<td class="text-center"> - </td>
                                         	<td class="text-center text-red gras" style="padding-top: 12px;">
                                         		<?= money($operation->mouvement->montant) ?> <?= $params->devise ?>
                                         	</td>
                                         <?php } ?>
                                         <?php $last += ($operation->mouvement->typemouvement_id == Home\TYPEMOUVEMENT::DEPOT)? $operation->mouvement->montant : -$operation->mouvement->montant ; ?>
                                         <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                                     </tr>
                                 <?php } ?>
                                 <tr style="height: 15px;"></tr>
                                 <tr>
                                 	<td style="border-right: 2px dashed grey" colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes au <?= datecourt(dateAjoute()) ?></h4></td>
                                 	<td><h3 class="text-center text-green"><?= money($entrees + $repport) ?> <?= $params->devise ?></h3></td>
                                 	<td><h3 class="text-center text-red"><?= money($depenses) ?> <?= $params->devise ?></h3></td>
                                 	<td style="background-color: #fafafa"><h3 class="text-center text-blue gras"><?= money($last) ?> <?= $params->devise ?></h3></td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>

                 <div class="col-md-2">

                 </div>
             </div>
         </div>
     </div>

 </div>
</div>

</div>

</div>