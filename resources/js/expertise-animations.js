import gsap from 'gsap';

export function initExpertiseAnimations() {
    const containers = document.querySelectorAll('.expertise-animation-container');
    
    containers.forEach(container => {
        const type = container.dataset.type;
        const svg = container.querySelector('svg');
        
        if (!svg) return;

        switch(type) {
            case 'api':
                animateApi(svg);
                break;
            case 'database':
                animateDatabase(svg);
                break;
            case 'observability':
                animateObservability(svg);
                break;
            case 'devops':
                animateDevOps(svg);
                break;
            case 'laravel':
                animateLaravel(svg);
                break;
            case 'engineering':
                animateEngineering(svg);
                break;
            case 'frontend':
                animateFrontend(svg);
                break;
        }
    });
}

function animateApi(svg) {
    const packets = svg.querySelectorAll('.packet');
    const nodes = svg.querySelectorAll('.api-node');
    const paths = svg.querySelectorAll('.api-path');

    // Pulse nodes
    gsap.to(nodes, {
        opacity: 0.4,
        duration: 1.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.2,
        ease: "sine.inOut"
    });

    // Animate packets along paths
    packets.forEach((packet, index) => {
        const path = paths[index % paths.length];
        gsap.set(packet, { opacity: 1 });
        gsap.to(packet, {
            motionPath: {
                path: path,
                align: path,
                alignOrigin: [0.5, 0.5]
            },
            duration: 3 + Math.random() * 2,
            repeat: -1,
            delay: index * 1.2,
            ease: "none"
        });
    });
}

function animateDatabase(svg) {
    const groups = svg.querySelectorAll('.db-layer-group');
    const leds = svg.querySelectorAll('.db-led');
    const flows = svg.querySelectorAll('.db-flow');

    // Float groups (layers + leds)
    gsap.to(groups, {
        y: -10,
        duration: 2.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.4,
        ease: "sine.inOut"
    });

    // Animate flow lines
    gsap.to(flows, {
        strokeDashoffset: -8,
        duration: 0.5,
        repeat: -1,
        ease: "none"
    });

    // Random LED flashes
    leds.forEach(led => {
        gsap.to(led, {
            opacity: 0.2,
            duration: "random(0.3, 1.0)",
            repeat: -1,
            yoyo: true,
            delay: "random(0, 2)"
        });
    });
}

function animateObservability(svg) {
    const central = svg.querySelector('.obs-central');
    const nodes = svg.querySelectorAll('.obs-node-group');
    const lines = svg.querySelectorAll('.obs-line');
    const scans = svg.querySelectorAll('.obs-scan');
    const needle = svg.querySelector('.gauge-needle');
    const bars = svg.querySelectorAll('.metric-bar');

    // Radar scan effect
    gsap.fromTo(scans, 
        { scale: 0.5, opacity: 0.8 },
        { scale: 3, opacity: 0, duration: 3, stagger: 1, repeat: -1, ease: "power1.out" }
    );

    // Pulse central hub
    gsap.to(central, {
        scale: 1.1,
        opacity: 0.4,
        duration: 2,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });

    // Gauge needle movement
    gsap.to(needle, {
        rotation: "random(-50, 50)",
        transformOrigin: "bottom center",
        duration: 0.8,
        repeat: -1,
        yoyo: true,
        ease: "power2.inOut"
    });

    // Metric bars pulsing
    gsap.to(bars, {
        scaleY: "random(0.5, 1.5)",
        transformOrigin: "bottom center",
        duration: 0.4,
        repeat: -1,
        yoyo: true,
        stagger: 0.1,
        ease: "sine.inOut"
    });

    // Move nodes
    nodes.forEach(node => {
        gsap.to(node, {
            x: "random(-4, 4)",
            y: "random(-4, 4)",
            duration: "random(2, 4)",
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });
    });

    // Animate flow lines
    gsap.to(lines, {
        strokeDashoffset: -20,
        duration: 1.5,
        repeat: -1,
        ease: "none"
    });
}

