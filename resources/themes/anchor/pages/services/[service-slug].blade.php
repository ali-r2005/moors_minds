<?php

use App\Models\Service;
use Livewire\Volt\Component;
use function Laravel\Folio\name;

name('services.show');

new class extends Component
{
    public Service $service;

    public function mount(Service $service)
    {
        $this->service = $service->load('projects');
    }
};

?>

<x-layouts.marketing>
    @volt('service-detail')
        <x-app.container>
            <div x-data="{
                        open: false,
                        selectedProject: null,
                        mainImage: '',
                        getYouTubeEmbedUrl(url) {
                            if (!url) return '';
                            let videoId = '';
                            if (url.includes('youtu.be/')) {
                                videoId = url.split('youtu.be/')[1].split(/[?#]/)[0];
                            } else if (url.includes('watch?v=')) {
                                videoId = url.split('watch?v=')[1].split(/[&#]/)[0];
                            } else if (url.length === 11 && !url.includes('/')) {
                                videoId = url;
                            }
                            if (videoId) {
                                return `https://www.youtube-nocookie.com/embed/${videoId}`;
                            }
                            return '';
                        }
                    }">

                <!-- Header and Intro Section -->
                <div class="py-12 sm:py-24">
                    <x-container>
                        <x-marketing.elements.heading
                            level="h1"
                            :title="$service->title"
                            :description="$service->subtitle"
                        />
                        <div class="grid grid-cols-1 gap-12 mt-12 md:grid-cols-2 md:gap-16">
                            <div class="flex items-center">
                                @if($service->image_url)
                                    <img src="{{ asset('storage/'.$service->image_url) }}" alt="{{ $service->title }}" class="w-full h-auto rounded-2xl shadow-lg">
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="prose prose-lg max-w-none text-zinc-500">
                                    {!! $service->description !!}
                                </div>
                                @if($service->cta_label && $service->cta_link)
                                    <div class="mt-8">
                                        <x-button tag="a" href="{{ $service->cta_link }}" size="lg">{{ $service->cta_label }}</x-button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </x-container>
                </div>

                <!-- Use Cases Section -->
                @if(!empty($service->use_cases))
                    <div class="py-12 border-t sm:py-24 border-zinc-200/75">
                        <x-container>
                            <x-marketing.elements.heading level="h2" title="Use Cases" description="Discover the powerful applications of this service." />
                            <ul class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2 lg:grid-cols-3">
                                @foreach($service->use_cases as $useCase)
                                    <li class="flex p-6 transition duration-300 bg-white shadow-lg rounded-2xl hover:shadow-xl hover:-translate-y-1">
                                        <x-phosphor-check-circle class="flex-shrink-0 w-8 h-8 text-primary-500" />
                                        <span class="ml-4 text-lg text-zinc-700">{{ $useCase }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </x-container>
                    </div>
                @endif

                <!-- Features Section -->
                @if(!empty($service->features))
                    <div class="py-12 border-t sm:py-24 border-zinc-200/75">
                        <x-container>
                            <x-marketing.elements.heading level="h2" title="Key Features" description="Explore the core features that set this service apart." />
                            <ul class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2">
                                @foreach($service->features as $feature)
                                    <li class="flex items-center p-6 bg-zinc-50 rounded-2xl">
                                        <x-phosphor-star class="flex-shrink-0 w-8 h-8 text-yellow-500" />
                                        <span class="ml-4 text-lg text-zinc-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </x-container>
                    </div>
                @endif

                <!-- Related Projects Section -->
                @if($service->projects->isNotEmpty())
                    <div class="py-12 border-t sm:py-24 border-zinc-200/75">
                        <x-container>
                            <x-marketing.elements.heading level="h2" title="Related Projects" description="See our work in action."/>
                            <div class="grid grid-cols-1 gap-8 mt-12 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($service->projects->take(3) as $project)
                                    <div @click="selectedProject = {{ json_encode($project) }}; mainImage = selectedProject.images ? selectedProject.images[0] : ''; open = true" class="flex flex-col justify-between overflow-hidden transition duration-300 bg-white border shadow-lg cursor-pointer rounded-2xl group hover:shadow-xl hover:-translate-y-1">
                                        <div class="relative">
                                            @if(isset($project->images[0]))
                                                <img src="{{ asset('storage/'.$project->images[0]) }}" alt="{{ $project->title }}" class="object-cover w-full h-48 transition duration-300 group-hover:scale-105">
                                            @else
                                                <div class="flex items-center justify-center w-full h-48 bg-zinc-200">
                                                    <x-phosphor-image class="w-12 h-12 text-zinc-400" />
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-0 group-hover:bg-opacity-50">
                                                <p class="text-lg font-bold text-white opacity-0 group-hover:opacity-100">View Details</p>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-zinc-900">{{ $project->title }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-container>
                    </div>
                @endif

                <!-- Project Modal -->
                <div x-show="open" @keydown.escape.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75" x-cloak>
                    <div @click.away="open = false" class="relative w-full max-w-4xl max-h-full overflow-y-auto bg-white shadow-2xl rounded-2xl">
                        <div class="p-8" x-if="selectedProject">
                            <button @click="open = false" class="absolute top-4 right-4 z-20 text-zinc-500 hover:text-zinc-800">
                                <x-phosphor-x class="w-6 h-6" />
                            </button>

                            <div class="flex flex-col space-y-6">
                                <h2 class="text-3xl font-bold text-zinc-900" x-text="selectedProject.title"></h2>

                                <!-- Media Section -->
                                <div>
                                    <!-- Image Gallery -->
                                    <template x-if="selectedProject.images && selectedProject.images.length > 0">
                                        <div class="mb-6">
                                            <img :src="'/storage/' + mainImage" alt="Main project image" class="w-full h-auto mb-4 rounded-lg shadow-md">
                                            <div class="flex space-x-2 overflow-x-auto">
                                                <template x-for="image in selectedProject.images">
                                                    <img :src="'/storage/' + image" @click="mainImage = image" class="w-16 h-16 object-cover rounded-md cursor-pointer hover:opacity-75" :class="{ 'ring-2 ring-primary-500': mainImage === image }">
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Video -->
                                    <template x-if="selectedProject.video_url">
                                        <div class="aspect-w-16 aspect-h-9">
                                            <iframe :src="getYouTubeEmbedUrl(selectedProject.video_url)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full rounded-lg"></iframe>
                                        </div>
                                    </template>
                                </div>

                                <!-- Details Section -->
                                <div class="space-y-6">
                                    <!-- Description -->
                                    <template x-if="selectedProject.description">
                                        <div>
                                            <h3 class="text-xl font-semibold text-zinc-800">Project Overview</h3>
                                            <div class="mt-2 prose max-w-none" x-html="selectedProject.description"></div>
                                        </div>
                                    </template>

                                    <!-- Results -->
                                    <template x-if="selectedProject.results">
                                        <div>
                                            <h3 class="text-xl font-semibold text-zinc-800">Key Results</h3>
                                            <div class="mt-2 prose max-w-none" x-html="selectedProject.results"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </x-app.container>
    @endvolt
</x-layouts.marketing>
