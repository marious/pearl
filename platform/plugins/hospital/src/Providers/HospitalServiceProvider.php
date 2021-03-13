<?php
namespace Botble\Hospital\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Carbon\Laravel\ServiceProvider;
use Botble\Base\Supports\Helper;
use Botble\Hospital\Models\Appointment;
use Botble\Hospital\Models\Department;
use Botble\Hospital\Models\Doctor;
use Botble\Hospital\Repositories\Caches\AppointmentCacheDecorator;
use Botble\Hospital\Repositories\Caches\DepartmentCacheDecorator;
use Botble\Hospital\Repositories\Caches\DoctorCacheDecorator;
use Botble\Hospital\Repositories\Eloquent\AppointmentRepository;
use Botble\Hospital\Repositories\Eloquent\DepartmentRepository;
use Botble\Hospital\Repositories\Eloquent\DoctorRepository;
use Botble\Hospital\Repositories\Interfaces\AppointmentInterface;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use SlugHelper;
use EmailHandler;

class HospitalServiceProvider extends ServiceProvider
{

    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(DepartmentInterface::class, function () {
            return new DepartmentCacheDecorator(new DepartmentRepository(new Department));
        });

        $this->app->bind(DoctorInterface::class, function () {
            return new DoctorCacheDecorator(new DoctorRepository(new Doctor));
        });

        $this->app->bind(AppointmentInterface::class, function () {
            return new AppointmentCacheDecorator(new AppointmentRepository(new Appointment));
        });


        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        SlugHelper::registerModule(Doctor::class, 'Hospital Doctors');
        SlugHelper::registerModule(Department::class, 'Hospital Departments');
        SlugHelper::setPrefix(Doctor::class, 'doctors');
        SlugHelper::setPrefix(Department::class, 'departments');

        $this->setNamespace('plugins/hospital')
            ->loadAndPublishConfigurations(['permissions', 'general', 'email'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {

            dashboard_menu()->registerItem([
                'id'    => 'cms-plugins-hospital',
                'priority' => 6,
                'parent_id' => null,
                'name' => 'plugins/hospital::hospital.hospital',
                'icon' => 'fa fa-hospital',
                'url' => '',
                'permissions' => ['departments.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 1,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.departments',
                'icon'          => '',
                'url'           => route('departments.index'),
                'permissions'   => ['departments.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 2,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.doctors',
                'icon'          => '',
                'url'           => route('doctors.index'),
                'permissions'   => ['doctors.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 3,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.appointments',
                'icon'          => '',
                'url'           => route('appointments.index'),
                'permissions'   => ['appointments.index'],
            ]);

            EmailHandler::addTemplateSettings(HOSPITAL_Appointment_MODULE_SCREEN_NAME, config('plugins.hospital.email'));

        });
    }
}
