<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $this->fetch('title'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo $this->Html->css('bootstrap');
    echo $this->Html->css('metisMenu.min.css');
    echo $this->Html->css('timeline');
    echo $this->Html->css('sb-admin-2');
    echo $this->Html->css('font-awesome.min');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>

<!-- If you'd like some sort of menu to
show up on all of your views, include it here -->
<!--<div id="header">-->
<!--    <div id="menu">-->
<div id="wrapper">
   <?php
        echo $this->element('navigation');
   ?>
<!--    </div>-->
<!--</div>-->

<div id="page-wrapper">
<div class="row">
    <?php

    $myalert = $this->Session->flash('success');
    if (!empty($myalert)) {
        echo $this->BootstrapHtml->alert($myalert, 'success');
    };
    unset($myalert);
    $myalert = $this->Session->flash('alert');
    if (!empty($myalert)) {
        echo $this->BootstrapHtml->alert($myalert);
    };
    unset($myalert);

    ?>


    <div class="col-lg-12">
        <?php echo $this->fetch('content'); ?>
<!--        <h1 class="page-header">Dashboard</h1>-->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<!--<script src="../bower_components/jquery/dist/jquery.min.js"></script>-->
<!---->
<!--<!-- Bootstrap Core JavaScript -->-->
<!--<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<!---->
<!--<!-- Metis Menu Plugin JavaScript -->-->
<!--<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>-->
<!---->
<!--<!-- Morris Charts JavaScript -->-->
<!--<script src="../bower_components/raphael/raphael-min.js"></script>-->
<!--<script src="../bower_components/morrisjs/morris.min.js"></script>-->
<!--<script src="../js/morris-data.js"></script>-->
<!---->
<!--<!-- Custom Theme JavaScript -->-->
<!--<script src="../dist/js/sb-admin-2.js"></script>-->




<!-- Add a footer to each displayed page -->
<div id="footer">...</div>
<?php
echo $this->Html->script('jquery-1.11.2.min');
echo $this->Html->script('jquery.dataTables.min');
echo $this->Html->script('dygraph-combined');
echo $this->Html->script('bootstrap.min');
echo $this->Html->script('metisMenu.min');
echo $this->Html->script('morris.min');
echo $this->Html->script('sb-admin-2');
echo $this->Html->script('ajax');
echo $this->Html->script('ready');
?>
</body>
</html>