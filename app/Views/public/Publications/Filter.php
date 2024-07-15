<?php if(!empty($filter)):?>
    <div class="form-floating py-2 position-relative">
        <input type="text" class="form-control" id="filter_<?=$tag??""?>" placeholder="<?=$title??""?>" value="">
        <label for="filter_<?=$tag??""?>">
            <?=$title??""?>
        </label>
    </div>
<?php endif;?>
