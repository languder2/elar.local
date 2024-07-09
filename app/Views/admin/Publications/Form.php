<div class="w-50 mx-auto">
    <form action="/admin/publications/form-processing" method="post" enctype="multipart/form-data">
        <h3 class="mt-2 mb-3 text-center">
            <?=$title??""?>
        </h3>
        <input  type="hidden"
                name="form[action]"
                value="<?=$action??"add"?>"
        >
        <input  type="hidden"
                name="id"
                value="<?=$id??0?>"
        >
        <input  type="hidden"
                name="form[data][pdf]"
                value="<?=$form->data->pdf??""?>"
        >
        <input  type="hidden"
                name="form[data][fileName]"
                value="<?=$form->data->fileName??""?>"
        >

        <?php if(isset($message) and !empty($message)):?>
            <div class="mb-3 callout <?=$message->class??""?>">
                <?=$message->message??""?>
            </div>
        <?php endif;?>

        <?php if(!empty($validatorErrors)):?>
            <div class="text-center mt-3 mb-2 callout callout-error" role="alert">
                <?php foreach ($validatorErrors as $error) echo "$error<br>";?>
            </div>
        <?php endif;?>

        <div class="form-floating my-2 px-1">
            <input  type="text"
                    id="form-authors"
                    name="form[data][authors]"
                    class="form-control h-auto <?=empty($validatorErrors->{"form.data.authors"})?"":"is-invalid"?>"
                    value="<?=$form->data->authors??""?>"
                    placeholder="Автор"
                    required
            >
            <label class="h-auto w-auto" for="form-authors">
                Укажите авторов, разделив запятой
                <span class="text-danger fw-bold">*</span>
            </label>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="text"
                    name="form[data][name]"
                    id="form-name"
                    placeholder="Название"
                    required
                    value="<?=$form->data->name??""?>"
                    class="form-control h-auto <?=empty($validatorErrors->{"form.data.name"})?"":"is-invalid"?>"

            >
            <label class="h-auto w-auto" for="form-name">
                Название
                <span class="text-danger fw-bold">*</span>
            </label>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="date"
                    name="form[data][date]"
                    id="form-date"
                    placeholder="Дата публикации"
                    value="<?=$form->data->date??date("Y-m-d")?>"
                    required
                    class="form-control h-auto">
            <label class="h-auto w-auto" for="form-date">Дата публикации</label>
        </div>

        <div class="my-2 px-1">
            <label class=" form-check form-switch">
                <input  name="form[data][display]"
                        class="form-check-input float-none change-visible me-2"
                        type="checkbox"
                        value="1"
                    <?=(!isset($form) || !empty($form->data->display))?"checked":""?>
                >
                Опубликовать
            </label>
        </div>
        <div class="my-2 px-1">
            <input  name="pdf"
                <?=empty($form->pdf)?"":"required"?>
                    class="form-control"
                    type="file"
                    <?=empty($form->data->pdf)?"required":""?>
                    accept="application/pdf"
            >
        </div>

        <?php if(!empty($form->data->pdf)):?>
            <div class="my-3 px-1">
                Загружен файл:
                <?=$form->data->fileName?>
            </div>
        <?php endif;?>

        <div class="mb-3">
            <div class="my-2 px-1">
                <label for="form-section">
                    Раздел
                    <span class="text-danger fw-bold">*</span>
                </label>
                <select class="form-select"
                        name="form[data][section]"
                        size="10"
                        required
                        id="form-section"
                >
                    <?php if(!empty($sections)) foreach($sections as $section):?>
                        <option value="<?=$section->id?>"
                            <?=(!empty($form->data->section) && $form->data->section==$section->id)?"selected":""?>
                                class="<?=$section->parent?"bi bi-arrow-return-right ps-2":""?>"
                        >
                            <?=$section->name?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="text"
                    name="form[data][tags]"
                    id="form-tags"
                    placeholder="Теги"
                    value="<?=$form->data->tags??""?>"
                    class="form-control h-auto"
            >
            <label class="h-auto w-auto" for="form-tags">Укажите теги, разделив запятой</label>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="text"
                    name="form[data][supervisor]"
                    id="form-tags"
                    placeholder="Научный руководитель"
                    value="<?=$form->data->supervisor??""?>"
                    class="form-control h-auto"
            >
            <label class="h-auto w-auto" for="form-tags">
                Научный руководитель
            </label>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="text"
                    name="form[data][speciality]"
                    id="form-tags"
                    placeholder="Специальность"
                    value="<?=$form->data->supervisor??""?>"
                    class="form-control h-auto"
            >
            <label class="h-auto w-auto" for="form-tags">Специальность</label>
        </div>

        <div class="my-2 px-1">
            <div class="main-container">
                <div class="editor-container editor-container_classic-editor editor-container_include-style" id="editor-container">
                    <div class="editor-container__editor">
                        <textarea   name="form[data][description]"
                                    id="form-description"
                                    class="form-control"
                                    style="resize: none; height: 200px"
                                    placeholder="Аннотация"
                        ><?=$form->data->description??""?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="mb-3">
            <div class="my-2 px-1">
                <label for="form-type">
                    Тип публикации
                    <span class="text-danger fw-bold">*</span>
                </label>
                <select class="form-select"
                        name="form[data][type]"
                        required
                        id="form-type"
                >
                    <option value=''>Выбрать тип</option>
                    <?php if(!empty($types)) foreach($types as $type):?>
                        <option value="<?=$type->id?>"
                            <?=(!empty($form->data->type) && $form->data->type==$type->id)?"selected":""?>
                        >
                            <?=$type->title?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?=$ckeditor??""?>