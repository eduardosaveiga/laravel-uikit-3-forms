<?php

namespace EduardoVeiga\Uikit3Forms;

class FormBuilder 
{
	/**
     * Form array data
     *
     * @var array
     */
    private $_Fdata;
	
	/**
     * Form input labels locale
     *
     * @var string
     */
    private $_Flocale;

    /**
     * Form method
     *
     * @var string
     */
    private $_Fmethod;

    /**
     * Multipart flag
     *
     * @var boolean
     */
    private $_Fmultipart;

    /**
     * Inputs id prefix
     * @var string
     */
	private $_Fprefix;
	
	/**
     * Input attributes
     *
     * @var array
     */
	private $_attrs;

	/**
     * Input color
     *
     * @var string
     */
    private $_color;

	/**
     * Disabled flag
     *
     * @var boolean
     */
	private $_disabled;

	/**
     * Input full flag
     *
     * @var boolean
     */
    private $_full;

	/**
     * Input help text
     *
     * @var string
     */
	private $_help;
	
	/**
	 * Icon to form input or button
	 *
	 * @var string
	 * @var boolean
	 */	
	private $_icon;
	
	/**
     * Input id
     *
     * @var string
     */
    private $_id;
	
	/**
     * Flag to determine checkbox/radio style
     *
     * @var boolean
     */
	private $_inline;

	/**
     * Input label
     *
     * @var string
     */
    private $_label;

    /**
     * Input meta data
     *
     * @var array
     */
	private $_meta;

	/**
     * Select multiple flag
     *
     * @var boolean
     */
    private $_multiple;
	
	/**
     * Input name
     *
     * @var string
     */
	private $_name;
	
	/**
     * Select options
     *
     * @var array
     */
    private $_options;

    /**
     * Input outline flag
     *
     * @var boolean
     */
	private $_outline;
	
	/**
     * Input placeholder
     *
     * @var string
     */
	private $_placeholder;
	
	/**
     * Readonly flag
     *
     * @var boolean
     */
	private $_readonly;
	
	/**
     * Input size
     *
     * @var string
     */
    private $_size;

    /**
     * Form control type
     *
     * @var string
     */
    private $_type;

    /**
     * Form/Link
     *
     * @var string
     */
    private $_url;

    /**
     * Input value
     *
     * @var boolean
     */
	private $_value;
	

    public function __construct()
    {
        $this->_resetFlags();
        $this->_resetFormFlags();
	}
	
	/**
     * Retrieve a class attribute
     *
     * @param string $attr
     * @return mixed
     */
    public function get(string $attr)
    {
        return $this->{'_' . $attr};
    }

    /**
     * Set a class attribute
     *
     * @param string $attr
     * @param mixed $value
     */
    public function set(string $attr, $value)
    {
        $this->{'_' . $attr} = $value;
    }

