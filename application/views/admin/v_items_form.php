<div class="container">
    <div class="hero-unit">
        <a class="btn" href="<?= base_url() ?>admin/items"><i class="icon-list"></i> Item List</a>
        <div class="action-add-new">
            <a class="btn btn-primary" href="<?= base_url() ?>admin/items/form"><i class="icon-plus"></i> Add New</a>  
        </div>
        <?php
        if (isset($row)) {
            if ($row) {
                $item = $row->row();

                foreach ($row_items_categories->result() as $cat):
                    $cat_ids[] = $cat->id_categories;
                endforeach;
				
				//get permalink
				if ($url) {
					$get_url = $url->row();
				}
            }
        }
        ?>
        
        <form class="form-horizontal" method="POST">
            <div class="control-group">
                <label class="control-label" for="input_url_permalink">Permalink</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_url_permalink" type="text" name="input_url_permalink" value="<?= isset($get_url) ? $get_url->permalink : set_value('input_url_permalink'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_name">Name</label>
                <div class="controls">
                    <input class="input-xlarge" id="input_items_name" type="text" name="input_items_name" value="<?= isset($item) ? $item->name : set_value('input_items_name'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_price">Price</label>
                <div class="controls input-prepend">
                    <span class="add-on">Rp</span><input class="input-small span2" id="input_items_price" type="text" name="input_items_price" value="<?= isset($item) ? $item->price : set_value('input_items_price'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="selected_categories">Category(es)</label>
                <div class="controls">
                    <select class="input-xlarge" id="selected_categories" name="selected_categories[]" multiple="multiple">
                        <?php
                        if (isset($row_category)) {
                            if ($row_category) {
                                foreach ($row_category->result() as $category):
                                    $selected = '';
                                    if (isset($cat_ids)) {
                                        foreach ($cat_ids as $cat_id):
                                            if ($category->id_categories == $cat_id) {
                                                $selected = 'selected="selected"';
                                                break;
                                            }
                                        endforeach;
                                    }
                                    ?>
                                    <option value="<?= $category->id_categories ?>" <?= isset($selected) ? $selected : set_select('selected_categories', $category->id_categories) ?>><?= $category->category ?><?=$category->active == 0 ? ' <b>*inactive</b>':''?></option>
                                    <?php
                                endforeach;
                            } else {
                                $alert_msg = alertMsg(0);
                                ?>
                                <option value="null"><?= $alert_msg['message'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_producing">Product</label>
                <div class="controls">
                    <select class="input-mini" id="input_items_producing" name="input_items_producing">
                        <option value="1" <?= @$item->producing == 1 ? 'selected="selected"' : '' ?>>Yes</option>
                        <option value="0" <?= @$item->producing == 0 ? 'selected="selected"' : '' ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_description">Description</label>
                <div class="controls">
                    <textarea class="ckeditor input-xxlarge" id="input_items_description" name="input_items_description" rows="10"><?= isset($item) ? $item->description : set_value('input_items_description'); ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_stock">Stock</label>
                <div class="controls">
                    <input class="input-mini" id="input_items_stock" type="text" name="input_items_stock" value="<?= isset($item) ? $item->stock : set_value('input_items_stock'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input_items_weight">Weight</label>
                <div class="controls input-append">
                    <input class="input-mini" id="input_items_weight" type="text" name="input_items_weight" value="<?= isset($item) ? $item->weight : set_value('input_items_weight'); ?>" /><span class="add-on">Kg</span>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-primary" type="submit" value="Save" />
                </div>
            </div>
        </form>

        <div id="item-photo-section">
            <h3>Photo(s)</h3>
            <form method="POST" action="<?= base_url() . 'admin/items/photo/' . @$item->id_items ?>" enctype="multipart/form-data">
                <input type="file" name="photo" />
                <input class="btn btn-inverse" type="submit" value="Upload" />
            </form>

            <form class="photo-item-list-form" action="<?= base_url() ?>admin/items/delete/<?= @$item->id_items ?>" method="POST">
                <table class="table table-striped table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($row_photo)) {
                            if ($row_photo) {
                                $no = 1;
                                foreach ($row_photo->result() as $photo):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><a class="group1" href="<?= base_url('assets/photo') . '/' . $photo->photo_original ?>" title="Photos"><img src="<?= base_url('assets/photo') . '/' . $photo->photo_thumbnail ?>" /></a></td>
                                        <td class="actions"><input type="checkbox" name="input_photos_id_photos[]" value="<?= $photo->id_photos ?>" title="Delete" /></td>
                                    </tr>
                                    <?php
                                endforeach;
                            }
                        } else {
                            $alert_msg = alertMsg(0);
                            echo '<tr><td colspan="3">' . $alert_msg['message'] . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <input class="btn btn-danger" id="delete-photo" type="submit" value="Delete" />
            </form>
        </div>
    </div>
</div>
