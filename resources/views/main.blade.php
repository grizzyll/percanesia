<!DOCTYPE html>
<html lang="id">
    {{-- Include Header --}}
    @include('components.header')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <body class="bg-percaBg font-sans antialiased text-percaDark min-h-screen flex flex-col justify-between">
        
        {{-- Include Navbar --}}
        @include('components.navbar')

        {{-- Main Page Content --}}
        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- Include Footer --}}
        @include('components.footer')

    </body>
</html>