<div class="container">
    <div class="hero-unit">
        <a class="btn" href="<?= base_url() ?>admin/blog"><i class="icon-list"></i> Blog List</a>
        <div class="action-add-new">
            <a class="btn btn-primary" href="<?= base_url() ?>admin/blog/form"><i class="icon-plus"></i> Add New</a>  
        </div>
        <?php
        if (isset($row)) {
            if ($row) {
                $record = $row->row();
				
				//get permalink
				if ($url) {
					$get_url = $url->row();
				}
			}
        }
        ?>
        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="control-group">
                <label class="control-label" for="input_url_permalink">Permalink</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_url_permalink" type="text" name="input_url_permalink" value="<?= isset($get_url) ? $get_url->permalink : set_value('input_url_permalink'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_blog_title">Title</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_blog_title" type="text" name="input_blog_title" value="<?= isset($record) ? $record->title : set_value('input_blog_title'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_blog_intro_text">Intro Text</label>
                <div class="controls">
                    <textarea class="ckeditor input-xlarge" id="input_blog_intro_text" name="input_blog_intro_text" rows="10"><?= isset($record) ? $record->intro_text : set_value('input_blog_intro_text'); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="photo">Image Intro</label>
                <div class="controls">
                    <?php 
                    if(isset($record)) { ?>
                    <div class="form-photo">
                        <img src="<?=base_url('assets/img/'.$record->intro_photo)?>" />
                    </div>
                    <?php } ?>
                    <input type="file" name="photo" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_blog_text">Description</label>
                <div class="controls">
                    <textarea class="ckeditor input-xlarge" id="input_blog_text" name="input_blog_text" rows="10"><?= isset($record) ? $record->text : set_value('input_blog_text'); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="blog_active">Active</label>
                <div class="controls">
                    <input id="blog_active" type="checkbox" name="blog_active" <?=isset($record) && ($record->active == 1) ? 'checked="checked"':''?> />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-primary" type="submit" value="Save" />
                </div>
            </div>
        </form>
        
    </div>
</div>
