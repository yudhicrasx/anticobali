<div class="container">
    <div class="hero-unit">
        <?php
            if($query) {
                $record = $query->row();
                ?>
        <div><?=$record->name?></div>
        <div><?=$record->email?></div>
        <div><?=$record->message?></div>
        <div><?=$record->input_date?></div>
        <?php
            }
        ?>
        <div>
            
        </div>
    </div>
</div>
