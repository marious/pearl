<script id="counter_template" type="text/x-custom-template">
    <li data-id="__id__" class="clearfix">
        <div class="swatch-name">
            <input type="text" class="form-control" value="__name__">
        </div>
        <div class="swatch-count">
            <input type="number" class="form-control" value="__count__">
        </div>
        <div class="swatch-order">
            <input type="number" class="form-control" value="__order_">
        </div>

        <div class="remove-item"><a href="#" class="font-red"><i class="fa fa-trash"></i></a></div>
    </li>
</script>
<textarea name="counters" id="counters" class="hidden">{!! json_encode($counters) !!}</textarea>
<textarea name="deleted_counters" id="deleted_counters" class="hidden"></textarea>
<div class="swatches-container">
    <div class="header clearfix">
        <div class="swatch-name">
            {{ __('name') }}
        </div>

        <div class="swatch-count">
            {{ __('count') }}
        </div>
        <div class="swatch-order">
            {{ __('order') }}
        </div>
        <div class="remove-item">{{ __('Remove') }}</div>
    </div>
    <ul class="swatches-list">
        @if (count($counters) > 0)
        @foreach($counters as $counter)
        <li data-id="{{ $counter['id'] }}" class="clearfix">

            <div class="swatch-name">
                <input type="text" class="form-control" value="{{ $counter['name'] }}">
            </div>
            <div class="swatch-count">
                <input type="number" class="form-control" value="{{ $counter['count'] }}">
            </div>
            <div class="swatch-order">
                <input type="number" class="form-control" value="{{ $counter['order'] }}">
            </div>

            <div class="remove-item"><a href="#" class="font-red"><i class="fa fa-trash"></i></a></div>
        </li>
        @endforeach
        @endif
    </ul>
    <button type="button" class="btn purple js-add-new-counter">{{ __('Add new counter') }}</button>
</div>
