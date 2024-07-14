<div class="container-lg">
    <div class="row">
        <div class="col-lg-10 col-sm-8">
            <h3 class="mt-2 mb-3">Источники</h3>
        </div>
        <div class="col-lg col-sm-4 pt-2 fs-5 text-end">
            <a href="<?=base_url('admin/types/add')?>" class="btn btn-primary w-75">
                Создать
            </a>
        </div>
    </div>
    <?php if(isset($message) and !empty($message)):?>
        <div class="mb-3 callout <?=$message->class?>">
            <?=$message->message?>
        </div>
    <?php endif; ?>
    <?=$filterSection??""?>
    <div class="sections-list-grid my-3">
        <div class="grid-title bg-light fw-bold">#</div>
        <div class="grid-title bg-light fw-bold">Название</div>
        <div class="grid-title bg-light fw-bold">Кол-во</div>
        <div class="grid-title bg-light fw-bold">vis</div>
        <div class="grid-title bg-light fw-bold">edit</div>
        <div class="grid-title bg-light fw-bold">del</div>
        <?php if(isset($edSource)) foreach ($edSource as $source):?>
            <div>
                <?=$source->id?>
            </div>
            <div class="ps-4">
                <?=$source->name?>
            </div>
            <div>
                <?=$source->cnt?>
            </div>
            <div>
                <div class="form-check form-switch">
                    <input class="form-check-input float-none change-visible" data-link="/admin/sources/change-visible" data-id="<?=$source->id?>" type="checkbox" <?=$source->display?"checked":""?>>
                </div>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="<?=base_url("admin/types/edit/$source->id")?>"><i class="bi bi-pencil"></i></a>
            </div>
            <div>
                <a class="btn btn-danger btn-sm"
                   href="<?=base_url("admin/types/delete/$source->id")?>"
                   data-title="Удалить Коллекцию"
                   data-message="Удалить #
                   <?=$source->id?> <?=$source->name?>"><i class="bi bi-trash3"></i></a>
            </div>
        <?php endforeach;?>
    </div>
</div>