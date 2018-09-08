# UIKit 3 forms for Laravel 5

This is a package for creating UIKit 3 styled form elements in Laravel 5.

## Features

*   Labels
*   Error messages
*   UIKit 3 markup and classes (including state, colors, and sizes)
*   Error validation messages
*   Form fill (using model instance, array or after form submission when a validation error occurs)
*   Internationalization
*   Add parameters using php chaining approach
*   Zero dependences (no Laravel Collective dependency)

## Introduction

### Before

```html
<div class="uk-margin">
    <label class="uk-form-label" for="username">Username</label>
    <input type="text" class="uk-input @if ($errors->has('username')) uk-form-danger @endif " id="username" value="{{ old('username', $username) }}">
    @if ($errors->has('username'))
		<span class="uk-label uk-label-danger">
			<small>{{ $errors->first('username') }}
		</div>
    @endif
</div>
```

### After

```php
Form::text('username', 'Username')
```

## Installation

#### Require the package using Composer.

```bash
composer require eduardosaveiga/laravel-uikit-3-forms
```

### Laravel 5.5 or above

If you is using Laravel 5.5, the auto discovery feature will make everything for you and your job is done, you can start using now. Else, follow the steps below to install.

### Laravel 5.4

#### Add the service provider to your config/app.php file

```php
'providers' => [
    //...
	EduardoVeiga\Uikit3Forms\Uikit3FormsServiceProvider::class,
],
```

#### Add the BootForm facade to the aliases array in config/app.php:

```php
'aliases' => [
    //...
    'Form' => EduardoVeiga\Uikit3Forms\Uikit3FormsFacade::class,
],
```

## Usage

### Basic form controls

#### Opening and closing a form

```php
// Opening a form using POST method

{!! Form::open() !!}
// ... Form components here
{!! Form::close() !!}
```

> Opening the form will add \_token field automatically for you

#### Fieldset

| Param   | Type   | Default | Description     |
| ------- | ------ | ------- | --------------- |
| $legend | string | null    | Fieldset Legend |

```php
// Example
{!! Form::fieldsetOpen('Legend title') !!}
// ... fieldset content
{!! Form::fieldsetClose() !!}
```

### Basic inputs

#### Text inputs

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!! Form::text('name', 'User name') !!}
```

##### Textarea

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!! Form::textarea('description', 'Description') !!}
```

##### Select

| Param    | Type   | Default | Description    |
| -------- | ------ | ------- | -------------- |
| $name    | string | null    | Input name     |
| $label   | string | null    | Input label    |
| $options | array  | []      | Select options |
| $default | string | null    | Default value  |

```php
// Example
{!! Form::select('city', 'Choose your city', [1 => 'Gotham City', 2 => 'Springfield']) !!}
```

##### Checkbox

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $label   | string  | null    | Input label   |
| $value   | string  | null    | Input value   |
| $default | boolean | null    | Default value |

```php
// Example
{!! Form::checkbox('orange', 'Orange') !!}
```

##### Radio

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $label   | string  | null    | Input label   |
| $value   | string  | null    | Input value   |
| $default | boolean | null    | Default value |

```php
// Example
{!! Form::radio('orange', 'Orange') !!}
```

##### Range

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $label   | string  | null    | Input label   |
| $default | string  | null    | Default value |
| $min     | string  | 0       | Minimum value |
| $max     | string  | 10      | Maximum value |
| $step    | string  | 0.1     | Step value    |

```php
// Example
{!! Form::range('like', 'Like', '2', '0', '20', '1') !!}
```

##### Hidden

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $default | boolean | null    | Default value |

```php
// Example
{!! Form::hidden('user_id') !!}
```

##### Anchor

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $value | string | null    | Anchor text |
| $url   | string | null    | Anchor url  |

```php
// Example
{!! Form::anchor("Link via parameter", 'foo/bar') !!}
```

##### Buttons

| Param  | Type   | Default | Description  |
| ------ | ------ | ------- | ------------ |
| $value | string | null    | Button value |
| $color | string | null    | Button color |
| $size  | string | null    | button size  |

