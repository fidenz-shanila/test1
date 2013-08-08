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

        <script type="text/javascript"> APP = {}; APP.base_url = '<?php echo Uri::base(); ?>'; </script>

        <?php echo Asset::js('jquery.js'); ?>   
        <?php echo Asset::js('jquery.dataTables.js'); ?>        
        <?php echo Asset::js('colorbox.js'); ?>
        <?php echo Asset::js('jquery.ui.js'); ?>
        <?php echo Asset::js('jquery.defaultvalue.js'); ?>
        <?php echo Asset::js('jec.js'); ?>
        <?php echo Asset::js('moment_1.7.2.js'); ?>
         <?php echo Asset::js('glDatePicker.min.js'); ?>
         <?php echo Asset::js('jshashtable.js'); ?>
         <?php echo Asset::js('jquery-numberformatter.js'); ?>
        <?php echo Asset::js('jquery.h5validate.js'); ?>
        

        <?php //echo Asset::js('window.js'); ?>
        
        <?php echo Asset::js('app.js'); ?>
       
		
        <?php if(isset($template_js) and !empty($template_js)) echo Asset::js($template_js); ?>

    </head>
    <body class="main-template <?php if(isset($body_classes)) echo implode(' ', $body_classes); ?>">

        <div id="header">
            <ul>
                <li><?php echo Html::anchor('dashboard', 'Dashboard'); ?></li>
                <li><?php echo Html::anchor('contacts', 'Contacts'); ?></li>
                <li><?php echo Html::anchor('quotes', 'Quotes'); ?></li>
                <li><?php echo Html::anchor('jobs', 'Jobs'); ?></li>
                <li><?php echo Html::anchor('reports', 'Reports'); ?></li>
                <li><?php echo Html::anchor('receipts', 'Receipts &amp; Dispatch'); ?></li>
                <li><?php echo Html::anchor('invoices', 'Invoices'); ?></li>
                <li><?php echo Html::anchor('reports/reportmaster', 'Report Master'); ?></li>
                <li><?php echo Html::anchor('files', 'CB File Listing'); ?></li>
                <li><?php echo Html::anchor('employees', 'Employees'); ?></li>
                <li><?php echo Html::anchor('users/scheduler', 'Scheduler'); ?></li>
                <li><?php echo Html::anchor('admins', 'Administration'); ?></li>
            </ul>
            <p class="user"><a href="<?php echo \Uri::create('employees/edit/'); ?><?php if(isset($current_user)){ echo $current_user['id'];} ?>"><?php echo $current_user['full_name']; ?> </a>| <?php echo Html::anchor('auth/logout', 'Logout'); ?></p>
        </div>

        <?php echo \Message::display(); ?>

        <?php echo $content; ?>

        <div id="footer">
            <?php echo \Asset::img('woodfin_logo.png', array('width'=>90)); ?>
            <p class="ver">
                <?php Config::load('deployment', true); ?>
                <?php echo Config::get('deployment.version_number'); ?>    <?php echo Config::get('deployment.timestamp'); ?>  | <?php echo Config::get('deployment.version'); ?>                
            </p>
        </div>

        <div id="ajax-load">
            <?php echo Asset::img('ajax_loader.gif'); ?>
        </div>
        
    </body>
    
</html>