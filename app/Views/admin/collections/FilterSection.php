<form method="post" action="/admin/collections/set-filter" class="formFilter">
    <div>
        <input type="text" class="form-control h-auto" name="filter[code]" placeholder="Код" value="<?=$filter->code??""?>">
    </div>
    <div>
        <input type="text" class="form-control h-auto" name="filter[name]" placeholder="Название" value="<?=$filter->name??""?>">
    </div>
    <div>
        <select class="form-select" name="filter[level]">
            <option value="all">Все</option>
            <?php if(!empty($edLevels)) foreach ($edLevels as $code=>$edLevel):?>
                <option
                    value="<?=$code?>"
                    <?=(isset($filter->level) && $filter->level==$code)?"selected":""?>
                >
                    <?=$edLevel->name?>
                </option>
            <?php endforeach;?>
        </select>

    </div>
    <div>
        <select class="form-select" name="filter[display]">
            <option value="all">Все</option>
            <option
                value="1"
                <?=(isset($filter->display) && $filter->display==1)?"selected":""?>
            >
                Видимые
            </option>
            <option
                value="0"
                <?=(isset($filter->display) && $filter->display==0)?"selected":""?>
            >
                Скрытые
            </option>
        </select>
    </div>
    <div class="text-end">
        <button class="btn btn-primary">Применить</button>
    </div>
</form>
