    <section class="list-box mb-5">
        <div class="title-view fs-5">
            <?=$title??""?>
        </div>
        <div class="container-fluid bg-light list-container">
            <?php if(empty($list[0])):?>
                <div class="text-center py-3 fw-bold">
                    Нет записей
                </div>
            <?php else:?>
                <div class="row row-cols-1 row-cols-lg-2">
                    <?php foreach ($list as $key=>$section):?>
                        <div class="list-section px-0 <?=($key==0 && !empty($equal)?"noLastBorder":"")?>">
                            <?php foreach ($section as $item):?>
                                <div class="list-item position-relative m-0 py-3 ps-4 pe-5">
                                    <a href="<?=isset($link)?$link.$item->id:"#"?>" class="link">
                                        <?=$item->name??""?>
                                    </a>
                                    <a href="<?=isset($link)?$link.$item->id:"#"?>" class="current-count">
                                        <?=$item->cnt??""?>
                                    </a>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
        <div class="section-footer py-3">
            <?php echo $paginator??"";?>
        </div>
    </section>


