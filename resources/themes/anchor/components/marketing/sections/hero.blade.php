<style>
    .font-neuropol {
        font-family: 'Neuropol', sans-serif;
    }
    .text-glow {
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.3), 0 0 20px rgba(192, 192, 192, 0.3);
    }
    .moon {
        background: radial-gradient(circle, #4a4a4a 0%, #2a2a2a 50%, #1a1a1a 100%);
        filter: blur(5px);
        transform: scale(1.5);
    }
</style>

<section id="hero-section" class="relative flex items-center justify-center w-full min-h-screen -mt-24 bg-black overflow-hidden">
    <div id="moon" class="absolute w-96 h-96 md:w-[600px] md:h-[600px] rounded-full moon"></div>
    <div class="relative z-10 flex flex-col items-center justify-center w-full max-w-4xl px-8 mx-auto text-center">
        <h1 id="hero-title" class="font-neuropol text-5xl font-bold tracking-wider text-white sm:text-6xl md:text-7xl text-glow">
            MOORS MINDS
        </h1>
        <p id="hero-subtitle" class="mt-6 text-xl font-light text-gray-300 md:text-2xl max-w-2xl">
            Pioneering the Future of Intelligent Systems
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
        const subtitle = document.getElementById('hero-subtitle');

        // GSAP Entrance Animation
        gsap.fromTo(moon, { opacity: 0, scale: 1.2 }, { opacity: 1, scale: 1.5, duration: 2.5, ease: 'power3.out' });
        gsap.fromTo(title, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 1.5, ease: 'power3.out', delay: 0.5 });
        gsap.fromTo(subtitle, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 1.5, ease: 'power3.out', delay: 0.8 });
        gsap.fromTo('#hero-buttons', { opacity: 0 }, { opacity: 1, duration: 1.5, ease: 'power3.out', delay: 1.2 });

        // GSAP Parallax on Mouse Move
        hero.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const x = (clientX / window.innerWidth) - 0.5;
            const y = (clientY / window.innerHeight) - 0.5;

            gsap.to(moon, {
                x: -x * 50,
                y: -y * 30,
                ease: 'power2.out',
                duration: 1.5
            });

            gsap.to(title, {
                x: x * 20,
                y: y * 10,
                ease: 'power2.out',
                duration: 1
            });
        });
    });
</script>