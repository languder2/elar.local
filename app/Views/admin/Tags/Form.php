<div class="w-50 mx-auto">
    <form action="/admin/tags/form-processing" method="post">
        <h3 class="mt-2 mb-3 text-center">
            <?=$title??""?>
        </h3>

        <input type="hidden" name="form[action]" value="<?=$action??"add"?>">
        <input type="hidden" name="form[id]" value="<?=$id??0?>">

        <?php if(isset($message) and !empty($message)):?>
            <div class="mb-3 callout <?=$message->class?>">
                <?=$message->message?>
            </div>
        <?php endif;?>

        <?php if(!empty($errors)):?>
            <div class="text-center mt-3 mb-2 callout callout-error" role="alert">
                <?php foreach ($errors as $error) echo "$error<br>";?>
            </div>
        <?php endif;?>
        <div class="mb-3">
            <div class="form-floating my-2 px-1">
                <input type="text" name="form[name]" placeholder="Название раздела" value="<?=$form->name??""?>" required class="
                    form-control h-auto
                    <?=(isset($validator) && !empty($validator->getError("form.name")))?"is-invalid":""?>
                "
                >
                <label class="h-auto w-auto">Тема</label>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
