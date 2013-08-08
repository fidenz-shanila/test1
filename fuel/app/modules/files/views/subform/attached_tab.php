<div id="attachinfo">
        <div class="tabbar">
        <div class="mainbox">
            <div class="div_1">
                <h1><?php echo $tab_title; ?></h1>
                
                <iframe id="attached_info" src="<?php echo \Uri::create('files/attached_info?quote_id='.\Input::get('quote_id')); ?>" scrolling="no" frameborder="0" height="600px" width="100%"></iframe>

            </div>

            <div class="div_2">
                <h1>CB FILE: <?php echo $CF_FileNumber_pk; ?> CONTENTS</h1>
                <h2>FILE TITAL ( as in TRIM )</h2>
                <div class="white_box">
                    <?php echo $cb_file['CF_Title']; ?>
                </div>
                <div class="blk1">
                    <div class="c1">
                        <h6>current location</h6>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                                <td bgcolor="#e0bcff" align="center" class="tdpar" colspan="2"><input type="text" value="<?php echo $cb_file['CF_FileLocation']; ?>" class="textbox-1"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="center"><p>Date at location</p></td>
                                <td align="center"><input type="text" value="<?php echo $cb_file['CF_FileLocationDate']; ?>" class="textbox-1"></td>
                            </tr>
                        </tbody></table>
                    </div>
                        <div class="c1">
                            <h6>requested location</h6>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                    <td bgcolor="#e0bcff" align="center" class="tdpar" colspan="2"><input type="text" value="<?php echo $cb_file['CF_FileRequestLocation']; ?>"  class="textbox-1"></td>
                                </tr>
                                <tr>
                                    <td width="50%" align="center"><p>Date required</p></td>
                                    <td align="center"><input type="text" value="<?php echo $cb_file['CF_FileRequestDate']; ?>"  class="textbox-1"></td>
                                </tr>
                            </tbody></table>
                        </div>
                    <div class="c2">
                        <button class="cb iframe " href="<?php echo \Uri::create('files/file_location'); ?>">CHANGE</button>
                    </div>
                </div>

                <div class="blk2">
                    <h2>CB FILE CONTENTS LISTING (ie., Related records)</h2>
                    <?php print_r($cb_file_content); foreach((array) $cb_file_content as $entry): ?>
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                                <tbody><tr>
                                    <td width="40%"><p>quote number</p></td>
                                    <td><p>owner</p></td>
                                </tr>
                            </tbody></table>
                            <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                                <tbody><tr>
                                    <td width="10%" align="center"><input type="button" value=".." class="button1"></td>
                                    <td width="30%" bgcolor="#fae79a" align="center"><input type="text" value="<?php echo $entry['Q_FullNumber']; ?>" class="textbox-1"></td>
                                    <td bgcolor="#8babff" align="center"><input type="text" value="<?php echo $entry['OR1_Name_ind']; ?>" class="textbox-1"></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#c1c2bd" align="center" colspan="3"><input type="text" value="<?php echo $entry['A_Description']; ?>" class="textbox-2"></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>

                <div class="blk4">
                    <div class="c1">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody>
                              <tr>
                                <td align="center"><p>directory path</p></td>
                                <td align="center">&nbsp;</td>
                                <td width="4%" align="center">&nbsp;</td>
                                <td width="5%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="center"><input type="text"  class="textbox-1" /></td>
                                <td align="center">&nbsp;</td>
                                <td align="center"><input type="button" class="folder_path" /></td>
                                <td><input type="button" value="CREATE" disabled="disabled" /></td>
                              </tr>
                              <tr>
                                <td align="center"><p>main image path</p></td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td width="87%" align="center"><input type="text" class="textbox-1"  /></td>
                                <td width="4%" align="center"><input type="button"  class="viewimage cb iframe"   href="<?php echo \Uri::create('Quotes/view_main_image?CF_FileNumber_pk='.$CF_FileNumber_pk);?>" /></td>
                                <td align="center"><input href="<?php echo \Uri::create('Files/upload_main_image/?CF_FileNumber_pk='.urlencode($CF_FileNumber_pk)); ?>" type="button" value="upload" class="cb iframe button2" /></td>
                                <td> <input type="button" class="" name="cancel" value="Cancel" /></td>
                            </tr>
                        </tbody></table>
                        </div>
          </div>
                    <div class="c2">
                        
                    </div>
                </div>


            </div>





        </div>
    </div>
</div>