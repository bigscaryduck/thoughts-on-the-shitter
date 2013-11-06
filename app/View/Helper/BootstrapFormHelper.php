<?php

App::uses('FormHelper', 'View/Helper');

class BootstrapFormHelper extends FormHelper {

	/**
	 * Defines the type of form being created; horizontal, inline, or normal.
	 *
	 * @var string
	 */
	private $_formType = null;
	
	/**
	 * Column class definitions for left and right (label and input) columns.
	 *
	 * @var string
	 */
	private $left  = 'col-md-3 col-lg-2';
	private $right = 'col-md-9 col-lg-10';
	
	/**
	 * Set the value of $_formType
	 *
	 * @var string
	 */
	protected function _setFormType($val){
		$this->_formType = $val;
	}
		
	/**
	 * Returns the current value of $_formType
	 */
	protected function _getFormType(){
		return $this->_formType;
	}
	
	/**
	 * Set the value of $left
	 *
	 * @var int
	 */
	public function setLeft($val){
		$this->left = $val;
	}
	
	/**
	 * Set the value of $right
	 *
	 * @var int
	 */
	public function setRight($val){
		$this->right = $val;
	}		

	/**
	 * Returns an HTML Form element.
	 *
	 * @param mixed $model The model name for which the form is being defined.
	 * @param array $options An array of html attributes and options.
	 * @return string An formatted opening FORM tag.
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-create
	 */
	public function create($model = null, $options = array()) {
		if (!isset($options['novalidate'])) {
			$options['novalidate'] = true;
		}
		if (!isset($options['role'])){
			$options['role'] = 'form';
		}
		$this->_setFormType(null);
		if (isset($options['class'])) {
			if (is_integer(strpos($options['class'], 'form-horizontal'))){
				$this->_setFormType('horizontal');
			} elseif (is_integer(strpos($options['class'], 'form-inline'))) {
				$this->_setFormType('inline');
			}
		}
		return parent::create($model, $options);
	}
	
	/**
	 * Generate format options
	 *
	 * @param array $options
	 * @return array
	 */
	protected function _getFormat($options) {
		if ($options['type'] === 'hidden') {
			return array('input');
		}
		if (is_array($options['format']) && in_array('input', $options['format'])) {
			return $options['format'];
		}
		if ($options['type'] === 'checkbox') {
			return array('before', 'label', 'between', 'input', 'error', 'after');
		}
		return array('before', 'label', 'between', 'input', 'error', 'after');
	}	
	
