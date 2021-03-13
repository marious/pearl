<?php
    use Botble\News\Repositories\Interfaces\NewsInterface;
	if (!function_exists('get_latest_news')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_news($limit, $excepts = [])
    {
        return app(NewsInterface::class)->getListNewsNonInList($excepts, $limit);
    }
}
?>