<style>
    .font-neuropol {
        font-family: 'Neuropol', sans-serif;
    }
    .text-glow {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5), 0 0 25px rgba(0, 191, 255, 0.5);
    }
    #hero-section {
        background-color: #000;
    }
    #moon-canvas {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 600px;
        height: 600px;
        z-index: 20;
        filter: blur(1.5px);
    }
</style>

<section id="hero-section" class="relative flex items-center justify-center w-full min-h-screen -mt-24 bg-black overflow-hidden">
    <canvas id="binary-canvas" class="absolute top-0 left-0 w-full h-full opacity-20 z-10"></canvas>
    <canvas id="moon-canvas"></canvas>
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
document.addEventListener('DOMContentLoaded', function () {
    // --- Binary Rain Animation ---
    const binaryCanvas = document.getElementById('binary-canvas');
    const binaryCtx = binaryCanvas.getContext('2d');
    let binaryWidth = binaryCanvas.width = window.innerWidth;
    let binaryHeight = binaryCanvas.height = window.innerHeight;
    let binaryColumns = Math.floor(binaryWidth / 20);
    let drops = Array(binaryColumns).fill(1);
    const binaryChars = "01";

    function drawBinary() {
        binaryCtx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        binaryCtx.fillRect(0, 0, binaryWidth, binaryHeight);
        binaryCtx.fillStyle = '#00bfff'; // Deep Sky Blue to match the glow
        binaryCtx.font = '20px monospace';
        for (let i = 0; i < drops.length; i++) {
            let text = binaryChars.charAt(Math.floor(Math.random() * binaryChars.length));
            binaryCtx.fillText(text, i * 20, drops[i] * 20);
            if (drops[i] * 20 > binaryHeight && Math.random() > 0.975) drops[i] = 0;
            drops[i]++;
        }
    }
    setInterval(drawBinary, 33);

    // --- Three.js 3D Moon --- 
    const moonCanvas = document.getElementById('moon-canvas');
    const renderer = new THREE.WebGLRenderer({ canvas: moonCanvas, alpha: true });
    renderer.setSize(600, 600);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
    camera.position.z = 5;

    // Moon Sphere
    const geometry = new THREE.SphereGeometry(1.5, 64, 64);
    const textureLoader = new THREE.TextureLoader();
    const texture = textureLoader.load('https://s3-us-west-2.amazonaws.com/s.cdpn.io/17271/lroc_color_poles_1k.jpg');
    const displacementMap = textureLoader.load('https://s3-us-west-2.amazonaws.com/s.cdpn.io/17271/ldem_3_8bit.jpg');
    const material = new THREE.MeshPhongMaterial({
        map: texture,
        displacementMap: displacementMap,
        displacementScale: 0.06,
        bumpMap: displacementMap,
        bumpScale: 0.04,
        specular: new THREE.Color('#223845'),
        shininess: 3
    });
    const moon = new THREE.Mesh(geometry, material);
    scene.add(moon);

    // Lighting
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(-100, 10, 50);
    scene.add(light);
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.1);
    scene.add(ambientLight);

    // Animation Loop
    function animate() {
        requestAnimationFrame(animate);
        moon.rotation.y += 0.0005;
        moon.rotation.x += 0.0001;
        renderer.render(scene, camera);
    }
    animate();

    // --- GSAP Animations ---
    gsap.from('#hero-title', { duration: 1.5, y: -100, opacity: 0, ease: 'power3.out', delay: 0.5 });
    gsap.from('#hero-subtitle', { duration: 1.5, y: 100, opacity: 0, ease: 'power3.out', delay: 0.8 });
    gsap.from('#hero-buttons', { duration: 1.5, scale: 0.5, opacity: 0, ease: 'back.out(1.7)', delay: 1.2 });
    gsap.fromTo('#moon-canvas', { scale: 0.5, opacity: 0 }, { duration: 3, scale: 1, opacity: 1, ease: 'power2.inOut', delay: 0.2 });

    // --- Resize Handling ---
    function onResize() {
        binaryWidth = binaryCanvas.width = window.innerWidth;
        binaryHeight = binaryCanvas.height = window.innerHeight;
        binaryColumns = Math.floor(binaryWidth / 20);
        drops = Array(binaryColumns).fill(1);
    }
    window.addEventListener('resize', onResize);
});
</script>