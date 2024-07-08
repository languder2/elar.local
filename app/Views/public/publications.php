<section>
    <div class="col col-lg-12 box-view">
        <div class="col col-lg-12 title-view">
            <span class="res">Ресурсы:</span>
            <div class="row row-cols-3">
                <div class="col-2"><span>По дате сохранения</span></div>
                <div class="col-8"><span>Название</span></div>
                <div class="col-2"><span>Авторы</span></div>
            </div>
        </div>
        <?php if(isset($list)) foreach ($list as $item):?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-0 row-view row-view-body">
                <div class="col col-md-2 col-lg-2">
                    <div>
                        <b class="pe-sm-2">По дате сохранения:</b>
                        <span><?=$item->date?></span>
                    </div>
                </div>
                <div class="col col-md-8 col-lg-8">
                    <div>
                        <b class="pe-sm-2">Название:</b>
                        <a href="/publication/<?=$item->id?>"><span><?=$item->name?></span></a>
                    </div>
                </div>
                <div class="col col-md-2 col-lg-2">
                    <div>
                        <b class="pe-sm-2">Авторы:</b>
                        <span><?php //(", ",$item->authors??[])?></span>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php if (empty($list)){
        echo '<h4 class="text-center mb-4 py-2 bg-white">Публикацйи нет</h4>';
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