<div class="container">
    <div class="hero-unit">
        <a class="btn btn-primary" href="<?=base_url()?>admin/blog/form"><i class="icon-plus"></i> Add New</a>
        <form id="blog-list-form" class="blog-list-form" action="<?=  base_url()?>admin/blog/reorder" method="POST">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Active</th>
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
                                    <td><?= $record->title ?></td>
                                    <td><?= $record->active == 1 ? 'Yes': '<span class="red-text">No</span>' ?></td>
                                    <td><input class="input-mini" id="input_blog_order" type="text" maxlength="3" name="input_blog_order[<?=$record->id_blog?>]" value="<?= $record->order?>" /></td>
                                    <td class="actions"><a class="btn btn-mini" href="<?=base_url().'admin/blog/form/'.$record->id_blog?>"><i class="icon-pencil"></i></a> <input class="checkbox" type="checkbox" name="input_blog_id_blog[]" value="<?= $record->id_blog?>" /></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>      
            <input class="btn btn-primary" type="submit" value="Re-Order" />
            <input id="btn-delete-blog" class="btn btn-danger" type="submit" value="Delete" />
        </form>
    </div>
</div>
