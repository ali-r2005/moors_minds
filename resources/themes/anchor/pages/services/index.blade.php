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
            <x-app.heading
                title="Our Services"
                description="Discover what we offer"
                :border="false"
            />

            @if($services->isEmpty())
                <div class="w-full p-20 text-center bg-gray-100 rounded-xl">
                    <p class="text-gray-500">No services available at the moment.</p>
                </div>
            @else
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-6">
                    @foreach($services as $service)
                        <div class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                            <h2 class="text-xl font-semibold text-indigo-600 mb-2">{{ $service->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>

                            @if ($service->price)
                                <p class="text-sm font-medium text-gray-800">
                                    Price: <span class="text-green-600">${{ number_format($service->price, 2) }}</span>
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </x-app.container>
    @endvolt
</x-layouts.app>
