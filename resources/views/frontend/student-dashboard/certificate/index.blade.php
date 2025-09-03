<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Certificate') }}</title>
    <style>
        <?php $scale = 3; ?>
        body {
            font-family: 'Noto Sans Bengali','Noto Sans','Noto Sans Arabic', sans-serif; /* Keep as fallback */
        }
        @foreach ($certificateItems as $item)
            #{{ $item->element_id }} {
                left: {{ $item->x_position * $scale }}px;
                top: {{ $item->y_position * $scale }}px;
            }
        @endforeach

        @page {
            size: {{ 930 * $scale }}px {{ 600 * $scale }}px;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .certificate-body {
            width: {{ 930 * $scale }}px !important;
            height: {{ 600 * $scale }}px !important;
            background: rgb(231, 231, 231);
            position: relative;
        }

        .draggable-element {
            position: absolute;

        }

        #title {
            font-size: {{ 21 * $scale }}px;
            font-weight: bold;
            color: black;
            left: 50%;
            transform: translate(-50%);
            width: {{ 730 * $scale }}px;
            text-align: center;
        }

        #sub_title {
            font-size: {{ 16 * $scale }}px;
            color: black;
            text-align: inherit;
            font-weight: inherit;
            left: 50%;
            transform: translate(-50%);
            width: {{ 730 * $scale }}px;
            text-align: center;
        }

        #description {
            font-size: {{ 13 * $scale }}px;
            color: black;
            text-align: center;
            font-weight: inherit;
            width: {{ 730 * $scale }}px;
            left: 50%;
            transform: translate(-50%);
        }

        #signature img {
            width: {{ 155 * $scale }}px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="certificate-outer">
        <div class="certificate-body" @if($background_path) style="background-image: url('{{ $background_path }}')" @endif >
            @if ($certificate->title)
                <div id="title" class="draggable-element">{{ $certificate->title }}</div>
            @endif
            @if ($certificate->sub_title)
                <div id="sub_title" class="draggable-element">{{ $certificate->sub_title }}
                </div>
            @endif

            @if ($certificate->description)
                <div id="description" class="draggable-element">{!! clean(nl2br($certificate->description)) !!}
                </div>
            @endif

            @if ($signature_path)
                <div id="signature" class="draggable-element"><img
                        src="{{ $signature_path }}"
                        alt=""></div>
            @endif
        </div>
    </div>
</body>

</html>
