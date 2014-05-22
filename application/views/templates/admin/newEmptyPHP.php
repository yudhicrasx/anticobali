<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">

        <title>:: AntiqueKu :: Administration</title>

        <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap-wysiwyg.css') ?>" rel="stylesheet">
        <!--<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">-->
        <link href="<?php echo base_url('assets/css/colorbox/colorbox.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

        <!--
        <script src="<?php echo base_url('assets/js/jquery191.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/lodash.min.js') ?>"></script>-->
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <!--<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>-->
        <script src="<?php echo base_url('assets/js/jquery.colorbox-min.js') ?>"></script>
        
        
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/assets/js/elfinder-2.0/css/elfinder.min.css">
        <script type="text/javascript" src="/assets/js/elfinder-2.0/js/elfinder.min.js"></script>            
        <!-- Mac OS X Finder style for jQuery UI smoothness theme (OPTIONAL) -->
        <link rel="stylesheet" type="text/css" media="screen" href="/assets/js/elfinder-2.0/css/theme.css">
        
        <script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
    </head>
    <body class="logged-in">
        <noscript>Your browser have not JavaScript enabled!</noscript>
        <?=$flash_message_view?>
        <?=$menubar_view?>
        <?= $body; ?>
    </body>
</html>