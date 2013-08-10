<div id="ContactEditDialog" style="height:100%;width:100%;background-color: #8FA5FA;" class="container clr_org">
    
    <form method="POST">
        <table border="0" class=""  width="100%"><tr><td width="40%" align="center">
        <table><tr><td ></td><td style="background-color: #CCD6FD;" ><h1 >CONTACTS DETAILS</h1></td><td></td></tr></table>
        </td><td width="60%"  align="center"> <h1>ORGANISATION DETAILS</h1></td></tr><tr><td class="specialTd">
        <div class="contact section clr_contact "> 
            <div  class="wrapper name">
<!--                <h1>Contact Details</h1>-->
<!--<table width="100%"><tr><td style="background-color: #8FA5FA;width: 33% "></td><td>Contact Detailshghh</td><td style="background-color: #8FA5FA;width: 33% "></td></tr></table>-->
                

              <fieldset id="contact_basic">
                    <table border="0" id="tablefullnameId" width="100%"><tr><td width="60%" align="right">
                    <h3><u>CONTACT FULL NAME</u></h3>
                    </td><td><div style="background-color:#FFCECE;border-style:dotted;width:30%; float: right;"> <label for="" class="lock" data-lock_container="#contact_basic"><?php echo Form::checkbox('CO_LockForm', '1', (bool) $contact->CO_LockForm); ?>Lock</label></div></h3></td></tr></table>
                <table border="0" width="100%"><tr><td style="width:10%"></td><td style="width:80%"><div id="contact_basic_id_h3" style="height:30px;"><h3 style="text-align:center;background-color:#D6D6D6;height:30px;border: 1px solid #7D7D7D;width:95%;height:8px;overflow: hidden;" id="" class="build_field_output"><?php echo $contact->CO_Fullname; ?></h3></div></td><td style="width:10%"></td></tr></table>
                  
                    <table >
                        <tr>
                            <td style="text-align:right">  
                                <label>Title:</label>
                            </td>
                            <td>  
                                <?php echo \Form::select('CO_Title_select',$contact->CO_Title, $dropdown['title'],array('id'=>'id_CO_Title','class'=>'build_field editable selectBox','style'=>'border-color:red')); ?>
                                (Not limited to list)</td>
                            <input type="hidden" id="id_CO_Title_hidden" name="CO_Title" value="m">
                        </tr>

                        <tr>
                            <td style="text-align:right">  <label>First Name:</label></td>
                            <td><input type="text" name="CO_Fname" id="id_CO_Fname" maxlength="25" class="build_field" value="<?php echo $contact->CO_Fname; ?>" /></td><td><label id="locked1"  style="font:italic bold 12px/30px Georgia,serif;color:#CCD6FD">LOCKED</label></td>
                        </tr>
                        <tr>
                            <td style="text-align:right">  <label>Last Name:</label>  </td>
                            <td> <input type="text" class="build_field" name="CO_Lname_ind" maxlength="25" id="id_CO_Lname_ind" value="<?php echo $contact->CO_Lname_ind; ?>"/> </td>
                            
                            <td>  <input type="button" class="build btn" id="id_Build" data-section=".name" value="Build"> </td>
                        </tr>
                    </table>


                </fieldset>

                <fieldset>

                    <table>
                        <tr>
                            <td style="text-align:right">
                                <label>Position:</label>
                            </td>
                            <td>
                                <input type="text" name="CO_Pos" maxlength="80" style="width:70%"  value="<?php echo $contact->CO_Pos; ?>" />
                            </td>
                        </tr>

                        <tr><td style="text-align:right">
                                <label>Phone:</label>
                            </td>
                            <td>
                                <input type="text" name="CO_Phone" maxlength="25"  value="<?php echo $contact->CO_Phone; ?>" />
                            </td>
                        </tr>

                        <tr><td style="text-align:right">
                                <label>Mobile:</label>
                            </td>
                            <td>
                                <input type="text" name="CO_Mobile" maxlength="25" value="<?php echo $contact->CO_Mobile; ?>"/>
                            </td>
                        </tr>

                        <tr><td style="text-align:right">
                                <label>Fax:</label>
                            </td>
                            <td>
                                <input type="text" name="CO_Fax" maxlength="25" value="<?php echo $contact->CO_Fax; ?>"  />
                            </td>
                        </tr>

                    </table>

                </fieldset>


                <fieldset>

                    <table>
                        <tr>
                            <td style="text-align:left;width:10%"><label>Email:</label></td>
                            <td><input type="text" style="color:blue;width:100%" name="CO_Email" maxlength="45"  id="emailId" value="<?php echo $contact->CO_Email; ?>"/></td>
                            <td><input type="button" id="conEmailButtonId" value="...."></td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset class="mail_merge clr_mailmerge">

                    <div class="wrapper">
                        <h4>Mail Merge Contact</h4>
                        <table>
                            <tr>
                                <td>
                                    <table height="150px"  style="border:1px dotted black;" >
                                        <tr align="left"><td><input type="radio" name="mailmerge" class="con_check_box" value="letter">Standard letter</td></tr>
                                        <tr align="left"><td><input type="radio" name="mailmerge" class="con_check_box"  value="fax" checked>Standard fax</td></tr>
                                        <tr align="left"><td><input type="radio" name="mailmerge" class="con_check_box"  value="label">Standard label</td></tr>
                                        <tr align="left"><td><input type="radio" name="mailmerge" class="con_check_box"  value="banner">Standard banner</td></tr>
                                        <tr align="left"><td><input type="radio" name="mailmerge" class="con_check_box"  id="mailmerge_id" value="custom">User defined</td></tr>
                                    </table>
                                </td>
                                <td>
                                    <table height="100px" style="border:1px dotted black;" >
                                        <tr>
                                            <td align="center">User defined document path</td>
                                        </tr>
                                        <tr>
                                            <td align="center"><textarea class="" style="font-size:10px" name="" style="cursor:not-allowed;" id="fileparthTxt" cols="50" rows="2" readonly></textarea></td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <input type="button"   id="Instructions_id" value="Instructions" style="color:green;height:30px" height="500px" disabled>
                                                <input type="button"  id="Browser_id" style="height:30px" value="Browser" disabled>
                                                <input type="file"  id="Browser_id_invis" value="Browser" style="display:none" >
