<?php if(!empty($list)):?>
    <section class="mb-5">
        <div class="title-view">
            Список разделов
        </div>
        <div class="bg-white section-list py-3 border-color-main">
            <?php foreach ($list as $key=>$section):?>
                <div class="position-relative m-0  <?=!empty($section->sub)?"pb-2":""?>">
                    <a href="<?=base_url("section/".$section->main->id)?>"
                       class="link ps-4 pe-5 fs-5"
                    >
                        <?=$section->main->name??""?>
                    </a>
                    <a href="<?=base_url("section/".$section->main->id)?>" class="current-count">
                        <?=$section->main->cnt??""?>
                    </a>
                </div>
                <?php if(!empty($section->sub)):?>
                    <?php foreach ($section->sub as $subsection):?>
                        <div class="subsection position-relative m-0 py-2 ms-5">
                            <a href="<?=base_url("section/".$subsection->id)?>" class="link">
                                <?=$subsection->name??""?>
                            </a>
                            <a href="<?=base_url("section/".$subsection->id)?>" class="current-count">
                                <?=$subsection->cnt??""?>
                            </a>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <hr>
            <?php endforeach;?>
        </div>
        <div class="section-footer py-3">
        </div>

    </section>
<?php endif;?>