<?php
namespace Botble\Hospital\Services;

use Illuminate\Http\Request;
use Botble\Hospital\Models\Doctor;
use Botble\Hospital\Services\Abstracts\StoreDepartmentServiceAbstract;

class StoreDepartmentService extends StoreDepartmentServiceAbstract
{
    public function execute(Request $request, Doctor $doctor)
    {
        $departments = $request->input('departments');
        if (!empty($departments)) {
          $doctor->departments()->detach();
          foreach ($departments as $department) {
            $doctor->departments()->attach($department);
          }
        }
    }
}