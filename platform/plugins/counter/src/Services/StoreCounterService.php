<?php
namespace Botble\Counter\Services;

use Botble\Counter\Models\Counter;
use Botble\Counter\Repositories\Interfaces\CounterInterface;
use Botble\Counter\Repositories\Interfaces\CounterItemInterface;
use Illuminate\Http\Request;

class StoreCounterService
{
    protected $counterRepository;

    protected $counterItemRepository;

    public function __construct(CounterInterface $counterRepository, CounterItemInterface $counterItemRepository)
    {
        $this->counterRepository = $counterRepository;
        $this->counterItemRepository = $counterItemRepository;
    }


    public function execute(Request $request, Counter $counter)
    {
        $data = $request->input();
        $counter->fill($data);
        $counter = $this->counterRepository->createOrUpdate($counter);

        $items = json_decode($request->get('counters', []), true) ?: [];
        $deletedItems = json_decode($request->get('deleted_counters', []), true) ?: [];

        $this->deleteCounterItem($counter->id, $deletedItems);
        $this->storeCounterItems($counter->id, $items);

        return $counter;
    }


    protected function deleteCounterItem($counterId, array $counterItemIds)
    {
        foreach ($counterItemIds as $id) {
            $this->counterItemRepository->deleteBy([
                'id' => $id,
                'counter_id' => $counterId
            ]);
        }
    }


    protected function storeCounterItems($counterId, array $counters)
    {
        foreach ($counters as $item) {
            if (isset($item['id'])) {
                $counter = $this->counterItemRepository->findById($item['id']);
                if (!$counter) {
                    $item['counter_id'] = $counterId;
                    $this->counterItemRepository->create($item);
                } else {
                    $counter->fill($item);
                    $this->counterItemRepository->createOrUpdate($counter);
                }
            }
        }
    }
}
