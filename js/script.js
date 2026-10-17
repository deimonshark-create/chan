/* ============================================================
   REGALO DE CUMPLEAÑOS PARA CHAN - JavaScript
   Particulas, regalos, confeti, musica y detalles
   ============================================================ */

document.addEventListener("DOMContentLoaded", () => {
    initParticles();
    initReveal();
    initGifts();
    initConfettiButton();
    initMusicButton();
    initCursorHearts();
});

/* ============================================================
   1) PARTICULAS - ceniza/diamantes flotando en el fondo
   ============================================================ */
function initParticles() {
    const canvas = document.getElementById("particles");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    let w, h, particles = [];
    const COLORS = ["#4aedd9", "#6ee06e", "#ffd700", "#ff5c8a"];

    function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
    }

    function createParticle() {
        return {
            x: Math.random() * w,
            y: Math.random() * h,
            size: Math.random() * 3 + 1,
            speedY: Math.random() * 0.6 + 0.2,
            drift: (Math.random() - 0.5) * 0.4,
            color: COLORS[Math.floor(Math.random() * COLORS.length)],
            alpha: Math.random() * 0.5 + 0.2,
        };
    }

    function init() {
        particles = [];
        const count = Math.min(70, Math.floor(w / 22));
        for (let i = 0; i < count; i++) particles.push(createParticle());
    }

    function draw() {
        ctx.clearRect(0, 0, w, h);
        for (const p of particles) {
            p.y += p.speedY;
            p.x += p.drift;
            if (p.y > h + 10) { p.y = -10; p.x = Math.random() * w; }
            if (p.x > w + 10) p.x = -10;
            if (p.x < -10) p.x = w + 10;

            ctx.globalAlpha = p.alpha;
            ctx.fillStyle = p.color;
            ctx.fillRect(p.x, p.y, p.size, p.size); // cuadraditos = pixel style
        }
        ctx.globalAlpha = 1;
        requestAnimationFrame(draw);
    }

    window.addEventListener("resize", () => { resize(); init(); });
    resize();
    init();
    draw();
}

/* ============================================================
   2) REVEAL - aparecer al hacer scroll
   ============================================================ */
function initReveal() {
    const elements = document.querySelectorAll(".reveal");
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add("visible"), i * 90);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    elements.forEach((el) => observer.observe(el));
}

/* ============================================================
   3) REGALOS - abrir modal con mensaje secreto
   ============================================================ */
function initGifts() {
    const modal  = document.getElementById("modal");
    const title  = document.getElementById("modalTitle");
    const text   = document.getElementById("modalText");
    const icon   = document.getElementById("modalIcon");
    const close  = document.getElementById("modalClose");
    if (!modal) return;

    document.querySelectorAll(".gift").forEach((gift) => {
        gift.addEventListener("click", () => {
            title.textContent         = gift.dataset.titulo;
            text.textContent          = gift.dataset.texto;
            icon.textContent          = gift.dataset.icono;
            icon.style.color          = gift.dataset.color;
            modal.classList.add("open");
            burstConfetti(28);
        });
    });

    function closeModal() { modal.classList.remove("open"); }
    close.addEventListener("click", closeModal);
    modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });
    document.addEventListener("keydown", (e) => { if (e.key === "Escape") closeModal(); });
}

/* ============================================================
   4) CONFETI - canvas temporal
   ============================================================ */
let confettiParticles = [];
let confettiRunning = false;

function burstConfetti(amount = 120) {
    const COLORS = ["#4aedd9", "#6ee06e", "#ffd700", "#ff5c8a", "#ff4655", "#ffffff"];

    for (let i = 0; i < amount; i++) {
        confettiParticles.push({
            x: window.innerWidth / 2,
            y: window.innerHeight / 2,
            vx: (Math.random() - 0.5) * 14,
            vy: (Math.random() - 0.7) * 14,
            size: Math.random() * 8 + 4,
            color: COLORS[Math.floor(Math.random() * COLORS.length)],
            life: 1,
            rot: Math.random() * Math.PI,
            vr: (Math.random() - 0.5) * 0.3,
        });
    }

    if (!confettiRunning) runConfetti();
}

function runConfetti() {
    confettiRunning = true;
    const canvas = getConfettiCanvas();
    const ctx = canvas.getContext("2d");

    function frame() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        confettiParticles.forEach((p) => {
            p.vy += 0.35;         // gravedad
            p.x += p.vx;
            p.y += p.vy;
            p.life -= 0.012;
            p.rot += p.vr;

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot);
            ctx.globalAlpha = Math.max(p.life, 0);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size);
            ctx.restore();
        });

        confettiParticles = confettiParticles.filter((p) => p.life > 0 && p.y < canvas.height + 50);

        if (confettiParticles.length > 0) {
            requestAnimationFrame(frame);
        } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            confettiRunning = false;
        }
    }

    frame();
}

