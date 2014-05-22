<?php
if (isset($query)) {
    $items = array();
    if ($query) {
        $records = $query->result();
        foreach ($records as $item):
            $items[$item->id_items][] = $item;
        endforeach;
    }
}

if (isset($urls)) {
	if ($urls) {
		foreach ($urls->result() as $url) {
			$shorter_link['url'][$url->directlink] = $url->permalink;
		}
	}
}
?>

    <div class="row ">
        <div class="span10 category-items-block">
            <div class="row items-collections">
                <div class="span10">
                    <div class="row title-wrapper">
                        <div class="span10 rounded-gray-title" itemscope itemtype="<?=isset($get_category) ? base_url('category/index/'.$get_category->row()->id_categories.'/'.urlSeo($get_category->row()->category)):''?>"><h2 itemprop="category"><?=isset($get_category) ? $get_category->row()->category:''?></h2></div>
                    </div>
                    <div class="row">
                        <div class="span10 items-wrapper clearfix">
                            <?php
                            if (isset($items)) {
                                $limit = 1;
                                foreach ($items as $each_item):
                                    $i = 1;
                                    ?>
                                    <div class="item-wrapper" itemscope itemtype="<?=isset($get_category) ? base_url('category/index/'.$get_category->row()->id_categories.'/'.urlSeo($get_category->row()->category)):''?>">
                                        <?php
                                        foreach ($each_item as $item):
                                            if ($i < 2) {
                                                ?>
                                                <div class="image-item">
												<?php 
													unset($new_url);
													if (isset($shorter_link) AND (array_key_exists('collections/details/'.$item->id_items, $shorter_link['url']))) {
															$new_url = $shorter_link['url']['collections/details/'.$item->id_items];
														
													}
												?>
                                                    <a itemprop="url" href = "<?= isset($new_url) ? base_url($new_url) : base_url('collections/details') . '/' . $item->id_items.'/'.  urlSeo($item->name) ?>" title = "<?= $item->name ?>">
                                                        <img itemprop="image" src="<?= base_url('assets/photo') . '/' . $item->photo_thumbnail ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>" />
                                                    </a>
                                                </div>
                                                <div itemprop="name" class="item-name"><?= $item->name ?></div>
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
