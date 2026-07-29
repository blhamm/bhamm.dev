@props([
    'src' => null,
    'srcset' => null,
    'alt' => '',
    'type' => 'image', // 'image' or 'video'
    'poster' => null,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'w-full h-full overflow-hidden ' . $class]) }}>
    @if ($type === 'image')
        <img
            src="{{ $src }}"
            @if ($srcset) srcset="{{ $srcset }}" @endif
            alt="{{ $alt }}"
            class="h-full w-full object-cover"
            loading="lazy"
        />
    @elseif ($type === 'video')
        <video
            src="{{ $src }}"
            @if ($poster) poster="{{ $poster }}" @endif
            class="h-full w-full object-cover"
            autoplay
            muted
            loop
            playsinline
        ></video>
    @endif
</div>
