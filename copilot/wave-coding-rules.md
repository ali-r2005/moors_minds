Wave Coding Rules & Standards

Project Stack: Laravel Framework 11.44.0 + Wave (latest) + Livewire Volt + Folio

1. ✅ File & Folder Structure

Folio + Volt Pages

Store all public pages in: resources/themes/anchor/pages/

Group logically using folders:

pages/services/index.blade.php

pages/projects/create.blade.php

Admin functionality is handled using FilamentPHP. Admin resources and pages should be created under app/Filament/Resources/ and access controlled via policies or Filament’s built-in middleware.

Components

Use anonymous Volt components (new class extends Component) as per official Wave docs.

Blade layout: <x-layouts.app>

Inner wrapper: <x-app.container>

2. ✅ Volt Page Structure

Each Volt page must follow this pattern:

<?php
use function Laravel\Folio\{middleware, name};
use App\Models\ModelName;
use Livewire\Volt\Component;

middleware('auth'); // if needed
name('route-name');

new class extends Component {
    public $items;

    public function mount() {
        $this->items = ModelName::latest()->get();
    }
};
?>

<x-layouts.app>
    @volt('route-name')
        <x-app.container>
            <!-- Your UI here -->
        </x-app.container>
    @endvolt
</x-layouts.app>

✅ Important: Always use @volt('name') directive inside the layout to avoid runtime errors.

3. ✅ Naming Conventions

Files/Folders

Use lowercase with dashes for folders and route names: services, user-profile, admin-panel

Keep blade filenames matching the URL structure: services/index.blade.php

Variables

Use camelCase in Volt classes: $serviceList, $userProjects

Use snake_case for database columns

Routes

Defined implicitly via file names with Folio. Use name('route-name') to explicitly name them.

4. ✅ UI Standards (Tailwind CSS)

All pages use Tailwind CSS utilities.

Use responsive grid-cols-{} for layout.

Cards: bg-white, shadow, rounded-xl, p-6

Tables (if used): should be responsive with overflow-x-auto

5. ✅ Best Practices

Data

Use mount() to load data in Volt components.

Avoid fetching in blade directly.

When filtering/paginating, use Livewire bindings if needed.

Interactions

Use wire:click for interactions (e.g., delete).

Avoid @php logic inside the blade. Keep logic in mount() or Volt methods.

6. ✅ Code Safety & Consistency

Always validate inputs server-side.

Use Str::limit() for content trimming in views.

Format prices with number_format($amount, 2).

Follow PSR-12 formatting in custom PHP classes.

7. ✅ Admin Functionality

Admin UI is managed through FilamentPHP.

Filament resources belong in app/Filament/Resources/

Admins should use Filament Panels and Filament’s role/middleware features.

Do not use Volt pages or frontend theme for admin-specific CRUD.

8. ✅ Livewire Volt Rules

Always use @volt('name') inside blade files.

Only 1 Volt component per page.

Avoid inline wire:model if not needed.

Use Livewire\Volt\Component anonymous classes for new functionality.

9. ✅ Theme Usage & Structure

📂 Theme Path

resources/themes/anchor

📁 Structure:

layouts/ → Page wrappers like app.blade.php

pages/ → Volt+Folio files

partials/ → Navbar, sidebar, etc.

components/ → Reusable UI blocks (<x-app.heading>, etc.)

tailwind.config.js → Custom styles for each theme

📄 Best Practices:

Always wrap content with <x-layouts.app> + <x-app.container>

Prefer built-in components from components/ folder

Page-specific content should go under pages/{section}/

Keep data-fetching in the Volt mount()

10. ✅ Deployment & Upgrading

Keep changes inside resources/themes/anchor to avoid breakage during Wave updates.

Never modify vendor or core Wave files.

Use Folio + Volt to isolate new features from core Wave files.

Document custom rules in wave-coding-rules.md.