function getConfettiCanvas() {
    let canvas = document.getElementById("confetti");
    if (!canvas) {
        canvas = document.createElement("canvas");
        canvas.id = "confetti";
        Object.assign(canvas.style, {
            position: "fixed",
            inset: "0",
            width: "100%",
            height: "100%",
            pointerEvents: "none",
            zIndex: "998",
        });
        document.body.appendChild(canvas);
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    return canvas;
}

function initConfettiButton() {
    const btn = document.getElementById("confettiBtn");
    if (!btn) return;
    btn.addEventListener("click", () => {
        for (let i = 0; i < 4; i++) {
            setTimeout(() => burstConfetti(80), i * 220);
        }
    });
}

/* ============================================================
   5) MUSICA - melodia de cumpleaños con Web Audio (sin archivos)
   ============================================================ */
let audioCtx = null;
let musicPlaying = false;

function playBirthdayTune() {
    const AC = window.AudioContext || window.webkitAudioContext;
    if (!AC) return;
    if (!audioCtx) audioCtx = new AC();
    if (audioCtx.state === "suspended") audioCtx.resume();

    // Notas: [frecuencia, inicio(beats), duracion(beats)]
    const N = {
        G4: 392.00, A4: 440.00, B4: 493.88, C5: 523.25,
        D5: 587.33, E5: 659.25, F5: 698.46, G5: 783.99,
    };
    const beat = 0.42;
    const melody = [
        [N.G4, 0, 0.5], [N.G4, 0.5, 0.5], [N.A4, 1, 1],     [N.G4, 2, 1],     [N.C5, 3, 1],     [N.B4, 4, 2],
        [N.G4, 0, 0.5], [N.G4, 0.5, 0.5], [N.A4, 1, 1],     [N.G4, 2, 1],     [N.D5, 3, 1],     [N.C5, 4, 2],
        [N.G4, 0, 0.5], [N.G4, 0.5, 0.5], [N.G5, 1, 1],     [N.E5, 2, 1],     [N.C5, 3, 1], [N.B4, 3.5, 0.5], [N.A4, 4, 1],
        [N.F5, 5, 0.5], [N.F5, 5.5, 0.5], [N.E5, 6, 1],     [N.C5, 7, 1],     [N.D5, 8, 1],     [N.C5, 9, 2],
    ];

    const startTime = audioCtx.currentTime + 0.1;

    melody.forEach(([freq, start, dur]) => {
        const t = startTime + start * beat;
        const o = audioCtx.createOscillator();
        const g = audioCtx.createGain();
        o.type = "triangle";
        o.frequency.value = freq;
        g.gain.setValueAtTime(0, t);
        g.gain.linearRampToValueAtTime(0.18, t + 0.02);
        g.gain.exponentialRampToValueAtTime(0.001, t + dur * beat);
        o.connect(g).connect(audioCtx.destination);
        o.start(t);
        o.stop(t + dur * beat);
    });

    return (9 + 2) * beat * 1000; // duracion total aprox
}

function initMusicButton() {
    const btn = document.getElementById("musicBtn");
    if (!btn) return;

    btn.addEventListener("click", () => {
        if (musicPlaying) return;
        musicPlaying = true;
        btn.textContent = "\u266B Suena la melodia...";
        playBirthdayTune();
        burstConfetti(50);
        setTimeout(() => {
            musicPlaying = false;
            btn.textContent = "\u266B Tocar cancion";
        }, 5000);
    });
}

/* ============================================================
   6) CORAZONES que siguen al cursor
   ============================================================ */
function initCursorHearts() {
    let last = 0;
    const SYMBOLS = ["\u2665", "\u2726", "\u2666"];

    document.addEventListener("mousemove", (e) => {
        const now = Date.now();
        if (now - last < 90) return; // limita la cantidad
        last = now;

        const el = document.createElement("span");
        el.className = "cursor-heart";
        el.textContent = SYMBOLS[Math.floor(Math.random() * SYMBOLS.length)];
        el.style.left = (e.clientX + (Math.random() * 16 - 8)) + "px";
        el.style.top = (e.clientY + (Math.random() * 16 - 8)) + "px";
        el.style.color = Math.random() > 0.5 ? "#ff5c8a" : "#4aedd9";
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 1000);
    });
}
