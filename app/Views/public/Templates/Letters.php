<?php if(isset($letters,$type)):?>
    <section class="mb-5">
        <h6 class="title-view mb-0">Перейти</h6>
        <div class="box bg-white px-2 py-3 text-center text-capitalize">
            <?php if(empty($current) || $current=="all"):?>
                <span
                        class="d-inline-block mx-2 fw-bold"
                >
                        все
                </span>

            <?php else:?>
                <a href="<?=base_url("$type/letter/all")?>"
                   class="d-inline-block mx-2 red-link"
                >
                    все
                </a>
            <?php endif;?>


            <?php foreach($letters as $letter):?>
                <?php if(isset($current) && $letter->letter == $current): ?>
                    <span
                         class="d-inline-block mx-2 fw-bold"
                    >
                        <?=$letter->letter?>
                    </span>
                <?php else:?>
                    <a href="<?=base_url("$type/letter/$letter->letter")?>"
                        class="d-inline-block mx-2 red-link"
                    >
                        <?=$letter->letter?>
                    </a>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </section>
<?php endif;?>
