document.addEventListener('click', (ev) => {
    let target = interceptableTarget(ev.target)
    if (!target) return
    if (shouldIgnore(target)) return

    ev.preventDefault()

    let method = (target.getAttribute('method') || 'GET').toUpperCase()
    if (method == 'GET') {
        navigate(target.getAttribute('href'))
    } else {
        submit(target)
    }
})

document.addEventListener('submit', (ev) => {
    ev.preventDefault()
    let form = ev.target
    let action = form.getAttribute('action')
    let method = (form.getAttribute('method') || 'POST').toUpperCase()

    if (method == 'GET') {
        let querystring = new URLSearchParams(new FormData(form)).toString()
        navigate(action + '?' + querystring)
    } else {
        submit(form)
    }
})

customElements.define('reflinks-frame', class extends HTMLElement {})

/**
 * Checks if the given element should be intercepted for AJAX request on click.
 *
 * @param {HTMLElement} elm
 * @return {HTMLElement|null}
 */
function interceptableTarget(elm) {
    let target = elm
    let maxDepth = 3
    while (target && --maxDepth) {
        if (target.hasAttribute('href')) return target
        target = target.parentElement
    }
}

/**
 * Ignored elements are wrapped with `data-reflinks="false"`.
 *
 * @param {HTMLElement} elm
 * @return {boolean}
 */
function shouldIgnore(elm) {
    let target = elm
    let maxDepth = 8
    while (target && --maxDepth) {
        if (target.getAttribute('data-reflinks') == 'false') return true
        target = target.parentElement
    }
}

/**
 * Navigates to the given url.
 *
 * @param {string} url
 * @return {Promise<void>}
 */
async function navigate(url) {
    window.history.pushState({ reflinks: true }, null, url)

    try {
        let { data } = await axios.get(url)
        let doc = document.createElement('html')
        doc.innerHTML = data
        let newBody = doc.querySelector('body')

        document.body.parentElement.replaceChild(newBody, document.body)

        triggerEvent('reflinks:load')
    } catch (err) {
        location = url
    }
}

/**
 * Submits the given form.
 *
 * @param {HTMLFormElement} method
 */
async function submit(target) {
    let method = target.getAttribute('method')
    let url = target.getAttribute('action') || target.getAttribute('href')
    let data = target.tagName == 'FORM' ? new FormData(target) : null

    updateButtonsDisableWith(target)
    clearValidationErrors(target)

    await new Promise((resolve) => setTimeout(resolve, 1000))

    try {
        await sendRequestExpectingDirectives({ method, url, data })
    } catch (err) {
        if (err.response.status == 422) {
            showValidationErrors(target, err.response.data.errors)
        }
    } finally {
        restoreButtonsFromDisableWith(target)
    }
}

/**
 * Sends an AJAX request to the server expecting a JSON response with encoded directives.
 *
 * @param {*} options
 */
async function sendRequestExpectingDirectives({ method, url, data }) {
    let response = await axios({ method, url, data })
    applyDirectives(response.data.directives)
}

/**
 * Applies the list of directives to redirect, append, update, delete, etc.
 *
 * @param {*} directives
 */
function applyDirectives(directives) {
    for (let directive of directives) {
        if (directive.redirect) {
            navigate(directive.redirect)
        }
    }
}

/**
 * Show validation errors based on the validation response from Laravel.
 *
 * @param {HTMLFormElement} form
 * @param {*} errors
 */
function showValidationErrors(form, errors) {
    Object.keys(errors).forEach((name) => {
        let field = form.querySelector(`[data-field="${name}"]`)
        if (!field) return
        field.querySelector('[data-validation]').innerHTML = errors[name][0]
    })
}

/**
 * Clears validation errors displayed from a previous submit.
 *
 * @param {HTMLFormElement} form
 */
function clearValidationErrors(form) {
    Array.from(form.querySelectorAll('[data-validation]')).forEach((node) => {
        node.innerHTML = ''
    })
}

/**
 * Updates buttons that declare a data-disable-with in order to provide immediate feedback on form submissions.
 *
 * @param {HTMLElement} target
 */
function updateButtonsDisableWith(target) {
    let swapHtml = (button) => {
        let html = button.getAttribute('data-disable-with')
        button.setAttribute('data-original-html', button.innerHTML)
        button.innerHTML = prependSpinnerDisableWith() + html
        button.setAttribute('disabled', true)
    }

    Array.from(target.querySelectorAll('[data-disable-with]')).forEach(swapHtml)
    if (target.hasAttribute('data-disable-with')) swapHtml(target)
}

/**
 * Restores buttons that uses `data-disable-with`.
 *
 * @param {HTMLElement} target
 */
function restoreButtonsFromDisableWith(target) {
    let swapHtml = (button) => {
        let html = button.getAttribute('data-original-html')
        button.removeAttribute('disabled')
        button.removeAttribute('data-riginal-html')
        button.innerHTML = html
    }

    Array.from(target.querySelectorAll('[data-disable-with]')).forEach(swapHtml)
    if (target.hasAttribute('data-disable-with')) swapHtml(target)
}

/**
 * Dispatches an event on the document.
 *
 * @param {string} eventName
 * @param {*} detail
 */
function triggerEvent(eventName, detail) {
    document.dispatchEvent(new CustomEvent(eventName, { detail }))
}

/**
 * HTML for the spinner preppended when disabling elements.
 *
 * @return {string}
 */
function prependSpinnerDisableWith() {
    let template = document.querySelector('#reflinks-disable-with-spinner')
    return template ? template.innerHTML : ''
}
