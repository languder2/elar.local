<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$meta->title??"Электронный научный архив МелГУ: "?></title>
    <meta name="description" content="<?=$meta->description??""?>">
    <meta name="keywords" content="<?=$meta->keywords??""?>">
    <link rel="icon" href="<?= base_url('img/favicon-1.ico');?>" sizes="32x32">
    <link rel="icon" href="<?= base_url('img/favicon-1.ico');?>" sizes="192x192">

    <link rel="stylesheet" href="<?= base_url('css/style.css');?>?t=<?=time()?>">
    <link rel="stylesheet" href="<?= base_url('css/public/main.css');?>?t=<?=time()?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="<?= base_url('css/anim-bg.css');?>?t=<?=time()?>">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('css/fb.css');?>?t=<?=time()?>">
    <script defer src="<?= base_url('js/imask.js');?>?t=<?=time()?>"></script>
    <script defer src="<?= base_url('js/fb.js');?>?t=<?=time()?>"></script>

    <?php if(!empty($includes->js)) foreach ($includes->js as $js):?>
        <script defer src="<?= base_url($js);?>?t=<?php echo(microtime(true).rand()); ?>"></script>
    <?php endforeach; ?>
    <?php if(!empty($includes->css)) foreach ($includes->css as $css):?>
        <link href="<?=base_url($css);?>?t=<?php echo(microtime(true).rand()); ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>

</head>
<body>

<header class="navbar navbar-expand-xl navbar-light fixed-top unscrolled" id="mainNav">
    <div class="col-12 d-flex justify-content-between p-2 pt-0" style="max-width: 1320px; margin: 0 auto;">
        <div class="logo">
            <a class="navbar-brand" href="/">
                <img class="clr-logo" src="<?= base_url('img/full-logo.png');?>" alt="Логотип">
                <img class="min-logo" src="<?= base_url('img/clr-logo.png');?>" alt="Логотип">
                <img class="white-logo log" src="<?= base_url('img/white-logo.png');?>" alt="Логотип">
            </a>
        </div>
        <div class="d-flex upper-bnt" style="align-items: center;">
            <a class="d-block fb_call" href="#">Задать вопрос<i class="bi bi-chat-left" style="margin-left: 10px;"></i></a>
        </div>
    </div>
    <div class="container-fluid under-header" style="max-width: 1320px; margin: 0 auto;">
        <a class="d-hidden" href="#"><img src=""></a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBasic" aria-controls="navbarBasic" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarBasic">
            <ul class="navbar-nav  mb-2 mb-xl-0">
                <li class="nav-item">
                    <a class="nav-link">
                        Разделы и коллекции
                    </a>
                </li>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Просмотреть
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <h6 class="dropdown-header">Посмотреть:</h6>
                        </li>
                        <li><a class="dropdown-item" href="/browse/date">По дате</a></li>
                        <li><a class="dropdown-item" href="/browse/authors">По автору</a></li>
                        <li><a class="dropdown-item" href="/browse/name">По заглавию</a></li>
                        <li><a class="dropdown-item" href="/browse/tags">Источники</a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</header>
<div class="container-lg wd main-content">
    <?=$pageContent??""?>
</div>
<div class="area">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<section class="section-footer" style="margin: 0">
    <footer>
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-4 px-2 pt-5 mt-5" style="max-width: 1320px; margin: 0 auto;">
            <div class="col-lg col-sm-12">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="/chapter.php" class="nav-link p-0 text-muted mb-3" style=" color: #CA182E !important;">Адрес</a>
                        <p>Запорожская обл.,
                            г. Мелитополь,
                            пр-кт Богдана Хмельницкого, д. 18</p>
                    </li>
                    <li class="nav-item mb-2"><a href="/chapter.php" class="nav-link p-0 text-muted how-find">Как нас найти?</a></li>
                </ul>
            </div>
            <div class="col">

            </div>
            <div class="col mb-3">
                <ul class="nav flex-column">

                </ul>
            </div>

            <div class="col">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link p-0 text-muted" style=" color: #CA182E !important;">Сайт МелГУ</a></li>
                    <li class="nav-item mb-2"><a href="https://mgu-mlt.ru/" class="nav-link p-0 text-muted text-decoration-underline">mgu-mlt.ru</a></li>
                </ul>
            </div>
        </div>
        <div class="border-top pt-3">
            <p class="text-center text-muted m-0 pb-2">МелГУ © 2024</p>
        </div>
    </footer>
</section>
</body>
</html>