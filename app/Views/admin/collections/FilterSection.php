<form method="post" action="/admin/collections/set-filter" class="formFilter">
    <div class="">
        <input type="text" class="form-control h-auto" name="filter[title]" placeholder="Название" value="<?=$filter->title??""?>">
    </div>
    <div class="text-end">
        <button class="btn btn-primary w-100">Применить</button>
    </div>
</form>