function animateDevOps(svg) {
    const nodes = svg.querySelectorAll('.devops-node');
    const activePath = svg.querySelector('.devops-pipeline-active');
    const activePath2 = svg.querySelector('.devops-pipeline-active-2');
    const status = svg.querySelector('.devops-status');
    const replicas = svg.querySelectorAll('.devops-replica');
    
    // Rotate/Pulse active paths
    gsap.to(activePath, {
        strokeDashoffset: -210,
        duration: 2,
        repeat: -1,
        ease: "none"
    });

    gsap.to(activePath2, {
        strokeDashoffset: 155,
        duration: 4,
        repeat: -1,
        ease: "none"
    });

    // Pulse nodes
    gsap.to(nodes, {
        scale: 1.2,
        duration: 1,
        repeat: -1,
        yoyo: true,
        stagger: 0.1,
        ease: "power1.inOut"
    });

    // Failure / Scaling timeline
    const tl = gsap.timeline({ repeat: -1, repeatDelay: 2 });
    
    tl.to(status, { fill: "#f07178", duration: 0.5 }) // Fail (Red)
      .to(replicas, { 
          opacity: 1, 
          scale: 1.1, 
          stagger: 0.2, 
          duration: 0.5,
          ease: "back.out(2)" 
      }) // Scale up
      .to(status, { fill: "#c3e88d", duration: 0.5, delay: 2 }) // Back to healthy (Green)
      .to(replicas, { 
          opacity: 0, 
          scale: 0.8, 
          stagger: -0.1, 
          duration: 0.5 
      }); // Scale down
}

function animateLaravel(svg) {
    const group = svg.querySelector('.laravel-logo-group');
    const path = svg.querySelector('.laravel-path');
    const nodes = svg.querySelectorAll('.laravel-node');
    const floatDots = svg.querySelectorAll('.laravel-float-dot');

    // Floating logo
    gsap.to(group, {
        y: -20,
        x: 10,
        rotation: 12,
        transformOrigin: "center center",
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });

    // Draw the logo path
    gsap.set(path, { strokeDasharray: 1000, strokeDashoffset: 1000 });
    gsap.to(path, {
        strokeDashoffset: 0,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    });

    // Pulsing nodes
    gsap.to(nodes, {
        opacity: 0.6,
        scale: 1.5,
        transformOrigin: "center center",
        duration: 2,
        repeat: -1,
        yoyo: true,
        stagger: 0.4,
        ease: "power1.inOut"
    });

    // Drift floating dots
    floatDots.forEach(dot => {
        gsap.to(dot, {
            x: "random(-20, 20)",
            y: "random(-20, 20)",
            opacity: "random(0.2, 0.6)",
            duration: "random(3, 6)",
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });
    });
}

function animateEngineering(svg) {
    const lines = svg.querySelectorAll('.eng-line');
    const nodes = svg.querySelectorAll('.eng-node');

    // Draw lines sequentially
    gsap.from(lines, {
        strokeDasharray: "0, 400",
        duration: 2,
        stagger: 0.1,
        repeat: -1,
        yoyo: true,
        ease: "power2.inOut"
    });

    // Pulse nodes on connection
    gsap.to(nodes, {
        opacity: 0.3,
        scale: 1.5,
        duration: 1,
        repeat: -1,
        yoyo: true,
        stagger: 0.2
    });
}

function animateFrontend(svg) {
    const container = svg.querySelector('.fe-container');
    const topBar = svg.querySelector('.fe-top-bar');
    const content = svg.querySelector('.fe-content');
    const nodes = svg.querySelectorAll('.fe-node');
    const leds = svg.querySelectorAll('.fe-led');

    // Morph timeline
    const tl = gsap.timeline({ repeat: -1, repeatDelay: 2 });

    tl.to(container, { attr: { x: 290, y: 105, width: 70, height: 130 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(topBar, { attr: { x: 300, y: 115, width: 50, height: 8 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(content, { attr: { x: 300, y: 130, width: 50, height: 95 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to([nodes[0], leds[0]], { attr: { cx: 300, cy: 115 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to([nodes[1], leds[1]], { attr: { cx: 350, cy: 225 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(container, { attr: { x: 220, y: 200, width: 160, height: 80 }, duration: 1.5, ease: "power2.inOut", delay: 2 })
      .to(topBar, { attr: { x: 235, y: 215, width: 40, height: 10 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(content, { attr: { x: 235, y: 235, width: 130, height: 30 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to([nodes[0], leds[0]], { attr: { cx: 230, cy: 210 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to([nodes[1], leds[1]], { attr: { cx: 370, cy: 270 }, duration: 1.5, ease: "power2.inOut" }, "<");

    // LED pulses
    gsap.to(nodes, {
        filter: "brightness(2)",
        duration: 0.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.3
    });
}
