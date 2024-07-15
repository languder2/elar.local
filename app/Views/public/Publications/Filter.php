<?php if(isset($filter,$tag)):?>
    <div class="filter-input-group">
        <input
                type="text"
                class="form-control focus-show-list"
                id="filter_<?=$tag?>"
                value="<?=$current??""?>"
        >
        <label class="<?=!empty($current)?"active":""?>"
                for="filter_<?=$tag?>"
        >
            <?=$title??""?>
        </label>

        <div class="variables">
            <a
                href="<?=base_url("set-$tag/0")?>"
                class="link default setFilter"
            >
                Показать все
            </a>
            <?php foreach ($filter as $item):?>
                <a
                    href="<?=isset($tag)?base_url("set-$tag/$item->id"):"#"?>"
                    class="link setFilter"
                >
                    <?=$item->name??""?>
                </a>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>
