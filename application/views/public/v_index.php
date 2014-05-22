<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Antique and Art shop sells necklace, bracelete, statue, furniture, traditional weapons and many more made from all over Indonesia . We are located in Bali, island of Gods.">
        <meta name="keywords" content="<?=isset($keywords) ? $keywords:GLOBAL_KEYWORDS?>">
        <meta name="author" content="yudhicrasx@gmail.com">

        <title>AntiqueKu</title>

        <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-wysiwyg.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/colorbox/colorbox.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

        <script src="<?php echo base_url('assets/js/jquery191.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <!--<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
        <script src="<?php echo base_url('assets/js/lodash.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.colorbox-min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
        
        <script type="text/javascript">var switchTo5x=true;</script>
        <script src="<?php echo base_url('assets/js/sharethis.js') ?>"></script>
        <script type="text/javascript">stLight.options({publisher: "22f9c058-55cc-42c4-9ed6-cdd3dc52fc41", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    </head>
    <body class="public">
        <noscript>Your browser have not JavaScript enabled!</noscript>
        <?= $menubar_view ?>
        <div class="container">
            <div class="row">
                <div class="span10 offset1 content-block">
                    <?= $flash_message_view ?>
                    <?= $body ?>
                </div>
            </div>
        </div>

        <?= $footerbar_view ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-4779135-2', 'antiqueku.com');
		  ga('send', 'pageview');

		</script>
    </body>
</html>