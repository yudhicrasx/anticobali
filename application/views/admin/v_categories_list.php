<div class="container">
    <div class="hero-unit">
        <a class="btn btn-primary" href="<?=base_url()?>admin/categories/form"><i class="icon-plus"></i> Add New</a>
        <form id="categories-list-form" class="categories-list-form" action="<?=  base_url()?>admin/categories/delete" method="POST">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Order</th>
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
                                    <td><img src="<?= base_url().'assets/category/'.$record->photo ?>" /></td>
                                    <td><?= $record->category ?></td>
                                    <td><?= $record->description ?></td>
                                    <td><?= $record->order ?></td>
                                    <td class="actions"><a class="btn btn-mini" href="<?=base_url().'admin/categories/form/'.$record->id_categories?>"><i class="icon-pencil"></i></a> <input type="checkbox" name="input_categories_id_categories[]" value="<?= $record->id_categories?>" /></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>      
            <input id="btn-delete-categories" class="btn btn-danger" type="submit" value="Delete" />
        </form>
    </div>
</div>
