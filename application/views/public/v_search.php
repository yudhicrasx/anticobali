<?php
if (isset($query)) {
    $items = array();
    if ($query) {
        foreach ($query->result() as $item):
            $items[$item->id_items][] = $item;
        endforeach;
    }
}
?>

<div class="row homepage-items-block">
    <div class="span10 category-items-block">
        <div class="row items-collections">
            <div class="span10">
                <div class="row title-wrapper">
                    <div class="span10 rounded-gray-title"><h2>Collections</h2></div>
                </div>
                <div class="row">
                    <div class="span10 items-wrapper clearfix">
                        <?php
                        if (isset($items)) {
                            $limit = 1;
                            foreach ($items as $each_item):
                                $i = 1;
                                ?>
                                <div class="item-wrapper">
                                    <?php
                                    foreach ($each_item as $item):
                                        if ($limit > 12) {
                                            break;
                                        }
                                        if ($i < 2) {
                                            ?>
                                            <div class="image-item">
                                                <a class href = "<?= base_url('collections/details') . '/' . $item->id_items.'/'.urlSeo($item->name) ?>" title = "<?= $item->name ?>">
                                                    <img src="<?= base_url('assets/photo') . '/' . $item->photo_thumbnail ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>" />
                                                </a>
                                            </div>
                                            <div class="item-name"><?= $item->name ?></div>
                                            <?php /*<div class="item-stock">Stock: <?= ($item->stock > 5) ? "Available" : $item->stock ?></div>
                                            <div class="item-price">IDR <?= $item->price ?></div> */ ?>
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
