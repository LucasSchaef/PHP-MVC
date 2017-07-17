<?php
/**
 * Form-class
 * Class to generate a form using Bootstrap-Styling
 *
 * @category	Style
 * @package		Form
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copyright (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 **/
 
class form {
	/**
	 * HTML of the Form
	 *
	 * @var string
	 **/
	private $form;
	/**
	 * Array of allowed Form-fields
	 *
	 * @var array
	 **/
	private $possibleFields = array(
									'text', 
									'password', 
									'file', 
									'checkbox', 
									'email', 
									'submit', 
									'select', 
									'radio', 
									'textarea', 
									'hidden'
									);
	/**
	 * Array containing Infos on the form (mainly used for debugging)
	 *
	 * @var array
	 **/
	public $formInfo = array(
							'formInfo'=>'', 
							'fields'=>''
							);
	
	/**
	 * __construct
	 * Basic form-properties will be set with this
	 *
	 * @param string $action	The URL to which the form will send it's information
	 * @param string $method	The method that should be used to send form data ('post' or 'get')
	 * @param string $addAtts	With this you can add additional HTML to the <form>-tag (e.g. classes or styles)
	 **/
	public function __construct($action, $method = 'post', $addAtts = NULL) {
		// Start with saving the basic information in the formInfo-Array
		$this->formInfo['formInfo'] = array('Action'=>$action, 'Method'=>$method, 'Additional HTML'=>$addAtts);
		// Start the Form-HTML by creating the Form-Opening-Tag
		$this->form = '<form role="form" method="'.$method.'" action="'.$action.'"';
		// If $addAtts is not null, it is added to the <form>-Tag
		if(!is_null($addAtts)) {
			$this->form .= ' '.$addAtts;
		}
		$this->form .= '>';
	}
		
