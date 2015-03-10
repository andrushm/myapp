<?php //foreach($lastMeters as $lastMeter){
//    echo $lastMeter['PowerMeters']['name'].'<br>';

?>


<?php //}; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Online</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Meters status
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table id="monitoring" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quality</th>
                    <th>Power</th>
                    <th>Energy</th>
                    <th>To Day</th>
                    <th>Yeterday</th>
                    <th>This week</th>
                    <th>Last week</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quality</th>
                    <th  id="fSum">Power</th>
                    <th>Energy</th>
                    <th>To Day</th>
                    <th>Yeterday</th>
                    <th>This week</th>
                    <th>Last week</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Bar Chart Example
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
                <div id="graphdiv"></div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->

    <canvas id="myChart" width="400" height="400"></canvas>
<!--    <div id="graphdiv" style="width:900px; height:700px;"></div>-->


<style>
    #graphdiv {width:900px; height:700px;}
</style>