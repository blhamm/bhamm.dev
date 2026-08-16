const canvas = document.getElementById('particles');
const ctx = canvas ? canvas.getContext('2d') : null;
const DPR = Math.min(window.devicePixelRatio || 1, 2);
const BASE_SPEED = 1 * DPR;
const SPEED_MULTIPLIER = 60;
const SPEED_VARIATION = 1.25 * DPR;
const PARTICLE_MAX = 1 << 8;
const PARTICLE_SPAWN_RATE = (1000 / 60);
const burstMax = (PARTICLE_MAX * 2);
const CELL_SIZE = 80 * DPR;
const particleBitmapCache = new Map();
let traces = [];
let logTimer = 0;
let physicsAccumulator = 0;
const PHYSICS_STEP = 1000 / 120; // 120Hz cap for physics/collisions
let gridCols = 0;
let gridRows = 0;
let grid = [];
let particleSpawnAccumulator = 0;
let particles = new Array(PARTICLE_MAX * 2);
let particleCount = 0;
let needsClear = true;
let mouse = { x: null, y: null };
let lastTime = 16.66;
let cw = 0;
let ch = 0;

//Listeners
window.addEventListener('resize', resizeCanvas);

export function emitFromElement(el, e = null) {
	if (!el || !ctx) return;
	const rect = el.getBoundingClientRect();
	const canvasRect = canvas ? canvas.getBoundingClientRect() : { left: 0, top: 0 };

	let x, y;

	if (e) {
		const touch = (e.touches && e.touches[0]) || (e.changedTouches && e.changedTouches[0]);
		const clientX = e.clientX !== undefined ? e.clientX : (touch ? touch.clientX : null);
		const clientY = e.clientY !== undefined ? e.clientY : (touch ? touch.clientY : null);

		if (clientX !== null && clientY !== null) {
			x = (clientX - canvasRect.left) * DPR;
			y = (clientY - canvasRect.top) * DPR;
		}
	}

	if (x === undefined || y === undefined) {
		x = (rect.left + rect.width / 2 - canvasRect.left) * DPR;
		y = (rect.top + rect.height / 2 - canvasRect.top) * DPR;
	}

	emitParticles(x, y);
}

const emitTrigger = document.getElementById('hero-typing');
if (emitTrigger) {
	const handleEmit = (e) => emitFromElement(emitTrigger, e);
	emitTrigger.addEventListener('mouseenter', handleEmit);
	emitTrigger.addEventListener('touchend', handleEmit);
}

if (canvas) {
	canvas.addEventListener('mouseleave', () => {
		mouse.x = null;
		mouse.y = null;
	});

	document.addEventListener('mousemove', (e) => {
		const rect = canvas.getBoundingClientRect();
		mouse.x = (e.clientX - rect.left) * DPR;
		mouse.y = (e.clientY - rect.top) * DPR;
	});
}

const radiusSum = (a, b) => (a.radius + b.radius) * (a.radius + b.radius);
const outOfBounds = (p) => {
	const margin = 25 * DPR;
	if (isNaN(p.x) || isNaN(p.y)) return true;
	return p.y < -margin || p.y > ch + margin || p.x < -margin || p.x > cw + margin;
};

function resizeCanvas() {
	if (!canvas || !ctx) return;
	const r = canvas.getBoundingClientRect();
	cw = r.width * DPR;
	ch = r.height * DPR;
	canvas.width = cw;
	canvas.height = ch;
	ctx.setTransform(1, 0, 0, 1, 0, 0);

	particleBitmapCache.clear();
	for (let i = 0; i < particleCount; i++) {
		const p = particles[i];
		p.bitmap = getParticleBitmap(p.char);
	}

	initGrid();
}

resizeCanvas();

// collision grid
function initGrid() {
	gridCols = Math.ceil(cw / CELL_SIZE);
	gridRows = Math.ceil(ch / CELL_SIZE);
	
	grid = Array.from({length: gridCols * gridRows}, () => []);
}