<!--                                                <input type="submit" name="mailmerge_submit" value="W" />-->
                                            </td>
                                        </tr>


                                    </table>
                                    <div align="right" >
                                    <input  type="button" class="wordImage" name="mailmerge_submit" value="" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </fieldset>

                <fieldset class="contact_cat_section clr_official">
                    <table  border="0">
                        <tr>
                            <td> <h4><u>Contact Categories</u></h4></td>
                           
                        </tr>

                        <tr><td>
                                <input type="text" name="CO_Categories" id="parantCategories" value="<?php echo $contact->CO_Categories;  ?>"  readonly  ></td><td align="right"><input type="button" id="categorisListButton" value="..." style=" height:30px;"/>
                            <?php //echo \Form::select('CO_Categories[]', \Contacts\Model_Contact::format_categories($contact->CO_Categories), \Contacts\Model_Contact::get_categories(), array('multiple'=>'multiple')); ?>
                            </td>
                        </tr>

                    </table>

                </fieldset>


               

                    <table border="0"  >
                        <tr>
                            <td width="27%"><table border="0" height="40px" ><tr style="border:1px solid #999999;"><td width="20%" class="ContactIdForContec"><label >ContactID: </label></td><td ><input type="text" readonly="readonly" name="CO_ContactID_pk"  value="<?php echo $contact->CO_ContactID_pk; ?>" style="text-align:center;width:80%" /></td></tr></table> </td>
                            
                        <td align="center" width="30%" > <table border="0" width="100%" height="40px"><tr  style="border:1px solid #999999;"><td align="center"><input type="button" value="Delete" class="action-delete spaced" style="color: red;font-weight: bold;" data-object="contact" href="<?php echo \Uri::create('contacts/delete/'.$contact->CO_ContactID_pk); ?>" /></td></tr></table>
                            </td>
                        

