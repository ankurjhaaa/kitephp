@if($paginator->hasPages())
<nav class="flex items-center justify-between border-t border-gray-800 bg-[#1c2128] px-4 py-3 sm:px-6">
    <div class="hidden sm:block">
        <p class="text-sm text-gray-400">
            Showing <span class="font-medium text-white">{{ ($paginator->currentPage - 1) * $paginator->perPage + 1 }}</span>
            to <span class="font-medium text-white">{{ min($paginator->currentPage * $paginator->perPage, $paginator->total) }}</span>
            of <span class="font-medium text-white">{{ $paginator->total }}</span> results
        </p>
    </div>
    <div class="flex flex-1 justify-between sm:justify-end gap-2">
        @if($paginator->onFirstPage())
            <span class="relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-600 ring-1 ring-inset ring-gray-800 bg-[#0d1117] cursor-not-allowed">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" kite:navigate class="relative inline-flex items-center rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-gray-700 hover:bg-gray-700 transition-colors">Previous</a>
        @endif

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" kite:navigate class="relative inline-flex items-center rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-gray-700 hover:bg-gray-700 transition-colors">Next</a>
        @else
            <span class="relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-600 ring-1 ring-inset ring-gray-800 bg-[#0d1117] cursor-not-allowed">Next</span>
        @endif
    </div>
</nav>
@endif
