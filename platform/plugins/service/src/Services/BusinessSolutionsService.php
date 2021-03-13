<?php
namespace Botble\Service\Services;

use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Eloquent;
use Botble\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use Botble\SeoHelper\SeoOpenGraph;
use Theme;
/**
 * 
 */
class BusinessSolutionsService
{
	public function handleFrontRoutes($slug)
	{
		if (!$slug instanceof Eloquent) {
            return $slug;
        }

        $condition = [
            'id'     => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check() && request()->input('preview')) {
            Arr::forget($condition, 'status');
        }

        $data = app(BusinessSolutionsInterface::class)->getFirstBy($condition, ['*'],['slugable']);

        if (empty($data)) {
            abort(404);
        }

        $data->slugable = $slug;

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, SERVICE_MODULE_SCREEN_NAME, $data);

        Theme::breadcrumb()->add('Services', '')->add('Business Solutions', 'http:...')->add($data->name);
        return [
            'view'         => 'services-details',
            'default_view' => 'plugins/blog::themes.service',
            'data'         => compact('data'),
            'slug'         => $data->slug,
        ];
	}
}

?>