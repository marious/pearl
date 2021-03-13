<?php
namespace Theme\Pearl\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Hospital\Models\Department;
use Botble\Hospital\Models\Doctor;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Repositories\Interfaces\SlugInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use SlugHelper;
use SeoHelper;
use Illuminate\Support\Str;
use Theme;

class ThemePearlController extends PublicController
{
    public function getIndex(BaseHttpResponse $response)
    {
        return Parent::getIndex($response);
    }

    public function getView(BaseHttpResponse $response, $key = null)
    {
        return parent::getView($response, $key);
    }

    public function getDoctor(string $key, SlugInterface $slugRepository, DoctorInterface $doctorRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Doctor::class)]);

        if (!$slug) {
            abort(404);
        }

        $doctor = $doctorRepository->getFirstBy([
            'id' => $slug->reference_id,
        ], ['*'], ['departments']);

        if (!$doctor) {
            abort(404);
        }

        SeoHelper::setTitle($doctor->name)->setDescription(Str::words($doctor->description, 120));

        $meta = new SeoOpenGraph;

        $meta->setDescription(strip_tags($doctor->description));
        $meta->setUrl($doctor->url);
        $meta->setTitle($doctor->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);



        return Theme::scope('doctor', compact('doctor'))->render();
    }

    public function getDepartments(Request $request, DepartmentInterface $departmentRepository, BaseHttpResponse $response)
    {
        SeoHelper::setTitle('الأقسام');
        $params = [
            'paginate' => [
                'per_page' => 9,
                'current_pages' => $request->input('page', 1),
            ],
            'order_by' => ['hs_departments.created_at' => 'DESC'],
        ];

        $departments = $departmentRepository->getPaginatedDepartments($params);

        return Theme::scope('departments', compact('departments'))->render();
    }

    public function getDepartment(string $key, SlugInterface $slugRepository, DepartmentInterface $departmentRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Department::class)]);

        if (!$slug) {
            abort(404);
        }

        $department = $departmentRepository->getFirstBy([
            'id' => $slug->reference_id,
        ], ['*']);

        if (!$department) {
            abort(404);
        }

        SeoHelper::setTitle($department->name)->setDescription(Str::words($department->description, 120));

        $meta = new SeoOpenGraph;

        $meta->setDescription(strip_tags($department->description));
        $meta->setUrl($department->url);
        $meta->setTitle($department->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        return Theme::scope('department', compact('department'))->render();
    }
}
