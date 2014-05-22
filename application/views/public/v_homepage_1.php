<?php
if (isset($query)) {
    $items = array();
    //$new_arrival_items = array();
    if ($query) {
        foreach ($query->result() as $item):
            $items[$item->id_items][] = $item;
            /* if($item->id_categories == 1) { //Category = New Arrival
              $new_arrival_items[] = $item;
              } */
            if ($item->id_categories == 6) { //Category = Favorite Items
                $fav_items[$item->id_items][] = $item;
            }
        endforeach;
    }
}

//Categories
if (isset($categories)) {
    if ($categories) {
        foreach ($categories->result() as $category):
            $cats[$category->id_categories] = $category->category;
        endforeach;
    }
}
?>

<div class = "row category-items-block">
    <div class = "span10 homepage-category-slider">
        <div class = "row">
            <div class = "span2">
                <!--Category Menu-->
                <div class = "dropdown category-menu clearfix">
                    <div class = "category-menu-title"><h2>Categories</h2></div>
                    <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu">
                        <?php
                        if (isset($cats)) {
                                foreach ($cats as $cat_key=>$cat):
                                    ?>
                                    <li><a tabindex="-1" href="<?= base_url('category') . '/index/' . $cat_key . '/' . urlSeo($cat); ?>"><?= $cat ?></a></li>
                                    <?php
                                endforeach;
                        }
                        ?>
                    </ul>
                </div>
                <!-- endOf Category Menu -->
            </div>
            <div class="span6 carousel-block">
                <?php
                if (isset($slider)) {
                    if ($slider) {
                        ?>
                        <div class="carousel-wrapper clearfix">
                            <div id="myCarousel" class="carousel slide">
                                <ol class="carousel-indicators">
                                    <?php
                                    for ($i = 0; $i < $slider->num_rows(); $i++):
                                        ?>
                                        <li data-target="#myCarousel" data-slide-to="<?= $i ?>"></li>
                                        <?php
                                    endfor;
                                    ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                    foreach ($slider->result() as $slider_row):
                                        ?>
                                        <div class="item">
                                            <img src="<?= base_url('assets/sliders') . '/' . $slider_row->photo_thumbnail ?>" alt="">
                                            <div class="carousel-caption">
                                                <h4><?= $slider_row->title ?></h4>
                                                <div class="description"><?= $slider_row->short_description ?></div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="span2 latest-news-menu-block">
                <!-- Latest News -->
                <div class="dropdown latest-news-menu clearfix">
                    <div class="category-menu-title"><h2>Latest News</h2></div>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                        <li><a tabindex="-1" href="#">Action</a></li>
                        <li><a tabindex="-1" href="#">Another action</a></li>
                        <li><a tabindex="-1" href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">More options</a>
                            <ul class="dropdown-menu">
                                <li><a tabindex="-1" href="#">Second level link</a></li>
                                <li><a tabindex="-1" href="#">Second level link</a></li>
                                <li><a tabindex="-1" href="#">Second level link</a></li>
                                <li><a tabindex="-1" href="#">Second level link</a></li>
                                <li><a tabindex="-1" href="#">Second level link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- endOf Category Menu -->
                <div class="">
                    <form action="<?=base_url('subscribe')?>" method="POST">
                        <div><!--Receive information about our latest news by--> subscribe Newsletter below</div>
                        <div><input name="input_subscribers_email" placeholder="Insert Your Email" /><input name="bot_trap" type="hidden" /></div>
                        <div><input type="submit" value="submit" /></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row items-favorite">
            <div class="span10">
                <div class="row title-wrapper">
                    <div class="span10 rounded-gray-title"><h2>Favorite</h2></div>
                    <div class="btn btn-mini btn-inverse btn-more"><a href="<?= isset($cats) ? base_url('category/index/6').'/'.urlSeo($cats[6]):'' ?>">More<span>»</span></a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span10 items-wrapper clearfix">
                <?php
                if (isset($fav_items)) {
                    $limit = 1;
                    foreach ($fav_items as $favorite):
                        if ($limit > 6) {
                            break;
                        }
                        $i = 1;
                        echo '<div class="item-wrapper">';
                        foreach ($favorite as $fav):
                            if ($i < 2) {
                                ?>
                                <div class="image-item">
                                    <a class href = "<?= base_url('item/details') . '/' . $fav->id_items . '/' . urlSeo($fav->name) ?>" title = "<?= $fav->name ?>">
                                        <img src="<?= base_url('assets/photo') . '/' . $fav->photo_thumbnail ?>" alt="<?= $fav->name ?>" title="<?= $fav->name ?>" />
                                    </a>
                                </div>
                                <div class="item-name"><?= $fav->name ?></div>
                                <div class="item-stock">Stock: <?= ($fav->stock > 5) ? "Available" : $fav->stock ?></div>
                                <div class="item-price">IDR <?= $fav->price ?></div>
                                <?php
                            } else {
                                break;
                            }
                            $i++;
                        endforeach;
                        ?>
                    </div>

                    <?php
                    $limit++;
                endforeach;
            }
            ?>
        </div>
    </div>
    <div class="row items-collections">
        <div class="span10">
            <div class="row title-wrapper">
                <div class="span10 rounded-gray-title"><h2>Collections</h2></div>
                <div class="btn btn-mini btn-inverse btn-more"><a href="<?= base_url('category/index') ?>">More<span>»</span></a></div>
            </div>
            <div class="row">
                <div class="span10 items-wrapper clearfix">
                    <?php
                    if (isset($items)) {
                        $limit = 1;
                        foreach ($items as $each_item):
                            $i = 1;
                            echo '<div class="item-wrapper">';
                            foreach ($each_item as $item):
                                if ($limit > 12) {
                                    break;
                                }
                                if ($i < 2) {
                                    ?>
                                    <div class="image-item">
                                        <a class href = "<?= base_url('item/details') . '/' . $item->id_items . '/' . urlSeo($item->name) ?>" title = "<?= $item->name ?>">
                                            <img src="<?= base_url('assets/photo') . '/' . $item->photo_thumbnail ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>" />
                                        </a>
                                    </div>
                                    <div class="item-name"><?= $item->name ?></div>
                                    <div class="item-stock">Stock: <?= ($item->stock > 5) ? "Available" : $item->stock ?></div>
                                    <div class="item-price">IDR <?= $item->price ?></div>
                                    <?php
                                    if ($item->id_categories == 1) { //Category = New Arrival
                                        echo '<div class="item-new">New</div>';
                                    }
                                } else {
                                    break;
                                }
                                $i++;
                            endforeach;
                            ?>
                        </div>

                        <?php
                        $limit++;
                    endforeach;
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
