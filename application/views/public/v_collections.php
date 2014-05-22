<?php
if (isset($urls)) {
	if ($urls) {
		foreach ($urls->result() as $url) {
			$shorter_link['url'][$url->directlink] = $url->permalink;
		}
	}
}

?>
<div class = "row category-block">
    <div class="span10 categories-wrapper clearfix">
		<div class="category_intro">
			Are you looking for antique items? Welcome, we are Indonesia antique and art store in Bali; selling hundreds of antique and art collections from sculputure, stone and wooden carving, animal skull, traditional weapon, sea shell, jewelry, household furnishings, home accessories and so on. Antico Bali sells the very best collections (production or non-production), wholesale or retail, from <strong>Bali - Indonesia</strong>, and gives them to the world to complete your antique and art collections.
		</div>
	</div>
    <div class="span10 categories-wrapper clearfix">
        <?php
        if (isset($categories)) {
            if ($categories) {
                ?>
                <ul class="clearfix">
                    <?php
                    foreach ($categories->result() as $cat):
						unset($new_url);
						if (isset($shorter_link) AND (array_key_exists('category/index/'.$cat->id_categories, $shorter_link['url']))) {
							$new_url = $shorter_link['url']['category/index/'.$cat->id_categories];
						}
                        ?>
                        <li class="category-wrapper span2">
                            <a href="<?= isset($new_url) ? base_url($new_url) : base_url('category') . '/index/' . $cat->id_categories . '/' . urlSeo($cat->category); ?>" title="<?= $cat->category ?>">
                                <div class="title"><?= $cat->category ?></div>
                                <div class="description"><?= $cat->description ?></div>
                                <div class="photo">
                                    <img src="<?= base_url('assets/category') . '/' . $cat->photo ?>" alt="<?= $cat->category ?>" />
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                </ul>
                <?php
            }
        }
        ?>
    </div>
</div>