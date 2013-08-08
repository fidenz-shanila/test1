    <div id="statisticsat">
    	
        <div class="content">
        	
            
            <div class="tital">
	            <h1>STATISTICS AT BRANCH LEVEL ( FROM 1/7/2005 TO 30/6/2012 )</h1>
                <a href="#" class="excel">SEND TO EXCEL</a>
            </div>
            
            <?php foreach($statistics as $stItem) { ?>
            <div class="box-1">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="10%"><p>branch:</p></td>
                        <td width="35%"><input type="text" class="textbox-1" value="<?php echo $stItem['MS_Branch']; ?>" /></td>
                        <td width="6%"><p>section:</p></td>
                        <td width="35%"><input type="text" class="textbox-1" value="<?php echo $stItem['MS_Section']; ?>" /></td>
                        <td rowspan="2"><a href="#" class="graph">GRAPH OVER TIME</a></td>
                    </tr>
                    <tr>
                    	<td><p>Project:</p></td>
                        <td><input type="text" class="textbox-1" value="<?php echo $stItem['MS_Project']; ?>" /></td>
                        <td><p>area:</p></td>
                        <td><input type="text" class="textbox-1" value="<?php echo $stItem['MS_Area']; ?>" /></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="13%" valign="top">
                        	<div class="box-1">
                            	<h2>QUOTES</h2>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="75%"><p>All quotes offered:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoAllQuotesOffered']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Ext. quotes offered:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoExternalQuotesOffered']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>NMI quotes offered</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoNmiQuotesOffered']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="75%"><p>Ext. quotes accepted:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoQuotesAccepted']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Ext. quote not accepted:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoQuotesNotAccepted']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td width="26%" valign="top">
                        	<div class="box-2">
                            	<h2>JOBS</h2>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="75%"><p>All jobs completed:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoAllJobsCompleted']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Ext. jobs completed:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoExternalJobsCompleted']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>NMI jobs completed</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoNmiJobsCompleted']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Jobs fully completed</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoJobsFullyCompleted']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Jobs not fully completed</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoJobsNotFullyCompleted']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="75%"><p>Avg. client delay (days):</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['AvgDelayInDays']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Avg. time for job - client delays (days):</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['AvgTimeBetweenJobStartAndEndMinusDelaysInDays']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td width="35%" valign="top">
                        	<div class="box-3">
                            	<h2>REPORT<span>NOTE: TRDD = Target Report Despatch Date</span></h2>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="75%"><p>All reports issued:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoAllReportsIssued']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Ext. reports issued:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoExternalReportsIssued']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>NMI reports issued:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoNmiReportsIssued']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td width="75%"><p>Reports re-issued:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['NoNmiReportsIssued']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="r2">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="80%"><p><input type="button" class="btn" value="underlying data" />Ext. reports Meeting TRDD 'A':</p></td>
                                            <td width="15%"><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_A']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Ext. reports not Metting TRDD, non-NMI Error 'B':</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_B']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Ext. reports not Metting TRDD, NMI Error 'C':</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_C']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Ext. reports not Metting TRDD, uncategorised 'D':</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_D']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Ext. reports, Client contract breach 'E':</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_E']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Metting TRDD, S=100x{1-(C+D)/(A+B+C+D+E)}:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['Trdd_S']; ?>" /></td>
                                            <td>%</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td valign="top">
                        	<div class="box-4">
                            	<h2>MONEY AND HOURS</h2>
                                
                                <div class="rlo">
                                    <div class="r1">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="70%"><p>Total quoted price:</p></td>
                                                <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalQuotedFee']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><p>Avg. quoted price:</p></td>
                                                <td><input type="text" class="textbox-1" value="<?php echo $stItem['AvgQuotedFee']; ?>" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="r1">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="70%"><p>Total hours (hh:mm):</p></td>
                                                <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalHoursExpended']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><p>Avg. $/hour:</p></td>
                                                <td><input type="text" class="textbox-1" value="<?php echo $stItem['AvgMoneyPerHour']; ?>" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="r2">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="70%"><p>Total fee due:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalFeeDue']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Total ext. fee due:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalExternalFeeDue']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Total Nmi fee due:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalNmiFeeDue']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Total self fee due:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['TotalSelfFeeDue']; ?>" /></td>
                                        </tr>
                                        <tr>
                                        	<td><p>Average fee due:</p></td>
                                            <td><input type="text" class="textbox-1" value="<?php echo $stItem['AvgFeeDue']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php } ?>

        </div>
        
    </div>
