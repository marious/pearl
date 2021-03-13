<?php
namespace Botble\Hospital;

use Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('hs_departments');
        Schema::dropIfExists('hs_doctors');
        Schema::dropIfExists('hs_appointments');
        Schema::dropIfExists('hs_doctor_departments');
    }
}
