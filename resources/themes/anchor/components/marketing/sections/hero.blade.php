<style>
    .font-neuropol {
        font-family: 'Neuropol', sans-serif;
    }
    .text-glow {
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.4), 0 0 20px rgba(192, 192, 192, 0.4);
    }
    .moon {
        background: radial-gradient(circle, #4a4a4a 0%, #2a2a2a 50%, #1a1a1a 100%);
        filter: blur(5px);
        transform: scale(1.5);
    }
    #galaxy-shadow {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow:
            0 0 60px 30px #4a00e0, /* Purple */
            0 0 100px 60px #8e2de2, /* Violet */
            0 0 140px 90px #1e00ff; /* Blue */
        opacity: 0.15;
        filter: blur(100px);
    }
</style>

<section id="hero-section" class="relative flex items-center justify-center w-full min-h-screen -mt-24 bg-black overflow-hidden">
    <div id="galaxy-shadow"></div>
    <canvas id="binary-canvas" class="absolute top-0 left-0 w-full h-full opacity-20 z-10"></canvas>
    <div id="moon" class="absolute w-96 h-96 md:w-[600px] md:h-[600px] rounded-full moon z-20"></div>
    <div class="relative z-30 flex flex-col items-center justify-center w-full max-w-4xl px-8 mx-auto text-center">
        <h1 id="hero-title" class="font-neuropol text-5xl font-bold tracking-wider text-white sm:text-6xl md:text-7xl text-glow">
            MOORS MINDS
        </h1>
        <p id="hero-subtitle" class="mt-6 text-xl font-light text-gray-300 md:text-2xl max-w-2xl">
          We architect digital growth with code and vision.
        </p>
        <div id="hero-buttons" class="flex flex-col items-center justify-center gap-4 mx-auto mt-10 sm:flex-row">
            <x-button size="lg" class="w-full sm:w-auto">Explore Our Work</x-button>
            <x-button size="lg" color="secondary" class="w-full sm:w-auto">Contact Us</x-button>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hero = document.getElementById('hero-section');
        const moon = document.getElementById('moon');
        const title = document.getElementById('hero-title');
        const galaxy = document.getElementById('galaxy-shadow');

        // GSAP Entrance Animation
        gsap.fromTo(galaxy, { opacity: 0, scale: 0.8 }, { opacity: 0.15, scale: 1, duration: 4, ease: 'power3.out' });
        gsap.fromTo(moon, { opacity: 0, scale: 1.2 }, { opacity: 1, scale: 1.5, duration: 2.5, ease: 'power3.out', delay: 0.5 });
        gsap.fromTo(title, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 1.5, ease: 'power3.out', delay: 1 });
        gsap.fromTo('#hero-subtitle', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 1.5, ease: 'power3.out', delay: 1.3 });
        gsap.fromTo('#hero-buttons', { opacity: 0 }, { opacity: 1, duration: 1.5, ease: 'power3.out', delay: 1.6 });

        // GSAP Parallax on Mouse Move
        hero.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const x = (clientX / window.innerWidth) - 0.5;
            const y = (clientY / window.innerHeight) - 0.5;

            gsap.to(galaxy, { x: -x * 100, y: -y * 80, ease: 'power2.out', duration: 2 });
            gsap.to(moon, { x: -x * 50, y: -y * 30, ease: 'power2.out', duration: 1.5 });
            gsap.to(title, { x: x * 20, y: y * 10, ease: 'power2.out', duration: 1 });
        });

        // GSAP Galaxy Animation
        gsap.to(galaxy, { rotation: 360, duration: 200, repeat: -1, ease: 'none' });

        // Binary Canvas Animation
        const canvas = document.getElementById('binary-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        const binary = '01';
        const fontSize = 24;
        const columns = canvas.width / fontSize;
        const drops = [];
        for (let x = 0; x < columns; x++) drops[x] = 1;

        function draw() {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.04)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = '#6B7280'; // Gray-500
            ctx.font = fontSize + 'px monospace';
            for (let i = 0; i < drops.length; i++) {
                const text = binary.charAt(Math.floor(Math.random() * binary.length));
                ctx.fillText(text, i * fontSize, drops[i] * fontSize);
                if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) drops[i] = 0;
                drops[i]++;
            }
        }
        setInterval(draw, 40);

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    });
</script>