function populateGrid() {
	// Reset existing arrays instead of recreating
	grid.forEach(cell => cell.length = 0);
	
	for (let i = 0; i < particleCount; i++) {
		const p = particles[i];
		
		if (p.x < 0 || p.x > cw || p.y < 0 || p.y > ch) continue;
		
		const cx = Math.floor(p.x / CELL_SIZE);
		const cy = Math.floor(p.y / CELL_SIZE);
		
		// Strict bounds checking
		const ix = Math.max(0, Math.min(gridCols - 1, cx));
		const iy = Math.max(0, Math.min(gridRows - 1, cy));
		
		const gridIndex = iy * gridCols + ix;
		
		// Additional safety check
		if (gridIndex >= 0 && gridIndex < grid.length) {
			grid[gridIndex].push(p);
		}
	}
}

function resolveCollisions() {
	 for (let y = 0; y < gridRows; y++) {
		 for (let x = 0; x < gridCols; x++) {
			 const baseIdx = y * gridCols + x;
			 const cell = grid[baseIdx];
			 
			 for (let i = 0; i < cell.length; i++) {
				const a = cell[i];
				
				// same‑cell neighbors
				for (let j = i + 1; j < cell.length; j++) {
					 const b = cell[j];
					 collidePair(a, b);
				}
				
				// neighbor cells
				for (let ny = -1; ny <= 1; ny++) {
					 const row = y + ny;
					 if (row < 0 || row >= gridRows) continue;
					 for (let nx = -1; nx <= 1; nx++) {
						const col = x + nx;
						if (col < 0 || col >= gridCols) continue;
						if (ny === 0 && nx === 0) continue;
						
						const neighborIdx = row * gridCols + col; //cache
						if (neighborIdx < baseIdx) continue; //skip already checked cells
						
						const neighbor = grid[neighborIdx];
						for (let k = 0; k < neighbor.length; k++) {
							collidePair(a, neighbor[k]);
						}
					}
				}
			}
		}
	}
}

function collidePair(a, b) {
	const dx = a.x - b.x;
	const dy = a.y - b.y;
	const dist2 = dx * dx + dy * dy;
	const minDist2 = radiusSum(a, b);
	
	if (dist2 < minDist2) {
		const inv = 1 / Math.sqrt(dist2);
		const nx = dx * inv;
		const ny = dy * inv;
		
		const rel = (a.vx - b.vx) * nx + (a.vy - b.vy) * ny;
		
		if (rel < 0) {
			const impulse = -1.5 * rel;
			a.vx += impulse * nx;
			a.vy += impulse * ny;
			b.vx -= impulse * nx;
			b.vy -= impulse * ny;
		}
	}
}

function generate(deltaTime) {
	particleSpawnAccumulator += deltaTime;
	let added = 0;
	while (
		particleSpawnAccumulator >= PARTICLE_SPAWN_RATE &&
		particleCount < PARTICLE_MAX &&
		added < 3
		) {
		addParticle(createParticle());
		particleSpawnAccumulator -= PARTICLE_SPAWN_RATE;
		added++;
	}
}

function handleMovement(p, dt) {
	const dtFactor = (dt / 1000) * SPEED_MULTIPLIER;
	if (mouse.x !== null && mouse.y !== null) {
		const dx = p.x - mouse.x;
		const dy = p.y - mouse.y;
		const dist2 = dx * dx + dy * dy;
		const repulsionRadius = 75 * DPR;
		if (dist2 < repulsionRadius * repulsionRadius && dist2 > 0.01) {
			const inv = 1 / Math.sqrt(dist2);
			p.vx += (dx * inv * 0.5 * DPR) * dtFactor;
			p.vy += (dy * inv * 0.5 * DPR) * dtFactor;
		}
	}
	
	// Unified movement: Combine base floating speed with active velocity
	p.x += (p.vx + p.speed * Math.sin(p.angle || 0)) * dtFactor;
	p.y += (p.vy - p.speed) * dtFactor;
	
	// Use linear damping approximation for better stability and performance
	const damping = Math.max(0, 1 - 0.05 * dtFactor);
	p.vx *= damping;
	p.vy *= damping;
}

