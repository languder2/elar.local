<div class="container-lg">
    <div class="row">
        <div class="col-lg-10 col-sm-8">
            <h3 class="mt-2 mb-3">Коллекции</h3>
        </div>
        <div class="col-lg col-sm-4 pt-2 fs-5 text-end">
            <a href="<?=base_url('admin/collections/add')?>" class="btn btn-primary w-75">
                Создать
            </a>
        </div>
    </div>
    <?php if(isset($message) and !empty($message)):?>
        <div class="mb-3 callout <?=$message->class?>">
            <?=$message->message?>
        </div>
    <?php endif; ?>

    <div class="grid-row py-2 text-center fw-bold ">
        <div>Количество</div>
        <div>Название</div>
        <div>
            Описание
        </div>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3"></div>
                    <?php if(isset($edForms)) foreach ($edForms as $form):?>
                        <div class="col-3"><?=empty($form->short)?$form->name:$form->short?></div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div></div>
    </div>
    <?php if(isset($edCollection)) foreach ($edCollection as $collection):?>
        <div class="grid-row py-2 text-center profileRow">
            <div>
                <?=$collection->count?>
            </div>
            <div class="text-start">
                <?=$collection->title?>
            </div>
            <div>
                <?=$collection->description?>
            </div>
            <div class="align-content-center">
                <a class="btn btn-primary btn-sm" href="<?=base_url("admin/collections/edit/$collection->id")?>">edit</a>
                <a
                        class="linkRemove btn btn-danger btn-sm"
                        href="<?=base_url("admin/collections/delete/$collection->id")?>"
                        data-title="Удалить Коллекцию"
                        data-message="Удалить #<?=$collection->id?> <?=$collection->title?>"
                >
                    del
                </a>
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input float-none changeVisible" data-link="/admin/collections/change-visible" type="checkbox" id="changeVisible-Profile<?=$collection->id?>" data-id="<?=$collection->id?>" <?=$collection->display?"checked":""?>>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>

<?php
//if(isset($edProfiles)) dd($edProfiles);
?>