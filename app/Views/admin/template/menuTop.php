<?php
if(empty($menu))
    return false;
?>
<div class="container-fluid bg-primary px-0 navbar-top-menu fs-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-1">
                <a href="/" class="nav-link py-3" target="_blank">Home</a>
            </div>
            <div class="col-11">
                <nav class="navbar navbar-expand-sm navbar-dark">
                    <ul class="navbar-nav ms-auto mb-0 text-end">
                        <?php foreach ($menu as $item):?>
                            <li class="nav-item <?=(!empty($item->submenu))?"dropdown":""?> ps-2">
                                <?php if(empty($item->link)):?>
                                    <span><?=$item->name?></span>
                                <?php else:?>
                                    <a
                                        <?php if(empty($item->submenu)):?>
                                            class="nav-link"
                                            href="<?=base_url($item->link)?>"
                                        <?php else:?>
                                            class="nav-link dropdown-toggle"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        <?php endif;?>
                                        <?php if($item->newTab):?>
                                            target="_blank"
                                        <?php endif;?>
                                    >
                                        <?=$item->name?>
                                    </a>
                                    <?php if(!empty($item->submenu)):?>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <?php foreach ($item->submenu as $subitem):?>
                                                <li><a class="dropdown-item" href="<?=base_url($subitem->link)?>"><?=$subitem->name?></a></li>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif;?>
                                <?php endif;?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>