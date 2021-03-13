<?php
namespace Botble\Service\Http\Controllers;

use Botble\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Service\Models\BusinessSolutions;
use Theme;
use Botble\Service\Services\BusinessSolutionsService;

/**
 * 
 */
class PublicController extends BaseController
{
	public function getBySlug($slug, \Botble\Slug\Repositories\Interfaces\SlugInterface $slugRepository)
	{
	    $slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => BusinessSolutions::class]);
	    if (!$slug) {
	        abort(404);
	    }
	    $data = app(BusinessSolutionsInterface::class)->getFirstById($slug->reference_id);

	    if (!$data) {
	        abort(404);
	    }
	    Theme::breadcrumb()->add('Services', '')->add('Business Solutions', 'http:...')->add($data->name);
	    do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, SERVICE_MODULE_SCREEN_NAME, $data);
	    return Theme::scope('service', compact('data'))->render();
	}

	public function getServiceBySlug($slug, BusinessSolutionsService $businessSolutionsService, \Botble\Slug\Repositories\Interfaces\SlugInterface $slugRepository)
	{
		$slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => BusinessSolutions::class]);
	    if (!$slug) {
	        abort(404);
	    }
	    $data = $businessSolutionsService->handleFrontRoutes($slug);
	    //var_dump($data);
	    return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
	}
}
?>