<section class="mb-5">
    <?php if(!empty($publication->sections)):?>
    <div class="col col-lg-12 title_publication">
        <h4 class="m-0"><?=$publication->name??""?></h4>
    </div>
    <div class="col col-lg-12 mt-4">
        <?php foreach ($publication->sections as $key=>$section):?>
            <a class=" px-3 my-1 py-2 bg-white rounded-5 d-inline-block" href="<?=base_url("/sections/$section->id")?>">
                <?=$section->name?>
            </a>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</section>

<section class="mb-5">
    <div class="col col-lg-12">

        <div class="col col-lg-12 title-view">
            <h6 class="m-0">
                <?=$publication->type->name??""?>:
            </h6>
        </div>
        <div class="row resource g-0">
            <?php if(!empty($publication->authors)):?>
                <div class="col-12 col-md-4 col-lg-3">
                    Авторы:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?php foreach ($publication->authors as $key=>$author):?>
                        <a href="<?=base_url("/author/$author->id")?>">
                            <?=$author->name?><?=(count($publication->authors)-$key>1)?", ":""?>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->date)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Дата публикации:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <p>
                        <?=date("d/m/Y",strtotime($publication->date))?>
                    </p>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->name)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Название:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?=$publication->name?>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->description)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Библиографическое описание:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?=$publication->description?>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->advisor)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Научный руководитель:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <a href="<?=base_url("/author/".$publication->advisor->id)?>">
                        <?=$publication->advisor->name?>
                    </a>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->speciality)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Специальность:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?=$publication->speciality?>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->tags)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Ключевые слова:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?php foreach ($publication->tags as $key=>$tag):?>
                        <a href="<?=base_url("/tag/$tag->id")?>">
                            <?=$tag->name?><?=(count($publication->authors)-$key>1)?", ":""?>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
    </div>
</section>

<!-- Вывод прикрепленного файла -->
<?php if(!empty($publication->filesize)):?>
    <section class="mb-5">
        <div class="col col-lg-12 box-view">
            <div class="col col-lg-12 title-view">
                <h6 class="m-0">Файл публикации:</h6>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-0 row-view-body py-sm-2 bg-white px-4">
                <div class="col py-2 py-sm-4">
                    <div class="fw-bold d-md-none">
                        Файл:
                    </div>
                    <div>
                        <?=$publication->fileName??""?>
                    </div>
                </div>
                <div class="col py-2 py-sm-4">
                    <div class="fw-bold d-md-none">
                        Размер:
                    </div>
                    <div>
                        <?=$publication->filesize??""?>
                    </div>
                </div>
                <div class="col py-2 py-sm-4">
                    <div class="fw-bold d-md-none">
                        Формат:
                    </div>
                    <div>
                        PDF
                    </div>
                </div>
                <div class="col py-2 py-sm-3">
                    <div>
                        <a class="btn-opn" target="_blank" href="<?=base_url($publication->pdf??"")?>">
                            Открыть
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>
