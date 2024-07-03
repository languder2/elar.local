<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title??""?></title>
    <script defer src="<?= base_url('js/lib/bootstrap.bundle.min.js');?>"></script>
    <link href="<?=base_url('css/lib/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url("css/admin/main.css"); ?>?t=<?php echo(microtime(true).rand()); ?>" rel="stylesheet" type="text/css">
    <script defer src="<?= base_url('/js/admin/main.js');?>?t=<?php echo(microtime(true).rand()); ?>"></script>

    <?php if(!empty($includes->js)) foreach ($includes->js as $js):?>
        <script defer src="<?= base_url($js);?>?t=<?php echo(microtime(true).rand()); ?>"></script>
    <?php endforeach; ?>
    <?php if(!empty($includes->css)) foreach ($includes->css as $css):?>
        <link href="<?=base_url($css);?>?t=<?php echo(microtime(true).rand()); ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>
</head>
<body>
<header class="container-fluid px-0">
    <?=$menuTop??""?>
</header>
<main class="container-lg px-2 py-3">
    <?=$pageContent??""?>
</main>
<footer>
</footer>
</body>