	/**
	 * Returns a form input element along with label and wrapper div
	 *
	 * @param array $fields An array of fields to generate inputs for, or null.
	 * @param array $blacklist A simple array of fields to not create inputs for.
	 * @param array $options Options array.
	 * @return string Completed form inputs.
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::inputs
	 */
	public function input($fieldName, $options = array()){
	
		if (!isset($options['type'])) {
			$options = $this->_magicOptions($options);
		}
		$type = $options['type'];
		
		if ($type == 'hidden') {
			return parent::input($fieldName, $options);
		}

		$state = '';
		if ($this->isFieldError($fieldName)) {
			$options['state'] = 'error';
		}
		if (isset($options['state'])) {
			switch ($options['state']) {
				case 'error':
					$state = ' has-error';
					break;
				case 'warning':
					$state = ' has-warning';
					break;
				case 'success':
					$state = ' has-success';
					break;
			}
			unset($options['state']);
		}	
			
		if (!isset($options['div'])) {
			$options['div'] = 'form-group' . $state;
		} elseif ($options['div'] !== false) {
			if (is_array($options['div'])) {
				if (!isset($options['div']['class'])) {
					$options['div']['class'] = 'form-group' . $state;
				} else {
					$options['div']['class'] .= ' form-group' . $state;
				}	
			} else {
				$options['div'] .= ' form-class' . $state;
			}
		}
		
		if (!in_array($type, array('checkbox', 'radio', 'file'))) {
			if (isset($options['class'])) {
				$options['class'] .= ' form-control';
			} else {
				$options['class'] = 'form-control';
			}
		}			

		$labelClass = false;
		switch ($this->_getFormType()) {
			case 'horizontal':
				$labelClass = 'control-label ' . $this->left;
				break;
			case 'inline':
				$labelClass = 'sr-only';
				break;
		}
		
		$labelInsert = null;
		if (!in_array($type, array('checkbox', 'radio'))) {
			if (!isset($options['label'])) {
				$options['label'] = array('class' => $labelClass);
			} elseif ($options['label'] !== false) {
				if (!is_array($options['label'])) {
					$options['label'] = array('class' => $labelClass, 'text' => $options['label']);
				} else {
					if (isset($options['label']['class'])) {
						$options['label']['class'] .= ' ' . $labelClass;
					} else {
						$options['label']['class'] = $labelClass;
					}
				}
			}
		} else {
			if (isset($options['label']) && is_string($options['label'])) {
				$for = isset($options['id']) ? $options['id'] : $fieldName;
				$labelInsert = $this->label($fieldName, $options['label'], array('class' => $labelClass, 'for' => $for . '_'));
			}
			$options['label'] = false;		
		}

		if (!isset($options['error'])) {
			$options['error'] = array('attributes' => array('wrap' => 'span', 'class' => 'help-block error-message'));
		} else {
			if (!isset($options['error']['attributes']['wrap'])) {
				$options['error']['attributes']['wrap'] = 'span';
			}
			if (!isset($options['error']['attributes']['class'])) {
				$options['error']['attributes']['class'] = 'help-block error-message';
			}
		}
		
		$between = $after = '';
		if (isset($options['prepend'])) {
			$between .= '<span class="input-group-addon">' . $options['prepend'] .'</span>';
		}
		if (isset($options['append'])) {
			$after = '<span class="input-group-addon">' . $options['append'] .'</span>' . $after;
		}
		if (isset($options['prepend']) || isset($options['append'])) {
			$between = '<div class="input-group">' . $between;
			$after .= '</div>';
			unset($options['prepend'], $options['append']);
		}
		if (isset($options['help'])) {
			$after .= $this->Html->tag('span', $options['help'], array('class' => 'help-block'));
			unset($options['help']);
		}
		if (isset($options['between'])) {
			$between = $options['between'] . $between;
		}
		if (isset($options['after'])) {
			$after .= $options['after'];
		}
				
		if ($this->_getFormType() == 'horizontal') {
			if (!in_array($type, array('checkbox', 'radio')) || $labelInsert) {
				$between = '<div class="'. $this->right .'">' . $between;			
			} 
			elseif (!empty($options['offset'])) {
				if (is_string($options['offset'])) {
					$offset = ' ' . $options['offset'];
				} else {
					$offset = ' ' . preg_replace('/(xs|sm|md|lg)-/', '$1-offset-', $this->left);
				}
				unset($options['offset']);
				$between = '<div class="'. $this->right . $offset .'">' . $between;
			} 
			else {
				$between = '<div class="col-lg-12">' . $between;
			}
			$after .= '</div>';
		}
		
		if ($labelInsert) {
			$between = $labelInsert . $between;
		}
	
		$options['between'] = $between;
		$options['after'] = $after;

		$out = parent::input($fieldName, $options);
		return str_replace(' error"', '"', $out);
	}	
	
	/**
	 * Returns a checkbox input element.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
	 * @param array $options Array of HTML attributes.
	 * @return string An HTML text input element.
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
	 */
	public function checkbox($fieldName, $options = array()){
	
		$out = parent::checkbox($fieldName, $options);

		if (isset($options['text'])) {
			if ($options['text'] !== false) {
				$out .= ' ' . $options['text'];
			}
		} else {
			if (strpos($fieldName, '.') !== false) {
				$fieldElements = explode('.', $fieldName);
				$text = array_pop($fieldElements);
			} else {
				$text = $fieldName;
			}
			if (substr($text, -3) === '_id') {
				$text = substr($text, 0, -3);
			}
			$text = __(Inflector::humanize(Inflector::underscore($text)));
			$out .= ' ' . $text;
		}		
		
		$inline = isset($options['inline']) && $options['inline'] == true;
		
		$labelOptions = array();
		if ($inline) {
			$labelOptions['class'] = 'checkbox-inline';
		}
				
		$out = $this->Html->tag('label', $out, $labelOptions);
	
		if (!$inline) {
			$out = $this->Html->div('checkbox', $out);
		}
		
		return $out;
	}	
	
