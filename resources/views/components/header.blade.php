<header>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <x-ui.button variant="danger">Logout</x-ui.button>
    </form>
</header>
