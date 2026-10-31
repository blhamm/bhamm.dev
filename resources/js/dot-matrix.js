export function initDotMatrix() {
    const canvas = document.getElementById('dot-matrix-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = 0, height = 0;
    let dots = [];
    const spacing = 18;
    const colors = ['#c3e88d', '#ffcb6b', '#f07178', '#82aaff', '#c792ea', '#89ddff'];
    let waves = [];
    let isVisible = false;
    let animFrameId = null;
    let waveTimeoutId = null;

    function resize() {
        const parent = canvas.parentNode;
        if (!parent) return;
        const rect = parent.getBoundingClientRect();
        if (rect.width === 0 || rect.height === 0) return;
        width = canvas.width = Math.floor(rect.width);
        height = canvas.height = Math.floor(rect.height);
        initDots();
        renderStaticGrid();
    }

    function initDots() {
        dots = [];
        for (let x = spacing / 2; x < width; x += spacing) {
            for (let y = spacing / 2; y < height; y += spacing) {
                dots.push({
                    x: x + (Math.random() - 0.5) * 1.5,
                    y: y + (Math.random() - 0.5) * 1.5,
                    baseRadius: 0.8 + Math.random() * 0.3,
                });
            }
        }
    }

    function triggerWave() {
        if (isVisible && width > 0 && height > 0) {
            waves.push({
                x: Math.random() * width,
                y: Math.random() * height,
                color: colors[Math.floor(Math.random() * colors.length)],
                startTime: performance.now(),
                duration: 2500,
                speed: 380,
                thickness: 180
            });
            startAnimationLoop();
        }
        waveTimeoutId = setTimeout(triggerWave, 3000 + Math.random() * 3000);
    }

    function renderStaticGrid() {
        if (!ctx || width === 0 || height === 0) return;
        ctx.clearRect(0, 0, width, height);
        const isDark = document.documentElement.classList.contains('dark');
        const baseColor = isDark ? 'rgba(130, 170, 255, 0.2)' : 'rgba(41, 45, 62, 0.25)';

        ctx.fillStyle = baseColor;
        ctx.beginPath();
        for (let i = 0; i < dots.length; i++) {
            const dot = dots[i];
            ctx.moveTo(dot.x + dot.baseRadius, dot.y);
            ctx.arc(dot.x, dot.y, dot.baseRadius, 0, Math.PI * 2);
        }
        ctx.fill();
    }

    function draw() {
        if (!isVisible) {
            animFrameId = null;
            return;
        }

        const now = performance.now();
        waves = waves.filter(w => now - w.startTime < w.duration);

        if (waves.length === 0) {
            renderStaticGrid();
            animFrameId = null;
            return;
        }

        ctx.clearRect(0, 0, width, height);
        const isDark = document.documentElement.classList.contains('dark');
        const baseColor = isDark ? 'rgba(130, 170, 255, 0.2)' : 'rgba(41, 45, 62, 0.25)';

        // Draw unaffected base dots in a single batch
        ctx.fillStyle = baseColor;
        ctx.beginPath();
        
        const activeWaveDots = [];

        for (let i = 0; i < dots.length; i++) {
            const dot = dots[i];
            let maxStrength = 0;
            let waveColor = null;

            for (let j = 0; j < waves.length; j++) {
                const w = waves[j];
                const elapsed = (now - w.startTime) / 1000;
                const waveRadius = w.speed * elapsed;
                
                const dx = dot.x - w.x;
                const dy = dot.y - w.y;
                const distSquared = dx * dx + dy * dy;
                
                const inner = Math.max(0, waveRadius - w.thickness);
                const outer = waveRadius + w.thickness;

                if (distSquared > inner * inner && distSquared < outer * outer) {
                    const dist = Math.sqrt(distSquared);
                    const diff = Math.abs(dist - waveRadius);
                    const strength = Math.pow(1 - (diff / w.thickness), 3);
                    if (strength > maxStrength) {
                        maxStrength = strength;
                        waveColor = w.color;
                    }
                }
            }

            if (maxStrength > 0) {
                activeWaveDots.push({
                    x: dot.x,
                    y: dot.y,
                    r: dot.baseRadius + (maxStrength * 1.5),
                    color: waveColor,
                    alpha: 0.3 + (maxStrength * 0.7)
                });
            } else {
                ctx.moveTo(dot.x + dot.baseRadius, dot.y);
                ctx.arc(dot.x, dot.y, dot.baseRadius, 0, Math.PI * 2);
            }
        }
        ctx.fill();

        // Draw wave-affected dots
        for (let i = 0; i < activeWaveDots.length; i++) {
            const aw = activeWaveDots[i];
            ctx.beginPath();
            ctx.fillStyle = aw.color;
            ctx.globalAlpha = aw.alpha;
            ctx.arc(aw.x, aw.y, aw.r, 0, Math.PI * 2);
            ctx.fill();
        }
        ctx.globalAlpha = 1;

        animFrameId = requestAnimationFrame(draw);
    }

    function startAnimationLoop() {
        if (!animFrameId && isVisible) {
            animFrameId = requestAnimationFrame(draw);
        }
    }

    const observer = new IntersectionObserver((entries) => {
        isVisible = entries[0].isIntersecting;
        if (isVisible) {
            if (waves.length > 0) {
                startAnimationLoop();
            } else {
                renderStaticGrid();
            }
        } else if (animFrameId) {
            cancelAnimationFrame(animFrameId);
            animFrameId = null;
        }
    }, { threshold: 0.01 });
    observer.observe(canvas);

    window.addEventListener('resize', resize);
    resize();
    setTimeout(triggerWave, 1000);
}
