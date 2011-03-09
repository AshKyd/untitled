<?php
require_once '/var/www/mustache.php/Mustache.php';
/**
 * A Class
 * 
 * AA description of the class
 * @author Ashley Kyd <ash@kyd.com.au>
 * @version 1.0
 */

class Form {
	protected $template = '<form id="{{id}}" class="form {{class}}">
	{{#fieldsets}}<fieldset id="{id}}">
		<legend>{{name}}</legend>
		{{#description}}<div class="description">{{description}}</div>{{/description}}
		{{#elements}}<div class="formContainerEditor formContainerEditor {{class}}{{#validation}} val-{{p}}{{/validation}}" id="c-{{id}}">
			{{renderLabel}}
			{{renderField}}
			{{renderDescription}}
		</div>
		{{/elements}}
	</fieldset>
	{{/fieldsets}
</form>';
	protected $name = 'My Form';
	protected $id = '';
	protected $class = '';
	protected $fields = Array();
}

class FormFieldset {
	public $name = '';
	public $id = '';
	public $description = '';
	public $elements = Array();
}

class FormField{
	
	public $type = 'text';
	public $default = '';
	public $value = '';
	public $class = '';
	public $id = '';
	public $label = '';
	public $description = '';
	public $validation = Array();
	public $options = Array();
	
	protected $elementTemplate = '<input type="text" class="formField formFieldText {{class}}{{#validation}} val-{{p}}{{/validation}}" id="{{id}}" value="" />';
	protected $labelTemplate = '<label for="{{id}}">{{label}}</label>';
	protected $descriptionTemplate = '{{#description}}<p>{{description}}</p>{{/description}}';
	protected static $m = false;
	
	function __construct($configuration = false){
		if($configuration)
			$this->loadFromConfig($configuration);
		
		if(!self::m){
			self::m = new Mustache();
		}
	}
	
	function loadFromConfig($configuration){
		foreach($configuration as $field => &$value){
			$this->$field = $value;
		}
	}
	
	function renderLabel(){
		return self::m->render($this->labelTemplate,&$this);
	}
	
	function renderField(){
		return self::m->render($this->elementTemplate,&$this);
	}
	
	function renderDescription(){
		return self::m->render($this->descriptionTemplate,&$this);
	}
	
	function __toString(){
		return $this->renderField();
		
	}
	
}

class FormFieldInput extends FormField{
	
}

class FormFieldMultiline extends FormField { 
	protected $elementTemplate = '<textarea class="formField formFieldEditor {{class}}{{#validation}} val-{{p}}{{/validation}}" id="{{id}}">{{value}}</textarea>';	
}

class FormFieldEditor extends FormField { 
	protected $elementTemplate = '<textarea class="formField formFieldMultiline {{class}}{{#validation}} val-{{p}}{{/validation}}" id="{{id}}">{{value}}</textarea>';
}

$saved = json_decode('{"type":"text","default":"","value":"clasps","class":"potato","id":"","label":"","validation":[]}');

$new = new FormField($saved);
die($new);
