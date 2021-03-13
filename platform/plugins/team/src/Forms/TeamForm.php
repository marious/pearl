<?php

namespace Botble\Team\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Team\Http\Requests\TeamRequest;
use Botble\Team\Models\Team;

class TeamForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Team)
            ->setValidatorClass(TeamRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('position', 'text', [
                'label'      => trans('Position'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('Position'),
                    'data-counter' => 120,
                ],
            ])
            ->add('quote', 'textarea', [
                'label'      => trans('Quote'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('Quote'),
                    'data-counter' => 400,
                ],
            ])
            ->add('facebook', 'text', [
                'label'      => trans('Facebook'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('http://facebook.com/...'),
                    'data-counter' => 120,
                ],
            ])
            ->add('linkedin', 'text', [
                'label'      => trans('Linkedin'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('Linkedin'),
                    'data-counter' => 120,
                ],
            ])
            ->add('dribbble', 'text', [
                'label'      => trans('Dribbble'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('Dribbble'),
                    'data-counter' => 120,
                ],
            ])
            ->add('information', 'editor', [
                'label'      => trans('Information'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('Information...'),
                    'with-short-code' => true,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
