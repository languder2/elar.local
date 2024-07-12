<section class="mb-5">
    <div class="col-12 box-view">
        <div class="col col-lg-12 title-view">
            <h6 class="m-0">Показать</h6>
        </div>
        <div class="col col-lg-12 box-section">
            <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-lg-1 row-cols-lg-5">
                <a href="<?=$baseurl??""?>date-asc/" class="d-block col sort-link">
                    <span>
                        По дате
                    </span>
                </a>
                <a href="<?=$baseurl??""?>name-asc/" class="d-block col sort-link">
                    <span>
                    По заглавию
                    </span>
                </a>
                <a href="<?=base_url("/tags/")?>" class="d-block col sort-link">
                    <span>
                    Темы
                    </span>
                </a>
                <a href="<?=base_url("/authors/")?>" class="d-block col sort-link">
                    <span>
                    Авторов
                    </span>
                </a>
                <a href="<?=base_url("/advisor/")?>" class="d-block col sort-link">
                    <span>
                    Руководители
                    </span>
                </a>
            </div>
        </div>
</section>
