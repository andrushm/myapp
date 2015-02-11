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
        <?php echo $this->fetch('content'); ?>
<?php
echo $this->Html->script('jquery-1.11.2.min');
echo $this->Html->script('bootstrap.min');
echo $this->Html->script('metisMenu.min');
echo $this->Html->script('morris.min');
echo $this->Html->script('sb-admin-2');
?>
</body>
</html>