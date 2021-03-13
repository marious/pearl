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
use Botble\Hospital\Forms\DepartmentForm;
use Botble\Hospital\Http\Requests\DepartmentRequest;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Hospital\Tables\DepartmentTable;
use Illuminate\Http\Request;
use Exception;
use Auth;

class DepartmentController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $departmentRepository;

    public function __construct(DepartmentInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(DepartmentTable $table)
    {
        dd(get_departments_id());
        page_title()->setTitle(trans('plugins/hospital::hospital.departments'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/hospital::department.create'));

        return $formBuilder->create(DepartmentForm::class)->renderForm();
    }


    public function store(DepartmentRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->departmentRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $department = $this->departmentRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));


        event(new CreatedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));

        return $response
                ->setPreviousUrl(route('departments.index'))
                ->setNextUrl(route('departments.edit', $department->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $department = $this->departmentRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $department));

        page_title()->setTitle(trans('plugins/hospital::department.edit') . ' " ' . $department->name . '"');

        return $formBuilder->create(DepartmentForm::class, ['model' => $department])->renderForm();
    }

    public function update($id, DepartmentRequest $request, BaseHttpResponse $response)
    {
        $department = $this->departmentRepository->findOrFail($id);
        
        if ($request->input('is_default')) {
            $this->departmentRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $department->fill($request->input());
        $this->departmentRepository->createOrUpdate($department);
        event(new UpdatedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));  // This event will go to make slug

        return $response
                ->setPreviousUrl(route('departments.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $department = $this->departmentRepository->findOrFail($id);
            if (!$department->is_default) {
                $this->departmentRepository->delete($department);
                event(new DeletedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));
            }
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setMessage(trans('core/base::notices.no_select'));
        }
        foreach ($ids as $id) {
            $department = $this->departmentRepository->findOrFail($id);
            if (!$department->is_default) {
                $this->departmentRepository->delete($department);
                event(new DeletedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));
            }
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
