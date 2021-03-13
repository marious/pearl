@if (count($sliders) > 0)
<section class="banner-section-three">
    <div class="banner-carousel owl-carousel owl-theme default-arrows dark">
        <!-- Slide Item -->
        @foreach($sliders as $slider)
        <div class="slide-item" style="background-image: url({{RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage())}});">
            <div class="auto-container">
                <div class="content-outer">
                    <div class="content-box">
                        <span class="title">مستشفيات اللؤلؤة</span>
                        @if ($slider->title)
                        <h4>{{ $slider->title }}</h4>
                        @endif
                        <!-- <h2>Could Help <span>Your Life</span></h2> -->
                        @if ($slider->description)
                        <div class="text">
                           {{ $slider->description }}
                        </div>
                        @endif
                        <div class="btn-box"><a href="#" class="theme-btn btn-style-one bg-kellygreen"><span class="btn-title">إكتشف المزيد</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        <!-- End Slide Item -->
    </div>
{{--    </div>--}}
</section>
@endif
