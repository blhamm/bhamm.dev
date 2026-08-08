import gsap from 'gsap';

let observer = null;

export function initExpertiseAnimations() {
    const containers = document.querySelectorAll('.expertise-animation-container:not([data-observed])');
    
    if (!observer) {
        observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const container = entry.target;
                const type = container.dataset.type;
                const svg = container.querySelector('svg');
                
                if (!svg) return;

                if (entry.isIntersecting) {
                    // Start or Resume animation
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
                } else {
                    // Stop animation to save resources
                    gsap.killTweensOf(svg.querySelectorAll('*'));
                }
            });
        }, { threshold: 0.05 });
    }

    containers.forEach(container => {
        container.setAttribute('data-observed', 'true');
        observer.observe(container);
    });
}

function animateApi(svg) {
    const packets = svg.querySelectorAll('.packet');
    const nodes = svg.querySelectorAll('.api-node');
    const paths = svg.querySelectorAll('.api-path');

    gsap.killTweensOf([packets, nodes]);

    // Pulse nodes
    gsap.to(nodes, {
        opacity: 0.4,
        duration: 1.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.2,
        ease: "sine.inOut"
    });

    // Animate packets along paths - more robust for hidden elements (modals)
    packets.forEach((packet, index) => {
        const path = paths[index % paths.length];
        
        // Use a small delay to ensure SVG measurements are available if modal is opening
        gsap.delayedCall(0.1, () => {
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
    });
}

function animateDatabase(svg) {
    const groups = svg.querySelectorAll('.db-layer-group');
    const leds = svg.querySelectorAll('.db-led');
    const flows = svg.querySelectorAll('.db-flow');

    gsap.killTweensOf([groups, flows, leds]);

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
    const pulses = svg.querySelectorAll('.obs-pulse');
    const paths = svg.querySelectorAll('.obs-path');
    const packets = svg.querySelectorAll('.obs-packet');
    const scans = svg.querySelectorAll('.obs-scan');
    const needle = svg.querySelector('.gauge-needle');

    gsap.killTweensOf([central, nodes, pulses, paths, packets, scans, needle]);

    // Radar scan effect - slowed down
    gsap.fromTo(scans, 
        { scale: 0.5, opacity: 0.6 },
        { 
            scale: 3, 
            opacity: 0, 
            duration: 4, 
            stagger: 1.5, 
            repeat: -1, 
            ease: "power1.out",
            transformOrigin: "center center" 
        }
    );

    // Hub pulse - very subtle
    gsap.to(central, {
        scale: 1.05,
        opacity: 0.4,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
        transformOrigin: "center center"
    });

    // Node pulsing - Pulsing from nodes symmetrically
    gsap.fromTo(pulses, 
        { scale: 1, opacity: 0.5 },
        { 
            scale: 2.5, 
            opacity: 0, 
            duration: 2, 
            stagger: 0.4, 
            repeat: -1, 
            ease: "sine.out",
            transformOrigin: "center center" 
        }
    );

    // Gauge needle movement - smoother
    gsap.to(needle, {
        rotation: "random(-45, 45)",
        transformOrigin: "bottom center",
        duration: 1.2,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });

    // Symmetrical inward data flow
    packets.forEach((packet, i) => {
        const startX = parseFloat(packet.getAttribute('cx'));
        const startY = parseFloat(packet.getAttribute('cy'));
        
        gsap.fromTo(packet, 
            { attr: { cx: startX, cy: startY }, opacity: 1 },
            {
                attr: { cx: 330, cy: 210 },
                opacity: 0,
                duration: 1.5 + Math.random(),
                repeat: -1,
                delay: i * 0.4,
                ease: "power1.in"
            }
        );
    });

    // Path flow effect
    gsap.to(paths, {
        strokeDashoffset: -20,
        duration: 2,
        repeat: -1,
        ease: "none"
    });
    
    // Subtle node drift - maintaining symmetry but adding life
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
}

function animateDevOps(svg) {
    const nodes = svg.querySelectorAll('.devops-node');
    const activePath = svg.querySelector('.devops-pipeline-active');
    const activePath2 = svg.querySelector('.devops-pipeline-active-2');
    const status = svg.querySelector('.devops-status');
    const replicas = svg.querySelectorAll('.devops-replica');
    
    gsap.killTweensOf([nodes, activePath, activePath2, status, replicas]);

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

    // Pulse nodes - with stable transform origin
    gsap.to(nodes, {
        scale: 1.2,
        transformOrigin: "center center",
        force3D: false,
        duration: 1.2,
        repeat: -1,
        yoyo: true,
        stagger: 0.15,
        ease: "sine.inOut"
    });

    // Failure / Scaling timeline
    const tl = gsap.timeline({ repeat: -1, repeatDelay: 2 });
    
    tl.to(status, { fill: "#f07178", duration: 0.5 }) // Fail (Red)
      .to(replicas, { 
          opacity: 1, 
          scale: 1.1, 
          stagger: 0.2, 
          duration: 0.5,
          ease: "back.out(2)",
          transformOrigin: "center center" 
      }) // Scale up
      .to(status, { fill: "#c3e88d", duration: 0.5, delay: 2 }) // Back to healthy (Green)
      .to(replicas, { 
          opacity: 0, 
          scale: 0.8, 
          stagger: -0.1, 
          duration: 0.5,
          transformOrigin: "center center"
      }); // Scale down
}

function animateLaravel(svg) {
    const group = svg.querySelector('.laravel-logo-group');
    const path = svg.querySelector('.laravel-path');
    const nodes = svg.querySelectorAll('.laravel-node');
    const floatDots = svg.querySelectorAll('.laravel-float-dot');

    gsap.killTweensOf([group, path, nodes, floatDots]);

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

    gsap.killTweensOf([lines, nodes]);

    // Draw lines sequentially and hold - increased visibility
    const tl = gsap.timeline({ repeat: -1 });
    
    tl.from(lines, {
        strokeDasharray: "0, 400",
        duration: 1.5,
        stagger: 0.1,
        ease: "power2.inOut"
    })
    .to({}, { duration: 2 }) // Hold fully drawn
    .to(lines, {
        strokeDasharray: "0, 400",
        duration: 1.5,
        stagger: -0.1, // Reverse stagger for undrawing
        ease: "power2.inOut"
    })
    .to({}, { duration: 1 }); // Hold empty

    // Pulse nodes on connection
    gsap.to(nodes, {
        opacity: 0.3,
        scale: 1.5,
        transformOrigin: "center center",
        duration: 1,
        repeat: -1,
        yoyo: true,
        stagger: 0.2
    });
}

function animateFrontend(svg) {
    const container = svg.querySelector('.fe-container');
    const topBar = svg.querySelector('.fe-top-bar');
    const sidebar = svg.querySelector('.fe-sidebar');
    const content = svg.querySelector('.fe-content');
    const details = svg.querySelectorAll('.fe-detail');
    const uiDots = svg.querySelectorAll('.fe-ui-dot');
    const nodes = svg.querySelectorAll('.fe-node');
    const leds = svg.querySelectorAll('.fe-led');

    gsap.killTweensOf([container, topBar, sidebar, content, details, uiDots, nodes, leds]);

    // Morph timeline
    const tl = gsap.timeline({ repeat: -1, repeatDelay: 2 });

    // Morph "inplace" - transitioning from widescreen to mobile-style vertical layout
    // Centered around x=300 for a true "inplace" feel
    tl.to(container, { attr: { x: 270, y: 180, width: 60, height: 110 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(topBar, { attr: { x: 275, y: 190, width: 50, height: 5 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(sidebar, { attr: { x: 275, y: 200, width: 50, height: 15 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(content, { attr: { x: 275, y: 220, width: 50, height: 60 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(details[0], { attr: { x: 280, y: 230, width: 40 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(details[1], { attr: { x: 280, y: 238, width: 30 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(details[2], { attr: { x: 280, y: 246, width: 40 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(uiDots[0], { attr: { cx: 280, cy: 192.5 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(uiDots[1], { attr: { cx: 285, cy: 192.5 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to(uiDots[2], { attr: { cx: 290, cy: 192.5 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to([nodes[0], leds[0]], { attr: { cx: 275, cy: 185 }, duration: 1.5, ease: "power2.inOut" }, 0)
      .to([nodes[1], leds[1]], { attr: { cx: 325, cy: 285 }, duration: 1.5, ease: "power2.inOut" }, 0)
      
      .to(container, { attr: { x: 220, y: 200, width: 160, height: 80 }, duration: 1.5, ease: "power2.inOut", delay: 2 })
      .to(topBar, { attr: { x: 235, y: 212, width: 130, height: 6 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(sidebar, { attr: { x: 235, y: 225, width: 30, height: 45 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(content, { attr: { x: 270, y: 225, width: 95, height: 45 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(details[0], { attr: { x: 275, y: 230, width: 85 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(details[1], { attr: { x: 275, y: 238, width: 60 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(details[2], { attr: { x: 275, y: 246, width: 85 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(uiDots[0], { attr: { cx: 240, cy: 215 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(uiDots[1], { attr: { cx: 245, cy: 215 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to(uiDots[2], { attr: { cx: 250, cy: 215 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to([nodes[0], leds[0]], { attr: { cx: 230, cy: 205 }, duration: 1.5, ease: "power2.inOut" }, "<")
      .to([nodes[1], leds[1]], { attr: { cx: 375, cy: 275 }, duration: 1.5, ease: "power2.inOut" }, "<");

    // LED pulses
    gsap.to(nodes, {
        opacity: 0.4,
        scale: 1.2,
        transformOrigin: "center center",
        duration: 0.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.3
    });
}
