<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">


               <div class="row">
                <div class="col-lg-4">
                    <div class="contact-box">
                        <a class="row" href="profile.html">
                            <div class="col-4">
                                <div class="text-center">
                                    <img alt="image" class="rounded-circle m-t-xs img-fluid" src="img/a2.jpg">
                                    <div class="m-t-xs font-bold">Graphics designer</div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h3><strong>John Smith</strong></h3>
                                <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                                <address>
                                    <strong>Twitter, Inc.</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-box">
                        <a class="row" href="profile.html">
                            <div class="col-4">
                                <div class="text-center">
                                    <img alt="image" class="rounded-circle m-t-xs img-fluid" src="img/a2.jpg">
                                    <div class="m-t-xs font-bold">Graphics designer</div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h3><strong>John Smith</strong></h3>
                                <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                                <address>
                                    <strong>Twitter, Inc.</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-box">
                        <a class="row" href="profile.html">
                            <div class="col-4">
                                <div class="text-center">
                                    <img alt="image" class="rounded-circle m-t-xs img-fluid" src="img/a2.jpg">
                                    <div class="m-t-xs font-bold">Graphics designer</div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h3><strong>John Smith</strong></h3>
                                <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                                <address>
                                    <strong>Twitter, Inc.</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br>

    <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

    <?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-ventecave.php")); ?> 

</div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
<script type="text/javascript" src="<?= $this->relativePath("../../production/miseenboutique/script.js") ?>"></script>

<script>
    $(document).ready(function() {

        var id = "<?= $this->id;  ?>";
        if (id == 1) {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Content de vous revoir de nouveau!', 'Bonjour <?= $employe->name(); ?>');
}, 1300);
}



var sparklineCharts = function(){

 $("#sparkline2").sparkline([24, 43, 43, 55, 44, 62, 44, 72], {
     type: 'line',
     width: '100%',
     height: '60',
     lineColor: '#1ab394',
     fillColor: "#ffffff"
 });

};

var sparkResize;

$(window).resize(function(e) {
    clearTimeout(sparkResize);
    sparkResize = setTimeout(sparklineCharts, 500);
});

sparklineCharts();




var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->direct ?>], <?php } ?> ];

var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->prospection ?>], <?php } ?> ];

var data3 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->cave ?>], <?php } ?> ];

var dataset = [
{
    label: "Vente directe",
    data: data1,
    color: "#1ab394",
    bars: {
        show: true,
        align: "left",
        barWidth: 12 * 60 * 60 * 600,
        lineWidth:0
    }

}, {
    label: "Vente par prospection",
    data: data2,
    color: "#cc0000",
    bars: {
        show: true,
        align: "right",
        barWidth: 12 * 60 * 60 * 600,
        lineWidth:0
    }

}, {
    label: "Vente en cave",
    data: data3,
    color: "#0088cc",
    bars: {
        show: true,
        align: "right",
        barWidth: 12 * 60 * 60 * 600,
        lineWidth:0
    }

}
];


var options = {
    xaxis: {
        mode: "time",
        tickSize: [2, "day"],
        tickLength: 0,
        axisLabel: "Date",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Arial',
        axisLabelPadding: 10,
        color: "#d5d5d5"
    },
    yaxes: [{
        position: "left",
        color: "#d5d5d5",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Arial',
        axisLabelPadding: 3
    }
    ],
    legend: {
        noColumns: 1,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: false,
        borderWidth: 0
    }
};

function gd(year, month, day) {
    return new Date(year, month - 1, day).getTime();
}

var previousPoint = null, previousLabel = null;

$.plot($("#flot-dashboard-chart"), dataset, options);



});
</script>


</body>

</html>