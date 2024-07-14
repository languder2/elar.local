<form method="post" action="<?=$action??"/"?>" class="box-search">
    <h6 class="title-view mb-0">Поиск</h6>
    <div class="box bg-white px-3 py-3">
        <div class="input-group">
            <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="поиск"
                    aria-label="search"
                    value="<?=$search??""?>"
            >

            <button
                    class="btn btn-outline-secondary"
                    type="submit"
            >
                Найти
            </button>
        </div>
    </div>
</form>
