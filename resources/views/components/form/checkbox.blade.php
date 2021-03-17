<label class="flex items-center group cursor-pointer">
    <input
        class="
            rounded-sm
            text-blue-400 border-gray-400 dark:border-gray-900
            group-hover:border-blue-400 focus:ring-blue-300 focus:ring-offset-white dark:focus:ring-offset-gray-900
        "
        name="{{ $name }}"
        type="checkbox"
        x-model="value"
        @if($attributes->has('required')) required @endif
    />

    <div class="ml-2 text-gray-900 dark:text-gray-200" style="user-select: none;">
        {{ $slot }}
    </div>
</label>