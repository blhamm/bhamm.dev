<div {{ $attributes->merge(['class' => 'dot-matrix-container absolute inset-0 pointer-events-none overflow-hidden']) }}>
    <canvas id="dot-matrix-canvas" class="w-full h-full"></canvas>
</div>

<style>
    .dot-matrix-container {
        mask-image: radial-gradient(ellipse at center, black 40%, transparent 90%);
        -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 90%);
    }
</style>
