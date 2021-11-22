<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|exists:reminders,id,deleted_at,NULL',
            'title' => 'required|string',
            'description' => 'required|string',
            'shape_id' => 'required|numeric',
            'color_id' => 'required|numeric',
            'time_schedules' => 'required|array',
            'time_schedules.*.time' => 'required|date_format:H:i',
            'time_schedules.*.dose' => 'required|numeric',
            'start_date' => 'required|date'
        ];

    }

    public function getValidatorInstance()
    {
        if($this->isMethod('patch')){
            $this->request->add(['id' => intval($this->route('reminderId'))]);
        }
        return parent::getValidatorInstance();
    }
}
