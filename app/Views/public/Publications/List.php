<section class="publications mb-5 bg-white rounded-4">
    <div class="title-view">
        <span class="d-inline-block d-md-none">Публикации:</span>
        <div class="container-fluid">

            <div class="row row-cols-3 d-none d-md-flex">
                <div class="col col-md-2 col-lg-2">
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
    </div>
    <div class="container-fluid">
    <?php if(isset($list)) foreach ($list as $item):?>
            <div class="publication row row-cols-1 row-cols-md-3 row-cols-lg-3 py-sm-2 px-4">
                <div class="col col-md-2 col-lg-2 py-2">
                    <div class="fw-bold d-md-none">
                        Дате сохранения:</div>
                    <?=date("d-m-Y",strtotime($item->date))?>
                </div>
                <div class="col col-md-8 col-lg-8 py-2">
                    <div class="fw-bold d-md-none">
                        Название:
                    </div>
                    <a href="/publication/<?=$item->id?>" class="red-   link">
                        <?=$item->name?>
                    </a>
                </div>
                <div class="col col-md-2 col-lg-2 py-2">
                    <div class="fw-bold d-md-none">
                        Авторы:
                    </div>
                    <?php foreach ($item->authors as $key=>$author):?>
                        <a href="/author/<?=$author->id??""?>" class="red-link text-nowrap">
                            <?=$author->name??$author;?><?=(count($item->authors)-$key>1)?", ":""?>
                        </a>
                    <?php endforeach;?>
                </div>
            </div>
    <?php endforeach;?>
    </div>
    <?php if (empty($list)){
        echo '<h4 class="text-center mb-4 py-2 bg-white">Публикацйи нет</h4>';
    } ?>
    <?=$paginator?? "" ?>
</section>