<!DOCTYPE html>
<html lang="en">
    <head>
		<?php
			$title = "Indonesia Antique and Art Store - ";
			if ( $this->uri->segment(1) && ( $this->uri->segment(4) === FALSE) ) {
				$title = ucwords(str_replace("_"," ",$this->uri->segment(1)))." - ";
			} else if( $this->uri->segment(4) ) {
				$title = ucwords(str_replace("-"," ",$this->uri->segment(4)))." - ";
			}
		?>
		<title><?=$title?>Antico Bali</title>
		
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="<?=isset($description) ? $description:GLOBAL_DESCRIPTION?>" />
        <meta name="author" content="yudhicrasx@gmail.com" />
		<link rel="canonical" href="<?php echo base_url(uri_string()); ?>">
		
		<meta property="og:title" content="Indonesia Antique and Art Store"/>
		<meta property="og:type" content="website" />
		<meta property="og:image" content="<?=base_url('/assets/img/IMG_3536_200x150.jpg')?>"/>
		<meta property="og:url" content="<?=current_url()?>" />
		<meta name="robots" content="index, follow">
		
        <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-wysiwyg.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/colorbox/colorbox.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
		<link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet">
		
        <script src="<?php echo base_url('assets/js/jquery191.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <!--<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
        <script src="<?php echo base_url('assets/js/lodash.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
        <!--<script src="<?php echo base_url('assets/js/jquery.colorbox-min.js') ?>"></script>-->
        <script src="<?php echo base_url('assets/js/custom.js') ?>"></script>		
		<script src="<?php echo base_url('assets/js/elevatezoom/jquery.elevatezoom.js') ?>"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        
        <script type="text/javascript">var switchTo5x=true;</script>
        <script src="<?php echo base_url('assets/js/sharethis.js') ?>"></script>
        <script type="text/javascript">stLight.options({publisher: "22f9c058-55cc-42c4-9ed6-cdd3dc52fc41", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
		<meta name="google-site-verification" content="8CN2ImGv4IaD8m74r86V4ynRfCey1PPdbD8Dv4ZiO_Y" />
		<meta name="msvalidate.01" content="73B74EBA82CDBAE177ADB4D8861747FD" />
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

		  ga('create', 'UA-4779135-2', 'anticobali.com');
		  ga('require', 'linkid', 'linkid.js');
		  ga('send', 'pageview');

		</script>
    </body>
</html>