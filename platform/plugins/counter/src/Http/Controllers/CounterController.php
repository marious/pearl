<?php

namespace Botble\Counter\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Counter\Http\Requests\CounterRequest;
use Botble\Counter\Repositories\Interfaces\CounterInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Counter\Services\StoreCounterService;
use Illuminate\Http\Request;
use Exception;
use Botble\Counter\Tables\CounterTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Counter\Forms\CounterForm;
use Botble\Base\Forms\FormBuilder;
use Assets;

class CounterController extends BaseController
{
    /**
     * @var CounterInterface
     */
    protected $counterRepository;

    /**
     * @param CounterInterface $counterRepository
     */
    public function __construct(CounterInterface $counterRepository)
    {
        $this->counterRepository = $counterRepository;
    }

    /**
     * @param CounterTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CounterTable $table)
    {
        page_title()->setTitle(trans('plugins/counter::counter.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/counter::counter.create'));

        Assets::addScripts(['spectrum', 'jquery-ui'])
            ->addStylesDirectly([
                asset('vendor/core/plugins/counter/css/counter.css'),
            ])
            ->addScriptsDirectly([
                asset('vendor/core/plugins/counter/js/counter.js'),
            ]);

        return $formBuilder->create(CounterForm::class)->renderForm();
    }

    /**
     * @param CounterRequest $request
     * @param StoreCounterService $service
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CounterRequest $request, StoreCounterService $service, BaseHttpResponse $response)
    {
        $counter = $this->counterRepository->getModel();
        $counter = $service->execute($request, $counter);

//        event(new CreatedContentEvent(COUNTER_MODULE_SCREEN_NAME, $request, $counter));

        return $response
            ->setPreviousUrl(route('counter.index'))
            ->setNextUrl(route('counter.edit', $counter->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $counter = $this->counterRepository->findOrFail($id);

        page_title()->setTitle(trans('plugins/counter::counter.edit') . ' "' . $counter->name . '"');

//        event(new BeforeEditContentEvent($request, $counter));

        Assets::addScripts(['spectrum', 'jquery-ui'])
            ->addStylesDirectly([
                asset('vendor/core/plugins/counter/css/counter.css'),
            ])
            ->addScriptsDirectly([
                asset('vendor/core/plugins/counter/js/counter.js'),
            ]);

        return $formBuilder->create(CounterForm::class, ['model' => $counter])->renderForm();
    }

    /**
     * @param $id
     * @param CounterRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CounterRequest $request, StoreCounterService $service, BaseHttpResponse $response)
    {
        $counter = $this->counterRepository->findOrFail($id);

        $service->execute($request, $counter);

//        event(new UpdatedContentEvent(COUNTER_MODULE_SCREEN_NAME, $request, $counter));

        return $response
            ->setPreviousUrl(route('counter.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $counter = $this->counterRepository->findOrFail($id);

            $this->counterRepository->delete($counter);

//            event(new DeletedContentEvent(COUNTER_MODULE_SCREEN_NAME, $request, $counter));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $counter = $this->counterRepository->findOrFail($id);
            $this->counterRepository->delete($counter);
//            event(new DeletedContentEvent(COUNTER_MODULE_SCREEN_NAME, $request, $counter));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
