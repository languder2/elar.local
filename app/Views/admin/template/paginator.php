<?php
    if(empty($currentPage)) $currentPage = 1;
    if(empty($maxPages)) $maxPages = 1;
    $from = ($currentPage>4)?$currentPage-4:1;
    $to = ($maxPages-$currentPage>1)?$currentPage+4:$maxPages;
    if(empty($baseLink)) $baseLink = '#';
    if($maxPages>9 && $from-$to<9){
        if($from<1) $from= 1;
        if($maxPages-$to<1) $from= $maxPages-8;
        $to= $from+8;
    }
?>
<div class="container-lg my-4">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

            <li class="page-item <?=($currentPage<4)?"disabled":""?>">
                <a class="page-link" href="<?=$baseLink.(1)?>" tabindex="-1" aria-disabled="<?=($currentPage<4)?"true":"false"?>"><i class="bi bi-arrow-bar-left"></i></a>
            </li>
            <li class="page-item <?=($currentPage<2)?"disabled":""?>">
                <a  class="page-link"
                    href="<?=$baseLink.($currentPage-1)?>"
                    tabindex="-1"
                    aria-disabled="<?=($currentPage<2)?"true":"false"?>">
                    <i class="bi bi-caret-left"></i>
                </a>
            </li>


            <?php for($i=$from;$i<=$to;$i++):?>
                <li class="page-item">
                    <?php if($currentPage==$i):?>
                        <span class="page-link active" aria-current="page">
                            <?=$i?>
                        </span>
                    <?php else: ?>
                        <a class="page-link" href="<?=$baseLink.$i?>">
                            <?=$i?>
                        </a>
                    <?php endif;?>
                </li>
            <?php endfor;?>


            <li class="page-item <?=($currentPage>=$maxPages)?"disabled":""?>">
                <a class="page-link" href="<?=$baseLink.($currentPage+1)?>" aria-disabled="<?=($currentPage>=$maxPages)?"true":"false"?>"><i class="bi bi-caret-right"></i></a>
            </li>
            <li class="page-item <?=($currentPage>=$maxPages-2)?"disabled":""?>">
                <a class="page-link" href="<?=$baseLink.$maxPages?>" aria-disabled="<?=($currentPage>=$maxPages-2)?"true":"false"?>"><i class="bi bi-arrow-bar-right"></i></a>
            </li>
        </ul>
    </nav>
</div>
