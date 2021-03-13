<?php

use Botble\Team\Repositories\Interfaces\TeamInterface;

if (!function_exists('get_latest_members')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_members($limit, $excepts = [])
    {
        return app(TeamInterface::class)->getListMemberNonInList($excepts, $limit);
    }
}
?>