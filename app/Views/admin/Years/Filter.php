<form method="post" action="/admin/years/set-filter" class="formFilter row row-cols-2 py-2">
    <div class="col-6 col-sm-8 col-lg-10 pe-1">
        <input type="text" class="form-control h-auto " name="filter[name]" placeholder="Название" value="<?=$filter->name??""?>">
    </div>
    <div class="col-6 col-sm-4 col-lg-2 text-end ps-1">
        <button class="btn btn-primary w-100">
            Применить
        </button>
    </div>
</form>