function drawParticles() {
	for (let i = 0; i < particleCount; i++) drawParticle(particles[i]);
}

function updatePhysics(dt) {
	populateGrid();
	resolveCollisions();
	generate(dt);
}

function tracePerformance(end, start) {
	traces.push(end - start);

	if (end > logTimer) {
	 logTimer = end + 1000;
	 
	 setTimeout(() => {
	  const count = traces.length;
	  const hasTraces = count > 0;
	  const avg = hasTraces ? traces.reduce((acc, val) => acc + val) / count : 0;
	  if (hasTraces) traces = [];
	  console.log(`FPS: ${count} | Frame time avg: ${avg.toFixed(2)}ms | ${particleCount} particles`);
	 }, 0);
	}
}

export function particleUp(deltaTime = 0, trace = true) {
	if (!ctx) return;
	
	if (particleCount === 0) {
		if (needsClear) {
			ctx.clearRect(0, 0, cw, ch);
			needsClear = false;
		}
		physicsAccumulator = 0;
		return;
	}
	
	needsClear = true;
	const start = trace ? performance.now() : null;
	
	// Aggressive smoothing (95/5) to ignore Safari's erratic RAF timing
	const clampedDelta = Math.min(deltaTime, 33.33); 
	lastTime = (lastTime * 0.95) + (clampedDelta * 0.05);
	physicsAccumulator += lastTime;

	ctx.clearRect(0, 0, cw, ch);
	
	// Use fixed-step physics accumulator with while loop to prevent time loss / stutter on Safari rAF jitter
	while (physicsAccumulator >= PHYSICS_STEP) {
		const physicsDelta = PHYSICS_STEP;
		physicsAccumulator -= PHYSICS_STEP;
		
		let write = 0;
		for (let i = 0; i < particleCount; i++) {
			const p = particles[i];
			if (outOfBounds(p)) continue;
			handleMovement(p, physicsDelta);
			particles[write++] = p;
		}
		particleCount = write;
		
		updatePhysics(physicsDelta);
	}
	
	drawParticles();
	
	trace ? tracePerformance(performance.now(), start) : null;
}


export function emitParticles(x = null, y = null) {
	if (!ctx) return;
	if (particleCount < burstMax) {
		const originX = x ?? (mouse.x !== null ? mouse.x : cw / 2);
		const originY = y ?? (mouse.y !== null ? mouse.y : ch / 2);
		const count = Math.floor(PARTICLE_MAX / 2);
		const speed = 9 * DPR;
		
		for (let i = 0; i < count; i++) {
			const angle = (Math.PI * 2 * i) / count;
			const vx = Math.cos(angle) * speed;
			const vy = Math.sin(angle) * speed;
			
			addParticle(
				createParticle(originX, originY, vx, vy),
				burstMax
			);
		}
	}
}

function addParticle(p, burstMax = 0) {
	const maxParticles = burstMax || PARTICLE_MAX;
	if (particleCount < maxParticles) {
		particles[particleCount++] = p;
	}
}

function createParticle(
	x = null,
	y = null,
	vx = 0,
	vy = 0,
) {
	const char = getRandomChar();
	return {
		x: x ?? Math.random() * cw,
		y: y ?? ch + 20 * DPR,
		radius: Math.random() * 8 * DPR,
		speed: BASE_SPEED + (Math.random() * SPEED_VARIATION),
		alpha: Math.random(),
		vx,
		vy,
		color: getRandomColor(),
		char,
		bitmap: getParticleBitmap(char)
	};
}

function drawParticle(p) {
	if (!ctx || !p.bitmap) return;
	ctx.drawImage(
		p.bitmap,
		p.x - p.bitmap.width / 2,
		p.y - p.bitmap.height / 2
	);
}

