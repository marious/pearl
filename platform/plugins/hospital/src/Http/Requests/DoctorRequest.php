<?php

namespace Botble\Hospital\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DoctorRequest extends Request
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
            'status'        => Rule::in(BaseStatusEnum::values()),
            'phone'         => 'max:25',
            'mobile'        => 'max:25',
            'departments'    => 'required',
        ];
    }
}
