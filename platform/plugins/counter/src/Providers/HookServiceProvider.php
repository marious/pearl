<?php

namespace Botble\Counter\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Counter\Repositories\Interfaces\CounterInterface;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Illuminate\Support\ServiceProvider;
use Theme;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            if (!$this->app->isDownForMaintenance()) {
                if (function_exists('shortcode')) {
                    add_shortcode('counter',
                    trans('plugins/counter::counter.counter_shortcode_name'),
                    trans('plugins/counter::counter.counter_shortcode_description'),
                    [$this, 'render']
                    );
                }
            }

        });
    }

    public function render($shortcode)
    {
        $counter = $this->app->make(CounterInterface::class)->getFirstBy([
            'key' => $shortcode->key,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        if (empty($counter)) {
            return null;
        }

        return view(apply_filters(COUNTER_VIEW_TEMPLATE, 'plugins/simple-slider::sliders'), ['counters' => $counter->counters]);

    }
}
