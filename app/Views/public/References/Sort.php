<div class="box-sort">
    <h6 class="title-view mb-0">Сортировать</h6>
    <div class="col col-lg-12 box-section py-0 bg-white">
        <div class="row row-cols-1 row-cols-lg-2 g-3 py-3">

            <a href="<?=$baseurl??""?>name-<?=(!isset($sort->name) || $sort->name=="desc")?"asc":"desc"?>/"
               class="d-block col sort-link"
            >
                    <span>
                        По наименованию

                        <?php if(!empty($sort->name) and $sort->name == "asc"):?>
                            <i class="bi bi-sort-down-alt ms-1"></i>
                        <?php endif; ?>

                        <?php if(!empty($sort->name) and $sort->name == "desc"):?>
                            <i class="bi bi-sort-down ms-1"></i>
                        <?php endif; ?>

                    </span>
            </a>

            <a  href="<?=$baseurl??""?>cnt-<?=(!isset($sort->cnt) or $sort->cnt=="asc")?"desc":"asc"?>/"
                class="d-block col sort-link"
            >
                    <span>
                        По количеству

                        <?php if(!empty($sort->cnt) and $sort->cnt == "asc"):?>
                            <i class="bi bi-sort-down-alt ms-1"></i>
                        <?php endif; ?>

                        <?php if(!empty($sort->cnt) and $sort->cnt == "desc"):?>
                            <i class="bi bi-sort-down ms-1"></i>
                        <?php endif; ?>

                    </span>
            </a>


        </div>
    </div>

</div>