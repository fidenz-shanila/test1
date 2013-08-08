<?php

/**
 * Form controller abstract
 * Abstract class for rendering and updating sub forms
 * when generating forms should be an array. ie:- artifact form field name should be artefact[name]
 * @author Sahan <[email]>
 */

abstract class Subform
{
	/**
	 * Assosiative array of fields, field name, type, options
	 * array(
	 * 	'name' => 'field_name',
	 * 	'class' => 'class_name',
	 * 	'value' => 'val'
	 * )
	 * @var [type]
	 */
	protected $fields = array();

	/**
	 * View file, for internal use
	 * @var [type]
	 */
	protected $view; 

	/**
	 * The form object for the view.
	 * @var [type]
	 */
	protected $form;

	/**
	 * prefix to use with field prefixing
	 * @var [type]
	 */
	protected $prefix;

	public static function forge($name = 'default')
	{
		$form = new static;
		return $form;
	}

	private function __construct()
	{
		
		$this->prefix = strtolower($this->prefix);

		//blank class for later usage in ::form()
		$this->form = new StdClass;

		//setup view
		if(!empty($this->view))
		{
			$this->set_view(\View::forge($this->view));
		}
	}

	public function __toString()
	{	
		//initiating render method to set $form
		return (string) $this->render();
	}

	/**
	 * Set prefix
	 * @param [type] $prefix [description]
	 */
	public function set_prefix($prefix)
	{
		$this->prefix = $prefix;
	}

	/**
	 * Get prefix
	 * @return [type] [description]
	 */
	public function get_prefix()
	{	
		return $this->prefix;
	}

	/**
	 * Set fields
	 * @param Array $fields [description]
	 */
	public function set_fields(Array $fields)
	{
		$this->fields = $fields;
	}

	/**
	 * Assign a view to the sub form object
	 */
	public function set_view(View $view)
	{
		$this->view = $view;
	}	

	/**
	 * Get view
	 * @return Fuel/Core/View [description]
	 */
	public function get_view()
	{
		return $this->view;
	}

	/**
	 * Generate the form object
	 * @return [type] [description]
	 */
	public function form()
	{
		foreach($this->fields as $name=>$field)
		{	
			$this->form->$name = $this->build_field($name);
		}

		return $this->form;
	}

	public function build_field($name)
	{
		
		if(!isset($this->fields[$name]))
			throw new \FuelException('Field not found');
			

		$field = $this->fields[$name];
		
		$field = $field + array('options' => '', 'type' => 'input', 'value' => '');

		$attributes = $field;
		unset($attributes['type']);
		unset($attributes['value']);

		if($field['type'] == 'text' or is_callable("\Form::{$field['type']}"))
		{
			if($field['type'] == 'select')
			{	
				return \Form::$field['type']("{$this->prefix}[{$name}]", $field['value'], $field['options'], $attributes);
			}
			else
				return \Form::$field['type']("{$this->prefix}[{$name}]", $field['value'], $attributes);
		}
		else
			throw new \FuelException('Invalid field type');

		//return $this->form[$field['name']];
	}

	/**
	 * Render the form view
	 * @return string
	 */
	public function render($params = array())
	{
		if(!$this->view instanceof View)
			throw new \FuelException('Valid view is not assigned');

		$this->view->set('form', $this->form(), false);
		return $this->view;
	}

	/**
	 * Populate field values (override) with post array
	 * @return [type] [description]
	 */
	public function populate(Array $values)
	{
		foreach($values as $key=>$value)
		{
			if(isset($this->fields[$key]))
				$this->fields[$key]['value'] = $value;
		}
	}

	/**
	 * Update logic
	 * @param Array fields from the form
	 * @return [type] [description]
	 */
	public function update($fields)
	{
		$this->fields = Arr::filter_keys((array) $fields, array_keys($this->fields));
	}

}
/* eof */