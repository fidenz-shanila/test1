<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consclasser adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="wclassth=device-wclassth">

      <?php echo Asset::css('app.css'); ?>
        
        <?php echo Asset::css('jquery.ui.css'); ?>
        <?php echo Asset::css('typography.css'); ?>
        <?php echo Asset::css('datatables.css'); ?>
        <?php echo Asset::css('colorbox.css'); ?>
        <?php echo Asset::css('datepicker.css'); ?>
        <?php echo Asset::css('style.css'); ?>
        <?php //echo Asset::css('bootstrap.css'); ?>

        <script type="text/javascript"> APP = {}; APP.base_url = '<?php echo Uri::base(); ?>'; </script>
         
        <?php echo Asset::js('jquery.js'); ?>   
        <?php echo Asset::js('jquery.dataTables.js'); ?>        
        <?php echo Asset::js('colorbox.js'); ?>
        <?php echo Asset::js('jquery.ui.js'); ?>
        <?php echo Asset::js('jquery.defaultvalue.js'); ?>
        <?php echo Asset::js('jec.js'); ?>
        <?php echo Asset::js('moment_1.7.2.js'); ?>
         <?php echo Asset::js('glDatePicker.min.js'); ?>
        <?php echo Asset::js('dialogs.js'); ?>
        <?php echo Asset::js('jshashtable.js'); ?>
        <?php echo Asset::js('jquery-numberformatter.js'); ?>
        <?php echo Asset::js('jquery.h5validate.js'); ?>
        <?php echo Asset::js('app.js'); ?>
         <?php //echo Asset::js('bootstrap.js'); ?> 
       
        
        <?php if(isset($template_js) and !empty($template_js)) echo Asset::js($template_js); ?>

    </head>
    <body class="<?php if(isset($body_classes)) echo implode(' ', $body_classes); ?> template_strip">
        <?php echo \Message::display(); ?>
        <?php echo $content; ?>

        <div id="ajax-load">
            <?php echo Asset::img('ajax_loader.gif'); ?>
        </div>
        
    </body>
</html>