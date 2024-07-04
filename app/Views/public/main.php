<section class="Section_tagline">
    <p class="h1" style="color: #CA182E">
        Электронный научный архив МелГУ
    </p>
</section>
<section>
    <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3">
        <div class="col col-lg-12">
            <h3>Фильтр</h3>
            <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-lg-1 row-cols-lg-3">
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
<section>
    <div class="col col-lg-12 box-inf">
        <h3>Разделы</h3>
        <span>Выберите раздел для просмотра его коллекций</span>
        <div class="list-group">
            <?php if(isset($edSections)) foreach ($edSections as $section):?>
            <div class="list-group-item">
                <div>
                <h5><a href="/sections/<?=$section->id?>"><?=$section->name?></a></h5>
                </div>
                <div class="cnt-box position-relative">
                <span class="count"><?=$section->cnt?></span>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>