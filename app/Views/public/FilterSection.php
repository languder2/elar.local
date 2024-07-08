<form method="post" action="/browse/<?=$search?>/set-filter" class="formFilter">
    <div class="row row-cols-1 row-cols-lg-2">
        <div class="col col-lg-6">
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" name="filter[title]" placeholder="Поиск" aria-label="Search" aria-describedby="search-addon" value="<?=$filter->title??""?>"/>
                <span class="input-group-text border-0" id="search-addon">
    <i class="bi bi-search"></i>
  </span>
            </div>
        </div>
        <div class="col col-lg-6 my-3 my-md-3 my-sm-3 my-lg-0">
            <select class="form-select " aria-label="Default select">
                <option selected="">Искать везде</option>
                <option value="1">По автору</option>
                <option value="2">По Дате</option>
                <option value="3">По заголовку</option>
            </select>
        </div>
    </div>
</form>
