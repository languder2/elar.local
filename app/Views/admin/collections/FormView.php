<div class="w-50 mx-auto">
    <form action="/admin/collections/form-processing" method="post">
        <input type="hidden" name="form[op]" value="<?=$op??"add"?>">
        <input type="hidden" name="form[id]" value="<?=$pID??""?>">
        <h3 class="mt-2 mb-3 text-center">
            <?php if($op=="add"):?>
                Создать Коллекцию
            <?php else:?>
                Редактировать Коллекцию: #<?=$pID??""?>
            <?php endif;?>
        </h3>
        <?php if(!empty($errors)):?>
            <div class="text-center mt-3 mb-2 callout callout-error" role="alert">
                <?php foreach ($errors as $error) echo "$error<br>";?>
            </div>
        <?php endif;?>
        <div class="mb-3">
            <div class="form-floating my-2 px-1">
                <input type="text" name="form[title]" placeholder="" value="<?=$form->title??""?>" required class="
                    form-control h-auto
                    <?=(isset($validator) && !empty($validator->getError("form.title")))?"is-invalid":""?>
                "
                >
                <label class="h-auto w-auto">Название</label>
            </div>
            <div class="form-floating my-2 px-1">
                <textarea name="form[description]" placeholder="" value="<?=$form->description??""?>" required class="
                    form-control h-auto" rows="3" style="resize: none;"
                ></textarea>
                <label class="h-auto w-auto">Краткое описание</label>
            </div>

        </div>
        <div class="text-center">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
