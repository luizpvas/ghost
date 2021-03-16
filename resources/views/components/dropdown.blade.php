<div class="relative" x-data="{open: false}">
    <span @click="open = true">{{ $trigger }}</span>

    <div
        x-show="open"
        @click.away="open = false"
        class="
            origin-top-right absolute right-0 mt-2 w-56 rounded-sm shadow-lg  focus:outline-none
            bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-50
        "
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>