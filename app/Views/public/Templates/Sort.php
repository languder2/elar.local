<section class="mb-5">
    <div class="col-12 box-view">
        <div class="col col-lg-12 title-view">
            <h6 class="m-0">Показать</h6>
        </div>
        <div class="col col-lg-12 box-section">
            <div class="row row-cols-1 row-cols-lg-5 g-3">

                <a  href="<?=$baseurl??""?>date-<?=(!isset($sort->date) || $sort->date=="asc")?"desc":"asc"?>/"
                        class="d-block col sort-link"
                >
                    <span>
                        По дате

                        <?php if(!empty($sort->date) and $sort->date == "asc"):?>
                            <i class="bi bi-sort-down-alt ms-1"></i>
                        <?php endif; ?>

                        <?php if(!empty($sort->date) and $sort->date == "desc"):?>
                            <i class="bi bi-sort-down ms-1"></i>
                        <?php endif; ?>

                    </span>
                </a>

                <a href="<?=$baseurl??""?>name-<?=(!isset($sort->name) || $sort->name=="desc")?"asc":"desc"?>/"
                        class="d-block col sort-link"
                >
                    <span>
                        По заглавию

                        <?php if(!empty($sort->name) and $sort->name == "asc"):?>
                            <i class="bi bi-sort-down-alt ms-1"></i>
                        <?php endif; ?>

                        <?php if(!empty($sort->name) and $sort->name == "desc"):?>
                            <i class="bi bi-sort-down ms-1"></i>
                        <?php endif; ?>

                    </span>
                </a>

                <a href="<?=base_url("show/tags")?>" class="d-block col sort-link">
                    <span>
                    Темы
                    </span>
                </a>

                <a href="<?=base_url("show//authors")?>" class="d-block col sort-link">
                    <span>
                    Авторов
                    </span>
                </a>

                <a href="<?=base_url("show//advisors")?>" class="d-block col sort-link">
                    <span>
                    Руководители
                    </span>
                </a>
            </div>
        </div>
</section>
