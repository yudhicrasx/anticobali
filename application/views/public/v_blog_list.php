<?php
if (isset($urls)) {
	if ($urls) {
		foreach ($urls->result() as $url) {
			$shorter_link['url'][$url->directlink] = $url->permalink;
		}
	}
}
?>
<div class="row">
    <div class="span10 blog-block">
        <div class="row title-wrapper">
            <div class="span10 rounded-gray-title"><h2>Blog</h2></div>
        </div>
        <div class="row">
            <div class="span10">
                <?php
                if (isset($query)) {
                    if ($query) {
                        foreach ($query->result() as $row):
							unset($new_url);
							if (isset($shorter_link) AND (array_key_exists('blog/detail/'.$row->id_blog, $shorter_link['url']))) {
								$new_url = $shorter_link['url']['blog/detail/'.$row->id_blog];
							}
                            ?>
                            <div class="row blog-item">
                                <div class="span10">
                                    <div class="row">
                                        <div class="span10 blog-item-title"><h3><a href="<?= isset($new_url) ? base_url($new_url) : base_url('blog/detail' . '/' . $row->id_blog . '/' . urlSeo($row->title)) ?>" title="<?= $row->title ?>"><?= $row->title ?></a></h3></div>
                                    </div>
                                </div>
                                <div class="span10">
                                    <div class="row">
                                        <div class="span2 blog-item-thumbnail"><img src="<?= base_url('assets/img' . '/' . $row->intro_photo) ?>" alt="<?=$row->title?>" /></div>
                                        <div class="span8 blog-item-intro"><?= $row->intro_text ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>