	/**
	 * Returns a set of radio input elements.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
	 * @param array $options Radio button options array.
	 * @param array $attributes Array of HTML attributes, and special attributes above.
	 * @return string Completed radio widget set.
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
	 */
	public function radio($fieldName, $options = array(), $attributes = array()) {

		$attributes = $this->_initInputField($fieldName, $attributes);
	
		$showEmpty = $this->_extractOption('empty', $attributes);
		if ($showEmpty) {
			$showEmpty = ($showEmpty === true) ? __d('cake', 'empty') : $showEmpty;
			$options = array('' => $showEmpty) + $options;
		}
		unset($attributes['empty']);

		if (isset($attributes['label'])) {
			unset($attributes['label']);
		}

		$separator = null;
		if (isset($attributes['separator'])) {
			$separator = $attributes['separator'];
			unset($attributes['separator']);
		}
		
		$between = null;
		if (isset($attributes['between'])) {
			$between = $attributes['between'];
			unset($attributes['between']);
		}

		$value = null;
		if (isset($attributes['value'])) {
			$value = $attributes['value'];
		} else {
			$value = $this->value($fieldName);
		}

		$disabled = array();
		if (isset($attributes['disabled'])) {
			$disabled = $attributes['disabled'];
		}
		
		if (isset($value) && is_bool($value)) {
			$value = $value ? 1 : 0;
		}

		$inline = false;
		if (isset($attributes['inline'])) {
			$inline = (bool)$attributes['inline'];
			unset($attributes['inline']);
		}

		$label = array();
		if ($inline) {
			$label['class'] = 'radio-inline';
		}
		
		$hiddenField = isset($attributes['hiddenField']) ? $attributes['hiddenField'] : true;
		unset($attributes['hiddenField']);		
		
		$out = array();
		foreach ($options as $optValue => $optTitle) {

			$optionsHere = array('value' => $optValue);

			if (isset($value) && strval($optValue) === strval($value)) {
				$optionsHere['checked'] = 'checked';
				$label['class'] = isset($label['class']) ? $label['class'] . ' ' . 'checked' : 'checked';
			}
			$isNumeric = is_numeric($optValue);
			if ($disabled && (!is_array($disabled) || in_array((string)$optValue, $disabled, !$isNumeric))) {
				$optionsHere['disabled'] = true;
			}
			$tagName = Inflector::camelize(
				$attributes['id'] . '_' . Inflector::slug($optValue)
			);

			$allOptions = array_merge($attributes, $optionsHere);
			$input = $this->Html->useTag('radio', $attributes['name'], $tagName, array_diff_key($allOptions, array('name' => null, 'type' => null, 'id' => null)), $optTitle);

			$input = $this->Html->tag('label', $input, $label);
			if (!$inline) {
				$input = $this->Html->div('radio', $input);
			}			
			
			$out[] = $input;
		}
		
		if (is_array($between)) {
			$between = '';
		}
		
		$hidden = null;
		if ($hiddenField) {
			if (!isset($value) || $value === '') {
				$hidden = $this->hidden($fieldName, array(
					'id' => $attributes['id'] . '_', 'value' => '', 'name' => $attributes['name']
				));
			}
		}		
		
		$out = $between . $hidden . implode($separator, $out);
		return $out;
	}	
	
