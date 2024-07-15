<div class="container-lg">
    <div class="row">
        <div class="col col-lg-10 col-sm-8">
            <h3 class="mt-2 mb-3">
                Темы
            </h3>
        </div>
        <div class="col col-lg-2 col-sm-4 pt-2 fs-5 text-end">
            <a href="<?=base_url('admin/tags/add')?>" class="btn btn-primary">
                Создать
            </a>
        </div>
    </div>
    <?php if(isset($message) and !empty($message)):?>
        <div class="mb-3 callout <?=$message->class??""?>">
            <?=$message->message??""?>
        </div>
    <?php endif;?>

    <?php echo $filter??""?>

    <?php if(empty($list)):?>
        <div class="mb-3 callout callout-error">
            Нет данных
        </div>
    <?php else:?>
        <div class=" years-list-grid my-3">
            <div class="grid-title bg-primary text-white">#</div>
            <div class="grid-title bg-primary text-white">Название</div>
            <div class="grid-title bg-primary text-white">Кол-во</div>
            <div class="grid-title bg-primary text-white">vis</div>

            <div class="grid-title bg-primary text-white">del</div>
            <?php foreach($list as $key=>$item):?>
                <div class="fw-bold">
                    <?=$item->id?>
                </div>
                <div class="fw-bold">
                    <?=$item->name?>
                </div>
                <div class="fw-bold">
                    <?=$item->cnt?>
                </div>
                <div>
                    <div class="form-check form-switch">
                        <label>
                            <input class="form-check-input float-none change-visible" data-link="/admin/tags/change-visible" data-id="<?=$item->id?>" type="checkbox" <?=$item->display?"checked":""?>>
                        </label>
                    </div>
                </div>

                <div>
                    <a class="btn btn-danger btn-sm" href="<?=base_url("admin/tags/delete/$item->id")?>"><i class="bi bi-trash3"></i></a>
                </div>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</div>