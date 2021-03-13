<?php

namespace Botble\Team\Providers;

use Botble\Team\Models\Team;
use Illuminate\Support\ServiceProvider;
use Botble\Team\Repositories\Caches\TeamCacheDecorator;
use Botble\Team\Repositories\Eloquent\TeamRepository;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class TeamServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(TeamInterface::class, function () {
            return new TeamCacheDecorator(new TeamRepository(new Team));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/team')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Team::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-team',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/team::team.name',
                'icon'        => 'fa fa-list',
                'url'         => route('team.index'),
                'permissions' => ['team.index'],
            ]);
        });
    }
}
