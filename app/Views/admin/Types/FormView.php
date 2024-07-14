<div class="w-50 mx-auto">
    <form action="/admin/types/form-processing" method="post">
        <input type="hidden" name="form[op]" value="<?=$op??"add"?>">
        <input type="hidden" name="form[id]" value="<?=$pID??""?>">
        <h3 class="mt-2 mb-3 text-center">
            <?php if(isset($op) and $op=="add"):?>
                Создать Источник
            <?php else:?>
                Редактировать Источник: #<?=$pID??""?>
            <?php endif;?>
        </h3>
        <?php if(!empty($errors)):?>
            <div class="text-center mt-3 mb-2 callout callout-error" role="alert">
                <?php foreach ($errors as $error) echo "$error<br>";?>
            </div>
        <?php endif;?>
        <div class="mb-3">
            <div class="form-floating my-2 px-1">
                <input type="text" name="form[name]" id="formName" placeholder="" value="<?=$form->name??""?>" required class="
                    form-control h-auto
                    <?=(isset($validator) && !empty($validator->getError("form.title")))?"is-invalid":""?>
                "
                >
                <label class="h-auto w-auto" for="formName">Название</label>
            </div>
            <div class="form-floating my-2 px-1">
                <textarea name="form[description]" id="formDescription" placeholder="" class="
                    form-control h-auto" rows="3" style="resize: none;"
                ><?=$form->description??""?></textarea>
                <label
                        class="h-auto w-auto"
                        for="formDescription"
                >
                    Описание
                </label>
            </div>

        </div>
        <div class="text-center">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