###### Submit

```php
// Example
{!! Form::submit("Send form") !!}
```

###### Button

```php
// Example
{!! Form::button("Do something", "primary", "large") !!}
```

###### Reset

```php
// Example
{!! Form::reset("Clear form") !!}
```

### Chainable methods

> This package uses [chaining](https://en.wikipedia.org/wiki/Method_chaining) feature, allowing easly pass more parameters.

### Filling a form

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $data | object | array   | null        | Data fo fill form inputs |

```php
// Examples

// With initial data using a Model instance
$user = User::find(1);
{!! Form::open()->fill($user) !!}

// With initial array data
$user = ['name' => 'Jesus', 'age' => 33];
{!! Form::open()->fill($user) !!}
```

### Url

Use in anchors and forms openings

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $url  | string | null    | Url         |

```php
// Example
{!! Form::anchor("Link via url")->url('foo/bar') !!}
```

### Route

Use in anchors and forms openings

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $route | string | null    | Route name  |

```php
// Example
{!! Form::anchor("Link via route")->route('home') !!}
```

### Checked

Set the checkbox/radio checked status

| Param    | Type    | Default | Description    |
| -------- | ------- | ------- | -------------- |
| $checked | boolean | true    | Checked status |

```php
// Examples

// Using readonly field
{!! Form::checkbox('agree', 'I agree')->checked() !!}

// You can use FALSE to turn off checked status
{!! Form::checkbox('agree', 'I agree')->checked(false) !!}
```

### Inline

Set the checkbox/radio checked status

```php
// Examples
{!! Form::radio('orange', 'Orange')->inline() !!}

{!! Form::checkbox('orange', 'Orange')->inline() !!}
```

### Placeholder

| Param        | Type   | Default | Description      |
| ------------ | ------ | ------- | ---------------- |
| $placeholder | string | null    | Placeholder text |

```php
// Example
{!! Form::text('name', 'Name')->placeholder('Input placeholder') !!}
```

### Select Multiple

```php
// Example
{!! Form::select('city', 'Choose your city', [1 => 'Gotham City', 2 => 'Springfield'])->multiple() !!}
```

### Locale

Using locale, the package will look for a resources/lang/{CURRENT_LANG}/forms/user.php language file and uses labels and help texts as keys for replace texts

```php
// Example
{!! Form::open()->locale('forms.user') !!}

{!! Form::text('name', 'labels.name') !!}
```

### Help Text

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $text | string | null    | Help text   |

```php
// Examples

// Conventional way
{!! Form::text('name', 'Name')->help('Help text here') !!}

// Using locale
{!! Form::text('name', 'Name')->help('help.text') !!}
```

### Custom attributes

| Param  | Type  | Default | Description             |
| ------ | ----- | ------- | ----------------------- |
| $attrs | array | []      | Custom input attributes |

```php
// Example
{!! Form::text('name', 'Name')->attrs(['data-foo' => 'bar', 'rel'=> 'baz']) !!}
```

### Readonly

| Param   | Type    | Default | Description      |
| ------- | ------- | ------- | ---------------- |
| $status | boolean | true    | Read only status |

```php
// Examples

// Using readonly field
{!! Form::text('name', 'Name')->readonly() !!}

// You can use FALSE to turn off readonly status
{!! Form::text('name', 'Name')->readonly(false) !!}
```

### Disabled

| Param   | Type    | Default | Description     |
| ------- | ------- | ------- | --------------- |
| $status | boolean | true    | Disabled status |

```php
// Examples

// Disabling a field
{!! Form::text('name', 'Name')->disabled() !!}

// Disabling a fieldset
{!! Form::fieldsetOpen('User data')->disabled() !!}

// You can use FALSE to turn off disabled status
{!! Form::text('name', 'Name')->disabled(false) !!}
```

### Full

| Param   | Type    | Default | Description     |
| ------- | ------- | ------- | --------------- |
| $status | boolean | true    | Disabled status |

```php
// Examples

// Field and button at full size
{!! Form::text('name', 'Name')->full() !!}

{!! Form::button('name')->full() !!}

// You can use FALSE to turn off block status
{!! Form::text('name', 'Name')->full(false) !!}
```

### Id

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $id   | string | null    | Id field    |

```php
// Example
{!! Form::text('name', 'Name')->id('user-name') !!}
```

### Id prefix

All ids will prepend by this prefix like: prefix-myclass

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $prefix | string | null    | Id prefix   |

```php
// Example
{!!Form::open()->idPrefix('register')!!}
```

### Multipart

| Param      | Type    | Default | Description    |
| ---------- | ------- | ------- | -------------- |
| $multipart | boolean | true    | Multipart flag |

```php
// Examples
{!! Form::open()->multipart() !!}

// You can use FALSE to turn off multipart
{!! Form::open()->multipart(false) !!}
```

### Method

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $method | string | null    | HTTP method |

```php
// Examples
{!! Form::open()->method('get') !!}
{!! Form::open()->method('post') !!}
{!! Form::open()->method('put') !!}
{!! Form::open()->method('patch') !!}
{!! Form::open()->method('delete') !!}
```

### explicit HTTP verbs

```php
// Examples
{!! Form::open()->get() !!}
{!! Form::open()->post() !!}
{!! Form::open()->put() !!}
{!! Form::open()->patch() !!}
{!! Form::open()->delete() !!}
```

### Color

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $color | string | null    | Color name  |

```php
// Examples
{!! Form::button("Do something")->color('primary') !!}

{!! Form::button("Do something")->color('secondary') !!}
```

### Size

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $size | string | null    | Size name   |

```php
// Examples
{!! Form::button("Do something")->size('small') !!}

{!! Form::button("Do something")->size('large') !!}
```

### Type

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $type | string | null    | Type field  |

```php
// Examples

// Password field
{!! Form::text('password', 'Your password')->type('password') !!}

// Number field
{!! Form::text('age', 'Your age')->type('number') !!}

// Email field
{!! Form::text('email', 'Your email')->type('email') !!}
```

### Name

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $name | string | null    | Input name  |

```php
// Examples
{!! Form::text('text')->name('name') !!}
```

### Label

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $label | string | null    | Input label |

```php
// Examples
{!! Form::text('age')->label('Your age') !!}
```

### Default Value

| Param  | Type  | Default | Description |
| ------ | ----- | ------- | ----------- |
| $value | mixed | null    | Input value |

```php
// Example
{!! Form::text('name', 'Your name')->value('Maria') !!}
```

### Render

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $render | string | null    | Render name |

```php
// Examples

// Number field
{!! Form::render('text')->name('age')->label('Your age') !!}
```

### Form Group

Additional class to form group (label + input)

| Param      | Type   | Default | Description      |
| ---------- | ------ | ------- | ---------------- |
| $formGroup | string | null    | Form group class |

```php
{!! Form::text('name', 'Name')->formGroup('uk-width-1-2@s') !!}
```

```html
<div class="uk-margin uk-width-1-2@s">
    <label class="uk-form-label" for="name">Name</label>
    <input type="text" class="uk-input @if ($errors->has('name')) uk-form-danger @endif " id="name" value="{{ old('name', $name) }}">
    @if ($errors->has('name'))
		<span class="uk-label uk-label-danger">
			<small>{{ $errors->first('name') }}
		</div>
    @endif
</div>
```

### Password Toggle

Switch input type from password to text (this feature needs implements an jQuery event).
*Only works with password input field.

| Param           | Type    | Default | Description      |
| --------------- | ------- | ------- | ---------------- |
| $passwordToggle | boolean | true    | Password toggle  |

```php
{!! Form::text('password', 'Password')->type('password')->passwordToggle() !!}
```
```javascript
$(function () {
	$('[uk-password-toggle]').on('click', function (e) {
		if ($(e.target).parent().next().attr('type') === 'password') {
			$(e.target).parent().next().attr('type', 'text');
			$(e.target).attr('uk-icon', 'lock');
		} else {
			$(e.target).parent().next().attr('type', 'password');
			$(e.target).attr('uk-icon', 'unlock');
		}
	});
});
```