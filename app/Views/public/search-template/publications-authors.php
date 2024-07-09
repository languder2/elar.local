<section>
    <div class="col col-lg-12 box-view">
        <div class="col col-lg-12 title-view">
            <span class="res">Ресурсы:</span>
            <div class="row row-cols-2">
                <div class="col-10"><span>Авторы</span></div>
                <div class="col-2"><span>Кол-во</span></div>
            </div>
        </div>
        <?php if(isset($list)) foreach ($list as $item):?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-0 row-view row-view-body">
                <div class="col col-md-10 col-lg-10">
                    <div>
                        <b class="pe-sm-2">Авторы:</b><br>
                        <a href="/publication/<?=$item->id?>"><span><?=$item->fio?></span></a>
                    </div>
                </div>
                <div class="col col-md-2 col-lg-2">
                    <div>
                        <b class="pe-sm-2">Кол-во:</b><br>
                        <span><?=$item->cnt?></span>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php if (empty($list)){
        echo '<h4 class="text-center mb-4 py-2 bg-white">Результатов Нет</h4>';
    } ?>
    <?=$paginator?? "" ?>
    <style>
        .page-link.active{
            background-color: #820000;
            color: #FFFFFF;
            border-color: #820000;
        }
    </style>
</section>