<?php

namespace Kiwi\Core\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	// override
	protected function failedValidation(Validator $validator)
	{
		throw new ValidationException($validator);
	}

	protected function nullable($key, $default)
	{
		$value = $this->input($key, $default);
		if ($value === null) {
			return $default;
		}
		return $value;
	}

	public function rules()
	{
		return [];
	}
}