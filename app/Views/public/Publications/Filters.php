<?php if(!empty($filters)):?>
<section class="mb-5">
    <h6 class="title-view mb-0">Фильтр</h6>
    <div class="container-fluid box">
        <div class="row row-cols-1 row-cols-lg-<?=count($filters)?> g-3 py-2">
            <?php foreach ($filters as $filter):?>
                <?=$filter?>
            <?php endforeach;?>
        </div>
    </div>
</section>
<?php endif;?>