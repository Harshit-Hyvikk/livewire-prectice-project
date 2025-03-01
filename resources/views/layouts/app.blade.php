{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true',
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Teleport Example</title>
    {{-- @rappasoftTableStyles
    @rappasoftTableThirdPartyStyles --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    @livewireStyles
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
    @filamentStyles()
    @fluxAppearance()

    @stack('extra_css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- In the <head> tag: -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Before </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</head>

<body class=" bg-gray-100 dark:bg-gray-800">
    <button @click="toggleDarkMode" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800">
        <template x-if="darkMode">
            <!-- Sun icon for light mode -->
            <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </template>
        <template x-if="!darkMode">
            <!-- Moon icon for dark mode -->
            <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </template>
    </button>
    <div class="min-h-screen bg-white">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class=" shadow  bg-white">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class=" bg-gray-100 rounded-10 ">
            {{ $slot }}
            {{-- <div class="bg-gray-50 p-4 m-2">
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>


            <div class="w-1/6 p-5 ">

                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model="status" id="country-select">
                        <option value="draft">Draft</option>
                        <option value="reviewing">Reviewing</option>
                        <option value="published">Published</option>
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div> --}}
        </main>
    </div>


    @livewireScripts
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    @stack('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @filamentScripts
    {{-- @rappasoftTableScripts
    @rappasoftTableThirdPartyScripts --}}

    {{-- filament select2 --}}
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     $('#country-select').select2({
        //         width: '100%', // Make the Select2 dropdown span the full width
        //     });
        // });
    </script>


    {{-- for ckediter script --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script> --}}
    <script>
        // ClassicEditor
        //     .create(document.querySelector('#description'))
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>

</body>

</html>
