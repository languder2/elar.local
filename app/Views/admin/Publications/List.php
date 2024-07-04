
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
            <div class="grid-title">#</div>
            <div class="grid-title">Дата</div>
            <div class="grid-title">Автор</div>
            <div class="grid-title">Название</div>
            <div class="grid-title"> </div>
            <div class="grid-title"> </div>
            <div class="grid-title"> </div>
            <div class="grid-title"> </div>
            <div class="grid-title"> </div>
            <?php foreach($list as $key=>$item):?>
                <div>
                    <?=$item->id?>
                </div>
                <div>
                    <?=date("d.m.Y",strtotime($item->date))?>
                </div>
                <div>
                    <?=$item->author?>
                </div>
                <div>
                    <?=$item->name?>
                </div>
                <div>
                    <a href="<?=base_url("/publication/$item->id")?>" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
                <div>
                    <a href="<?=$item->pdf??"#"?>" target="_blank">
                        <i class="bi bi-filetype-pdf"></i>
                    </a>
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

<?=$paginator??""?>