<!--                        <tr style="border:1px dotted black;">-->
                            <td align="center" width="43%"> <table border="0" height="40px" width="100%" ><tr style="border:1px solid #999999;"><td width="" class="ContactIdForContec"><label>CURRENCY:</label></td></td><td > <?php echo \Helper_Form::currency_type('CO_CurrencyStatus', $contact->CO_CurrencyStatus,array('style'=>'width:100%')); ?> </td></tr></table>
                                
                            <td> 
                               
                            </td>
                        </tr>
                    </table>

               

                <fieldset class=" clr_official_User">
                    <table width="100%">
                        <tr>
                             <td>
                                <label> 
                                <label style="font-size:10px"><u>OFFICIAL USE ONLY</u></label>
                            </td>
                            
                            <td>
                                <label>Approved By:</label>
                            </td>
                            <td>
                                <?php echo \Helper_Form::list_employees_For_Con('CO_ApprovedByEmployeeID', $contact->CO_ApprovedByEmployeeID); ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset class="updates">
                    <table>
                        <tr>
                            <td style="background-color: #DFBFFF; "><label>CREATED BY</label>
                                <input type="text" name="CO_CreationDate" readonly="readonly" value="<?php echo $contact->CO_CreatedBy; ?>"/>
                            </td>
                            <td><label><u>CREATED</u></label>
                                <input type="text" name="CO_CreatedBy" readonly="readonly" value="<?php echo DATE("d/m/y g:i a", STRTOTIME($contact->CO_CreationDate)) ; ?>"/>
                            </td>
                            <td><label><u>LAST UPDATED</u></label>
                                <input type="text" name="CO_LastUpdatedDate" readonly="readonly" value="<?php echo  DATE("d/m/y g:i a", STRTOTIME($contact->CO_LastUpdatedDate))  ; ?>"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>




            </div>
        </div> <!-- ENd of contacts -->
        </td><td>
        <div class="organization section">
            <div style="text-align:center" class="inst wrapper">
                
                
                <h4><?php //echo $contact->organization1->OR1_FullName; ?></h4>
               
                
                <fieldset id="org_basic">
                    
                    <table border="0"><tr><td width="100%"><label  id="locked2" style="font:italic bold 12px/30px Georgia,serif;color:#8FA5FA;margin-right:90%;">LOCKED</label></td><td><h3><u>ORGANISATION FULL NAME</u></h3></td>
                            <td > <div style="background-color:#FFCECE;border-style:dotted;width:60%; float: right;"> <label for="" class="lock" data-lock_container="#org_basic"><?php echo Form::checkbox('OR1_LockForm', '1', (bool) $contact->organization1->OR1_LockForm,array('id'=>'organization_checkbox')); ?>Lock</label></div></td>
                        </tr></table>
                    
                   
                    
                    <table border="0" height="80px"><tr><td style="width:10%"></td><td style="width:80%"><div id="orgaisation_basic_id_h3" style="background-color:#D6D6D6;height:50px;overflow: hidden;"><h3 style="text-align:center;background-color:#D6D6D6;height:20px;width:95%;height:8px;" class="build_field_output"><?php echo $contact->organization1->OR1_FullName; ?></h3></div></td><td style="width:10%"></td><tr></table>
                     
                   
                    <table border="0" width="100%">
                        <tr >
                            <td style="text-align:right"><label>Name:</label></td>
                            <td><input class="build_field" type="text" name="organization1[OR1_Name_ind]" id="id_organization1_name"  value="<?php echo $contact->organization1->OR1_Name_ind; ?>" style="width:100%" maxlength="119"/></td>

                        </tr>
                        <tr>
                            <td style="text-align:right"><label>Section:</label></td>
                            <td><input class="build_field" type="text" name="organization1[OR1_Section]" id="id_organization1_section"  value="<?php echo $contact->organization1->OR1_Section; ?>" style="width:100%" maxlength="119"/></td>
                            <td>(Optional)</td>

                        </tr>
                        <tr border="0"><td class="clr_official_User" style="text-align:right"><label>Location:</label></td>
                            <td class="clr_official_User" style="text-align:left"><label> <?php echo \Form::select('organization1[OR1_Location]_select',$contact->organization1->OR1_Location, $dropdown['location'],array('id'=>'Location_OR1_select','class'=>'build_field editable ','style'=>'border-color:red')); ?>
                                <span class="field_hint">OFFICIAL USE ONLY</span>  
                                 <input type="hidden" id="Location_OR1_select_hidden" name="organization1[OR1_Location]" value="aa"></label></td>
                            <td class="" align="left">
                               
                            </td>
                            <td></td>
                            
                            <td><input type="button" class="build" data-section=".inst" id="Id_build" value="Build"></td>

                        </tr>

                        <tr>
                            <td></td>
                            

                        </tr>


                    </table>
                </fieldset>




                <fieldset>
                    <table class="OrgTableSp" width="100%" border="0">
                        <tr>
                            <td  style="text-align:right"><label>MAIN PHONE:</label></td>
                            <td><input type="text" name="organization2[OR2_Phone]"  value="<?php echo $contact->organization2->OR2_Phone; ?>" maxlength="25"/></td>

                            <td width="5%" style="text-align:right"><label>ABN:</label></td>
                            <td><input type="text" name="organization2[OR2_ABN]"  value="<?php echo $contact->organization2->OR2_ABN; ?>" maxlength="60"/></td>
                            
                             <td width="10%" style="text-align:right"><label>COUNTRY:</label></td>
                             <?php //echo \Form::select('CO_Title_select',$contact->CO_Title, $dropdown['title'],array('id'=>'id_CO_Title','class'=>'build_field editable selectBox','style'=>'border-color:red')); ?>
                             <td><label><?php echo \Form::select("organization2_select[OR2_Country_select]",$contact->organization2->OR2_Country, array_merge(array(""=>''),$dropdown['country']),array('id'=>'organization2_Country_select','style'=>'width:100%','class'=>'editable ')); ?>
                             <input type="hidden" id="organization2_Country_hidden" name="organization2[OR2_Country]" value="aa"></label></td>
                        </tr>
  </table>  <table class="OrgTableSp" border="0">
                        <tr>
                            
                            
                            
                            
                            
                            <td style="text-align:right" ><label>MAIN FAX:</label></td>
                            <td align="left" width="20%"><input type="text" name="organization2[OR2_Fax]"  value="<?php echo $contact->organization2->OR2_Fax; ?>" maxlength="25"/></td>

                            <td style="text-align:right" width="15%"><label>WEB SITE:</label></td>
                            <td align="left" width="40%"><input type="text" style="color:red;width:100%;text-align:right" name="organization2[OR2_Web]" id="tetWebSite" value="<?php echo $contact->organization2->OR2_Web; ?>" maxlength="80"/></td>
                            <td align="left" width="10%"><input type="button"  name="fname" id="openWebSite" value="..."></td>

                        </tr>

                        <tr>
                            <td style="text-align:right"><label>OTHER:</label></td>
                            <td align="left"><input type="text" name="organization2[OR2_PhoneOther]"  value="<?php echo $contact->organization2->OR2_PhoneOther; ?>" maxlength="25"/></td>

                            <td style="text-align:right"><label>MAIN EMAIL:</label></td>
                            <td align="left"><input type="email" style="color:blue;width:100%;text-align:right;" id="orgEmail" name="organization2[OR2_Email]" value="<?php echo $contact->organization2->OR2_Email; ?>" maxlength="45"/></td>
                            <td align="left"><input type="button" id="orgEmailButtonId" value="..."></td>
                        </tr>

                    </table>
                </fieldset>



                <fieldset class="address_section">
                    <table width="100%" class="address_section_table" border="0">
                        <tr>
                            <td class="specialTd" width="50%">
                                <h4><u>POSTAL ADDRESS</u></h4>
                                <input type="text" name="organization2[OR2_Postal1]" style="border: none;width:99%;" tabindex="1" value="<?php echo $contact->organization2->OR2_Postal1;  ?>" id="id_OR2_Postal1">
                                <input type="text" name="organization2[OR2_Postal2]" style="border: none;width:99%;" tabindex="2" value="<?php echo $contact->organization2->OR2_Postal2;  ?>" id="id_OR2_Postal2">
                                 <input type="text" name="organization2[OR2_Postal3]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Postal3;  ?>" id="id_OR2_Postal3">
                                <input type="text" name="organization2[OR2_Postal4]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Postal4;  ?>" id="id_OR2_Postal4">
                                
                            </td>
                            <td class="specialTd" width="50%">
                                <h4><u>PHYSICAL ADDRESS</u></h4>
                                 <input type="text" name="organization2[OR2_Physical1]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Physical1;  ?>" id="id_OR2_Physical1">
                                <input type="text" name="organization2[OR2_Physical2]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Physical2;  ?>" id="id_OR2_Physical2">
                                 <input type="text" name="organization2[OR2_Physical3]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Physical3;  ?>" id="id_OR2_Physical3">
                                <input type="text" name="organization2[OR2_Physical4]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Physical4;  ?>" id="id_OR2_Physical4">
                              
                            </td>
                        </tr>

                        <tr>
                            <td class="specialTd" width="50%"></br>
                                <input type="button" id="copyLeftId" class="leftArw" style="float: right;" value=""><input type="button" id="copyDown" class="downArw" style="float: right;">
                                </br>
                                <h4><u>INVOICING ADDRESS</u></h4>
                                <input type="text" name="organization2[OR2_Invoice1]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Invoice1;  ?>" id="id_OR2_OR2_Invoice1">
                                <input type="text" name="organization2[OR2_Invoice2]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Invoice2;  ?>" id="id_OR2_OR2_Invoice2">
                                 <input type="text" name="organization2[OR2_Invoice3]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Invoice3;  ?>" id="id_OR2_OR2_Invoice3">
                                <input type="text" name="organization2[OR2_Invoice4]" style="border: none;width:99%;" value="<?php echo $contact->organization2->OR2_Invoice4;  ?>" id="id_OR2_OR2_Invoice4">
                                
                            </td>
                            <td class="specialTd" width="50%" >
                                <table clase="seoundtable_in_address_section" border="0"><tr><td class="specialTd"><input type="button" id="" class="rightArw" style="float: left;" value=""></td><td class="specialTd" style="border:1px dotted black;text-align:center"><h4><u>COMMENTS (pertaining to organisation)</u></h4>
                                
                                <textarea name="organization2[OR2_Comments]"><?php echo $contact->organization2->OR2_Comments; ?></textarea>
                               <table class="editDatap OrgTableSp1" border="0"><tr class="specialTrForaddressSection"><td class="specialTd ContactIdAndDelete DateSURVEY">DATE SURVEY SENT:</td><td class="specialTd"><input type="text" name="organization2[OR2_DateSurveySent]" class="datepicker" width="30%" value="<?php echo $contact->organization2->OR2_DateSurveySent;  ?>"></td></tr></table></td></tr></table>
                                
                            </td>
                        </tr>



                    </table>
