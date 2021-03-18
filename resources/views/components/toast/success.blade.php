<div
    class="
        inline-flex items-center bg-white space-x-2 p-2 shadow-lg rounded-sm
        transform -translate-y-16 transition ease-out duration-300
    "
    x-data="{}"
    x-init="() => {
        setTimeout(() => {
            $el.classList.remove('-translate-y-16')
            $el.classList.add('translate-y-0')
        }, 50)

        setTimeout(() => {
            $el.classList.add('opacity-0')
            setTimeout(() => {
                $el.parentElement.removeChild($el)
            }, 300)
        }, 1500)
    }"
>
    <x-heroicon.solid.check-circle class="h-5 text-green-500" />
    <div>{{ $slot }}</div>
</div>