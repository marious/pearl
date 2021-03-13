<?php

namespace Botble\Hospital\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Hospital\Forms\DoctorForm;
use Botble\Hospital\Http\Requests\DoctorRequest;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Botble\Hospital\Services\StoreDepartmentService;
use Botble\Hospital\Tables\DoctorTable;
use Illuminate\Http\Request;
use Exception;
use Auth;                           

class DoctorController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $doctorRepository;
    protected $departmentRepository;

    public function __construct(DoctorInterface $doctorRepository, DepartmentInterface $departmentRepository)
    {
        $this->doctorRepository = $doctorRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index(DoctorTable $table)
    {
        page_title()->setTitle(trans('plugins/hospital::hospital.doctors'));                         
        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/hospital::doctor.create'));

        return $formBuilder->create(DoctorForm::class)->renderForm();
    }


    public function store(
        DoctorRequest $request, 
        StoreDepartmentService $departmentService,
        BaseHttpResponse $response
    ) {
        $doctor = $this->doctorRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),  
        ]));

        event(new CreatedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $doctor));

        $departmentService->execute($request, $doctor);

        return $response
                ->setPreviousUrl(route('doctors.index'))
                ->setNextUrl(route('doctors.edit', $doctor->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $doctor = $this->doctorRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $doctor));

        page_title()->setTitle(trans('plugins/hospital::doctor.edit') . ' " ' . $doctor->name . '"');

        return $formBuilder->create(DoctorForm::class, ['model' => $doctor])->renderForm();
    }

    public function update(
        $id, 
        DoctorRequest $request,
        StoreDepartmentService $departmentService,
        BaseHttpResponse $response
    ) {
        $doctor = $this->doctorRepository->findOrFail($id);
        $doctor->fill($request->input());
        $this->doctorRepository->createOrUpdate($doctor);
        event(new UpdatedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $doctor));  // This event will go to make slug
        $departmentService->execute($request, $doctor);

        return $response
                ->setPreviousUrl(route('doctors.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $department = $this->departmentRepository->findOrFail($id);
            $this->departmentRepository->delete($department);
            event(new DeletedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $department));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $this->executeDeleteItems($request, $response, $this->departmentRepository, HOSPITAL_DOCTOR_MODULE_SCREEN_NAME);
    }
}
