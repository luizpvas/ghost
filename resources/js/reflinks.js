listenForClicksAndSubmitsRelativeTo(document, 'body')

customElements.define(
    'reflinks-frame',
    class extends HTMLElement {
        connectedCallback() {
            if (!this.id) return console.error('reflinks-frame must have an id.', this)

            listenForClicksAndSubmitsRelativeTo(this, '#' + this.id)
        }
    }
)

function listenForClicksAndSubmitsRelativeTo(container, rootSelector) {
    container.addEventListener('click', (ev) => {
        let target = interceptableTarget(ev.target)
        if (!target) return
        if (shouldIgnore(target)) return

        ev.preventDefault()
        ev.stopPropagation()

        let method = (target.getAttribute('method') || 'GET').toUpperCase()
        if (method == 'GET') {
            navigate(target.getAttribute('href'), { rootSelector })
        } else {
            submit(target, { rootSelector })
        }
    })

    container.addEventListener('submit', (ev) => {
        ev.preventDefault()
        let form = ev.target
        let action = form.getAttribute('action')
        let method = (form.getAttribute('method') || 'POST').toUpperCase()

        if (method == 'GET') {
            let querystring = new URLSearchParams(new FormData(form)).toString()
            navigate(action + '?' + querystring, { rootSelector })
        } else {
            submit(form, { rootSelector })
        }
    })
}

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
 * @param {*} opts
 * @return {Promise<void>}
 */
async function navigate(url, opts = {}) {
    window.history.pushState({ reflinks: true }, null, url)

    try {
        let { data } = await axios.get(url)
        let doc = document.createElement('html')
        doc.innerHTML = data
        let newBody = doc.querySelector(opts.rootSelector)
        let currentBody = document.body.parentElement.querySelector(opts.rootSelector)

        currentBody.parentElement.replaceChild(newBody, currentBody)

        triggerEvent('reflinks:load')
    } catch (err) {
        location = url
    }
}

/**
 * Submits the given form.
 *
 * @param {HTMLFormElement} method
 * @param {*} opts
 */
async function submit(target, opts = {}) {
    let method = target.getAttribute('method')
    let url = target.getAttribute('action') || target.getAttribute('href')
    let data = target.tagName == 'FORM' ? new FormData(target) : null

    updateButtonsDisableWith(target)
    clearValidationErrors(target)

    await new Promise((resolve) => setTimeout(resolve, 1000))

    try {
        let response = await axios({ method, url, data })
        applyDirectives(response.data.directives, opts)
    } catch (err) {
        if (err.response.status == 422) {
            showValidationErrors(target, err.response.data.errors)
        }
    } finally {
        restoreButtonsFromDisableWith(target)
    }
}

/**
 * Applies the list of directives to redirect, append, update, delete, etc.
 *
 * @param {*} directives
 * @param {*} opts
 */
function applyDirectives(directives, opts) {
    for (let directive of directives) {
        if (directive.redirect) {
            navigate(directive.redirect, opts)
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