function getRandomChar() {
	const codeChars = [
		'\\u0025',               // %
		'\\u0024',               // $
		'\\u0040',               // @
		'\\u002A',               // *
		'\\u0026',               // &
		'\\u0023',               // #
		'\\u0027',               // '
		'\\u0022',               // "
		// '\\u007C',               // |
		'\\u003B',               // ;
		'\\u002C',               // ,
		'\\u003A',               // :
		'\\u0028\\u0029',        // ()
		'\\u003F\\u003F',        // ?? (nullish coalescing)
		'\\u0021\\u0021',        // ! (logical NOT
		'\\u003D\\u003E',        // => (arrow func operator)
		'\\u0026\\u0026',        // && (logical AND)
		// '\\u007C\\u007C',        // || (logical OR)
		'\\u005E',               // ^ (bitwise XOR)
		'\\u007E',               // ~ (bitwise NOT)
		'\\u003C\\u003C',        // << (left shift)
		'\\u003E\\u003E',        // >> (right shift)
		'\\u002B\\u002B',        // ++ (increment)
		'\\u002D\\u002D',        // -- (decrement)
		'\\u002B\\u003D',        // += (addition assignment)
		'\\u002D\\u003D',        // -= (subtraction assignment)
		'\\u003D\\u003D',        // == (loose equality)
		'\\u003D\\u003D\\u003D', // === (strict equality)
		'\\u0021\\u003D',        // != (loose inequality)
		'\\u0021\\u003D\\u003D', // !== (strict inequality)
		'\\u005B\\u005D',        // [] (empty array literal)
		'\\u007B\\u007D',        // {} (empty object literal)
		'\\u003C\\u002F\\u003E', // </>  (self‑closing tag placeholder)
	];
	const charsLength = codeChars.length;
	return decodeEscapes(codeChars[Math.floor(Math.random() * charsLength)])
}

function getParticleBitmap(txt) {
	if (particleBitmapCache.has(txt)) return particleBitmapCache.get(txt);
	const factor = DPR;
	const scale = { width: 20, height: 16 };
	const width = scale.width * factor;
	const height = scale.height * factor;
	
	let canvasEl, bitmap;

	if (typeof OffscreenCanvas !== 'undefined') {
		const off = new OffscreenCanvas(width, height);
		const octx = off.getContext('2d');
		octx.font = `${12 * factor}px BrandDisplay, monospace, monospace`;
		octx.textBaseline = 'middle';
		octx.antialias = 'subpixel';
		octx.fillStyle = getRandomColor();
		octx.fillText(txt, 0, height / 2);
		bitmap = off.transferToImageBitmap();
	} else {
		canvasEl = document.createElement('canvas');
		canvasEl.width = width;
		canvasEl.height = height;
		const octx = canvasEl.getContext('2d');
		octx.font = `${12 * factor}px BrandDisplay, monospace, monospace`;
		octx.textBaseline = 'middle';
		octx.antialias = 'subpixel';
		octx.fillStyle = getRandomColor();
		octx.fillText(txt, 0, height / 2);
		bitmap = canvasEl;
	}

	particleBitmapCache.set(txt, bitmap);
	return bitmap;
}

function decodeEscapes(esc) {
	if (!esc.includes('\\u')) return esc;
	const raw = esc.replace(/^\\\\/, '');
	const parts = raw.split('\\u').filter(Boolean);
	return parts
		.map(hex => String.fromCharCode(parseInt(hex, 16)))
		.join('');
}

function getRandomColor() {
	const materialLighterColors = [
		'#0090f7', // royal
		'#ba62fc', // purple
		'#f2416b', // magenta
		'#f55600', // orange
		'#c3e88d', // green
    '#ffcb6b', // yellow
    '#f07178', // red
    '#82aaff', // blue
    '#c792ea', // lavender
    '#89ddff', // teal
	]; //ff80ab
	return materialLighterColors[
		Math.floor(Math.random() * materialLighterColors.length)
  ];
}
