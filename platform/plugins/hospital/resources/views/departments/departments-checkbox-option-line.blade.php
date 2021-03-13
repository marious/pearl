@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($departments)
    <ul>
        @foreach($departments as $department)
            @if($department->id != $currentId)
                <li value="{{ $department->id ?? '' }}"
                        {{ $department->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $department->id, $department->name, in_array($department->id, $value),
                        ]
                    ]) !!}
                    @include('plugins/hospital::departments.departments-checkbox-option-line', [
                        'departments' => $department->child_cats,
                        'value' => $value,
                        'currentId' => $currentId,
                        'name' => $name
                    ])
                </li>
            @endif
        @endforeach
    </ul>
@endif
