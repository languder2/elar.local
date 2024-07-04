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
                    id="form-author"
                    name="form[data][author]"
                    class="form-control h-auto <?=empty($validatorErrors->{"form.data.author"})?"":"is-invalid"?>"
                    value="<?=$form->data->author??""?>"
                    placeholder="Автор"
                    required
            >
            <label class="h-auto w-auto" for="form-author">Автор</label>
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
            <label class="h-auto w-auto" for="form-name">Название</label>
        </div>

        <div class="form-floating my-2 px-1">
            <input  type="date"
                    name="form[data][date]"
                    id="form-date"
                    placeholder="Название"
                    value="<?=$form->data->date??date("Y-m-d")?>"
                    required
                    class="form-control h-auto">
            <label class="h-auto w-auto" for="form-date">Название</label>
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
                    accept="application/pdf"
            >
        </div>

        <?php if(!empty($form->data->pdf)):?>
            <div class="my-3 px-1">
                Загружен файл:
                <?=$form->data->fileName?>
            </div>
        <?php endif;?>

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
            <textarea   name="form[data][description]"
                        id="form-description"
                        class="form-control h-auto"
                        rows="5"
                        style="resize: none;"
                        placeholder="Описание"
            ><?=$form->data->description??""?></textarea>
            <label class="h-auto w-auto" for="form-description">Описание</label>
        </div>

        <div class="mb-3">
            <div class="my-2 px-1">
                <label for="form-section">Раздел</label>
                <select class="form-select"
                        name="form[data][section]"
                        size="5"
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

        <div class="mb-3">
            <div class="my-2 px-1">
                <label for="form-source">Источник</label>
                <select class="form-select"
                        name="form[data][source]"
                        required
                        id="form-source"
                >
                    <option value=''>Выбрать источник</option>
                    <?php if(!empty($sources)) foreach($sources as $source):?>
                        <option value="<?=$source->id?>"
                                <?=(!empty($form->data->source) && $form->data->source==$source->id)?"selected":""?>
                        >
                            <?=$source->title?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <div class="my-2 px-1">
                <label for="form-collections">Выберите коллекции</label>
                <select class="form-select"
                        name="form[data][collections][]"
                        multiple
                        size="5"
                        id="form-collections"
                >
                    <?php if(!empty($collections)) foreach($collections as $collection):?>
                        <option value="<?=$collection->id?>"
                                <?=(!empty($form->data->collections) && in_array($collection->id,$form->data->collections))?"selected":""?>
                        >
                            <?=$collection->title?>
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