    /**
     * Return a open form tag
     *
     * @return string
     */
    public function open(): string
    {
        $props = [
			'action' => $this->_url,
			'class' => 'uk-form-stacked',
            'method' => $this->_Fmethod === 'get' ? 'get' : 'post'
        ];

        if ($this->_Fmultipart) {
            $props['enctype'] = 'multipart/form-data';
        }

        $attrs = $this->_buildAttrs($props);

        $ret = '<form ' . $attrs . '>';

        if ($this->_Fmethod !== 'get') {
            $ret .= csrf_field();

            if ($this->_Fmethod !== 'post') {
                $ret .= method_field($this->_Fmethod);
            }
        }

        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a close form tag
     *
     * @return string
     */
    public function close(): string
    {
        $ret = '</form>';

        $this->_resetFormFlags();
        $this->_resetFlags();

        return $ret;
	}

	/**
     * Return a anchor tag
     *
     * @return string
     */
    public function anchor(): string
    {
        return $this->_renderButtonOrAnchor();
    }

	/**
     * Return a button tag
     *
     * @return string
     */
    public function button(): string
    {
        return $this->_renderButtonOrAnchor();
    }

	/**
     * Return a checkbox tag
     *
     * @return string
     */
    public function checkbox(): string
    {
        return $this->_renderCheckboxOrRadio();
    }
	
	/**
     * Return a email input tag
     *
     * @return string
     */
    public function email(): string
    {
        return $this->_renderInput('email');
    }

    /**
     * Return a file input tag
     *
     * @return string
     */
    public function file(): string
    {
        $attrs = $this->_buildAttrs();

        return $this->_renderWrapperCommonField('<input ' . $attrs . '>');
	}
	
	/**
     * Return a hidden input tag
     *
     * @return string
     */
    public function hidden(): string
    {
		$value = $this->_getValue();
		
        $attrs = $this->_buildAttrs(['value' => $value]);

        $this->_resetFlags();

        return '<input ' . $attrs . '>';
	}
	
	/**
     * Return a number input tag
     *
     * @return string
     */
    public function number(): string
    {
        return $this->_renderInput('number');
	}

    /**
     * Return a password input tag
     *
     * @return string
     */
    public function password(): string
    {
        return $this->_renderInput('password');
    }
	
	/**
     * Return a range input tag
     *
     * @return string
     */
    public function range(): string
    {
        return $this->_renderInput('range');
	}

	/**
     * Return a radio tag
     *
     * @return string
     */
    public function radio(): string
    {
        return $this->_renderCheckboxOrRadio();
    }

    /**
     * Return a reset button tag
     *
     * @return string
     */
    public function reset(): string
    {
        return $this->_renderButtonOrAnchor();
    }

	/**
     * Return a select tag
     *
     * @return string
     */
    public function select(): string
    {
		$attrs = $this->_buildAttrs();
		
		$value = $this->_getValue();
		
        $options = '';

        if ($this->_multiple) {
            if (!is_array($value)) {
                $value = [$value];
            }

            foreach ($this->_options as $key => $label) {
                if (array_key_exists($key, $value)) {
                    $match = true;
                } else {
                    $match = false;
                }

				$checked = ($match) ? ' selected' : '';
				
                $options .= '<option value="' . $key . '"' . $checked . '>' . $label . '</option>';
            }
        } else {
            foreach ($this->_options as $optvalue => $label) {
				$checked = $optvalue == $value ? ' selected' : '';
				
                $options .= '<option value="' . $optvalue . '"' . $checked . '>' . $label . '</option>';
            }
        }

        return $this->_renderWrapperCommonField('<select ' . $attrs . '>' . $options . '</select>');
	}
	
	/**
     * Return a submit input tag
     *
     * @return string
     */
    public function submit(): string
    {
        return $this->_renderButtonOrAnchor();
    }
	
	/**
     * Return a text input tag
     *
     * @return string
     */
    public function text(): string
    {
        return $this->_renderInput();
    }

    /**
     * Return a textarea tag
     *
     * @return string
     */
    public function textarea(): string
    {
		$attrs = $this->_buildAttrs(['rows' => 3]);
		
        $value = $this->_getValue();

        return $this->_renderWrapperCommonField('<textarea ' . $attrs . '>' . $value . '</textarea>');
    }

    /**
     * Return a generic input tag
     *
     * @param string $type
     * @return string
     */
    private function _renderInput($type = 'text'): string
    {
		$value = $this->_getValue();
		
        $attrs = $this->_buildAttrs(['value' => $value, 'type' => $type]);

        return $this->_renderWrapperCommonField('<input ' . $attrs . '>');
    }

    /**
     * Return a button or anchor tag
     *
     * @return string
     */
    private function _renderButtonOrAnchor(): string
    {
		$disabled = $this->_disabled ? ' disabled' : '';	
		$full 	  = $this->_full ? ' uk-width-1-1' : '';
		$icon 	  = $this->_getIcon('button');
		$outline  = $this->_outline ? ' uk-button-outline' : '';
		$size 	  = $this->_size ? ' uk-button-' . $this->_size : '';
		$value 	  = $this->_e($this->_value);

		if ($this->_icon && array_key_exists('flip', $this->_icon)) {
			if ($this->_icon['flip']) {
				$value = $value . $icon;
			} else {
				$value = $icon . $value;
			}
		}
		
		$color = ' uk-button-' . $this->_color;

        $class = 'uk-button' . $outline . $color . $size . $full;

        if ($this->_type == 'anchor') {
			$href = $this->_url ?: 'javascript:void(0)';
			
            $attrs = $this->_buildAttrs([
				'class' => $class . $disabled,
				'href' 	=> $href,
				'role' 	=> 'button',
				'aria-disabled' => $disabled ? 'true' : null
            ]);

            $ret = '<div class="uk-margin"><a ' . $attrs . '>' . $value . '</a></div>';
        } else {
            $attrs = $this->_buildAttrs(['class' => $class, 'type' => $this->_type]);

            $ret = '<div class="uk-margin"><button ' . $attrs . ' ' . $disabled . '>' . $value . '</button></div>';
        }

        $this->_resetFlags();

        return $ret;
	}

	/**
     * Return a checkbox or radio HTML element
     *
     * @return string
     */
    private function _renderCheckboxOrRadio(): string
    {
        $attrs  = $this->_buildAttrs([ 
			"type" 	=> $this->_type, 
			"value" => $this->_meta['value']
		]);

		$error 	= $this->_getValidationFieldMessage();
		$for 	= $this->_id ? $this->_id : $this->_name;
        $inline = $this->_inline ? ' uk-inline' : '';
		$label  = $this->_e($this->_label);
        
        $this->_resetFlags();

        return '<div class="uk-margin ' . $inline . '"><label for="' . $for . '"><input ' . $attrs . '> ' . $label . '</label>' . $error . '</div>';
	}
	
	/**
     * Return a input with a wrapper HTML markup
     *
     * @param type $field
     * @return string
     */
    private function _renderWrapperCommonField(string $field): string
    {
        $error = $this->_getValidationFieldMessage();
		$help  = $this->_getHelpText();
		$icon  = $this->_getIcon();
		$label = $this->_getLabel();
        
        $formIcon = '';
		
		if ($icon && array_key_exists('flip', $this->_icon)) {
			if (!$this->_icon['flip']) {
				$formIcon .= ' uk-form-with-icon';
			} else {
				$formIcon .= ' uk-form-with-icon-flip';
			}
		}

		$this->_resetFlags();
		
		$input = '<div class="uk-margin' . $formIcon . '">' . $label;

		if ($icon) {
			$input .= '<div class="uk-inline uk-width-1-1">' . $icon;
		}

		$input .= $field;

		if ($icon) {
			$input .= '</div>';
		}

		$input .= $help . $error . '</div>';
		
        return $input;
    }

	/**
     * Return a help text
     *
     * @return string
     */
    private function _getHelpText(): string
    {
        $id = $this->_getIdHelp();

        return $this->_help ? '<small id="' . $id . '" class="uk-text-muted">' . $this->_e($this->_help) . '</small>' : '';
    }
	
	/**
     * Return a icon span
     *
     * @return string
     */
	private function _getIcon(string $render = 'input'): string
	{
		$icon = $this->_icon;

		$result = '';

		if ($icon) {
			$attrs = '';
			$class = '';

			$clickable = $icon['clickable'];
			$flip = $icon['flip'];
			$name = $icon['icon'];

			if ($render === 'input') {
				$class = 'uk-form-icon';

				if ($flip) {
					$class .= ' uk-form-icon-flip';
				}
			} else if ($render === 'button') {
				$class = 'uk-margin-small-right';

				if ($flip) {
					$class = 'uk-margin-small-left';
				}
			}

			if ($icon['attrs']) {
				foreach ($icon['attrs'] as $key => $value) {
					if ($value === null) {
						continue;
					}

					if ($key === 'class') {
						$class .= ' ' . htmlspecialchars($value);
					} else {
						if (is_string($value)) {
							$value = '="' . htmlspecialchars($value) . '" ';
						} else {
							$value = '';
						}

						$attrs .= $key . $value;
					}
				}
			}

			if ($clickable && $render === 'input') {
				$result = '<a class=" ' . $class . '" uk-icon="' . $name . '" ' . $attrs . '></a>';
			} else {
				$result = '<span class=" ' . $class . '" uk-icon="' . $name . '" ' . $attrs . '></span>';
			}
		}

		return $result;
	}

	/**
     * Return a element id
     *
     * @return string
     */
    private function _getId()
    {
        $id = $this->_id;

        if (!$id && $this->_name) {
			$id = $this->_name;
			
            if ($this->_type == 'radio') {
                $id .= '-' . str_slug($this->_meta['value']);
            }
        }

        if (!$id) {
            return null;
        }

        return $this->_Fprefix . $id;
    }

    /**
     * Return a help text id HTML element
     *
     * @return string
     */
    private function _getIdHelp()
    {
        $id = $this->_getId();

        return $id ? 'help-' . $id : '';
    }

    /**
     * Return a label tag
     *
     * @return string
     */
    private function _getLabel(): string
    {
		$label = $this->_label === true ? $this->_name : $this->_label;
		
        $result = '';

        if ($label) {
			$id = $this->_getId();
			
            $result = '<label class="uk-form-label" for="' . $id . '">' . $this->_e($label) . '</label>';
        }

        return $result;
	}

	/**
	 * Return validation class
	 *
	 * @return string
	 */
	private function _getValidationFieldClass(): string
    {
        if (!$this->_name) {
            return '';
        }

        if (session('errors') === null) {
            return '';
        }

        if ($this->_getValidationFieldMessage()) {
            return ' uk-form-danger';
        }

        return '';
	}
	
	/**
     * Return a validation error message
     *
     * @param string $prefix
     * @param string $sufix
     * @return string|mull
     */
    private function _getValidationFieldMessage(string $prefix = '<span class="uk-label uk-label-danger"><small>', string $sufix = '</small></span>')
    {
		$errors = session('errors');
		
        if (!$errors) {
            return null;
		}
		
        $error = $errors->first($this->_name);

        if (!$error) {
            return null;
        }

        return $prefix . $error . $sufix;
    }

	/**
     * Return a input value
     *
     * @return mixed
     */
    private function _getValue()
    {
        $name = $this->_name;

        if ($this->_hasOldInput()) {
            return old($name);
        }

        if ($this->_value !== null) {
            return $this->_value;
        }

        if (isset($this->_Fdata[$name])) {
            return $this->_Fdata[$name];
        }
    }

    /**
     * Return a string with HTML element attributes
     *
     * @param array $props
     * @return string
     */
    private function _buildAttrs(array $props = [], array $ignore = []): string
    {
		$ret = '';
		
        $props['name'] = $this->_name;
        $props['autocomplete'] = $props['name'];

		$props['class'] = isset($props['class']) ? $props['class'] : '';
		$props['id'] 	= $this->_getId();
		$props['type'] 	= $this->_type;
		
		if ($this->_help) {
            $props['aria-describedby'] = $this->_getIdHelp();
		}
		
		if ($this->_placeholder) {
            $props['placeholder'] = $this->_e($this->_placeholder);
        }

        if ($this->_type == 'select' && $this->_multiple) {
            $props['name'] = $props['name'] . '[]';
        }

		if (!$props['class']) {
			if (
				$this->_type == 'email' ||
				$this->_type == 'number' || 
				$this->_type == 'password' || 
				$this->_type == 'text'
			) {
				$props['class'] = 'uk-input';
			} else {
				$props['class'] = 'uk-' . $this->_type;
			}
        }

        if ($this->_size && ($this->_type != 'button' && $this->_type != 'submit')) {
            $props['class'] .= ' uk-form-' . $this->_size;
		}
		
        $props['class'] .= ' ' . $this->_getValidationFieldClass();

        if (isset($this->_attrs['class'])) {
            $props['class'] .= ' ' . $this->_attrs['class'];
        }

        $props['class'] = trim($props['class']);

        if (!$props['class']) {
            $props['class'] = null;
		}
		
		if ($this->_disabled) {
            $ret .= 'disabled ';
        }

        if ($this->_type == 'select' && $this->_multiple) {
            $ret .= 'multiple ';
        }

        if ($this->_readonly) {
            $ret .= 'readonly ';
        }

        if (in_array($this->_type, ['radio', 'checkbox'])) {
			$value = $this->_getValue();
			
            if ($value && ($this->_type === 'checkbox' || $this->_type === 'radio' && $value === $this->_meta['value'])) {
                $ret .= 'checked ';
            }
        }

        if ($this->_type == 'hidden') {
            unset($props['autocomplete']);
            unset($props['class']);
        }

        $allProps = array_merge($this->_attrs, $props);
        
        foreach ($allProps as $key => $value) {
            if ($value === null) {
                continue;
            }
			
            $ret .= $key . '="' . htmlspecialchars($value) . '" ';
        }

        return trim($ret);
    }

    /**
     * Return a text with translations, if available
     *
     * @param string $key
     *
     * @return string
     */
    private function _e($key): string
    {
        $fieldKey = $key ?: $this->_name;

        return $this->_Flocale ? __($this->_Flocale . '.' . $fieldKey) : $fieldKey;
	}
	
	/**
     * Check if has a old request
     *
     * @return boolean
     */
    private function _hasOldInput()
    {
        return count((array) old()) != 0;
	}
	
	/**
     * Reset form flags
     */
    private function _resetFormFlags()
    {
        $this->_Fdata 	= null;
        $this->_Flocale = null;
        $this->_Fmethod = 'post';
        $this->_Fmultipart = false;
        $this->_Fprefix = '';
    }

    /**
     * Reset input flags
     */
    private function _resetFlags()
    {
        $this->_attrs 	 = [];
        $this->_color 	 = 'default';
        $this->_disabled = false;
        $this->_full 	 = false;
        $this->_help 	 = null;
        $this->_id 		 = null;
		$this->_icon 	 = [];
        $this->_inline 	 = false;
        $this->_label 	 = null;
        $this->_meta 	 = [];
        $this->_multiple = false;
        $this->_name 	 = null;
        $this->_options  = [];
        $this->_outline  = false;
        $this->_placeholder = null;
        $this->_readonly = false;
        $this->_render 	 = null;
        $this->_size 	 = null;
        $this->_type 	 = null;
        $this->_url 	 = null;
		$this->_value 	 = null;
    }
}
