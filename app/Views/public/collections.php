<section>
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2">
        <div class="col-lg-9">
<section>
        <div class="w-100 title-chapter">
            <div class="row">
                <div class="col-lg-12 d-flex">
                    <?php if(isset($edCollections)) foreach ($edCollections as $collection):?>
                        <h4><?=$collection->title?> :</h4>
                        <h4 class="count"><?=$collection->cnt?></h4>
                    <?php endforeach;?>
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

            <?=$publications?>
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