	/**
	 * text
	 * Function to add a text-field to the form
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 * @param string $placeholder	If not NULL, this will be used as placeholder. Else the $label will be used.
	 **/
	public function text($label, $id, $help = NULL, $error = false, $placeholder = NULL) {
		if(is_null($placeholder)) {
			$placeholder = $label;
		}
		$options = array(
						'type'=>'text',
						'id'=>$id,
						'placeholder'=>$placeholder,
						'label'=>$label,
						'helptext'=>$help,
						'error'=>$error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * hidden
	 * Creates an hidden field within the form
	 *
	 * @param string $id	The ID (also used as "name") of the hidden field
	 * @param string $value	The value of the hidden field
	 **/
	public function hidden($id, $value) {
		$options = array(
						'type'=>'hidden',
						'id'=>$id,
						'value'=>$value);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * password
	 * Function to add a password-field to the form
	 *
	 * @param string $label		The label for the field
	 * @param string $id		The ID of the field (will also be used as "name")
	 * @param string $help		An additional helptext
	 * @param boolean $error	If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 **/
	public function password($label, $id, $help = NULL, $error = false) {
		$options = array(
						'type'=>'password',
						'id'=>$id,
						'placeholder'=>$label, // This is just so something is displayed in the field
						'label'=>$label,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * file_field
	 * Function to add a upload-field to the form
	 *
	 * @param string $label		The label for the field
	 * @param string $id		The ID of the field (will also be used as "name")
	 * @param string $help		An additional helptext
	 * @param boolean $error	If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 **/
	public function file_field($label, $id, $help = NULL, $error = false) {
		$options = array(
						'type'=>'file',
						'id'=>$id,
						'label'=>$label,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * email
	 * Function to add a email-field to the form (which basically is a text-field, but bootstrap has some validation-functions on email-fields)
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 * @param string $placeholder	If not NULL, this will be used as placeholder. Else the $label will be used.
	 **/
	public function email($label, $id, $help = NULL, $error = false, $placeholder = NULL) {
		if(is_null($placeholder)) {
			$placeholder = $label;
		}
		$options = array(
						'type'=>'email',
						'id'=>$id,
						'placeholder'=>$placeholder,
						'label'=>$label,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * checkbix
	 * Function to add a checkbox to the form
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 **/
	public function checkbox($label, $id, $help = NULL, $error = false) {
		$options = array(
						'type'=>'checkbox',
						'id'=>$id,
						'label'=>$label,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * radio
	 * Function to add a radio to the form
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 **/
	public function radio($label, $id, $help = NULL, $error = false) {
		$options = array(
						'type'=>'radio',
						'id'=>$id,
						'label'=>$label,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * textarea
	 * Function to add a textarea to the form
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param integer $rows			The number of rows of which the textarea should consist
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 * @param string $placeholder	If not NULL, this will be used as placeholder. Else the $label will be used.
	 **/
	public function textarea($label, $id, $rows = 5, $help = NULL, $error = false, $placeholder = NULL) {
		if(is_null($placeholder)) {
			$placeholder = $label;	
		}
		$options = array(
						'type'=>'textarea',
						'id'=>$id,
						'placeholder'=>$placeholder,
						'label'=>$label,
						'rows'=>$rows,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * select
	 * Function to add a select-field to the form
	 *
	 * @param string $label			The label for the field
	 * @param string $id			The ID of the field (will also be used as "name")
	 * @param array $options		Array of the choosable options withing this select-field
	 * @param string $help			An additional helptext
	 * @param boolean $error		If true, there will occur an error on this field (we're using the bootstrap class "has-error")
	 **/
	public function select($label, $id, array $options, $help = NULL, $error = false) {
		$options = array(
						'type'=>'select',
						'id'=>$id,
						'label'=>$label,
						'options'=>$options,
						'helptext'=>$help,
						'error'=> $error);
		$this->formInfo['fields'][$id] = $options;
	}
	
	/**
	 * submit
	 * Adds a submit-button to the form
	 *
	 * @param string $label	The label for the button
	 **/
	public function submit($label) {
		$options = array(
						'type'=>'submit', 
						'label'=>$label,);
		$this->formInfo['fields']['submit'] = $options;
	}
	
	/**
	 * addError
	 * Method to afterwards add an error to a specific field
	 *
	 * @param string $id		The ID of the field to which the error should be added
	 * @param string $errormsg	This will be displayed as helptext
	 **/
	public function addError($id, $errormsg) {
		$this->formInfo['fields'][$id]['helptext'] = $errormsg;
		$this->formInfo['fields'][$id]['error'] = true;	
	}
	
	/**
	 * addValue
	 * Method to afterwards add a value to a specific field
	 *
	 * @param string $id	The ID of the field to which the value should be added
	 * @param string $value	The value that will be added
	 **/
	public function addValue($id, $value) {
		$this->formInfo['fields'][$id]['value'] = $value;	
	}
	
	/**
	 * write
	 * Method to print the form
	 **/
	public function write() {
		foreach($this->formInfo['fields'] as $field) {
			switch($field['type']) {
				case 'checkbox':
				case 'radio':
					if($field['error']) {
						$this->form .= '<div class="has-error">';
					}
					$this->form .= '<div class="'.$field['type'].'"><label>';
					$this->form .= '<input type="'.$field['type'].'" id="'.$field['id'].'" name="'.$field['id'].'" /> '.$field['label'];
					$this->form .= '</label></div>';
					if($field['error']) {
						$this->form .= '</div>';
					}
				break;
				case 'select':
					$this->form .= '<div class="form-group'.(($field['error']) ? ' has-error': '').'">';
					$this->form .= '<label for="'.$field['id'].'">'.$field['label'].'</label>';
					$this->form .= '<select id="'.$field['id'].'" name="'.$field['id'].'" class="form-control">';
					foreach($field['options'] as $val => $option) {
						$this->form .= '<option value="'.$val.'">'.$option.'</option>';	
					}
					$this->form .= '</select>';
					if(!empty($field['helptext'])) {
						$this->form .= '<p class="help-block" id="'.$field['id'].'">'.$field['helptext'].'</p>';	
					}
					$this->form .= '</div>';
				break;
				case 'hidden':
					$this->form .= '<input type="hidden" id="'.$field['id'].'" name="'.$field['id'].'" value="'.$field['value'].'" />';
				break;
				case 'textarea':
					$this->form .= '<div class="form-group'.(($field['error']) ? ' has-error': '').'">';
					$this->form .= '<label for="'.$field['id'].'">'.$field['label'].'</label>';
					$this->form .= '<textarea id="'.$field['id'].'" name="'.$field['id'].'" class="form-control" rows="'.$field['rows'].'"></textarea>';
					if(!empty($field['helptext'])) {
						$this->form .= '<p class="help-block" id="'.$field['id'].'">'.$field['helptext'].'</p>';	
					}
					$this->form .= '</div>';
				break;
				case 'submit':
					$this->form .= '<button type="submit" class="btn btd-default">'.$field['label'].'</button>';
				break;
				default:
					$this->form .= '<div class="form-group'.(($field['error']) ? ' has-error': '').'">';
					$this->form .= '<label for="'.$field['id'].'">'.$field['label'].'</label>';
					$this->form .= '<input type="'.$field['type'].'" id="'.$field['id'].'" name="'.$field['id'].'"';
					if($field['type'] != 'file') {
						$this->form .= ' class="form-control" placeholder="'.$field['placeholder'].'"';
					}
					if(isset($field['value']) && !empty($field['value'])) {
						$this->form .= ' value="'.$field['value'].'"';
					}
					
					$this->form .= ' />';
					if(!empty($field['helptext'])) {
						$this->form .= '<p class="help-block" id="'.$field['id'].'">'.$field['helptext'].'</p>';	
					}
					$this->form .= '</div>';
				break;
			}
		}
		echo $this->form.'</form>';
	}
}

?>