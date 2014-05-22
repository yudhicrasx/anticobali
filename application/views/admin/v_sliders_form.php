<div class="container">
    <div class="hero-unit">
        <a class="btn" href="<?= base_url() ?>admin/sliders"><i class="icon-list"></i> Slider List</a>
        <div class="action-add-new">
            <a class="btn btn-primary" href="<?= base_url() ?>admin/sliders/form"><i class="icon-plus"></i> Add New</a>  
        </div>
        <?php
        if (isset($row)) {
            if ($row) {
                $record = $row->row();
            }
        }
        ?>
        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="control-group">
                <label class="control-label" for="input_sliders_title">Title</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_sliders_title" type="text" name="input_sliders_title" value="<?= isset($record) ? $record->title : set_value('input_sliders_title'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_sliders_short_description">Short Description</label>
                <div class="controls">
                    <textarea class="ckeditor input-xlarge" id="input_sliders_short_description" name="input_sliders_short_description" rows="10"><?= isset($record) ? $record->short_description : set_value('input_sliders_short_description'); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_sliders_description">Description</label>
                <div class="controls">
                    <textarea class="ckeditor input-xlarge" id="input_sliders_description" name="input_sliders_description" rows="10"><?= isset($record) ? $record->description : set_value('input_sliders_description'); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="photo">Image</label>
                <div class="controls">
                    <input type="file" name="photo" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_sliders_link">Link</label>
                <div class="controls">
                    <?=base_url()?><input class="input-large" id="input_sliders_link" type="text" name="input_sliders_link" value="<?= isset($record) ? $record->link : set_value('input_sliders_link'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sliders_active">Active</label>
                <div class="controls">
                    <input id="sliders_active" type="checkbox" name="sliders_active" <?=isset($record) && ($record->active == 1) ? 'checked="checked"':''?> />
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