</fieldset>
                    <table width="100%" style="margin-top:10px;" border="0">
                        <tr><td width="25%"></td><td style="background-color:#CFDECB;">  <label><u>ORGANISATION CATEGORIES:</u></h4></label></td></tr><tr>
                            <td width="25%" style="border:1px solid #999999;">
                                <table><tr style="font-size: 12px;"><td><label>CURRENCY:</label> <?php echo \Helper_Form::currency_type('organization1[OR1_CurrencyStatus]', $contact->organization1->OR1_CurrencyStatus,array('width'=>'90%')); ?></td></tr></table>
                                
                            </td>
                         
                                
                            
                            
                            <td colspan="2" style="background-color:#CFDECB;">
                                <table width="100%"><tr><td width="90%" ><input type="text" name="organization1[OR1_Categories]" id="parantorgCategories" value="<?php echo $contact->organization1->OR1_Categories;  ?>" readonly></td>
                                    
                                    <td width="10%"> <input type="button" id="OrgaisationButtonId" value="..."></td></tr></table>
                              
                            </td>
                        </tr>
                       
                    </table>
                
<table border="0" width="100%" style="margin-top:10px;"><tr><td width="100%">
            <table class="clr_official_User" width="100%"><tr><td align="center"><u>OFFICIAL USE ONLY</u></td></tr><tr><td>
                <fieldset class="final_section clr_official_User">
                    <table border="0">
                        <tr>
                            <td>
                                <h5>FINANCIAL STATUS</h5>
                                <?php echo \Helper_Form::financial_status('organization1[OR1_FinancialStatus]', $contact->organization1->OR1_FinancialStatus); ?>
                            </td>

                            <td>
                                <h5>ORG. TYPE</h5>
                                <?php echo \Helper_Form::org_type_con_edit('organization1[OR1_InternalOrExternal]', $contact->organization1->OR1_InternalOrExternal,array('id'=>'organization1_OR1_InternalOrExternal_id')); ?>
                            </td>

                            <td>
                                <h5>CONTRACT ID</h5>
                                <input type="text" name="organization1[OR1_ContractID]" value="<?php echo $contact->organization1->OR1_ContractID ;?>" />
                            </td>
                            <td>
                                <h5>CONTRACT EXPIRY DATE</h5>
                                <input type="text" name="organization1[OR1_ContractExpiryDate]" id="OR1_ContractExpiryDate_id" class="datepicker" value="<?php echo $contact->organization1->OR1_ContractExpiryDate ;?>"/>
                                
                            </td>
                        </tr>
                    </table>

                   

                </fieldset>
                </td></tr></table>
            </td><td width="10%">
                 <input type="submit" id="saveId" name="save" onclick="" style="width:100px;height:50px;" value="Save / Close" />
            </td></tr></table>
                <table width="100%" style="margin-top:10px;"><tr><td width="10%">
                             <input type="button"  class=" button1 spaced" id="insertCon" style="font-weight:600;" value="ADD ANOTHER&#13;&#10; CONTACT" />
 </td><td width="90%">
     <table border="0" width="100%" class="frm_con_last">
                        <tr><td style="width:10%" class=""> 
                                
                            </td>
                            <td style="width:10%" class="">
                                
                            </td>
                            <td style="width:25%;background-color:#DFBFFF" class="clr_official">
                                <label>CREATED BY</label>
                                
                            </td>
                            <td style="background-color: #BECBFC;width:25%;"><label><u>CREATED</u></label>
                                
                                
                            </td>
                             <td style="background-color: #BECBFC;width:25%;"><label><u>LAST UPDATED</u></label>
                               
                            </td>
                        </tr><tr>
                            <td align="right" class="">
                                <label>OrgID:</label></td><td>
                                <input type="text" name="organization1[OR1_OrgID_pk]" readonly="readonly" style="font-size" value="<?php echo $contact->organization1->OR1_OrgID_pk; ?>"/>
                            </td>
                            <td style="background-color:#DFBFFF">
                                
                                <input type="text" name="organization1[OR1_CreatedBy]" readonly="readonly" value="<?php echo $contact->organization1->OR1_CreatedBy; ?>"/>
                            </td>
                            <td style="background-color: #BECBFC">
                                
                                <input type="text" name="organization1[OR1_CreationDate]" readonly="readonly" value="<?php  echo  DATE("d/m/y g:i a", STRTOTIME($contact->organization1->OR1_CreationDate)) ; ?>"/>
                            </td>
                            <td style="background-color: #BECBFC">
                                <input type="text" name="organization1[OR1_LastUpdatedDate]" readonly="readonly"  value="<?php echo DATE("d/m/y g:i a", STRTOTIME($contact->organization1->OR1_LastUpdatedDate)) ; ?>"/>
                            </td>
                        </tr>
                    </table>
                       
                        </td></tr></table>
               
                                
                                 
