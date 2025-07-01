<?php
    use function Laravel\Folio\{name};
    name('home');
?>

<x-layouts.marketing
    :seo="[
        'title'         => setting('site.title', 'Laravel Wave'),
        'description'   => setting('site.description', 'Software as a Service Starter Kit'),
        'image'         => url('/og_image.png'),
        'type'          => 'website'
    ]"
>
        
        <x-marketing.sections.hero />
        
        <div class="scroll-animate-section">
            <x-container class="py-12 border-t sm:py-24 border-zinc-200">
                <x-marketing.sections.why-choose-us />
            </x-container>
        </div>

        <div class="scroll-animate-section">
            <x-container class="py-12 border-t sm:py-24 border-zinc-200">
                <x-marketing.sections.testimonials />
            </x-container>
        </div>
        
        <div class="scroll-animate-section">
            <x-container class="py-12 border-t sm:py-24 border-zinc-200">
                <x-marketing.sections.pricing />
            </x-container>
        </div>

@push('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        gsap.registerPlugin(ScrollTrigger);

        const sections = document.querySelectorAll('.scroll-animate-section');

        // Set the initial state of all sections to be invisible and shifted down
        gsap.set(sections, { opacity: 0, y: 50 });

        sections.forEach(section => {
            // Animate each section to its final state when it enters the viewport
            gsap.to(section, { 
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
            });
        });
    });
</script>
@endpush

</x-layouts.marketing>
