<?php

namespace Botble\Service\Providers;

use Botble\Service\Models\Service;
use Botble\Service\Models\BusinessSolutions;
use Illuminate\Support\ServiceProvider;
use Botble\Service\Repositories\Caches\ServiceCacheDecorator;
use Botble\Service\Repositories\Eloquent\ServiceRepository;
use Botble\Service\Repositories\Interfaces\ServiceInterface;
use Botble\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use Botble\Service\Repositories\Caches\BusinessSolutionsCacheDecorator;
use Botble\Service\Repositories\Eloquent\BusinessSolutionsRepository;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use SlugHelper;

class ServiceServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ServiceInterface::class, function () {
            return new ServiceCacheDecorator(new ServiceRepository(new Service));
        });
        $this->app->bind(BusinessSolutionsInterface::class, function () {
            return new BusinessSolutionsCacheDecorator(new BusinessSolutionsRepository(new BusinessSolutions));
        });
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        SlugHelper::registerModule(BusinessSolutions::class);
        SlugHelper::setPrefix(BusinessSolutions::class, 'business-solutions');

        $this->setNamespace('plugins/service')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Service::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-service',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/service::service.name',
                'icon'        => 'fa fa-list',
                'url'         => route('service.index'),
                'permissions' => ['service.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-service-service',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-service',
                'name'        => 'Service',
                'icon'        => null,
                'url'         => route('service.index'),
                'permissions' => ['service.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-service-business-solutions',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-service',
                'name'        => 'Business solutions',
                'icon'        => null,
                'url'         => route('business-solutions.index'),
                'permissions' => ['service.index'],
            ]);
        });
    }
}