<input type="hidden" id="insertUrl" value="<?php echo \Uri::create('contacts/new_contact/'.$contact->CO_OrgID_fk); ?>">
                               
                               
                       




            </div>


        </div> <!-- ENd of organization -->
        </td></tr></table>
        <div class="clear"></div>
        <div class="actions">

        </div><!-- ENd of controls -->
        <div id="categorisListDiv"  style="display: none"> <div> <?php echo \Form::select('CO_Categories[]', \Contacts\Model_Contact::format_categories($contact->CO_Categories), \Contacts\Model_Contact::get_categories(), array('multiple'=>'multiple')); ?></div></div>
        <input type="text" id="CheckClose" style="display: none" value="<?php  echo $successful; ?>">
    <input type="text" id="insertCheckr" style="display:none" value="">
   
    <div id="ContactCotDialog" title="frmSelectContactCategories" style="display:none;">
        
       <div style="width:500px;height:600px; background-color:#FFCC99;"> 
       <div id="divContactWendowH1" style="width:500px;"><h3  id="ContactWendowH1" class="" align="center">AAA</h3></div>
       
           <div style="margin:20px 10px; padding:0px 0px;border: 1px solid #A2A2A2;height:460px;">
            <div style="margin:8px 8px;background-color:#D6D6D6;height:440px;">
       <?php $i=0; echo '<ol id="selectable">'; foreach(\Contacts\Model_Contact::get_categories()as $key => $value){ echo '<li value='.$key.' id='.$i.' class="ui-widget-content Contactcon">'.$value.'</li>' ;$i++; };echo '</ol>'; ?>
             </div>
            </div>
       <div style="margin:20px 10px; padding:10px 5px;border: 1px solid #A2A2A2;height:30px;">
<!--            <div style="margin:4px 4px;background-color:#D6D6D6;height:90%;">-->
                <table><tr><td width="5%"><u>CATS:</u></td><td width="80%"><input type="text" id="cattxtBox" style="background-color:#D6D6D6;width:100%;border: none;height: 25px"></td><td width="15%"><input type="button" style="height:30px" id="contactCatClose" value="CLOSE" ></td></tr></table>
       
             </div>
            </div>
       </div>
        
        
         <div id="OrgaisationCotDialog" title="frmSelectOrganisationCategories" style="display:none;">
        
       <div style="width:525px;height:550px; background-color:#B7CEB0;"> 
       <h3 id="OrgaisationWendowH1" style="width:100%;height:15px;" class="" align="center">AAA</h3>
       
           <div style="margin:20px 10px;background-color:#A7C29E; padding:0px 0px;border: 1px solid #A2A2A2;height:420px;">
            <div style="margin:8px 8px;background-color:#D6D6D6;height:400px;overflow:auto;">
       <?php $j=1000; echo '<ol id="selectable">'; foreach(\Contacts\Model_Contact::get_org_cat_list()as $key => $value){ echo '<li value='.$key.' id='.$j.' class="ui-widget-content orgcon">'.$value.'</li>' ;$j++; };echo '</ol>'; ?>
             </div>
            </div>
       <div style="margin:20px 10px; padding:10px 5px;border: 1px solid #A2A2A2;height:30px;">
<!--            <div style="margin:4px 4px;background-color:#D6D6D6;height:90%;">-->
                <table><tr><td width="5%"><u>CATS:</u></td><td width="80%"><input type="text" id="orgTxtBox" style="background-color:#D6D6D6;width:100%;border: none;height: 25px"></td><td width="15%"><input type="button" id="orgCatClose" style="height:30px"  value="CLOSE" ></td></tr></table>
       
             </div>
            </div>
       </div>
   
<div id="InsertCotDialog"  style="display:none;">
    <div style="width:450px;height:300px; background-color:#C0C0C0;">
   <h1  class="" align="center">CREATE NEW CONTACT</h1>
   <div style="margin:20px 15px;background-color:#CCD6FD; padding:30px 0px;border: 0px solid #A2A2A2;height:60%;">
       <table width="100%" height="50%" style="" border="0"><tr><td align="right">Title:</td><td><input type="text"></td></tr><tr><td align="right">First name:</td><td><input type="text"></td></tr><tr><td align="right">Last name:</td><td><input type="text"></td></tr></table>
           
    </div>
    </div></div>
    
    </form> 
   

</div>

