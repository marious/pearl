<?php

namespace Botble\Counter;

use Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('counters');
        Schema::dropIfExists('counter_items');
    }
}
