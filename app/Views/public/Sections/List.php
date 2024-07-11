<?php if(!empty($list)):?>
    <h4 class="m-0 py-2 pe-5 mb-2">
        <?=$title??""?>:
    </h4>
    <section class="bg-white py-4 px-4 rounded-4 mb-5">
        <?php foreach ($list as $section):?>
            <h5 class="position-relative m-0 py-2 pe-5">
                <a href="<?=base_url("/section/".$section->id)?>" class="section">
                    <?=$section->name??""?>:
                </a>
                <a href="<?=base_url("/section/".$section->id)?>" class="current-count">
                    <?=$section->cnt??""?>
                </a>
            </h5>
        <?php endforeach;?>
    </section>
<?php endif;?>