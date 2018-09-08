<?php

namespace EduardoVeiga\Uikit3Forms;

/**
 * FormService class
 *
 * @author eduardosaveiga
 */
class FormService 
{
    /**
     * The Form builder instance
     *
     * @var \EduardoVeiga\Uikit3Forms\FormBuilder
     */
    private $_builder;

    /**
     * Render to be used
     *
     * @var string
     */
    private $_render;

    /**
     * Allowed renders
     *
     * @var array
     */
    private $_allowedRenders = [
		'anchor', 
		'button', 
		'checkbox', 
		'close', 
		'email', 
		'file', 
		'hidden', 
		'number', 
		'open', 
		'password', 
		'radio', 
		'range', 
		'reset', 
		'select', 
		'submit', 
		'text', 
		'textarea', 
	];

    /**
     * Create a new FormSevice instance
     */
    public function __construct()
    {
        $this->_builder = new FormBuilder;
    }

    /**
     * Magic method to return a class string version
     *
     * @return string
     */
    public function __toString()
    {
        $output = '';

        if (in_array($this->_render, $this->_allowedRenders)) {
            $output = $this->_builder->{$this->_render}();
        }

        $this->_render = null;

        return $output;
    }

    /**
     * Open the form
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function open(): FormService
    {
        return $this->render('open');
    }

    /**
     * Close the form
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function close(): FormService
    {
        return $this->render('close');
    }

    /**
     * Set a prefix id for all inputs
     *
     * @param string $prefix
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function idPrefix(string $prefix = ''): FormService
    {
        return $this->_set('FidPrefix', $prefix);
    }

    /**
     * Set multipart attribute for a form
     *
     * @param bool $multipart
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function multipart(bool $multipart = true): FormService
    {
        return $this->_set('Fmultipart', $multipart);
    }

    /**
     * Set a method attribute for the form
     *
     * @param string $method
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function method(string $method): FormService
    {
        return $this->_set('Fmethod', $method);
    }

    /**
     * Set get method for the form attribute
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function get(): FormService
    {
        return $this->method('get');
    }

    /**
     * Set post method for the form attribute
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function post(): FormService
    {
        return $this->method('post');
    }

    /**
     * Set put method for the form attribute
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function put(): FormService
    {
        return $this->method('put');
    }

    /**
     * Set patch method for the form attribute
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function patch(): FormService
    {
        return $this->method('patch');
    }

    /**
     * Set delete method for the form attribute
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function delete(): FormService
    {
        return $this->method('delete');
    }

    /**
     * Fill the form values
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function fill($data): FormService
    {

        if (method_exists($data, 'toArray')) {
            $data = $data->toArray();
        }

        if (!is_array($data)) {
            $data = [];
        }

        return $this->_set('Fdata', $data);
    }

    /**
     * Set locale file for inputs translations
     *
     * @param string $path
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function locale(string $path): FormService
    {
        return $this->_set('Flocale', $path);
    }

    /**
     * Set inline style for checkbox and radio inputs
     * @param bool $inline
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function inline(bool $inline = true): FormService
    {
        return $this->_set('checkInline', $inline);
    }

    /**
     * Set url for links and form action
     *
     * @param string $url
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function url(string $url): FormService
    {
        return $this->_set('url', url($url));
    }

    /**
     * Set route for links and form action
     *
     * @param string $route
     * @param array $params
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function route(string $route, array $params = []): FormService
    {
        return $this->_set('url', route($route, $params));
    }

    /**
     * Open a fieldset
     *
     * @param string $legend
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function fieldsetOpen(string $legend = null): FormService
    {
        return $this->_set('meta', ['legend' => $legend])->render('fieldsetOpen');
    }

    /**
     * Close a fieldset
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function fieldsetClose(): FormService
    {
        return $this->render('fieldsetClose');
    }

    /**
     * Set a help text
     *
     * @param string $text
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function help(string $text): FormService
    {
        return $this->_set('help', $text);
    }

    /**
     * Create a file input
     *
     * @param string $name
     * @param string $label
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function file(string $name = null, string $label = null): FormService
    {
        return $this->name($name)->label($label)->type('file');
    }

    /**
     * Create a text input
     *
     * @param string $name
     * @param string $label
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function text(string $name = null, $label = null, string $default = null): FormService
    {
        return $this->type('text')->name($name)->label($label)->value($default);
    }

    /**
     * Create a hidden input
     *
     * @param string $name
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function hidden(string $name = null, string $default = null): FormService
    {
        return $this->name($name)->value($default)->type('hidden');
    }

    /**
     * Create a select input
     *
     * @param string $name
     * @param string $label
     * @param array $options
     * @param string|array $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function select(string $name = null, string $label = null, $options = [], $default = null): FormService
    {
        return $this->name($name)->label($label)->options($options)->value($default)->type('select');
    }

    /**
     * Set options for a select field
     *
     * @param array $options
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function options(array $options = []): FormService
    {
        $items = is_iterable($options) ? $options : [0 => 'Must be iterable'];
        return $this->_set('options', $items);
    }

    /**
     * Create a checkbox input
     *
     * @param string $name
     * @param string $label
     * @param string $value
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function checkbox(string $name = null, string $label = null, string $value = null, string $default = null): FormService
    {
        return $this->_checkboxRadio('checkbox', $name, $label, $value, $default);
    }

    /**
     * Create a radio input
     *
     * @param string $name
     * @param string $label
     * @param string $value
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function radio(string $name = null, string $label = null, string $value = null, string $default = null): FormService
    {
        return $this->_checkboxRadio('radio', $name, $label, $value, $default);
	}
	
    /**
     * Create a range input
     *
     * @param string $name
     * @param string $label
     * @param string $value
     * @param string $default
     * @param string $min
     * @param string $max
     * @param string $step
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function range(string $name = null, string $label = null, string $default = null, string $min = '0', string $max = '10', string $step = '0.1'): FormService
    {
		return $this->type('range')->name($name)->label($label)->value($default)->attrs(['min' => $min, 'max' => $max, 'step' => $step]);
    }

    /**
     * Create a textarea input
     *
     * @param string $name
     * @param type $label
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function textarea(string $name = null, $label = null, string $default = null): FormService
    {
        return $this->type('textarea')->name($name)->value($default)->label($label);
    }

    /**
     * Set a label
     *
     * @param type $label
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function label($label): FormService
    {
        return $this->_set('label', $label);
    }

    /**
     * Create a button
     *
     * @param string $value
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function button(string $value = null): FormService
    {
        return $this->type('button')->value($value);
    }

    /**
     * Create a button type submit
     *
     * @param string $value
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function submit(string $value): FormService
    {
        return $this->button($value)->type('submit');
    }

    /**
     * Create a button type reset
     *
     * @param string $value
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function reset(string $value): FormService
    {
        return $this->type('reset')->button($value);
    }

    /**
     * Create a anchor
     *
     * @param string $value
     * @param type $url
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function anchor(string $value, $url = null): FormService
    {
        if ($url) {
            $this->url($url);
        }

        return $this->button($value)->type('anchor');
    }

    /**
     * Flag a checkbox or a radio input as checked
     *
     * @param bool $checked
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function checked(bool $checked = true): FormService
    {
        $type = $this->_builder->get('type');
        $meta = $this->_builder->get('meta');

        if ($type === 'radio' && $checked) {
            $checked = $meta['value'];
        }

        return $this->value($checked);
    }

    /**
     * Set a input value
     *
     * @param type $value
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function value($value = null): FormService
    {
        if ($value !== null) {
            return $this->_set('value', $value);
        }

        return $this;
    }

    /**
     * Set a input type
     *
     * @param type $type
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function type($type): FormService
    {
        return $this->_set('type', $type)->render($type);
    }

    /**
     * Set a render
     *
     * @param string $render
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function render(string $render): FormService
    {
        $this->_render = $render;

        return $this;
    }

    /**
     * Set a field id
     *
     * @param type $id
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function id($id): FormService
    {
        return $this->_set('id', $id);
    }

    /**
     * Set a field name
     *
     * @param type $name
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function name($name): FormService
    {
        return $this->_set('name', $name);
    }

    /**
     * Set the size
     *
     * @param string $size
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function size(string $size = null): FormService
    {
        return $this->_set('size', $size);
    }

    /**
     * Set the color
     *
     * @param string $color
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function color(string $color = null): FormService
    {
        return $this->_set('color', $color);
    }

    /**
     * Set outline style
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function outline(bool $outline = true): FormService
    {
        return $this->_set('outline', $outline);
    }

    /**
     * Set full style
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function full(bool $status= true): FormService
    {
        return $this->_set('full', $status);
    }

    /**
     * Set readonly style
     *
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function readonly($status = true): FormService
    {
        return $this->_set('readonly', $status);
    }

    /**
     * Set the input disabled status
     *
     * @param type $status
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function disabled($status = true): FormService
    {
        return $this->_set('disabled', $status);
    }

    /**
     * Set the input placeholder
     *
     * @param type $placeholder
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function placeholder($placeholder): FormService
    {
        return $this->_set('placeholder', $placeholder);
    }

    /**
     * Set custom attributes for a input
     *
     * @param array $attrs
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function attrs(array $attrs = []): FormService
    {
        return $this->_set('attrs', $attrs);
    }

    /**
     * Set a multiple select attribute
     *
     * @param bool $multiple
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function multiple(bool $multiple = true): FormService
    {
        return $this->_set('multiple', $multiple);
    }

    /**
     * Set more classes to form group div
     *
     * @param type $class
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function formGroup($class): FormService
    {
        return $this->_set('formGroup', $class);
    }

    /**
     * Set the input passwordToggle status
     *
     * @param type $status
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    public function passwordToggle($status = true): FormService
    {
        return $this->_set('passwordToggle', $status);
    }

    /**
     * Set a form builder attribute
     *
     * @param string $attr
     * @param mixed $value
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    private function _set($attr, $value): FormService
    {
        $this->_builder->set($attr, $value);

        return $this;
    }

    /**
     * Render a checkbox or a radio input
     *
     * @param string $type
     * @param string $name
     * @param string $label
     * @param mixed $value
     * @param string $default
     * @return \EduardoVeiga\Uikit3Forms\FormService
     */
    private function _checkboxRadio($type, $name, $label, $value, $default): FormService
    {
        $inputValue = $value === null ? $name : $value;

        if ($default) {
            $default = $inputValue;
        }

        return $this->_set('meta', ['value' => $inputValue])->type($type)->name($name)->label($label)->value($default);
    }
}