<script type="text/javascript">
var checkEmail=0;
var emailValue=0;
$(function(){
        $('input[type=button].build').click(function(){
            
            var section = $(this).data('section');
           // alert(section);
            $(section + ' .build_field_output').empty();

            $(section +  ' .build_field').each(function(){
               $(section + ' .build_field_output').append($(this).val()+' ');
            });
        });

        //TODO refactor
        $('.name .build_field .selectBox').bind('change keyup', function(){
            $('.name input[type=button].build').click();
        });

        //TODO refactor
        $('.inst .build_field .selectBox').bind('change keyup', function(){
            $('.inst input[type=button].build').click();
        });

    });
    
    
     $('.name  .selectBox').bind('change keyup', function(){
            $('.name input[type=button].build').click();
        });

        //TODO refactor
        $('.inst  .selectBox').bind('change keyup', function(){
            $('.inst input[type=button].build').click();
        });
    
    $("#form_CO_LockForm").change(function() {
    if(this.checked) {
        $("#dropdown").prop("readonly", true);
        $("#id_CO_Fname").attr("readonly", "readonly");
        $("#id_CO_Lname_ind").attr("readonly", "readonly");
        $("#contact_basic").css("border","red solid 3px");
        $("#id_Build").prop('disabled', true);
        $("#locked1").css('color', 'red');
        $("#id_CO_Title").prop('disabled', true);
            
    }else{
        $("#dropdown").prop("readonly", false); 
        $("#id_CO_Fname").removeAttr("readonly");
        $("#id_CO_Lname_ind").removeAttr("readonly");
         $("#contact_basic").css("border","#999999 solid 1px");
         $("#id_Build").prop('disabled', false);
          $("#locked1").css('color', '#CCD6FD');
          $("#id_CO_Title").prop('disabled', false);
    }
});

 $("#organization_checkbox").change(function() {
    if(this.checked) {
        $("#form_organization1_OR1_Location").prop("readonly", true);
        $("#id_organization1_name").attr("readonly", "readonly");
        $("#id_organization1_section").attr("readonly", "readonly");
        $("#org_basic").css("border","red solid 3px");
        $("#Id_build").prop('disabled', true);
        $("#locked2").css('color', 'red');
        $("#Location_OR1_select").prop('disabled', true);
            
    }else{
        $("#form_organization1_OR1_Location").prop("readonly", false); 
        $("#id_organization1_name").removeAttr("readonly");
        $("#id_organization1_section").removeAttr("readonly");
         $("#org_basic").css("border","#999999 solid 1px");
         $("#Id_build").prop('disabled', false);
         $("#locked2").css('color', '#8FA5FA');
         $("#Location_OR1_select").prop('disabled', false);
    }
});

    $("#copyDown").click(function(){
        // alert("sometext");
        $('#id_OR2_OR2_Invoice1').val($("#id_OR2_Postal1").val());
        $('#id_OR2_OR2_Invoice2').val($("#id_OR2_Postal2").val());
        $('#id_OR2_OR2_Invoice3').val($("#id_OR2_Postal3").val());
        $('#id_OR2_OR2_Invoice4').val($("#id_OR2_Postal4").val());
    });
    $("#copyLeftId").click(function(){
        // alert("sometext");
        $('#id_OR2_Physical1').val($("#id_OR2_Postal1").val());
        $('#id_OR2_Physical2').val($("#id_OR2_Postal2").val());
        $('#id_OR2_Physical3').val($("#id_OR2_Postal3").val());
        $('#id_OR2_Physical4').val($("#id_OR2_Postal4").val());
    });
    $('#openWebSite').click(function(){
       // alert('dfd');
    
        
        var myVariable = $('#tetWebSite').val();
if(/^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)/i.test(myVariable)) {
window.open('http://'+myVariable);
           // alert("valid url");
} else {
  alert("invalid url");
}
    });
    jQuery(document).ready(function($){
     //alert('ff');
    
    if($('#organization_checkbox').is(':checked')) {
        $("#form_organization1_OR1_Location").prop("readonly", true);
        $("#id_organization1_name").attr("readonly", "readonly");
        $("#id_organization1_section").attr("readonly", "readonly");
        $("#org_basic").css("border","red solid 3px");
        $("#Id_build").prop('disabled', true);
        $("#locked2").css('color', 'red');
        $("#Location_OR1_select").prop('disabled', true);
            
    }
 if($('#form_CO_LockForm').is(':checked')) {
        $("#dropdown").prop("readonly", true);
        $("#id_CO_Fname").attr("readonly", "readonly");
        $("#id_CO_Lname_ind").attr("readonly", "readonly");
        $("#contact_basic").css("border","red solid 3px");
        $("#id_Build").prop('disabled', true);
        $("#locked1").css('color', 'red');
        $("#id_CO_Title").prop('disabled', true);
            
    }
     
     $("#id_CO_Title_hidden").val($("#id_CO_Title").val()); 
     $("#Location_OR1_select_hidden").val($("#Location_OR1_select").val());
     $("#organization2_Country_hidden").val($("#organization2_Country_select").val());
//     for(var chkr=0;chkr<($('ol .Contactcon').length);chkr++){
//         // alert('$("#"+chkr).val())');
//          if($("#"+chkr).hasClass("my-selected")){
//               valtxtBox.push($("#"+chkr).val());
//          }

$('#cattxtBox').val($('#parantCategories').val());
var set_val_for_cat=$('#parantCategories').val();
var set_val_for_cat_split=set_val_for_cat.split(";");
var set_val_for_cat_count=set_val_for_cat_split.length;
for(var chkr=0;chkr<($('ol .Contactcon').length);chkr++){
   for(var Subchkr=0;Subchkr<set_val_for_cat_count;Subchkr++){
    if($('#'+chkr).val()==set_val_for_cat_split[Subchkr]){
        //alert($('#'+chkr).val());
        $('#'+chkr).css('background', 'black'); 
      $('#'+chkr).css('color', 'white'); 
      $('#'+chkr).addClass("my-selected");
        
}}
}

$('#orgTxtBox').val($('#parantorgCategories').val());
var set_val_for_org=$('#parantorgCategories').val();
var set_val_for_org_split=set_val_for_org.split(";");
var set_val_for_org_count=set_val_for_org_split.length;
for(var chkr1=0;chkr1<($('ol .orgcon').length);chkr1++){
   for(var Subchkr1=0;Subchkr1<set_val_for_org_count;Subchkr1++){
    if($('#'+(chkr1+1000)).val()==set_val_for_org_split[Subchkr1]){
        //alert($('#'+chkr1+1000);
        $('#'+(chkr1+1000)).css('background', 'black'); 
      $('#'+(chkr1+1000)).css('color', 'white'); 
      $('#'+(chkr1+1000)).addClass("my-selected");
        
}}
}
     
     if($('#organization1_OR1_InternalOrExternal_id').val()=='EXTERNAL'){
               $('#insertCon').removeAttr('disabled','disabled');
          }else{
             
              $('#insertCon').attr('disabled','disabled');
          }
    
   
//     setInterval(function(){ 
//       
//        if(($('#insertCheckr').val()).length != 0){
//           parent.$('#insertCheckr2nd').val($('#insertCheckr').val()) ;
//          $("#saveId").click();
//           //clearInterval(intervalId);
//        }
//        },1000);
//   

});
 
    function getDataFromNew1(val){
     $("#saveId").click();
     parent.getDataFromNew2(val);
       // alert(val);
    }
      


//$('#insertCheckr').change(function(){
//    $('#Browser_id_invis').click();
//}) ;
   
</script>

<script>
//   $('#saveId').on('click',function(){
//        document.loction.reload();
//   })
  function reloadPage()
  {
  //location.reload()
  }
