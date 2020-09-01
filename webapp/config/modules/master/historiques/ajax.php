<?php 
namespace Home;
require '../../../../../core/root/includes.php';
use Native\ROOTER;
use Native\RESPONSE;
use Native\FICHIER;


$data = new RESPONSE;
extract($_POST);


if ($action == "refresh") {
	$datas = HISTORY::findBy(["DATE(created) ="=>dateAjoute(-$nb-3)], [], ["created"=>"DESC"]);
	foreach ($datas as $key => $ligne) {
		$ligne->actualise(); ?>
		<div class="stream">
			<div class="stream-badge">
				<i class="fa fa-circle"></i>
			</div>
			<div class="stream-panel">
				<div class="stream-info">
					<a href="#">
						<img src="img/a6.jpg" />
						<span><?= $ligne->employe->name() ?></span>
						<span class="date"><?= depuis($ligne->created) ?></span>
					</a>
				</div>
				<?= $ligne->sentense  ?>
			</div>
		</div>
	<?php }
}

