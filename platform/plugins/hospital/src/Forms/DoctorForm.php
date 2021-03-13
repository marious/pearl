<?php

namespace Botble\Hospital\Forms;

use Botble\Hospital\Models\Doctor;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Hospital\Http\Requests\DoctorRequest;
use Botble\Hospital\Forms\Fields\DepartmentMultiField;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;

class DoctorForm extends FormAbstract
{
    public function __construct()
    {
        parent::__construct();


    }

    public function buildForm()
    {
        $selectedDepartments = [];
        if ($this->getModel()) {
            $selectedDepartments = $this->getModel()->departments()->pluck('department_id')->all();
        }

        if (empty($selectedDepartments)) {
            $selectedDepartments = app(DepartmentInterface::class)
                            ->getModel()
                            ->where('is_default', 1)
                            ->pluck('id')
                            ->all();
        }

        if (!$this->formHelper->hasCustomField('departmentMulti')) {
            $this->formHelper->addCustomField('departmentMulti', DepartmentMultiField::class);
        }

        $this
            ->setupModel(new Doctor)
            ->setValidatorClass(DoctorRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                    'class' => 'slug-field form-control',
                ],
            ])
            ->add('phone', 'number', [
                'label'      => trans('core/base::forms.phone'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.phone_placeholder'),
                    'data-counter' => 25,
                    'class' => 'form-control',
                ],
            ])
            ->add('mobile', 'number', [
                'label'      => trans('core/base::forms.mobile'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.mobile_placeholder'),
                    'data-counter' => 25,
                    'class' => 'form-control',
                ],
            ])
            ->add('description', 'editor', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                ],
            ])
           
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
         
            ->add('departments[]', 'departmentMulti', [
                'label'      => trans('plugins/hospital::department.form.department'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_departments_with_children(),
                'value'      => old('departments', $selectedDepartments),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
           
            ->setBreakFieldPoint('status');
    }
}
