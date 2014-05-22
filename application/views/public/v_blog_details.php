<?php
if (isset($query)) {
    if ($query) {
        $row = $query->row();
    }
}
?>

    <div class="row detail-blog-block">
        <div class="span10">
            <div class="row">
                <div class="span10">
                    <div class="row title-wrapper">
                        <div class="span10 rounded-gray-title"><h2><?=isset($row)? $row->title:''?></h2></div>
                    </div>
                    <div class="row">
                        <div class="span10 clearfix">
                            <div class="item-wrapper">
                                <div class="item-top clearfix">
                                    <?php
                                    if (isset($row)) {
                                        ?>
                                        <div class="detail-wrapper">
                                            <?=$row->text?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="item-bottom">
                                    <div class="item-description"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>