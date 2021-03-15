<label class="flex items-start group cursor-pointer" x-data="{value: false}">
    <input
        name="{{ $name }}"
        type="checkbox"
        class="hidden"
        x-model="value"
        @if($attributes->has('required')) required @endif
    />

    <div
        class="w-4 h-4 flex items-center justify-center rounded-sm border border-gray-400 mt-0.5 group-hover:border-blue-400"
        :class="{'border-blue-500 bg-blue-400': value}"
    >
        <svg class="w-3 h-3 text-white" x-show="value" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
    </div>

    <div class="ml-2 text-gray-900" style="user-select: none;">
        {{ $slot }}
    </div>
</label>