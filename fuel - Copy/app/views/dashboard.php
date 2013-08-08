<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>NMI :: Test and Calibration Database</title>
	<?php echo \Asset::css(array('dashboard.css', 'colorbox.css')); ?>
	<?php echo \Asset::js(array('jquery.js', 'colorbox.js', 'app.js', 'dashboard.js')); ?>

</head>

<body>
	<p style="text-align:right;padding-right:8px;">Logged in as <strong><?php echo $current_user['full_name']; ?></strong></p>
	<br />
	<div id="wrap">
		<h1 class="app_title">Test and Calibration Database</h1>
		<ul class="icons_grid">
			
			<li class="contacts">
				<a href="<?php echo \Uri::create('contacts'); ?>">
					<?php echo \Asset::img('dashboard/contacts.png'); ?>
					<span>Contacts</span>
				</a>
			</li>
			
			<li class="quotes">
				<a href="<?php echo \Uri::create('quotes'); ?>">
					<?php echo \Asset::img('dashboard/quotes.png'); ?>
					<span>Quotes</span>
				</a>
			</li>

			<li class="jobs">
				<a href="<?php echo \Uri::create('jobs'); ?>">
					<?php echo \Asset::img('dashboard/jobs.png'); ?>
					<span>Jobs</span>
				</a>
			</li>
			
			<li class="reports">
				<a href="<?php echo \Uri::create('reports'); ?>">
					<?php echo \Asset::img('dashboard/reports.png'); ?>
					<span>Reports</span>
				</a>
			</li>
			
			<li class="receipts_dispatch">
				<a href="<?php echo \Uri::create('receipts'); ?>">
					<?php echo \Asset::img('dashboard/receipts_dis.png'); ?>
					<span>Receipts and Despatch</span>
				</a>
			</li>
			
			<li class="invoices">
				<a href="<?php echo \Uri::create('invoices'); ?>">
					<?php echo \Asset::img('dashboard/invoices.png'); ?>
					<span>Invoices</span>
				</a>
			</li>

			

			<li class="report_master">
				<a href="<?php echo \Uri::create('reports/reportmaster'); ?>">
					<?php echo \Asset::img('dashboard/reportsmaster.png'); ?>
					<span>Report Master</span>
				</a>
			</li>
			
			<li class="cb_files">
				<a href="<?php echo \Uri::create('files'); ?>">
					<?php echo \Asset::img('dashboard/CBFileBig2.png'); ?>
					<span>CB File Listing</span>
				</a>
			</li>

			<li class="employees">
				<a href="<?php echo \Uri::create('employees'); ?>">
					<?php echo \Asset::img('dashboard/employees.png'); ?>
					<span>Employees</span>
				</a>
			</li>
			
			<li class="scheduler">
				<a class="cb iframe" href="<?php echo \Uri::create('users/scheduler'); ?>">
					<?php echo \Asset::img('dashboard/scheduler.png'); ?>
					<span>Scheduler</span>
				</a>
			</li>
			
			<li class="admin">
				<a href="<?php echo \Uri::create('admins'); ?>">
					<?php echo \Asset::img('dashboard/admins.png'); ?>
					<span>Administration</span>
				</a>
			</li>


			
		</ul>
		<div class="clear"></div>
		
		<div id="footer_actions">
			<a href="#" id="settings"><?php echo \Asset::img('dashboard/Notes.png', array('width' => '44px', 'height' => '45px' )); ?></a>
			<a href="<?php echo \Uri::create('users/settings'); ?>" id="settings" class="cb iframe"><?php echo \Asset::img('dashboard/settings.png', array('width' => '44px', 'height' => '45px' )); ?></a>
			<a href="<?php echo \Uri::create('auth/logout'); ?>" id="logout"><?php echo \Asset::img('dashboard/close.png'); ?></a>
		</div>
		
	</div>
	
</body>
</html>