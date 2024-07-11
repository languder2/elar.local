<?php if(!empty($section)):?>
    <section class="bg-white py-4 px-4 rounded-4 mb-5">
        <?php if(!empty($section->parent)):?>
            <h4 class="position-relative m-0 py-2 pe-5">
                <a href="<?=base_url("/section/".$section->parent->id)?>" class="section">
                    <?=$section->parent->name??""?>:
                </a>
                <a href="<?=base_url("/section/".$section->parent->id)?>" class="current-count">
                    <?=$section->parent->cnt??""?>
                </a>
            </h4>
        <?php endif;?>
        <h4 class="position-relative m-0 py-2 pe-5 <?=!empty($section->parent)?"ps-3":""?>">
            <?=$section->name??""?>:
            <a href="<?=base_url("/section/".$section->id)?>" class="current-count">
                <?=$section->cnt??""?>
            </a>
        </h4>
    </section>
<?php endif;?>

<?=$subsections??""?>

<?=$sort??""?>

<?=$publication??""?>