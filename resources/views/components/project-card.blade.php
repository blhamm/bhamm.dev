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
            @if ($modal)
                <flux:modal.trigger name="{{ $modal }}">
                    <flux:button
                        variant="primary"
                        class="bg-pale-night-black/10 text-pale-night-black/70 dark:bg-white/10 dark:text-white/70 hover:bg-pale-night-black/40 hover:text-pale-night-white dark:hover:bg-white/40 my-6 cursor-pointer rounded-4xl transition-colors"
                    >
                        <flux:icon.plus-circle variant="mini" />
                        {{ $buttonText }}
                    </flux:button>
                </flux:modal.trigger>
            @else
                <flux:button
                    href="{{ $href }}"
                    variant="primary"
                    class="bg-pale-night-black/10 text-pale-night-black/70 dark:bg-white/10 dark:text-white/70 hover:bg-pale-night-black/40 hover:text-pale-night-white dark:hover:bg-white/40 my-6 cursor-pointer rounded-4xl transition-colors"
                >
                    <flux:icon.plus-circle variant="mini" />
                    {{ $buttonText }}
                </flux:button>
            @endif
        @endif
    </x-card>
</div>
