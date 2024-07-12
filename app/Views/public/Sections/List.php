<?php if(!empty($list)):?>
    <section class="sections bg-white rounded-4 mb-5">
        <div class="title-view">
            <?=$title??""?>
        </div>
        <?php foreach ($list as $section):?>
            <div class="section position-relative m-0 py-3 ps-4 pe-5 fs-5">
                <a href="<?=base_url("/section/".$section->id)?>" class="link">
                    <?=$section->name??""?>
                </a>
                <a href="<?=base_url("/section/".$section->id)?>" class="current-count">
                    <?=$section->cnt??""?>
                </a>
            </div>
        <?php endforeach;?>
    </section>
<?php endif;?>