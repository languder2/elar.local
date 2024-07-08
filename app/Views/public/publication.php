
<section>
    <div class="w-100 title-chapter">
        <div class="row">
            <div class="col-lg-12 d-flex">
                <h4><?=$publication->name??""?></h4>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="col col-lg-12">
        <div class="row resource g-0">
            <?php if(!empty($publication->sections)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Раздел:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?php foreach ($publication->sections as $key=>$section):?>
                        <a href="<?=base_url("/section/$section->id")?>">
                            <?php if($key):?>
                                <br><i class="bi bi-arrow-return-right ps-1"></i>
                            <?php endif;?>
                            <?=$section->name?>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
            <?php if(!empty($publication->authors)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Авторы:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?php foreach ($publication->authors as $key=>$author):?>
                        <a href="<?=base_url("/author/$author")?>">
                            <?=$author?>
                            <?=(count($publication->authors)-$key>1)?",":""?>
                        </a>
                    <?php endforeach;?>
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
            <?php if(!empty($publication->supervisor)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Научный руководитель:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?=$publication->supervisor?>
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
            <?php if(!empty($publication->source)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Издатель:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <a href="<?=base_url("/source/".$publication->source->id);?>">
                        <?=$publication->source->title?>
                    </a>
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
            <?php if(!empty($publication->tags)):?>
                <div class="col-12 col-md-4 col-lg-3 ">
                    Ключевые слова:
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <?php foreach ($publication->tags as $key=>$tag):?>
                        <a href="<?=base_url("/tag/$tag")?>">
                            <?=$tag?>
                            <?=(count($publication->tags)-$key>1)?",":""?>
                        </a>
                    <?php endforeach;?>
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
        </div>
    </div>
</section>

<!-- Вывод прикрепленного файла -->
<?php if(!empty($publication->filesize)):?>
    <section>
        <div class="col col-lg-12 box-view">
            <div class="col col-lg-12 title-view">
                <h6 class="m-0">Файл публикации:</h6>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-0 row-view row-view-body">
                <div class="col">
                    <div>
                        <b class="pe-sm-2">Файл:</b>
                        <?=$publication->fileName??""?>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <b class="pe-sm-2">Размер:</b>
                        <?=$publication->filesize??""?>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <b class="pe-sm-2">Формат:</b>
                        PDF
                    </div>
                </div>
                <div class="col">
                    <div><a class="btn-opn" target="_blank" href="<?=base_url($publication->pdf??"")?>">Открыть</a></div>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>