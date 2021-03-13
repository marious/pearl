<?php
namespace Botble\Hospital\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class DepartmentMultiField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/hospital::departments.departments-multi';
    }
}
