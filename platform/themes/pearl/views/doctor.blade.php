<!--Page Title-->
<section class="page-title" style="background-image: url(/storage/images/background/8.jpg);">
    <div class="auto-container">
        <div class="title-outer">
            <h1>{{ $doctor->name }}</h1>
        </div>
    </div>
</section>
<!--End Page Title-->

<section class="doctor-detail-section">
    <div class="auto-container">
        <div class="row">
            <!-- Content Side -->
            <div class="content-side col-lg-8 col-md-12 col-sm-12 order-2">
                <div class="docter-detail">
                    <h3 class="name">{{ $doctor->name }}</h3>
                    <span class="designation">
                          @foreach($doctor->departments as $department)
                            {{ $department->name }} @if (!$loop->last) {{ ' , '}} @endif
                        @endforeach
                    </span>
                    <div class="text">
                        {{ $doctor->descripiton }}
                    </div>
                    <!-- <ul class="doctor-info-list">
                       <li>الخصائص هنا</li>
                    </ul> -->
                </div>
            </div>

            <!-- Sidebar Side -->
            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                <div class="sidebar">
                    <!-- Team Block -->
                    <div class="team-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="inner-box">
                            <figure class="image single"><img src="{{ RvMedia::getImageUrl($doctor->image, 'featured', false, RvMedia::getDefaultImage()) }}" alt="{{ $doctor->name }}"></figure>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{!! Theme::partial('appointment', ['backgroundColor' => '#216960'])  !!}
