 <section>
        <div class="w-100 title-chapter">
            <div class="row">
                <div class="col-lg-12 d-flex">
                    <?php if(isset($Publicate)) foreach ($Publicate as $item):?>
                    <h4><?=$item->name?></h4>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </section>
<section>
    <div class="col col-lg-12">
    <div class="row row-cols-2 resource g-0">
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Название:</span>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
                <?php if(isset($Publicate)) foreach ($Publicate as $item):?>
            <p>
                <?=$item->name?>
            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Авторы:</span>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>
                <?=$item->author?>
            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Научный руководитель:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>

            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Дата публикации:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>
                <?=$item->date?>
            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Издатель:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>

            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Библиографическое описание:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>
                <?=$item->description?>
            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Ключевые слова:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>
                <?php foreach ($item->tags as $tag)  :?>
                <?=$tag?>
                <?php endforeach;?>
            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Код специальности ВАК:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>

            </p>
            </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-2 d-flex align-items-stretch">
            <div class="d-flex align-items-center">
            <span>Специальность:</span>
        </div>
        </div>
        <div class="col col-6 col-sm-6 col-md-6 col-lg-10 d-flex align-items-stretch">
            <div class="d-flex align-items-stretch">
            <p>

            </p>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    </div>
</section>
<section>
    <div class="col col-lg-12 box-view">
        <div class="col col-lg-12 title-view">
            <h6 class="m-0">Файл этого ресурса:</h6>
        </div>
        <div class="row row-cols-5 g-0 row-view row-view-head">
            <div class="col">
                <div><b>Файл</b></div>
            </div>
            <div class="col">
                <div><b>Описание</b></div>
            </div>
            <div class="col">
                <div><b>Размер</b></div>
            </div>
            <div class="col">
                <div><b>Формат</b></div>
            </div>
            <div class="col">
                <div><b></b></div>
            </div>
        </div>
        <?php if(isset($Publicate)) foreach ($Publicate as $item):?>
        <div class="row row-cols-1 row-cols-md-5 row-cols-lg-5 g-0 row-view row-view-body">
            <div class="col">
                <div>
                    <b class="pe-sm-2">Файл:</b>
                    <span><?=$item->fileName?></span>
                </div>
            </div>
            <div class="col">
                <div>
                    <b class="pe-sm-2">Описание:</b>
                    <span></span>
                </div>
            </div>
            <div class="col">
                <div>
                    <b class="pe-sm-2">Размер:</b>
                    <span>11.47MB</span>
                </div>
            </div>
            <div class="col">
                <div>
                    <b class="pe-sm-2">Формат:</b>
                    <span>PDF</span>
                </div>
            </div>
            <div class="col">
                <div><a class="btn-opn" href="<?=$item->id?>">Открыть</a></div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</section>