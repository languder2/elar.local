<?php if(!empty($section)):?>
    <section class="box bg-white rounded-4 mb-5">
        <div class="title-view">
            Раздел
        </div>
        <?php if(!empty($section->parent)):?>
            <h4 class="position-relative m-0 pt-3 px-4 fs-5">
                <a href="<?=base_url("/section/".$section->parent->id)?>" class="link">
                    <?=$section->parent->name??""?>
                </a>
                <a href="<?=base_url("/section/".$section->parent->id)?>" class="current-count">
                    <?=$section->parent->cnt??""?>
                </a>
            </h4>
        <?php endif;?>
        <h4 class="position-relative m-0 py-3 px-4 fs-5 <?=!empty($section->parent)?"ps-5":""?>">
            <?=$section->name??""?>
            <a href="<?=base_url("/section/".$section->id)?>" class="current-count">
                <?=$section->cnt??""?>
            </a>
        </h4>
    </section>
<?php endif;?>

<?=$subsections??""?>

<?=$sort??""?>

<?=$publication??""?>