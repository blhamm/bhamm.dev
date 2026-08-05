import Lenis from 'lenis';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import ScrollToPlugin from 'gsap/ScrollToPlugin';
import Draggable from 'gsap/Draggable';

// Expose to window for global access (Livewire components, Alpine.js)
// Done before other imports to ensure availability
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollToPlugin = ScrollToPlugin;
window.Draggable = Draggable;
window.Lenis = Lenis;

import { emitParticles, particleUp, emitFromElement } from '@/particles.js';

const targetFPS = 60;
const frameInterval = 1000 / targetFPS;
const lenis = new Lenis({ lerp: 0.1 });
window.lenis = lenis;

const trace = false;
let lastTime = performance.now();
let particlesOn = false;

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, Draggable);
gsap.ticker.lagSmoothing(0);

// Sync Lenis with ScrollTrigger
lenis.on('scroll', ScrollTrigger.update);

// Use GSAP ticker for synchronized updates
gsap.ticker.add((time, deltaTime, frame) => {
  lenis.raf(time * 1000);
  
  // Throttle particles if needed, or just run them every frame
  if (particlesOn) {
    particleUp(deltaTime, trace);
  }
});

window.addEventListener('load', () => ScrollTrigger.refresh());

const avatar = document.getElementById('avatar');
const gradient = document.querySelector('.gradient');
const container = document.querySelector('.avatar-container');

let avatarShown = false;
function typingComplete() {
  particlesOn = true;
  
  // Emit from the avatar position
  if (container) {
    emitFromElement(container);
  } else {
    emitParticles();
  }

  if (!avatarShown) {
    showScrollHelperText();
    showAvatar();
    avatarShown = true;
  }
}

function showScrollHelperText() {
  const scrollHelperText = document.querySelector('.scroll-helper-text');
  if (scrollHelperText) {
    gsap.fromTo(scrollHelperText, { autoAlpha: 0, y: -20 }, { autoAlpha: 1, y: 0, ease: 'circ' });
    scrollHelperText.classList.add('animate-pulse');
  }
}

function showAvatar() {
  if (container && gradient && avatar) {
    gsap.fromTo(container, {
      width: 1,
      height: 1,
      paddingRight: "128px",
    }, {
      width: 128,
      height: 128,
      paddingRight: 0,
      duration: .25,
    });

    gsap.fromTo(gradient, {
      autoAlpha: 0,
      y: 150,
      scale: 0
    }, {
      autoAlpha: 1,
      y: 0,
      scale: 1,
      ease: 'circ',
      duration: .25,
      onComplete: () => {
        gradient.classList.add('slow-spin');
      },
    });

    gsap.fromTo(avatar, {
      autoAlpha: 0,
      y: 150,
      scale: 0
    }, {
      autoAlpha: 1,
      y: 0,
      scale: 1,
      ease: 'circ',
      duration: .25,
    });
  }
}

function typeText(el, onComplete = null, initialDelay = 0.75, textOverride = null) {
  if (el._typingTimeline) {
    el._typingTimeline.kill();
  }

  el.classList.add('visible');

  const text = textOverride || el.getAttribute('data-typing-text') || el.innerText;
  
  // Only set data-typing-text if we're not using an override (to preserve original text for sections)
  if (!el.hasAttribute('data-typing-text') && !textOverride) {
    el.setAttribute('data-typing-text', text);
  }

  const chars = text.split('');
  el.innerText = '\u00a0';

  const tl = gsap.timeline({ delay: initialDelay });
  el._typingTimeline = tl;

  chars.forEach((char, i) => {
    tl.call(() => {
      if (i === 0) el.innerText = '';
      el.innerText += char === ' ' ? '\u00a0' : char;
    }, null, i * 0.08);
  });

  if (onComplete) {
    tl.call(onComplete, null, '+=0.15');
  }

  return tl;
}

const heroText = document.querySelector('#hero-typing');
const heroStrings = [
  "Hey, I'm Brandon.",
  "I write, test and ship code.",
  "I'm a proud dad!",
  "I love hiking and all dogs.",
  "Thanks for stopping by!",
];
let heroIndex = 0;

function cycleHeroText() {
  if (!heroText) return;
  
  typeText(heroText, () => {
    if (heroIndex === 0) {
      typingComplete();
    }
    
    // Wait for a bit before clearing and typing next
    gsap.delayedCall(2.5, () => {
        heroIndex = (heroIndex + 1) % heroStrings.length;
        cycleHeroText();
    });
  }, heroIndex === 0 ? 0.75 : 0.5, heroStrings[heroIndex]);
}

if (heroText) {
  cycleHeroText();
}

// Header .dev color tween
const headerDev = document.querySelector('.header-dev');
if (headerDev) {
  gsap.to(headerDev, {
    keyframes: {
      "0%": { color: '#82aaff' },    // blue (start)
      "16%": { color: '#c3e88d' },   // green
      "33%": { color: '#ffcb6b' },   // yellow
      "50%": { color: '#f07178' },   // red
      "66%": { color: '#c792ea' },   // purple
      "83%": { color: '#89ddff' },   // teal
      "100%": { color: '#82aaff' }   // back to blue
    },
    duration: 12,
    repeat: -1,
    ease: "none"
  });
}

// Color theme gradient tween for hero typing text
if (heroText) {
  gsap.to(heroText, {
    backgroundPosition: '200% center',
    duration: 10,
    repeat: -1,
    ease: "none"
  });
}

// Hero Terminal Parallax
const terminal = document.querySelector('.terminal-window');
if (terminal) {
  gsap.to(terminal, {
    y: -120,
    ease: "none",
    scrollTrigger: {
      trigger: "#hero",
      start: "top top",
      end: "bottom top",
      scrub: true
    }
  });
}

// Section headings typing
const sectionHeadings = document.querySelectorAll('.typing-animation:not(#hero-typing)');
sectionHeadings.forEach((el) => {
  ScrollTrigger.create({
    trigger: el,
    start: 'top 85%',
    onEnter: () => typeText(el, null, 0.2), // shorter delay for sections
    onEnterBack: () => typeText(el, null, 0.2),
  });
});

// Main loop is now handled by gsap.ticker above
