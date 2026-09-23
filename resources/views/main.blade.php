<!DOCTYPE html>
<html lang="id">
    {{-- Include Header --}}
    @include('components.header')

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