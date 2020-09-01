<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/config/elements/templates/head.php")); ?>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">
                    <!--<div class="navbar-header">-->
                        <!--<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">-->
                            <!--<i class="fa fa-reorder"></i>-->
                            <!--</button>-->

                            <a href="#" class="navbar-brand " style="padding: 3px 15px;"><h1 class="mp0 gras" style="font-size: 45px">GPV</h1></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-reorder"></i>
                            </button>

                            <!--</div>-->
                            <div class="navbar-collapse collapse" id="navbar">
                                <ul class="nav navbar-nav mr-auto">
                                    <li class="gras <?= (isJourFerie(dateAjoute(1)))?"text-red":"text-muted" ?>">
                                        <span class="m-r-sm welcome-message text-uppercase" id="date_actu"></span> 
                                        <span class="m-r-sm welcome-message gras" id="heure_actu"></span> 
                                    </li>

                                </ul>
                                <a id="onglet-master" href="<?= $this->url("config", "master", "dashboard") ?>" class="onglets btn btn-xs btn-white" style="font-size: 12px; margin-right: 10px;"><i class="fa fa-long-arrow-left"></i> Retour au tableau de bord</a>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig container-fluid">

                            <div class="ibox-content">

                                <div class="activity-stream">

                                    <?php foreach ($datas as $key => $ligne) {
                                        $ligne->actualise(); ?>
                                        <div class="stream">
                                            <div class="stream-badge">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                            <div class="stream-panel">
                                                <div class="stream-info">
                                                    <a href="#">
                                                        <img src="<?= $this->stockage("images", "employes", $ligne->employe->image)  ?>" />
                                                        <span><?= $ligne->employe->name() ?></span>
                                                        <span class="date"><?= depuis($ligne->created) ?></span>
                                                    </a>
                                                </div>
                                                <?= $ligne->sentense  ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <br>

                    <?php include($this->rootPath("webapp/config/elements/templates/footer.php")); ?>


                </div>
            </div>



            <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

            <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.js"></script>


            <script type="text/javascript">
                var url = "../../webapp/config/modules/master/historiques/ajax.php";
                $('.activity-stream').infiniteScroll({
                  // options
                  path: function() {
                    console.log(this.loadCount)
                    var pageNumber = ( this.loadCount + 1 ) * 10;
                    $.post(url, {action:"refresh", nb:this.loadCount}, (data)=>{
                        $('.activity-stream').append(data);
                    },"html");
                    return '../../webapp/manager/elements/templates/script.php';
                },
                append: '.stream',
                history: false,
            });
        </script>

    </body>



    </html>