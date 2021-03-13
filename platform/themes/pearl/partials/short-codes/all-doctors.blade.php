<section class="page-title" style="background-image: url(storage/images/background/8.jpg);">
    <div class="auto-container">
        <div class="title-outer">
            <h1>الفريق الطبى</h1>
        </div>
    </div>
</section>

@php
$doctors = get_all_doctors(20, true, ['departments']);

@endphp
@if (!empty($doctors))
<section class="team-section-two alternate alternate2">
    <div class="auto-container">
        <div class="row">
            @foreach($doctors as $doctor)
            <!-- Team Block -->
            <div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                <div class="inner-box">
                    <div class="image-box">
                        <a href="{{ $doctor->url }}">
                            <figure class="image"><img src="{{ RvMedia::getImageUrl($doctor->image, 'featured', false, RvMedia::getDefaultImage()) }}" alt="{{ $doctor->name }}"></figure>
                        </a>
                    </div>
                    <div class="info-box">
                        <h5 class="name"><a href="doctor-detail.html">{{ $doctor->name }}</a></h5>
                        <span class="designation">
                            @foreach($doctor->departments as $department)
                                {{ $department->name }} @if (!$loop->last) {{ ' , '}} @endif
                            @endforeach
                        </span>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
    </div>
</section>
@endif
