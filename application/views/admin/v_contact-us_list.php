<div class="container">
    <div class="hero-unit">
        <form id="item-list-form" action="<?= base_url() ?>admin/contact_us/delete" method="POST">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date</th>
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
                                    <td><?= $record->name ?></td>
                                    <td><?= $record->email ?></td>
                                    <td><?= $record->input_date ?></td>
                                    <td class="actions"><a class="btn btn-mini colorbox" href="<?=base_url().'admin/contact_us/details/'.$record->id_contact_us?>"><i class="icon-info-sign"></i></a><input name="input_contactus_id_contact_us[]" title="Delete" type="checkbox" value="<?= $record->id_contact_us ?>" /></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>      
            <input class="btn btn-danger" type="submit" value="Delete" />
        </form>
    </div>
</div>
