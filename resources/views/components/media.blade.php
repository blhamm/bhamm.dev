@props([
    'src' => null,
    'srcset' => null,
    'alt' => '',
    'type' => 'image', // 'image' or 'video'
    'poster' => null,
    'class' => '',
])

@php
    use Illuminate\Support\Facades\Image;
    use Illuminate\Support\Facades\File;

    $width = null;
    $height = null;

    if ($type === 'image' && $src && !str_starts_with($src, 'http')) {
        $fullPath = public_path($src);
        if (File::exists($fullPath)) {
            try {
                $img = Image::fromPath($fullPath);
                $width = $img->width();
                $height = $img->height();
            } catch (\Exception $e) {
                // Fail silently if image cannot be read
            }
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'w-full h-full overflow-hidden ' . $class]) }}>
    @if ($type === 'image')
        <img
            src="{{ $src }}"
            @if ($srcset) srcset="{{ $srcset }}" @endif
            alt="{{ $alt }}"
            @if ($width) width="{{ $width }}" @endif
            @if ($height) height="{{ $height }}" @endif
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
