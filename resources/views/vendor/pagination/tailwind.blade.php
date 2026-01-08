@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between py-4">

        {{-- Version Mobile --}}
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="bg-surface text-text-muted cursor-not-allowed rounded-xl border border-white/5 px-4 py-2 text-sm font-medium">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="bg-surface text-text-main hover:border-primary/50 rounded-xl border border-white/5 px-4 py-2 text-sm font-medium transition-all">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="bg-surface text-text-main hover:border-primary/50 rounded-xl border border-white/5 px-4 py-2 text-sm font-medium transition-all">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="bg-surface text-text-muted cursor-not-allowed rounded-xl border border-white/5 px-4 py-2 text-sm font-medium">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Version Desktop --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-text-muted text-sm tracking-wide">
                    Affichage de <span class="text-text-main font-semibold">{{ $paginator->firstItem() }}</span> à <span
                        class="text-text-main font-semibold">{{ $paginator->lastItem() }}</span> sur <span
                        class="text-text-main font-semibold">{{ $paginator->total() }}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex gap-1">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true"
                            class="bg-surface text-text-muted flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-xl border border-white/5">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="bg-surface text-text-muted hover:text-primary hover:border-primary/50 flex h-10 w-10 items-center justify-center rounded-xl border border-white/5 transition-all">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true"
                                class="bg-surface text-text-muted flex h-10 w-10 items-center justify-center rounded-xl border border-white/5 italic">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                        class="bg-primary/20 text-primary border-primary/50 flex h-10 w-10 items-center justify-center rounded-xl border font-bold">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="bg-surface text-text-muted hover:text-text-main flex h-10 w-10 items-center justify-center rounded-xl border border-white/5 font-medium transition-all hover:border-white/20">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="bg-surface text-text-muted hover:text-primary hover:border-primary/50 flex h-10 w-10 items-center justify-center rounded-xl border border-white/5 transition-all">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span aria-disabled="true"
                            class="bg-surface text-text-muted flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-xl border border-white/5">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
