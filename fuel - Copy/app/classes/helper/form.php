<?php
/**
 * Form helper for app
 */
class Helper_Form
{
	public static function seach_criteria($key, $values = null, $atts = array())
	{	
		$options = array('LIKE', 'NOT LIKE', 'EQUAL TO', 'NOT EQUAL TO', 'STARTS WITH', 'ENDS WITH');
		$dd_options = array_combine($options, $options);
		//$dd_options = array_merge(array(''=>'Select'), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}
        public static function seach_criteria2($key, $values = null, $atts = array())
	{	
		$options = array('','LIKE', 'NOT LIKE', 'EQUAL TO', 'NOT EQUAL TO', 'STARTS WITH', 'ENDS WITH');
		$dd_options = array_combine($options, $options);
		//$dd_options = array_merge(array(''=>'Select'), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}

	public static function financial_status($key, $values = null, $atts = array())
	{
		$options = array('No credit (O/S)', 'No credit (AUS)', 'Credit OK');
		$dd_options = array_combine($options, $options);
		//$dd_options = array_merge(array(''=>'Select'), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}

	public static function org_type($key, $values = null, $atts=array())
	{
		$options = array('EXTERNAL','NMI');
		$dd_options = array_combine($options, $options);
		$dd_options = array_merge(array(''=>''), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}
        public static function org_type_con_edit($key, $values = null, $atts=array())
	{
		$options = array('EXTERNAL','NMI');
		$dd_options = array_combine($options, $options);
		

		return \Form::select($key, $values, $dd_options, $atts);
	}
        public static function org_type_contacts($key, $values = null, $atts=array())
	{
		$options = array('NMI', 'EXTERNAL','APPROVED','UNAPPROVED','Credit OK','No credit (O/S)','No credit (AUS)');
		$dd_options = array_combine($options, $options);
		$dd_options = array_merge(array(''), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}


	public static function currency_type($key, $values = null, $atts=array())
	{
		$options = array('CURRENT', 'OBSOLETE');
		$dd_options = array_combine($options, $options);
		//$dd_options = array_merge(array(''=>''), $dd_options);

		return \Form::select($key, $values, $dd_options, $atts);
	}
	
	public static function list_employees($key, $values = null, $atts=array(),$btn_disabled=null,$required=array(),$class=null)
	{
		$id = uniqid('empselect_');
		$atts = array_merge((array) $atts, array('id' => $id));
		$emp_id = Nmi::current_user('id');
                
                if($class==''){
                    $class = 'employee_select';
                     //set button
                      $edit_button = '<input type="button" value="..." class="emp_view button2 cb iframe" ' . $btn_disabled.'  /></div>';
                   }else{
                        $class='employee_select wdb_data add_reset_filter';
                        $edit_button = '';
                   }
               
        
                        $javascript = '<script type="text/javascript">';
                        $javascript .= '  $(".emp_view").click(function(){';
			$javascript .= " var id = $(this).siblings('select').val();";
			$javascript .='	id = id+"?form=form";';
                        $javascript .=' var url = "'. \Uri::create('employees/edit/').'";';
                        $javascript .=" $(this).attr('href', url+id);";
                        $javascript .=' });';
                        $javascript .= ' </script>';

		$types = \NMI::Db()->query("SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
		 $allData=( \Arr::assoc_to_keyval($types, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst'));
                //return '<div class="employee"><input ' . $required .' class="select_current_employee" '.$btn_disabled .' data-emp_id="'.$emp_id.'" data-dropdown="#'.$id.'" type="button"  />'.
		//print_r(\Arr::assoc_to_keyval($types, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst'));exit;
                  $allData=array(''=>'')+$allData;    
                return '<div class="employee"><input ' . $required .' class="select_current_employee" '.$btn_disabled .' data-emp_id="'.$emp_id.'" data-dropdown="#'.$id.'" type="button"  />'.
                        \Form::select($key, $values, $allData, $atts + array('class' => $class)).
		$edit_button . $javascript;
		
	}
        public static function list_employees_For_Con($key, $values = null, $atts=array(),$btn_disabled=null,$required=array(),$class=null)
	{
		$id = uniqid('empselect_');
		$atts = array_merge((array) $atts, array('id' => $id));
		$emp_id = Nmi::current_user('id');
                
                if($class==''){
                    $class = 'employee_select';
                     //set button
                      $edit_button = '<input type="button" value="..." class="emp_view button2 cb iframe" ' . $btn_disabled.'  /></div>';
                   }else{
                        $class='employee_select wdb_data add_reset_filter';
                        $edit_button = '';
                   }
               
        
                        $javascript = '<script type="text/javascript">';
                        $javascript .= '  $(".emp_view").click(function(){';
			$javascript .= " var id = $(this).siblings('select').val();";
			$javascript .='	id = id+"?form=form";';
                        $javascript .=' var url = "'. \Uri::create('employees/edit/').'";';
                        $javascript .=" $(this).attr('href', url+id);";
                        $javascript .=' });';
                        $javascript .= ' </script>';

		$types = \NMI::Db()->query("SELECT EM1_EmployeeID_pk , EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
		 $allData= \Arr::assoc_to_keyval($types, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
                 $allData=array(''=>'')+$allData;
                return '<div class="employee"><input ' . $required .' class="select_current_employee" '.$btn_disabled .' data-emp_id="'.$emp_id.'" data-dropdown="#'.$id.'" type="button"  />'.
		//print_r(\Arr::assoc_to_keyval($types, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst'));exit;
                //  print_r($allData1);exit;   
                        
                        
                        \Form::select($key, $values, $allData, $atts + array('class' => $class));
		 
	}
        public static function list_employees1($key, $values = null, $atts=array(),$btn_disabled=null,$required=array(),$class=null)
	{
		$id = ('wdb_officer');
                $atts = array_merge((array) $atts, array('id' => $id));
		
                
		$emp_id = Nmi::current_user('full_name_no_title');
                
                
                    $class = 'testSelect filter_field';
                     //set button
                     
                   
                        
                   
               
        
		$types = \NMI::Db()->query("SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
		return '<input ' . $required .' class="testSelectBtn " '.$btn_disabled .' data-emp_id="'.$emp_id.'" data-dropdown="#'.$id.'"  type="button"  />'.
		\Form::select($key, $values,array(0), $atts + array('class' => $class));
		
	}
         public static function list_employees2($key, $values = null, $atts=array(),$btn_disabled=null,$required=array(),$class=null)
	{
		$id = ('wdb_officer');
                $atts = array_merge((array) $atts, array('id' => $id));
		
                
		$emp_id = Nmi::current_user('full_name_no_title');
                
                
                    $class = 'testSelect filter_field';
                     //set button
                     
                   
                        
                   
               
        
		$types = \NMI::Db()->query("SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
		return '<input ' . $required .' class="testSelectBtn1 " '.$btn_disabled .' data-emp_id="'.$emp_id.'" data-dropdown="#'.$id.'"  type="button"  />'.
		\Form::select($key, $values,array(0), $atts + array('class' => $class));
		
	}

	public static function clear_select($select_name, $atts = array())
	{	
		$atts = array('data-dropdown' => $select_name, 'class' => 'clear-dd ','style'=>'height:20px ;width:15px;', 'value' => '...', 'type' => 'button') + (array) $atts;
		return Form::input("clear_{$select_name}", '    ', $atts);
	}

	public static function range_filter()
	{
		$str = '';
                //$str.='<table border="1" id="rangDiv" align="center" style="width:100%;  background-color:#e6e5e0;float:left; padding:0px 4px 3px 3px ;"><tr><td>';
                $str.='<div id="rangDiv" align="center" style="width:100%;  background-color:#e6e5e0;float:left; padding:0px 4px 3px 3px ;">';
                $str .='<table><tr><td><h5 align="left" style="margin-left:23%;"><u>FILTER:</u></h5></td>';
               // $str .='</td><td>';
                $str .= '</tr><tr><td><input type="text" id="ColourChenger" style="height: 6px;width: 135px;padding:6px ;border:1px solid black" disabled="disabled" name="filter" value="" /></td><td>';
                //$str .='</td></tr>';
		foreach (range('A', 'Z') as $range_filter) {
		    $str .= '<input class="range-filter rangeB " type="button" style="height:30px; width: 25px" onclick="filterChangeColour()" value="'.$range_filter.'" id="'.$range_filter.'" />';
		}
		$str .= '<input type="button" onclick="filterResetColour()" class="range-filter-reset btnReset" style="height:30px; width: 75px;color:red;"  id="btnReset" value="RESET" /></td></tr></table>';
               $str.='</div>';
                //$str.='</table>';
		return $str;
	}
        public static function range_filter1()
	{
		$str = '';
                //$str.='<table border="1" id="rangDiv" align="center" style="width:100%;  background-color:#e6e5e0;float:left; padding:0px 4px 3px 3px ;"><tr><td>';
                $str.='<div id="rangDiv" align="center" style="width:100%;  background-color:#e6e5e0;float:left; padding:0px 4px 3px 3px ;">';
                $str .='<table><tr><td><h5 align="left" style="margin-left:23%;">FILTERS:</h5></td>';
               // $str .='</td><td>';
                $str .= '</tr><tr><td><input type="text" id="ColourChenger" style="height: 6px;width: 135px;padding:6px ;border:1px solid black" disabled="disabled" name="filter" value="" /></td><td>';
                //$str .='</td></tr>';
		foreach (range('A', 'Z') as $range_filter) {
		    $str .= '<input class="range-filter rangeB " type="button" style="height:30px; width: 25px font-size:10px;" onclick="filterChangeColour()" value="'.$range_filter.'" id="'.$range_filter.'" />';
		}
		$str .= '<input type="button" onclick="filterResetColour()" class="range-filter-reset btnReset" style="height:30px; width: 75px;color:red;"  id="btnReset" value="Remove" /></td></tr></table>';
               $str.='</div>';
                //$str.='</table>';
		return $str;
	}
        
        public static function print_rr($array){ 
            
    
                echo '<pre>',print_r($array),'</pre>';
    
          }

}

