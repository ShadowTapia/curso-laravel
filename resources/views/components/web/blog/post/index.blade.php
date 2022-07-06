<div>

    {{ $slot }}

    @foreach ($posts as $p)
        <div class="mb-2 card card-white">
            <h3>{{ $p->title }}</h3>
            <a href='{{ route("web.blog.show", $p) }}'>Ir</a>
            <p>{{ $p->description }}</p>
        </div>
    @endforeach
    {{ $posts->links() }}
</div>
