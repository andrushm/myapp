<?php //foreach($lastMeters as $lastMeter){
//    echo $lastMeter['PowerMeters']['name'].'<br>';

    ?>


<?php //}; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="col-lg-12">
    <table id="statistic" class="table table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Device_ID</th>
            <th>Name</th>
        </tr>
        </thead>

    </table>

<table class="table table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Device_ID</th>
        <th>Name</th>
        <?php foreach($statistics['months'] as $res){
                echo "<th>$res</th>";
              };
        ?>
    </tr>
    </thead>

    <?php foreach($statistics['data'] as $res){
//        var_dump($res);
            echo "<tr>";
            foreach ($res[0] as $row){
                echo "<td>$row</td>";
            }
            echo "</tr>";
        }
    ?>

</table>
</div>
<div id="graphdiv" style="width:900px; height:700px;"></div>