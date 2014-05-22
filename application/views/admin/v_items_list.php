<div class="container">
    <div class="hero-unit">
        <a class="btn btn-primary" href="<?=base_url()?>admin/items/form"><i class="icon-plus"></i> Add New</a>
        <form id="item-list-form" class="item-list-form" action="<?=  base_url()?>admin/items/reorder" method="POST">
            <table class="table table-striped table-condensed table-hover table-items-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                    
                    if (isset($query)) {
                        if ($query) {
                            $photos = array();
                            foreach($item_photo->result() as $photo):
                                $photos[$photo->id_items][] = $photo->photo_thumbnail;
                            endforeach;
                            
                            $no = 1;
                            foreach ($query->result() as $items) {
                                ?>                         
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $items->name ?></td>
                                    <?php
                                    if(array_key_exists($items->id_items, $photos)) { ?>
                                    <td><img src="<?=base_url('assets/photo').'/'.$photos[$items->id_items][0]?>" alt="<?= $items->name ?>" />
                                    <?php 
                                    } else { echo '<td></td>'; }
                                    ?>
                                    <td class="price"><?= number_format($items->price) ?></td>
                                    <td><?= $items->stock ?></td>
                                    <td><input class="input-mini" id="input_items_order" type="text" maxlength="3" name="input_items_order[<?=$items->id_items?>]" value="<?= $items->order?>" /></td>
                                    <td><input type="checkbox" name="input_items_active[<?=$items->id_items?>]" <?= $items->active == 0 ? '':'Checked="Checked"'; ?> /></td>
                                    <td class="actions"><a class="btn btn-mini" href="<?=base_url().'admin/items/form/'.$items->id_items?>"><i class="icon-pencil"></i></a> <input type="checkbox" name="input_items_id_items[]" value="<?= $items->id_items?>" /></td>
                                </tr>
                                <?php
                            }
                        }else{
						$alert_msg = alertMsg(0);
                            echo '<tr><td colspan="6">'.$alert_msg['message'].'</td></tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>      
            <input class="btn btn-primary" type="submit" value="Re-Order" />
            <input id="btn-delete-items" class="btn btn-danger" type="submit" value="Delete" />
        </form>
    </div>
</div>
