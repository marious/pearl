<?php

namespace Botble\News\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class NewsRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'content'   =>'required',
            'description' => 'max:400',
            'image' =>'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