	/**
	 * Returns a formatted SELECT element.
	 *
	 * @param string $fieldName Name attribute of the SELECT
	 * @param array $options Array of the OPTION elements (as 'value'=>'Text' pairs) to be used in the SELECT element
	 * @param array $attributes The HTML attributes of the select element.
	 * @return string Formatted SELECT element
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
	 */
	public function select($fieldName, $options = array(), $attributes = array()) {
		$select = array();
		$style = null;
		$tag = null;
		$attributes += array(
			'class' => null,
			'escape' => true,
			'secure' => true,
			'empty' => '',
			'showParents' => false,
			'hiddenField' => true,
			'disabled' => false,
			'inline' => false
		);

		$escapeOptions = $this->_extractOption('escape', $attributes);
		$secure = $this->_extractOption('secure', $attributes);
		$showEmpty = $this->_extractOption('empty', $attributes);
		$showParents = $this->_extractOption('showParents', $attributes);
		$hiddenField = $this->_extractOption('hiddenField', $attributes);
		unset($attributes['escape'], $attributes['secure'], $attributes['empty'], $attributes['showParents'], $attributes['hiddenField']);
		$id = $this->_extractOption('id', $attributes);

		$attributes = $this->_initInputField($fieldName, array_merge(
			(array)$attributes, array('secure' => self::SECURE_SKIP)
		));

		if (is_string($options) && isset($this->_options[$options])) {
			$options = $this->_generateOptions($options);
		} elseif (!is_array($options)) {
			$options = array();
		}
		if (isset($attributes['type'])) {
			unset($attributes['type']);
		}

		if (!empty($attributes['multiple'])) {
			$style = ($attributes['multiple'] === 'checkbox') ? 'checkbox' : null;
			$template = ($style) ? 'checkboxmultiplestart' : 'selectmultiplestart';
			$tag = $template;
			if ($hiddenField) {
				$hiddenAttributes = array(
					'value' => '',
					'id' => $attributes['id'] . ($style ? '' : '_'),
					'secure' => false,
					'name' => $attributes['name']
				);
				$select[] = $this->hidden(null, $hiddenAttributes);
			}
		} else {
			$tag = 'selectstart';
		}
		
		if ($tag !== 'checkboxmultiplestart' &&
			!isset($attributes['required']) &&
			empty($attributes['disabled']) &&
			$this->_introspectModel($this->model(), 'validates', $this->field())
		) {
			$attributes['required'] = true;
		}

		if (!empty($tag) || isset($template)) {
			$hasOptions = (count($options) > 0 || $showEmpty);
			if ((!isset($secure) || $secure) && empty($attributes['disabled']) && (!empty($attributes['multiple']) || $hasOptions)) {
				$this->_secure(true, $this->_secureFieldName($attributes));
			}
			$select[] = $this->Html->useTag($tag, $attributes['name'], array_diff_key($attributes, array('name' => null, 'value' => null)));
		}
		$emptyMulti = (
			$showEmpty !== null && $showEmpty !== false && !(
				empty($showEmpty) && (isset($attributes) &&
				array_key_exists('multiple', $attributes))
			)
		);
		
		if ($emptyMulti) {
			$showEmpty = ($showEmpty === true) ? '' : $showEmpty;
			$options = array('' => $showEmpty) + $options;
		}

		if (!$id) {
			$attributes['id'] = Inflector::camelize($attributes['id']);
		}
		
		$select = array_merge($select, $this->_selectOptions(
			array_reverse($options, true),
			array(),
			$showParents,
			array(
				'escape' => $escapeOptions,
				'style' => $style,
				'name' => $attributes['name'],
				'value' => $attributes['value'],
				'class' => $attributes['class'],
				'id' => $attributes['id'],
				'disabled' => $attributes['disabled'],
				'inline' => (bool)$attributes['inline']
			)
		));

		$template = ($style === 'checkbox') ? 'checkboxmultipleend' : 'selectend';
		$select[] = $this->Html->useTag($template);
		return implode("\n", $select);
	}
		
