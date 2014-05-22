<?php
if (isset($query)) {
    if ($query) {
        $item = $query->row();

        $photos = array();
        foreach ($query->result() as $row):
            $photos[$row->photo_thumbnail] = $row->photo_original;
        endforeach;
    }
}
?>
    <div class="row detail-item-block">
        <div class="span10">
            <div class="row">
                <div class="span10" itemscope itemtype="<?=isset($item) ? 'http://schema.org/Product':''?>">
                    <div class="row title-wrapper">
                        <div class="span10 rounded-gray-title"><h2 itemprop="name"><?=isset($item)? $item->name:''?></h2></div>
                    </div>
                    <div class="row">
                        <div class="span10 clearfix">
                            <div class="item-wrapper">
                                <div class="item-top clearfix">
                                    <?php
                                    if (isset($query)) {
                                        ?>
                                        <div class="image-item">
                                            <!--<div class="image-initiate">-->
											<img id="zoom_03" itemprop="image" width="300" src="<?= base_url('assets/photo') . '/' . $item->photo_original ?>" data-zoom-image="<?= base_url('assets/photo') . '/' . $item->photo_original ?>" alt="<?= $item->name ?>" id="productImage" title="<?= $item->name ?>" />
											<!--</div>-->
                                            <div id="gallery_01" class="item-thumbnails">
                                                <?php
												$i = 1;
                                                foreach ($photos as $thumb=>$photo):
                                                    ?>
                                                    <!--<div class="item-zoom">-->
                                                        <a href="#" class="elevatezoom-gallery<?=$i==1 ? " active":""?>" data-image="<?= base_url('assets/photo') . '/' . $photo ?>" data-zoom-image="<?= base_url('assets/photo') . '/' . $photo ?>" title="<?= $item->name ?>">
                                                            <img id="zoom_03" itemprop="image" src="<?= base_url('assets/photo') . '/' . $thumb ?>" alt="<?= $item->name.' '.+$i ?>" title="<?= $item->name.' '.+$i ?>" />
                                                        </a>
                                                    <!--</div>-->
                                                    <?php
													$i++;
                                                endforeach;
                                                ?>
                                            </div>
                                            <div class="images-zoom">Click to zoom</div>
                                        </div>
                                        <div class="detail-wrapper">
                                            <?php /*<div class="block-name fields"><div class="labels-item">Name</div><div class="label-values"><?= $item->name ?></div></div> */ ?>
                                            <div class="block-stock fields">
												<div class="labels-item">Availability</div>
												<div class="label-values"><?= ($item->stock > 5) ? "In Stock" : $item->stock ?></div>
											</div>
                                            <div class="block-price fields"><div class="labels-item">Weight </div><div class="label-values" itemprop="weight"><?= $item->weight ?> Kg</div></div>
											<div class="block-order fields"><a class="btn btn-primary" href="mailto:sales@antiqueku.com?subject=AnticoBali.com%20<?= str_replace(' ', '_', $item->name)."_".$item->id_items;?>">Click to Order</a></div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="item-bottom">
                                    <div class="item-description" itemprop="description"><?= $item->description ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>