window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.Alpine = require('alpinejs')
require('./reflinks')

// Bridge between Reflinks and AlpineJS
document.addEventListener('reflinks:load', () => {
    Alpine.discoverUninitializedComponents(Alpine.initializeComponent)
})

if (localStorage.theme == 'dark') {
    document.documentElement.classList.add('dark')
}
