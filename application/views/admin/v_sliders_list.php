<div class="container">
    <div class="hero-unit">
        <a class="btn btn-primary" href="<?=base_url()?>admin/sliders/form"><i class="icon-plus"></i> Add New</a>
        <form id="slider-list-form" class="slider-list-form" action="<?=  base_url()?>admin/sliders/reorder" method="POST">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($query)) {
                        if ($query) {
                            $no = 1;
                            foreach ($query->result() as $record) {
                                ?>                         
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="<?= base_url().'assets/sliders/'.$record->photo_thumbnail ?>" /></td>
                                    <td><?= $record->title ?></td>
                                    <td><?= $record->order ?></td>
                                    <td><input class="input-mini" id="input_items_order" type="text" maxlength="3" name="input_items_order[<?=$record->id_sliders?>]" value="<?= $record->order?>" /></td>
                                    <td class="actions"><a class="btn btn-mini" href="<?=base_url().'admin/sliders/form/'.$record->id_sliders?>"><i class="icon-pencil"></i></a> <input type="checkbox" name="input_sliders_id_sliders[]" value="<?= $record->id_sliders?>" /></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>      
            <input class="btn btn-primary" type="submit" value="Re-Order" />
            <input id="btn-delete-sliders" class="btn btn-danger" type="submit" value="Delete" />
        </form>
    </div>
</div>
