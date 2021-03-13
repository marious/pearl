<?php


namespace Botble\Hospital\Http\Requests;


use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AppointmentRequest extends Request
{
    public function rules()
    {
        return [
            'patient_name'          => 'required|min:5|max:200',
            'patient_phone'         => ['required', 'max:20', 'regex:/((\+?2?01)[0-9]{9})|[0-9]{6,10}/'],
            'patient_email'         => 'email|max:150',
            'message'               => 'max:255',
            'department_id'         => Rule::in(array_values(get_departments_id())),
            'appointment_date'      => 'required|date_format:Y-m-d H:i',
        ];
    }
}
