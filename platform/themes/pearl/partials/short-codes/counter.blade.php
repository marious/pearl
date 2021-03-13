@if (count($counters) > 0)
<section class="counter-section">
    <div class="auto-container">
        <div class="outer-box">
            <div class="row">
                @foreach($counters as $counter)
                <div class="col-lg-3 col-md-6">
                    <div class="counter">
                        <div class="counter-num count-box">
                            <span class="count-text" data-speed="3000" data-stop="{{ $counter->count }}">0</span>
                        </div>
                        <div class="counter-text">
                            <h3>
                                {{ $counter->name  }}
                            </h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
