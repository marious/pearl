<?php

namespace Botble\Hospital\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DepartmentRequest extends Request
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
            'description'   => 'max:400',
            'status'        => Rule::in(BaseStatusEnum::values()),
            'order'       => 'required|integer|min:0|max:127',
        ];
    }
}