//  $("#saveId").click(function(){
//   $("span").click();
//  
//});
 // $(function() {
   // $( "input[type=submit],input[type=button],button," )
     // .button()
     // .click(function( event ) {
     //   event.preventDefault();
     // });
 // });
 $('.con_check_box').click(function() {
   if($('#mailmerge_id').is(':checked')) {
       
           $("#Instructions_id").prop('disabled', false);
           $("#Browser_id").prop('disabled', false);
        }else{
            $("#Instructions_id").prop('disabled', true);
            $("#Browser_id").prop('disabled', true);
        }
});
 
 
$('#Browser_id').click(function(){
    $('#Browser_id_invis').click();
}) ;
$('#Browser_id_invis').change(function () {
      //console.dir(this.files[0])
      $('#fileparthTxt').val($('#Browser_id_invis').val());
     
})
 
 
  $(function() {
//    $( "#dp1371633601161" ).datepicker({
//      showOn: "button",
//      buttonImage: "images/calendar.gif",
//      buttonImageOnly: true
//    });
  });
  
  
  
  
     $("#id_CO_Title").change(function(){
   $("#id_CO_Title_hidden").val($("#id_CO_Title").val());
   
});
$("#id_CO_Title").keyup(function(){
   $("#id_CO_Title_hidden").val($("#id_CO_Title").val());
   
});
 $("#Location_OR1_select").change(function(){
   $("#Location_OR1_select_hidden").val($("#Location_OR1_select").val());
   
});
$("#Location_OR1_select").keyup(function(){
   $("#Location_OR1_select_hidden").val($("#Location_OR1_select").val());
   
});
$("#organization2_Country_select").change(function(){
   $("#organization2_Country_hidden").val($("#organization2_Country_select").val());
   
});
$("#organization2_Country_select").keyup(function(){
   $("#organization2_Country_hidden").val($("#organization2_Country_select").val());
   
});


$('#saveId').click(function(e){
		var get_ContractExpiryDate=$("#OR1_ContractExpiryDate_id").val();
                var array_ContractExpiryDate=get_ContractExpiryDate.split("/");
                
		if((!isNaN(array_ContractExpiryDate[0]) && !isNaN(array_ContractExpiryDate[1]) && !isNaN(array_ContractExpiryDate[2]))||get_ContractExpiryDate.length==0){
                   // alert(array_ContractExpiryDate[2]);
			return true;
		}
		else {
                    alert('The value are entered isn\'t valid for this field');
			e.preventDefault();
			return false;
		}
	});

$('#saveId').click(function(e){
		var get_email=$("#emailId").val();
                var get_email_count=get_email.length;
                var get_email_count_without=get_email.replace('@','').length;
               // var get_email_val=get_email.split("@");
              
		if((get_email_count!=get_email_count_without)||get_email.length==0){
                   // alert(array_ContractExpiryDate[2]);
                   
			return true;
		}
		else {
                    alert('The value are entered isn\'t valid for \'Email\' field');
                    $("#emailId").css('border-color','red');
                     e.stopImmediatePropagation();
                        e.preventDefault();
			return false;
		}
	});
        
        $('#saveId').click(function(e){
		var get_email=$("#orgEmail").val();
                var get_email_count=get_email.length;
                var get_email_count_without=get_email.replace('@','').length;
               // var get_email_val=get_email.split("@");
              
		if((get_email_count!=get_email_count_without)||get_email.length==0){
                   // alert(array_ContractExpiryDate[2]);
                   
			return true;
		}
		else {
                    alert('The value are entered isn\'t valid for \'Main Email\' field');
                    $("#orgEmail").css('border-color','red');
                     e.stopImmediatePropagation();
                        e.preventDefault();
			return false;
		}
	});

$('#id_Build').click(function(e){
		var get_email=$("#emailId").val();
                var get_email_val=get_email.split("@");
                
		if((get_email_val[0].length!=0 && get_email_val[1].length!=0)||get_email.length==0){
                   // alert(array_ContractExpiryDate[2]);
                   //alert(get_email_val[1]);
			return true;
		}
		else {
                    //alert('The value are entered isn\'t valid for this field');
                     e.stopImmediatePropagation();
                        e.preventDefault();
			return false;
		}
	});





$(function() {
    $("#thedialog1").attr('src', "<?php echo \Uri::create('contacts/edit #categorisListDiv'); ?>");
                                        $("#somediv1").dialog({
                                           // open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
                                            height: 10000,
      width: 10000,
                                            modal: true,
                                            
                                            
                                            
                                        });
//    $( "#categorisListDiv" ).dialog({
//        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
//      autoOpen: false,
//      height: 'auto',
//      width: 'auto',
//      modal: true,
//      resize:false,
//      resizable: false,
//      hide: 'puff',
//        show: 'puff',
//    });
   
 
    $( "#categorisListButton" ).button().click(function() {
       // alert('gfgfg');
         $( "#somediv1" ).dialog( "open" );
         $(this).parent().css('position', 'relative');
//$(this).parent().css('z-index', 3000);
           $("div").removeClass("ui-resizable-handle");
          //  alert('gfgfg');
           //parent.$('body').css('overflow','hidden');
          
        });
           
           
  });



  </script>

<style>
  #ContactCotDialog { background: #FFCC99; }
  #OrgaisationCotDialog { background: #B7CEB0; }  
  #feedback { font-size: 12px; }
  #selectable .ui-selecting {  background: black; color: white; }
  #selectable .ui-selected { background: black; color: white; }
  #selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #selectable li { margin: 3px; padding: 3px; font-size: 10px; height: 12px;border: none;background-color:#D6D6D6; }
  </style>
  <script>
       
      
//  $(function() {
//    $("li").selectable({
//  selected: function(event, ui) {
//    $(".ui-selected", this)
//  }
//});
//
//  $( "#selectable" ).selectable();   
  
//  function SelectSelectableElement (selectableContainer, elementsToSelect)
//{
//    // add unselecting class to all elements in the styleboard canvas except the ones to select
//    $(".ui-selected", selectableContainer).not(elementsToSelect).removeClass("ui-selected").addClass("ui-unselecting");
//    
//    // add ui-selecting class to the elements to select
//    $(elementsToSelect).not(".ui-selected").addClass("ui-selecting");
//
//    // trigger the mouse stop event (this will select all .ui-selecting elements, and deselect all .ui-unselecting elements)
//    selectableContainer.data("selectable")._mouseStop(null);
//}
//
//  

