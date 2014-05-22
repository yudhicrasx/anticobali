<div class="container">
    <div class="hero-unit">
        <a class="btn" href="<?= base_url() ?>admin/categories"><i class="icon-list"></i> Category List</a>
        <div class="action-add-new">
            <a class="btn btn-primary" href="<?= base_url() ?>admin/categories/form"><i class="icon-plus"></i> Add New</a>  
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
                <label class="control-label" for="input_categories_category">Title</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_categories_category" type="text" name="input_categories_category" value="<?= isset($record) ? $record->category : set_value('input_categories_category'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_categories_description">Description</label>
                <div class="controls">
                    <input class="input-xxlarge" id="input_categories_description" type="text" name="input_categories_description" value="<?= isset($record) ? $record->description: set_value('input_categories_description'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="photo">Image</label>
                <div class="controls">
                    <input type="file" name="photo" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_categories_order">Order</label>
                <div class="controls">
                    <input class="input-mini" id="input_categories_order" type="text" name="input_categories_order" value="<?= isset($record) ? $record->order : set_value('input_categories_order'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="category_active">Active</label>
                <div class="controls">
                    <input id="category_active" type="checkbox" name="category_active" <?=isset($record) && ($record->active == 1) ? 'checked="checked"':''?> />
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
