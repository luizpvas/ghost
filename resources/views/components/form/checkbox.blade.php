<label class="flex items-center group cursor-pointer">
    <input
        class="rounded-sm border-gray-400 group-hover:border-blue-400 text-blue-400 focus:ring-blue-300"
        name="{{ $name }}"
        type="checkbox"
        x-model="value"
        @if($attributes->has('required')) required @endif
    />

    <div class="ml-2 text-gray-900" style="user-select: none;">
        {{ $slot }}
    </div>
</label>