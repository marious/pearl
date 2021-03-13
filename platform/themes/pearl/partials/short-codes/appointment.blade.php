@php
$departments = get_all_departments(['parent_id' => 0]);
@endphp
<!-- Appointment Section -->
<section class="appointment-section">
    <h2>الحجز أونلاين</h2>
    <p>
        بمكنك الان الحجز اونلاين عن طريق ملىء الاستمارة بالاسفل وسيتم التواصل معك فى الحال
    </p>
    <div class="auto-container">
        <div class="outer-box">
            <div class="contact-form-two wow fadeInUp">
                {!! Form::open(['route' => 'public.send.appointment', 'method' => 'POST', 'class' => 'appointment-form']) !!}

                <div class="form-group">
                    <div class="appointment-message appointment-success-message alert alert-success" style="display: none;"></div>
                    <div class="appointment-message appointment-error-message alert alert-danger" style="display: none;"></div>
                </div>

                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="text" name="name" placeholder="الاسم" required value="{{ old('name') }}">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="tel" name="phone" placeholder="الهاتف" required value="{{ old('phone') }}">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="email" name="email" placeholder="البريد الالكترونى" required value="{{ old('email') }}"> 
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <select name="department" id="departments" required>
                                <option value="default" selected disabled>اختر القسم</option>
                                @if (count($departments))
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="date" name="date" placeholder="dd-mm-yyyy" required="" value="{{ old('date') }}">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <textarea name="message" placeholder="أضف رسالة" required="">{{ old('message') }}</textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <button class="btn btn-style" type="submit" name="submit-form"><span class="btn-title">إرسال </span></button>
                        </div>

                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<!-- End Appointment -->
