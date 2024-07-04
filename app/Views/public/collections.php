<section>
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2">
        <div class="col-lg-9">
<section>
        <div class="w-100 title-chapter">
            <div class="row">
                <div class="col-lg-12 d-flex">
                    <h4 class="headline-chapter">Авторефераты и диссертации :</h4>
                    <h4 class="count">1231</h4>
                </div>
            </div>
        </div>
</section>
<section>
    <div class="col-12 box-view">
        <div class="col col-lg-12 title-view">
            <h6 class="m-0">Просмотреть</h6>
        </div>
        <div class="col col-lg-12 box-section">
            <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-lg-1 row-cols-lg-5">
                <div class="col box-inf">
                    <div class="list-group-btn" onclick="location.href='#'">
                        <div class="list-group-item-btn">
                            <a>По дате</a>
                        </div>
                    </div>
                </div>
                <div class="col box-inf">
                    <div class="list-group-btn" onclick="location.href='#'">
                        <div class="list-group-item-btn">
                            <a>По автору</a>
                        </div>
                    </div>
                </div>
                <div class="col box-inf">
                    <div class="list-group-btn" onclick="location.href='#'">
                        <div class="list-group-item-btn">
                            <a>По заглавию</a>
                        </div>
                    </div>
                </div>
                <div class="col box-inf">
                    <div class="list-group-btn" onclick="location.href='#'">
                        <div class="list-group-item-btn">
                            <a>По тематике</a>
                        </div>
                    </div>
                </div>
                <div class="col box-inf">
                    <div class="list-group-btn" onclick="location.href='#'">
                        <div class="list-group-item-btn">
                            <a>Источники</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
            <section>
                <div class="col col-lg-12 box-view">
                    <div class="col col-lg-12 title-view">
                        <span class="res">Ресурсы:</span>
                        <div class="row row-cols-3">
                            <div class="col"><span>По дате сохранения</span></div>
                            <div class="col"><span>Название</span></div>
                            <div class="col"><span>Авторы</span></div>
                        </div>
                    </div>
                    <?php if(isset($edCollections)) foreach ($edCollections as $collection):?>
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-0 row-view row-view-body">
                        <div class="col col-md-2 col-lg-2">
                            <div>
                                <b class="pe-sm-2">По дате сохранения:</b>
                                <span><?=$row["date"]?></span>
                            </div>
                        </div>
                        <div class="col col-md-8 col-lg-8">
                            <div>
                                <b class="pe-sm-2">Название:</b>
                                <span><?=$row["title"]?></span>
                            </div>
                        </div>
                        <div class="col col-md-2 col-lg-2">
                            <div>
                                <b class="pe-sm-2">Авторы:</b>
                                <span><?=$row["author"]?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <nav aria-label="Page navigation example" class="pagination-box mt-3 d-flex">
                    <ul class="pagination pagination-item">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">Предыдущая</a>
                        </li>
                        <?php for($i = 1; $i <= $pages; $i++) : ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Следующая</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
        <div class="col-lg-3">
            <section>
                <div class="col col-lg-12">
                    <h4>Фильтр</h4>
                    <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-lg-1 row-cols-lg-1">
                        <div class="col box-inf">
                            <span>По автору</span>
                            <div class="list-group author">
                                <div class="list-group-item">
                                    <h5><a href="#">Шур. В. Я.</a></h5>
                                    <span class="count">1</span>
                                </div>
                            </div>
                        </div>
                        <div class="col box-inf">
                            <span>По тематике</span>
                            <div class="list-group subject">
                                <div class="list-group-item">
                                    <h5><a href="#">ПЕРИОДИЧЕСКАЯ ПЕЧАТЬ (ГАЗЕТЫ)</a></h5>
                                    <span class="count">1</span>
                                </div>
                            </div>
                        </div>
                        <div class="col box-inf">
                            <span>По дате</span>
                            <div class="list-group date">
                                <div class="list-group-item">
                                    <h5><a href="#">2020-2024</a></h5>
                                    <span class="count">1</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

