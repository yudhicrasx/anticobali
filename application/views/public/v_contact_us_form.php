<script type="text/javascript">
    $(document).ready(function(){
       
        //<![CDATA[
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'message',
        {
            toolbar :
                [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
            ]
        });
        //]]>

    });
</script>
<div class="row">
    <div class="span10 contact-us-block">
        <div class="row title-wrapper">
            <div class="span10 rounded-gray-title"><h2>Contact Us</h2></div>
        </div>
        <div class="row">
            <div class="span9">
                <form class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="input-large" id="name" type="text" name="name" value="<?= set_value('name'); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">E-mail</label>
                        <div class="controls">
                            <input class="input-large" id="email" type="text" name="email" value="<?= set_value('email'); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="message">Description</label>
                        <div class="controls">
                            <textarea class="ckeditor input-large" id="message" name="message" rows="2"><?= set_value('message'); ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="word">Captcha</label>
                        <div class="controls">
                            <?= $captcha ?>
                            <input class="input-small" id="word" type="text" name="word" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input name="bot_trap" type="hidden" />
                            <input class="btn" type="submit" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>