//});

  
  $("li").click(function(){
      
  var valtxtBox=new Array();
  var valtxtBox1=new Array();
  if($(this).hasClass("my-selected")){
      //alert('dd');
      
     // color: white;);
     $(this).css('background', '#D6D6D6'); 
      $(this).css('color', 'black'); 
     $(this).removeClass("my-selected");
     
       if($(this).hasClass("Contactcon")){
      for(var chkr=0;chkr<($('ol .Contactcon').length);chkr++){
         // alert('$("#"+chkr).val())');
          if($("#"+chkr).hasClass("my-selected")){
               valtxtBox.push($("#"+chkr).val());
          }
      }
      $('#cattxtBox').val(valtxtBox.join(";"));
      }else{
          //alert(($('ol .orgcon').length));
           for(var chkr1=0;chkr1<($('ol .orgcon').length);chkr1++){
        //  alert($("#"+(chkr1+1000)).val());
          if($("#"+(chkr1+1000)).hasClass("my-selected")){
               valtxtBox1.push($("#"+(chkr1+1000)).val());
          }
      }
      $('#orgTxtBox').val(valtxtBox1.join(";"));
      }
      //$('#cattxtBox').val(valtxtBox);
        //alert($(this).val());
  }else{
     //alert($('ol .Contactcon').length);
      
     
     // valtxtBox=valtxtBox.push($(this).val());
      
      $(this).css('background', 'black'); 
      $(this).css('color', 'white'); 
      $(this).addClass("my-selected");
      if($(this).hasClass("Contactcon")){
      for(var chkr=0;chkr<($('ol .Contactcon').length);chkr++){
         // alert('$("#"+chkr).val())');
          if($("#"+chkr).hasClass("my-selected")){
               valtxtBox.push($("#"+chkr).val());
          }
      }
      $('#cattxtBox').val(valtxtBox.join(";"));
     // $('#cattxtBox').val(valtxtBox);
     //alert(valtxtBox); 
     }else{
         
          for(var chkr1=0;chkr1<($('ol .orgcon').length);chkr1++){
         // alert('$("#"+chkr).val())');
          if($("#"+(chkr1+1000)).hasClass("my-selected")){
               valtxtBox1.push($("#"+(chkr1+1000)).val());
          }
      }
      $('#orgTxtBox').val(valtxtBox1.join(";"));
     }
  }
  
});
//$(this).addClass('highlight');
//});
  
 $(function() {
    $( "#ContactCotDialog" ).dialog({
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      height: 'auto',
      width: 'auto',
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
    
  
 
    $( "#categorisListButton" ).button().click(function() {
       //var section = $(this).data('section');
            
            $( '.name .build_field_output').empty();

            $(  '.name .build_field').each(function(){
               $( '.name .build_field_output').append($(this).val()+' ');
            });
             $('.name input[type=button].build').click();
         
         $( "#ContactCotDialog" ).dialog( "open" );
        // alert($('#contact_basic_id_h3').text());
          $('#ContactWendowH1').html('CONTACT CATEGORIES FOR '+($('#contact_basic_id_h3').text()).toUpperCase());
          $('#divContactWendowH1').css('overflow','auto');
           $("div").removeClass("ui-resizable-handle");
          
        });
           
  });
  $( "#contactCatClose" ) .click(function() {
       $('#parantCategories').val($('#cattxtBox').val());
    $( "#ContactCotDialog"  ).dialog( "close" );
 });
 
  $(function() {
    $( "#OrgaisationCotDialog" ).dialog({
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      height: 'auto',
      width: 'auto',
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
    
  
 
    $( "#OrgaisationButtonId" ).button().click(function() {
//       $( ' .build_field_output').empty();

            $(  '.inst .build_field').each(function(){
               $( '.inst .build_field_output').append($(this).val()+' ');
            });
             $('.inst input[type=button].build').click();
//         
//alert($('#id_organization1_name').val());
         $( "#OrgaisationCotDialog" ).dialog( "open" );
           $('#OrgaisationWendowH1').html('ORGAISATION CATEGORIES FOR '+($('#id_organization1_name').val()).toUpperCase());
           $("div").removeClass("ui-resizable-handle");
          
        });
        
         $( "#orgCatClose" ) .click(function() {
           
       $('#parantorgCategories').val($('#orgTxtBox').val());
    $( "#OrgaisationCotDialog"  ).dialog( "close" );
 });
           
  });
 
 
   
 
 parent.$("#dialog").dialog({
     open: function(event, ui) {  parent.$(".ui-dialog-titlebar-close").hide(); },
    autoOpen: false,
    modal: true,
    width:570,
    height:330,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
parent.$(".ui-dialog-titlebar-close").hide();
              parent.$('#myIframe').attr('src',$('#insertUrl').val());
          }
});
$('#insertCon').click(function(){
    //alert($('#insertUrl').val());
   
    parent.$('#dialog').dialog('open');
});
 
  $('#insertCloseId').click(function(){
         // alert('dd');
          $(" .ui-dialog-titlebar-close").click();
      });
$('#conEmailButtonId').click(function(){
         // alert('dd');
          $("#conEmailButtonId").attr("href", "mailto:"+$("#emailId").val());
      });
    
    $('#orgEmailButtonId').click(function(){
         // alert('dd');
          $("#orgEmailButtonId").attr("href", "mailto:"+$("#orgEmail").val());
      });
    
 $(' input[type=text]').keypress(function(event) {
    // Check the keyCode and if the user pressed Enter (code = 13) 
    // disable it
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});
$('#organization1_OR1_InternalOrExternal_id').change(function(){
          if($('#organization1_OR1_InternalOrExternal_id').val()=='EXTERNAL'){
               $('#insertCon').removeAttr('disabled','disabled');
          }else{
             
              $('#insertCon').attr('disabled','disabled');
          }
         
      });
      
      $('#saveId').click(function() {
    window.parent.openWindowAndClose();
    });

  </script>

