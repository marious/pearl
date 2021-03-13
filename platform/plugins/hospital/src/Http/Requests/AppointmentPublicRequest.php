<?php
namespace Botble\Hospital\Http\Requests;


use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AppointmentPublicRequest extends Request
{
    public function rules()
    {
        return [
            'name'          => 'required|min:5|max:200',
            'phone'         => ['required', 'max:20', 'regex:/((\+?2?01)[0-9]{9})/'],
            'email'         => 'email|max:150',
            'message'       => 'max:255',
            'department'    => Rule::in(array_values(get_departments_id())),
            'date'          => 'required|date_format:Y-d-m',
        ];
    }
}
