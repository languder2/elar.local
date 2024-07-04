
<div class="container-lg">
    <div class="row">
        <div class="col col-lg-10 col-sm-8">
            <h3 class="mt-2 mb-3">
                Публикации
            </h3>
        </div>
        <div class="col col-lg-2 col-sm-4 pt-2 fs-5 text-end">
            <a href="<?=base_url('admin/publications/add')?>" class="btn btn-primary">
                Создать
                <i class="bi bi-plus-square-dotted"></i>
            </a>
        </div>
    </div>
    <?php if(isset($message) and !empty($message)):?>
        <div class="mb-3 callout <?=$message->class??""?>">
            <?=$message->message??""?>
        </div>
    <?php endif;?>

    <?php echo $filter??""?>

    <?php if(!isset($list) or empty($list)):?>
        <div class="mb-3 callout callout-error">
            Нет данных
        </div>
    <?php else:?>
        <div class="list-grid my-3">
            <div class="grid-title bg-light fw-bold">#</div>
            <div class="grid-title bg-light fw-bold">Название</div>
            <div class="grid-title bg-light fw-bold">Кол-во</div>
            <div class="grid-title bg-light fw-bold">vis</div>
            <div class="grid-title bg-light fw-bold">edit</div>
            <div class="grid-title bg-light fw-bold">del</div>
            <?php foreach($list as $key=>$item):?>
                <div>
                    <?=$item->id?>
                </div>
                <div>
                    <?=$item->name?>
                </div>
                <div>
                </div>
                <div>
                    <div class="form-check form-switch">
                        <label>
                            <input class="form-check-input float-none change-visible" data-link="/admin/publications/change-visible" data-id="<?=$item->id?>" type="checkbox" <?=$item->display?"checked":""?>>
                        </label>
                    </div>
                </div>
                <div>
                    <a class="btn btn-primary btn-sm" href="<?=base_url("admin/publications/edit/$item->id")?>"><i class="bi bi-pencil"></i></a>
                </div>
                <div>
                    <a class="btn btn-danger btn-sm" href="<?=base_url("admin/publications/delete/$item->id")?>"><i class="bi bi-trash3"></i></a>
                </div>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</div>