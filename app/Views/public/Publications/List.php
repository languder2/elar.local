<section>
    <div class="col col-lg-12 box-view">
        <div class="col col-lg-12 title-view">
            <span class="d-inline-block d-md-none">Публикации:</span>
            <div class="row row-cols-3 d-none d-md-flex">
                <div class="col-2">
                    Дата
                </div>
                <div class="col-8">
                    Название
                </div>
                <div class="col-2">
                    Авторы
                </div>
            </div>
        </div>
        <?php if(isset($list)) foreach ($list as $item):?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-0 row-view row-view-body py-sm-2 bg-white px-4">
                <div class="col col-md-2 col-lg-2 py-2">
                    <div>
                        <div class="fw-bold d-md-none">
                            Дате сохранения:</div>
                            <?=date("d-m-Y",strtotime($item->date))?>
                    </div>
                </div>
                <div class="col col-md-8 col-lg-8 py-2">
                    <div>
                        <div class="fw-bold d-md-none">
                            Название:
                        </div>
                        <a href="/publication/<?=$item->id?>">
                            <?=$item->name?>
                        </a>
                    </div>
                </div>
                <div class="col col-md-2 col-lg-2 py-2">
                    <div>
                        <div class="fw-bold d-md-none">
                            Авторы:
                        </div>
                        <?php foreach ($item->authors as $key=>$author):?>
                            <a href="/author/<?=$author->id??""?>" class="text-nowrap">
                                <?=$author->name??$author;?><?=(count($item->authors)-$key>1)?", ":""?>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php if (empty($list)){
        echo '<h4 class="text-center mb-4 py-2 bg-white">Публикацйи нет</h4>';
    } ?>
    <?=$paginator?? "" ?>
</section>