	/**
	 * Returns an array of formatted OPTION/OPTGROUP elements
	 *
	 * @param array $elements
	 * @param array $parents
	 * @param boolean $showParents
	 * @param array $attributes
	 * @return array
	 */
	protected function _selectOptions($elements = array(), $parents = array(), $showParents = null, $attributes = array()) {
		$select = array();
		$attributes = array_merge(
			array('escape' => true, 'style' => null, 'value' => null, 'class' => null),
			$attributes
		);
		$selectedIsEmpty = ($attributes['value'] === '' || $attributes['value'] === null);
		$selectedIsArray = is_array($attributes['value']);
		
		$inline = $attributes['inline'];
		
		foreach ($elements as $name => $title) {
		
			$htmlOptions = array();
			if (is_array($title) && (!isset($title['name']) || !isset($title['value']))) {
				if (!empty($name)) {
					if ($attributes['style'] === 'checkbox') {
						$select[] = $this->Html->useTag('fieldsetend');
					} else {
						$select[] = $this->Html->useTag('optiongroupend');
					}
					$parents[] = $name;
				}
				$select = array_merge($select, $this->_selectOptions(
					$title, $parents, $showParents, $attributes
				));

				if (!empty($name)) {
					$name = $attributes['escape'] ? h($name) : $name;
					if ($attributes['style'] === 'checkbox') {
						$select[] = $this->Html->useTag('fieldsetstart', $name);
					} else {
						$select[] = $this->Html->useTag('optiongroup', $name, '');
					}
				}
				$name = null;
			} elseif (is_array($title)) {
				$htmlOptions = $title;
				$name = $title['value'];
				$title = $title['name'];
				unset($htmlOptions['name'], $htmlOptions['value']);
			}

			if ($name !== null) {
				$isNumeric = is_numeric($name);
				if (
					(!$selectedIsArray && !$selectedIsEmpty && (string)$attributes['value'] == (string)$name) ||
					($selectedIsArray && in_array((string)$name, $attributes['value'], !$isNumeric))
				) {
					if ($attributes['style'] === 'checkbox') {
						$htmlOptions['checked'] = true;
					} else {
						$htmlOptions['selected'] = 'selected';
					}
				}

				if ($showParents || (!in_array($title, $parents))) {
					$title = ($attributes['escape']) ? h($title) : $title;

					$hasDisabled = !empty($attributes['disabled']);
					if ($hasDisabled) {
						$disabledIsArray = is_array($attributes['disabled']);
						if ($disabledIsArray) {
							$disabledIsNumeric = is_numeric($name);
						}
					}
					if (
						$hasDisabled &&
						$disabledIsArray &&
						in_array((string)$name, $attributes['disabled'], !$disabledIsNumeric)
					) {
						$htmlOptions['disabled'] = 'disabled';
					}
					if ($hasDisabled && !$disabledIsArray && $attributes['style'] === 'checkbox') {
						$htmlOptions['disabled'] = $attributes['disabled'] === true ? 'disabled' : $attributes['disabled'];
					}
					if ($attributes['style'] === 'checkbox') {
					
						$htmlOptions['value'] = $name;

						$tagName = $attributes['id'] . Inflector::camelize(Inflector::slug($name));
						$htmlOptions['id'] = $tagName;
	
						$name = $attributes['name'];
						$item = $this->Html->useTag('checkboxmultiple', $name, $htmlOptions);

						$label = array();
						if ($inline) {
							$label['class'] = 'checkbox-inline';
						}
						
						if (isset($htmlOptions['checked']) && $htmlOptions['checked'] === true) {
							$label['class'] = isset($label['class']) ? $label['class'] .= ' ' . 'checked' : 'checked';
						}
												
						$item = $this->Html->tag('label', $item . ' ' . $title, $label);
						
						if (!$inline) {
							$item = $this->Html->div('checkbox', $item);
						}
						$select[] = $item;
					} else {
						$select[] = $this->Html->useTag('selectoption', $name, $htmlOptions, $title);
					}
				}
			}
		}

		return array_reverse($select, true);
	}	

}
