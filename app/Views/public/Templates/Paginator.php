<?php if(isset($currentPage,$baseLink,$from,$to,$maxPages)):?>
    <nav>
        <ul class="public-pagination justify-content-center py-0 my-0">

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
<?php endif;?>