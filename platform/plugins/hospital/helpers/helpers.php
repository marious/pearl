<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Botble\Base\Supports\SortItemsWithChildrenHelper;
use Illuminate\Support\Arr;


if (!function_exists('get_departments_id')) {
    function get_departments_id()
    {
        return app(DepartmentInterface::class)->get_departments_id();
    }
}

if (!function_exists('get_all_departments')) {
    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    function get_all_departments(array $condition = [], $with = [])
    {
        return app(DepartmentInterface::class)->getAllDepartments($condition, $with);
    }
}

if (!function_exists('get_departments_for_front')) {
    function get_departments_for_front($limit) {
        return app(DepartmentInterface::class)->getDepartmentsFroFront($limit);
    }
}

if (!function_exists('get_department_by_id')) {
    /**
     * @param integer $id
     * @return array
     */
    function get_department_by_id($id)
    {
        return app(DepartmentInterface::class)->getDepartmentById($id);
    }
}

if (!function_exists('get_departments')) {

    function get_departments(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '--');
        $repo = app(DepartmentInterface::class);

        $departments = $repo->getDepartments(Arr::get($args, 'select', ['*']), [
            'hs_departments.created_at' => 'DESC',
            'hs_departments.is_default' => 'DESC',
            'hs_departments.order'      => 'ASC',
        ]);

        $departments = sort_item_with_children($departments);

        foreach ($departments as $department) {
            $indentText = '';
            $depth = (int)$department->depth;
            for ($index = 0; $index < $depth; $index++) {
                $indentText .= $indent;
            }
            $department->indent_text = $indentText;
        }

        return $departments;
    }
}

if (!function_exists('get_departments_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_departments_with_children()
    {
        $departments = app(DepartmentInterface::class)
            ->getAllDepartmentsWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($departments);

        return $sortHelper->sort();
    }
}


if (!function_exists('get_featured_doctors')) {

    function get_featured_doctors($limit) {
        return app(DoctorInterface::class)->getFeatured($limit);
    }
}

if (!function_exists('get_all_doctors')) {
    function get_all_doctors($limit = 20, $active = true, $with = []) {
        return app(DoctorInterface::class)->getAllDoctors($limit, $active, $with);
    }
}
