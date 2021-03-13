@if (is_plugin_active('hospital'))
  @php
      $featured = get_featured_doctors(4);
      $featuredList = [];
      if (!empty($featured)) {
        $featuredList = $featured->pluck('id')->all();
      }
  @endphp
  @if (!empty($featured))
<section class="team">
    <div class="auto-container">
        <div class="outer-box">
            <h2>الفريق الطبى</h2>
       <div class="row">
      @foreach ($featured as $featureItem)

              <div class="col-lg-3 col-md-6">
                  <div class="team-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                      <div class="inner-box">
                          <a href="{{ $featureItem->url }}">
                              <figure class="image"><img src="{{ RvMedia::getImageUrl($featureItem->image, 'featured', false, RvMedia::getDefaultImage()) }}" alt="{{ $featureItem->name }}"></figure>
                          </a>
                      </div>
                  </div>
              </div>

      @endforeach
       </div>
            <div class="more-team"><a href="{{ url('doctors') }}">المزيد</a></div>
        </div>
    </div>
</section>
  @endif
@endif
