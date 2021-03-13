<!--Page Title-->
<section class="page-title" style="background-image: url(/storage/images/background/8.jpg);">
    <div class="auto-container">
        <div class="title-outer">
           <h1>{{ $department->name }}</h1>
        </div>
    </div>
</section>
<!--End Page Title-->

<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">

            <!--Content Side / Our Blog-->
            <div class="content-side col-xl-9 col-lg-8 col-md-12 col-sm-12 order-2">
                <div class="service-detail">
                    <div class="images-box">
                        <figure class="image wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;"><a href="/storage/images/resource/service-single.jpg" class="lightbox-image" data-fancybox="services"><img src="images/resource/service-single.jpg" alt=""></a></figure>
                    </div>

                    <div class="content-box">
                        <div class="title-box">
                            <h2>{{ $department->name }}</h2>
                            <span class="theme_color"></span>
                        </div>

                        {{ $department->description }}



                    </div>
                </div>
            </div>

            <!--Sidebar Side-->
            <div class="sidebar-side col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <aside class="sidebar services-sidebar">

                    <!-- Category Widget -->
                    <div class="sidebar-widget categories">
                        <div class="widget-content">
                            <!-- Services Category -->
                            <ul class="services-categories">
                                <li><a href="{{ route('public.departments') }}">كل الأقسام</a></li>
                                <li><a href="department-detail.html">الأشعة</a></li>
                                <li class="active"><a href="department-detail.html">النساء والتوليد</a></li>
                                <li><a href="department-detail.html">الجراحة</a></li>
                                <li><a href="department-detail.html">الأطفال</a></li>
                                <li><a href="department-detail.html">التحاليل</a></li>
                                <li><a href="department-detail.html">الباطنة</a></li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
