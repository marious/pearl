<?php
namespace Botble\Hospital\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Hospital\Events\SendAppointmentEvent;
use Botble\Hospital\Http\Requests\AppointmentPublicRequest;
use Botble\Hospital\Repositories\Interfaces\AppointmentInterface;
use EmailHandler;

class PublicController extends Controller
{
    protected $appointmentRepository;

    public function __construct(AppointmentInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function postSendAppointment(AppointmentPublicRequest $request, BaseHttpResponse $response)
    {
        try {
          $appointment = $this->appointmentRepository->getModel();
          $appointment->fill($request->input());
          $this->appointmentRepository->createOrUpdate($appointment);

          event(new SendAppointmentEvent($appointment));

          EmailHandler::setModule(HOSPITAL_Appointment_MODULE_SCREEN_NAME)
          ->setVariableValues([
              'appointment_name'    => $appointment->name ?? 'N/A',
              'appointment_department' => $appointment->department->name ?? 'N/A',
              'appointment_email'   => $appointment->email ?? 'N/A',
              'appointment_phone'   => $appointment->phone ?? 'N/A',
              'appointment_content' => $appointment->message ?? 'N/A',
          ])
          ->sendUsingTemplate('notice');

      return $response->setMessage(__('تم إرسال رسالتك بنجاح'));

        } catch (Exception $e) {
          info($e->getMessage());
          return $response
              ->setError()
              ->setMessage('حدث خطأ برجاء المحاولة فى وقت لاحق');
              // ->setMessage(trans('plugins/contact::contact.email.failed'));
        }
    }
}