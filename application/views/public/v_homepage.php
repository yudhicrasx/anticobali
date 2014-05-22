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

?>

<div class = "row category-items-block">
    <div class = "span10 homepage-category-slider">
        <div class = "row">
            <div class="span10 carousel-block">
                <?php
                if (isset($slider)) {
                    if ($slider) {
                        ?>
                        <div class="carousel-wrapper clearfix">
                            <div id="myCarousel" class="carousel slide carousel-fade">
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
                                    $i = 1;
                                    foreach ($slider->result() as $slider_row):
                                        ?>
                                        <div class="item<?php if ( $i == 1) echo ' active'; ?>">
                                            <img src="<?= base_url('assets/sliders') . '/' . $slider_row->photo_thumbnail ?>" alt="">
                                            <?php /* <div class="carousel-caption">
                                                <h4><a class="carousel-title" href="<?=base_url('collections/details/20')?>" title="Detail of <?= $slider_row->title ?>"><?= $slider_row->title ?></a></h4>
                                                <div class="description"><?= $slider_row->short_description ?></div>
                                            </div>  */ ?>
                                        </div>
                                        <?php
                                        $i++;
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
        </div>
    </div>
</div>
