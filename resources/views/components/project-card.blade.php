@props([
    'title',
    'description',
    'tags' => [],
    'image' => null,
    'href' => '#',
    'buttonText' => 'Learn More',
    'size' => 'w-64 md:w-sm',
    'modal' => null,
    'titleClass' => null,
    'buttonClass' => null,
])

<div class="snap-start shrink-0 {{ $size }}">
    <x-card>
        @if ($image)
            <x-slot name="background">
                <x-media :src="$image" :alt="$title" />
            </x-slot>
        @elseif (isset($animation))
            <x-slot name="background">
                {{ $animation }}
            </x-slot>
        @endif

        @if (! empty($tags))
            <x-slot name="tags">
                @foreach ($tags as $tag)
                    <x-tag>{{ $tag }}</x-tag>
                @endforeach
            </x-slot>
        @endif

        <x-slot name="title">
            <h3 class="mt-4 text-xl leading-tight font-bold {{ $titleClass ?? 'text-pale-night-black dark:text-pale-night-white' }}">{{ $title }}</h3>
        </x-slot>

        <x-slot name="description">
            <div class="text-pale-night-black dark:text-pale-night-white font-medium md:text-lg">{{ $description }}</div>
        </x-slot>

        @if ($buttonText)
            @php
                $btnClasses = "bg-pale-night-black/5 text-pale-night-black dark:bg-white/5 dark:text-pale-night-white my-6 ring-pale-night-black/10 dark:ring-white/20 hover:ring-transparent " . ($buttonClass ?? '');
            @endphp
            @if ($modal)
                <flux:modal.trigger name="{{ $modal }}">
                    <x-button class="{{ $btnClasses }}">
                        <flux:icon.plus-circle variant="outline" class="mr-2 size-4" />
                        {{ $buttonText }}
                    </x-button>
                </flux:modal.trigger>
            @else
                <x-button
                    href="{{ $href }}"
                    class="{{ $btnClasses }}"
                >
                    <flux:icon.plus-circle variant="outline" class="mr-2 size-4" />
                    {{ $buttonText }}
                </x-button>
            @endif
        @endif
    </x-card>
</div>
