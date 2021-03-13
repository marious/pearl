<?php
namespace Botble\Hospital\Services\Abstracts;

use Botble\Hospital\Models\Doctor;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Illuminate\Http\Request;

abstract class StoreDepartmentServiceAbstract
{
    protected $departmentRepository;

    public function __construct(DepartmentInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    abstract public function execute(Request $request, Doctor $doctor);
}