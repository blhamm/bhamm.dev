import gsap from 'gsap';

export function initDotMatrix() {
    const canvas = document.getElementById('dot-matrix-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let dots = [];
    const spacing = 16;
    const colors = ['#c3e88d', '#ffcb6b', '#f07178', '#82aaff', '#c792ea', '#89ddff'];
    let waves = [];

    function resize() {
        const rect = canvas.parentNode.getBoundingClientRect();
        if (!rect) return;
        width = canvas.width = rect.width;
        height = canvas.height = rect.height;
        initDots();
    }

    function initDots() {
        dots = [];
        for (let x = spacing / 2; x < width; x += spacing) {
            for (let y = spacing / 2; y < height; y += spacing) {
                // Jitter slightly for organic feel
                dots.push({
                    x: x + (Math.random() - 0.5) * 2,
                    y: y + (Math.random() - 0.5) * 2,
                    baseRadius: 0.7 + Math.random() * 0.4,
                });
            }
        }
    }

    function triggerWave() {
        waves.push({
            x: Math.random() * width,
            y: Math.random() * height,
            color: colors[Math.floor(Math.random() * colors.length)],
            startTime: performance.now(),
            duration: 3000,
            speed: 350,
            thickness: 200
        });

        setTimeout(triggerWave, 2000 + Math.random() * 3000);
    }

    let isVisible = false;
    const observer = new IntersectionObserver((entries) => {
        isVisible = entries[0].isIntersecting;
    }, { threshold: 0.01 });
    observer.observe(canvas);

    function draw() {
        if (!isVisible) {
            requestAnimationFrame(draw);
            return;
        }
        ctx.clearRect(0, 0, width, height);
        const now = performance.now();
        const isDark = document.documentElement.classList.contains('dark');
        const baseColor = isDark ? 'rgba(130, 170, 255, 0.2)' : 'rgba(41, 45, 62, 0.25)';
        
        waves = waves.filter(w => now - w.startTime < w.duration);

        dots.forEach(dot => {
            let maxStrength = 0;
            let waveColor = null;

            waves.forEach(w => {
                const elapsed = (now - w.startTime) / 1000;
                const waveRadius = w.speed * elapsed;
                
                const dx = dot.x - w.x;
                const dy = dot.y - w.y;
                const distSquared = dx*dx + dy*dy;
                
                const inner = Math.max(0, waveRadius - w.thickness);
                const outer = waveRadius + w.thickness;

                if (distSquared > inner*inner && distSquared < outer*outer) {
                    const dist = Math.sqrt(distSquared);
                    const diff = Math.abs(dist - waveRadius);
                    const strength = Math.pow(1 - (diff / w.thickness), 3);
                    if (strength > maxStrength) {
                        maxStrength = strength;
                        waveColor = w.color;
                    }
                }
            });

            ctx.beginPath();
            ctx.arc(dot.x, dot.y, dot.baseRadius + (maxStrength * 1.5), 0, Math.PI * 2);
            
            if (maxStrength > 0) {
                ctx.fillStyle = waveColor;
                ctx.globalAlpha = 0.3 + (maxStrength * 0.7);
            } else {
                ctx.fillStyle = baseColor;
                ctx.globalAlpha = 1;
            }
            
            ctx.fill();
        });
        requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();
    draw();
    setTimeout(triggerWave, 1000);
}
