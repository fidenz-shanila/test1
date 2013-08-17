<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>NMI :: Test and Calibration Database</title>
	<?php echo \Asset::css(array('dashboard.css', 'colorbox.css')); ?>
	<?php echo \Asset::js(array('jquery.js', 'colorbox.js', 'app.js', 'dashboard.js')); ?>
<?php echo Asset::css('app.css'); ?>
        
        <?php echo Asset::css('jquery.ui.css'); ?>
        <?php echo Asset::css('typography.css'); ?>
        <?php echo Asset::css('datatables.css'); ?>
        <?php echo Asset::css('colorbox.css'); ?>
        <?php echo Asset::css('datepicker.css'); ?>
        <?php echo Asset::css('style.css'); ?>
        <?php echo Asset::css('bootstrap.css'); ?>

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
         <?php echo Asset::js('bootstrap.js'); ?> 
</head>

<body>  <div id="dialogtest"  style="display:none;background-color: #0080C0">
        <h1 class="app_title">Test and Calibration Database</h1>
<!--	<p style="text-align:right;padding-right:8px;">Logged in as <strong><?php echo $current_user['full_name']; ?></strong></p>-->
	<br />
      
           
            
	<div id="wrap" style="background-color: #7BAFFD;">
		<h1 class="app_title" style="padding-top:20px;">MAIN MENU</h1>
                <h4 class="app_title">Welcome <?php echo $current_user['full_name']; ?>.</h4>
		<h4 class="app_title">Please make a selection from the menu.</h4>
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
                <input type="button" id="ok_tt">
		<div class="clear"></div>
		
		<div id="footer_actions">
                    
			<a href="#" id="settings"><?php echo \Asset::img('dashboard/Notes.png', array('width' => '44px', 'height' => '45px' )); ?></a>
			<a href="<?php echo \Uri::create('users/settings'); ?>" id="settings" class="cb iframe"><?php echo \Asset::img('dashboard/settings.png', array('width' => '44px', 'height' => '45px' )); ?></a>
			<a href="<?php echo \Uri::create('auth/logout'); ?>" id="logout"><?php echo \Asset::img('dashboard/close.png'); ?></a>
                        <br>
                        <div align="right">
                <?php Config::load('deployment', true); ?>
                <?php echo Config::get('deployment.version_number'); ?>    <?php echo Config::get('deployment.timestamp'); ?>  | <?php echo Config::get('deployment.version'); ?>                
            </div>
		</div>
		
	</div>
            </div>
        <div id="frmContactListing" title="frmContactListing" scrolling="no" width="100%"  style="display:none;background-color:#BAC7FC;" >
    <iframe id="frmContactListingIF" width="100%" height="100%" style=" background-color:#BAC7FC;border: thin hidden;position:absolute;left:-10px;top:0px;"></iframe>
</div>
        <div id="somediv" title="frmContact" width="100%" height="1000px" style="display:none;background-color:#8FA5FA;" >
    <iframe id="thedialog" width="100%" height="1000px" style="background-color:#8FA5FA;overflow:auto;border:none"></iframe>
</div>
        <div id="dialog" title="frmInsertContact" class="abcdef" style="width:650px;height:20px;overflow:hidden;background-color:#C0C0C0;display:none;">
    <iframe style="width:550px;height:290px;" id="myIframe" src=""></iframe>
</div>
        <div id="CatWendow" title="frmContactAndOrgCats" scrolling="no" width="100%" height="100%" style="display:none;overflow:hidden;background-color:#8FA5FA;" >
    <iframe id="CatWendowIF" width="100%" height="100%" style="background-color:#8FA5FA;overflow:hidden;border: none;"></iframe>
</div>
         <div id="lll" title="frmContactAndOrgCats" scrolling="no" width="100%" height="100%" style="display:none;overflow:hidden;background-color:#8FA5FA;" >
    <iframe id="lllIF" width="100%" height="100%" src="contacts/search_contacts" style="background-color:#8FA5FA;overflow:hidden;border: none;"></iframe>
</div>
        <div id="NewOrg" title="frmInsertOrganisation" scrolling="no" width="100%" height="1000px" style="display:none;background-color:#BAC7FC;" >
    <iframe id="NewOrgIF" width="100%" height="100%" style=" background-color:#BAC7FC;border: none"></iframe>
</div>
        
        <script type="text/javascript">
            var globale='';
              $("#dialogtest").dialog({
    autoOpen: false,
    modal: true,
    title:"frmSwitch",
    width:1055,
    height:900,
    resize:false,
      resizable: false,
         open: function(ev, ui){
$(".ui-dialog-titlebar-close").hide();
            
          }
  
});
 $('#dialogtest').dialog('open');
        $("#frmContactListing").dialog({
    autoOpen: false,
    modal: true,
    width:900,
    height:1000,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
$(".ui-dialog-titlebar-close").hide();
             $('#frmContactListingIF').attr('src',"<?php echo \Uri::create('contacts'); ?>");
          }
});

$('#ok_tt').click(function(){
    //alert($('#insertUrl').val());
  //  parent.$('body').css('overflow','hidden'); 
    $('#frmContactListing').dialog('open');
});

function closeIframe()
{

document.getElementById('frmContactListingIF').contentWindow.ContactListin();
//var x=document.getElementById("frmContactListingIF");
//alert(x);
//var y=(x.contentWindow || x.contentDocument);
//if (y.document)y=y.document;
//y.body.style.backgroundColor="#0000ff";
//y.jscript.ContactListin();
//document.getElementById('frmContactListingIF').contentWindow.ContactListin();
    parent.$('#somediv').dialog('close');
   // alert(globale);
    if(globale.length!=0){
       // alert(globale);
        document.getElementById('frmContactListingIF').contentWindow.openNewContact(globale);
        globale='';
      //  alert('ee');
    }

}
function closeForm(){
     $.ajax({
    //type: "get",
    url: "<?php echo \Uri::create('contacts/load_project_select_ajax'); ?>",
    //type: "GET",
//            dataType: 'json',
//            data: 'id=testdata',
//            cache: false,
    success: function(data) {
        alert('data');
    }
});
}

function openNewWen(id){
document.getElementById('thedialog').contentWindow.submitItself();
globale=id;
//document.getElementById('frmContactListingIF').contentWindow.openNewContact(id);
//alert(id);

}
function openNewWen1(id){
//document.getElementById('thedialog').contentWindow.submitItself();
document.getElementById('frmContactListingIF').contentWindow.openNewContact(id);
//alert(id);

}
function newOrgParent(id){
    document.getElementById('frmContactListingIF').contentWindow.openNewContact(id)
}

function setData(contact_cat,org_cat){
    document.getElementById('frmContactListingIF').contentWindow.setData(contact_cat,org_cat) 
}

        </script>
<!--        <input type="text" id="controlpanal" >-->
</body>
</html>