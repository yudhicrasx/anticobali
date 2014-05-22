<?php
if (isset($query)) {
    $items = array();
    //$new_arrival_items = array();
    if ($query) {
        foreach ($query->result() as $item):
            $items[$item->id_items][] = $item;
        endforeach;
    }
}
?>

<div class = "row category-items-block items-collections">
    <div class="span10 items-wrapper clearfix">
        <?php
        if (isset($items)) {
            foreach ($items as $each_item):
                ?>
                <div class="item-wrapper">
                    <?php
                    $i = 1;
                    foreach ($each_item as $item):
                        if ($i < 2) {
                            ?>
                            <div class="image-item">
                                <a class href = "<?= base_url('item/details') . '/' . $item->id_items . '/' . urlSeo($item->name) ?>" title = "<?= $item->name ?>">
                                    <img src="<?= base_url('assets/photo') . '/' . $item->photo_thumbnail ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>" />
                                </a>
                            </div>
                            <?php
                        } else {
                            break;
                        }
                        $i++;
                    endforeach;
                    ?>
                </div>
                <?php
            endforeach;
        }
        ?>
    </div>
</div>