@props(['data', 'style' => 'advanced'])
@if ($style === 'advanced')
    @dump($data)
@else
    <pre>
        @php
            print_r($data);
        @endphp
    </pre>
@endif
