<?php

namespace Botble\Counter\Providers;

use Botble\Counter\Models\Counter;
use Botble\Counter\Models\CounterItem;
use Botble\Counter\Repositories\Caches\CounterItemCacheDecorator;
use Botble\Counter\Repositories\Eloquent\CounterItemRepository;
use Botble\Counter\Repositories\Interfaces\CounterItemInterface;
use Illuminate\Support\ServiceProvider;
use Botble\Counter\Repositories\Caches\CounterCacheDecorator;
use Botble\Counter\Repositories\Eloquent\CounterRepository;
use Botble\Counter\Repositories\Interfaces\CounterInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class CounterServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(CounterInterface::class, function () {
            return new CounterCacheDecorator(new CounterRepository(new Counter));
        });

        $this->app->bind(CounterItemInterface::class, function () {
            return new CounterItemCacheDecorator(new CounterItemRepository(new CounterItem));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/counter')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {


            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-counter',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/counter::counter.name',
                'icon'        => 'fa fa-list',
                'url'         => route('counter.index'),
                'permissions' => ['counter.index'],
            ]);
        });

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Counter::class]);
            }
            $this->app->register(HookServiceProvider::class);
        });
    }
}
