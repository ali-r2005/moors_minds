<?php

use function Laravel\Folio\{middleware, name};
use App\Models\Service;
use Livewire\Volt\Component;

name('services');

new class extends Component {
    public $services;

    public function mount()
    {
        $this->services = Service::latest()->get();
    }
};
?>

<x-layouts.marketing>
    @volt('services')
        <x-app.container>
            <div class="py-12 sm:py-24">
                <x-marketing.elements.heading
                    level="h1"
                    title="Our Services"
                    description="Explore our comprehensive suite of services designed to elevate your business."
                />

                @if($services->isEmpty())
                    <div class="w-full p-20 mt-12 text-center bg-zinc-50 rounded-xl">
                        <p class="text-zinc-500">No services available at the moment. Please check back later.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-10 mt-12 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($services as $service)
                            <a href="{{ route('services.show', ['service' => $service->slug]) }}" class="block overflow-hidden transition duration-300 bg-white border shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                                <div>
                                    @if($service->image_url)
                                        <img class="object-cover w-full h-64 transition duration-300 group-hover:scale-105" src="{{ asset('storage/'.$service->image_url) }}" alt="{{ $service->title }}">
                                    @else
                                        <div class="flex items-center justify-center w-full h-64 bg-zinc-200">
                                            <x-phosphor-image class="w-16 h-16 text-zinc-400" />
                                        </div>
                                    @endif
                                    <div class="p-8">
                                        <h2 class="text-2xl font-bold text-zinc-900 transition duration-300 group-hover:text-primary-500">{{ $service->title }}</h2>
                                        <p class="mt-4 text-base text-zinc-500">{{ Str::limit($service->description, 120) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-app.container>
    @endvolt
</x-layouts.marketing>
