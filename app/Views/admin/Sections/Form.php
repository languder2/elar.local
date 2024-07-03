<div class="w-50 mx-auto">
    <form action="/admin/sections/form-processing" method="post">
        <input type="hidden" name="form[action]" value="<?=$action??"add"?>">
        <input type="hidden" name="form[id]" value="<?=$id??0?>">
        <h3 class="mt-2 mb-3 text-center">
            <?=$title??""?>
        </h3>
        <?php if(!empty($errors)):?>
            <div class="text-center mt-3 mb-2 callout callout-error" role="alert">
                <?php foreach ($errors as $error) echo "$error<br>";?>
            </div>
        <?php endif;?>
        <div class="mb-3">
            <div class="my-2 px-1">
                <select class="form-select" name="form[parent]">
                    <option <?=(empty($form->level))?"selected":""?> value="0">Родительский раздел</option>
                    <?php if(!empty($sections)) foreach($sections as $section):?>
                        <option <?=(!empty($form->parent) && $form->parent==$section->id)?"selected":""?> value="<?=$section->id?>"><?=$section->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-floating my-2 px-1">
                <input type="text" name="form[name]" placeholder="Название раздела" value="<?=$form->name??""?>" required class="
                    form-control h-auto
                    <?=(isset($validator) && !empty($validator->getError("form.name")))?"is-invalid":""?>
                "
                >
                <label class="h-auto w-auto">Название раздела</label>
            </div>
        </div>
        <div class="my-2 px-1">
            <textarea class="form-control" name="form[description]" rows="10" placeholder="Описание раздела"><?=$form->description??""?></textarea>
        </div>
        <div class="text-center">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
