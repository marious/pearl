<?php

namespace Botble\News\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\News\Http\Requests\NewsRequest;
use Botble\News\Repositories\Interfaces\NewsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\News\Tables\NewsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\News\Forms\NewsForm;
use Botble\Base\Forms\FormBuilder;

class NewsController extends BaseController
{
    /**
     * @var NewsInterface
     */
    protected $newsRepository;

    /**
     * @param NewsInterface $newsRepository
     */
    public function __construct(NewsInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param NewsTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(NewsTable $table)
    {
        page_title()->setTitle(trans('plugins/news::news.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/news::news.create'));

        return $formBuilder->create(NewsForm::class)->renderForm();
    }

    /**
     * @param NewsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(NewsRequest $request, BaseHttpResponse $response)
    {
        $news = $this->newsRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(NEWS_MODULE_SCREEN_NAME, $request, $news));

        return $response
            ->setPreviousUrl(route('news.index'))
            ->setNextUrl(route('news.edit', $news->id))
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
        $news = $this->newsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $news));

        page_title()->setTitle(trans('plugins/news::news.edit') . ' "' . $news->name . '"');

        return $formBuilder->create(NewsForm::class, ['model' => $news])->renderForm();
    }

    /**
     * @param $id
     * @param NewsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, NewsRequest $request, BaseHttpResponse $response)
    {
        $news = $this->newsRepository->findOrFail($id);

        $news->fill($request->input());

        $this->newsRepository->createOrUpdate($news);

        event(new UpdatedContentEvent(NEWS_MODULE_SCREEN_NAME, $request, $news));

        return $response
            ->setPreviousUrl(route('news.index'))
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
            $news = $this->newsRepository->findOrFail($id);

            $this->newsRepository->delete($news);

            event(new DeletedContentEvent(NEWS_MODULE_SCREEN_NAME, $request, $news));

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
            $news = $this->newsRepository->findOrFail($id);
            $this->newsRepository->delete($news);
            event(new DeletedContentEvent(NEWS_MODULE_SCREEN_NAME, $request, $news));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
