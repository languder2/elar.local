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
        <div class="grid-title bg-light fw-bold">vis</div>
        <div class="grid-title bg-light fw-bold">edit</div>
        <div class="grid-title bg-light fw-bold">del</div>
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
                <div class="form-check form-switch">
                    <input class="form-check-input float-none changeVisible" data-link="/admin/collections/change-visible" type="checkbox" id="changeVisible-Section<?=$item->id?>" data-id="<?=$item->id?>" <?=$item->display?"checked":""?>>
                </div>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="<?=base_url("admin/sections/edit/$item->id")?>"><i class="bi bi-pencil"></i></a>
            </div>
            <div>
                <a class="btn btn-danger btn-sm" href="<?=base_url("admin/sections/edit/$item->id")?>"><i class="bi bi-trash3"></i></a>
            </div>
        <?php endforeach;?>
    </div>

</div>