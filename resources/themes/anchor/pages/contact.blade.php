<?php

use function Laravel\Folio\name;
use App\Models\Service;
use App\Models\ContactRequest;
use Livewire\Volt\Component;
use Livewire\Attributes\Rule;

name('contact');

new class extends Component {
    public $services;

    #[Rule('required|string|max:255')]
    public $full_name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('nullable|string|max:255')]
    public $phone = '';

    #[Rule('nullable|string')]
    public $message = '';

    #[Rule('nullable|exists:services,id')]
    public $service_id = '';

    public $source = 'contact-page';

    public $successMessage = '';

    public function mount()
    {
        $this->services = Service::all(['id', 'title']);
    }

    public function submit()
    {
        $this->validate();

        ContactRequest::create([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'service_id' => $this->service_id ?: null,
            'source' => $this->source,
            'status' => 'pending',
        ]);

        $this->successMessage = 'Thank you for your message! We will get back to you shortly.';
        $this->reset('full_name', 'email', 'phone', 'message', 'service_id');
    }
};

?>

<x-layouts.marketing>
    @volt('contact')
        <x-app.container>
            <div class="py-12 sm:py-24">
                <x-marketing.elements.heading
                    level="h1"
                    title="Contact Us"
                    description="Have a question or a project in mind? We'd love to hear from you."
                />

                <div class="grid grid-cols-1 gap-12 mt-12 md:grid-cols-3">
                    <!-- Contact Info -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-zinc-900">Get in Touch</h2>
                        <div class="flex items-center space-x-4">
                            <x-phosphor-envelope-simple class="w-6 h-6 text-primary-500" />
                            <a href="mailto:contact@moorsminds.com" class="text-zinc-600 hover:text-primary-500">contact@moorsminds.com</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            <x-phosphor-phone class="w-6 h-6 text-primary-500" />
                            <a href="tel:+1234567890" class="text-zinc-600 hover:text-primary-500">+1 (234) 567-890</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            <x-phosphor-whatsapp-logo class="w-6 h-6 text-primary-500" />
                            <a href="https://wa.me/1234567890" target="_blank" class="text-zinc-600 hover:text-primary-500">Chat on WhatsApp</a>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="md:col-span-2">
                        @if ($successMessage)
                            <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-200 rounded-lg">
                                {{ $successMessage }}
                            </div>
                        @else
                            <form wire:submit.prevent="submit" class="space-y-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-zinc-700">Full Name</label>
                                    <input wire:model.defer="full_name" id="full_name" type="text" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('full_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-zinc-700">Email Address</label>
                                    <input wire:model.defer="email" id="email" type="email" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-zinc-700">Phone Number (Optional)</label>
                                    <input wire:model.defer="phone" id="phone" type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="service_id" class="block text-sm font-medium text-zinc-700">Service of Interest (Optional)</label>
                                    <select wire:model.defer="service_id" id="service_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Select a service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-zinc-700">Message (Optional)</label>
                                    <textarea wire:model.defer="message" id="message" rows="5" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                                    @error('message') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <input type="hidden" wire:model="source">

                                <div class="text-right">
                                    <x-elements.button type="submit" size="lg">
                                        Send Message
                                    </x-elements.button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </x-app.container>
    @endvolt
</x-layouts.marketing>
