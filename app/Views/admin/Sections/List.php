<div class="container-lg">
    <div class="row">
        <div class="col-lg-10 col-sm-8">
            <h3 class="mt-2 mb-3">Разделы</h3>
        </div>
        <div class="col-lg col-sm-4 pt-2 fs-5 text-end">
            <a href="<?=base_url('admin/sections/add')?>" class="btn btn-primary w-75">
                Создать
            </a>
        </div>
    </div>
    <?php if(isset($message) and !empty($message)):?>
        <div class="mb-3 callout <?=$message->class?>">
            <?=$message->message?>
        </div>
    <?php endif;?>

    <?php echo $filter??""?>

    <div class="sections-list-grid my-3">
        <div class="grid-title bg-light fw-bold">#</div>
        <div class="grid-title bg-light fw-bold">Название</div>
        <div class="grid-title bg-light fw-bold">Кол-во</div>
        <div class="grid-title bg-light fw-bold"></div>
        <?php if(isset($list)) foreach($list as $key=>$item):?>
            <div>
                <?=$item->id?>
            </div>
            <div class="<?=$item->parent?"ps-4":""?>">
                <?=$item->name?>
            </div>
            <div>
                <?=$item->cnt?>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="<?=base_url("admin/sections/edit/$item->id")?>">edit</a>
            </div>
        <?php endforeach;?>
    </div>

</div>