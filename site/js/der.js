// replaces element "from" with "to" in the tab order
function transferTabOrder(from, to) {
    to.tabIndex = from.tabIndex
    from.removeAttribute('tabindex')
}

// initializes the UI for creating supertag BOWs
function initSuperBOWs() {
    document.querySelectorAll('div.editable table.lex').forEach(table => {
        const td = table.querySelector('td.cat')
        td.onfocus = event => {
            if (busy || isMarkedCorrect()) {
                return
            }
            if (td.firstChild.nodeType == Node.TEXT_NODE) {
                const currentCat = td.textContent.trim()
                const input = document.createElement('input')
                transferTabOrder(td, input)
                input.type = 'text'
                input.value = currentCat
                td.removeChild(td.firstChild)
                td.appendChild(input)
                input.focus()
                input.onblur = event => {
                    transferTabOrder(input, td)
                    let newCat = input.value.trim()
    
                    if (newCat == '') {
                        newCat = '\u00A0' // non-breaking space
                    }
    
                    const textNode = document.createTextNode(newCat)
                    td.removeChild(input)
                    td.appendChild(textNode)
                }
                input.onchange = event => {
                    goBusy()
                    api(
                        'sentences/' + lang + '/' + encodeURIComponent(sentence),
                        'add_super_bow',
                        {
                            offset_from: table.dataset['from'],
                            offset_to: table.dataset['to'],
                            tag: input.value
                        },
                        req => {
                            console.log(req.responseText)
                            window.location.reload()
                        }
                    )
                }
            }
        }
    })
}

// initializes the UI for creating span BOWs
function initSpanBOWs() {
    const lexes = document.querySelectorAll('div.editable table.lex')
    let spanStart = null
    for (const lex of lexes) {
        const swiper = lex.querySelector('td.span-swiper')
        if (swiper == null) {
            continue
        }
        swiper.onmousedown = event => {
            if (busy || isMarkedCorrect()) {
                return
            }
            event.preventDefault()
            spanStart = event.clientX
            lex.classList.add('selected')
        }
    }
    document.addEventListener('mousemove', event => {
        if (spanStart == null) {
            return
        }
        event.preventDefault()
        const spanEnd = event.clientX
        for (const lex of lexes) {
            const swiper = lex.querySelector('td.span-swiper')
            if (swiper == null) {
                continue
            }
            const rect = swiper.getBoundingClientRect()
            if ((spanStart < rect.left && spanEnd < rect.left) ||
                    (spanStart > rect.right && spanEnd > rect.right)) {
                lex.classList.remove('selected')
            } else {
                lex.classList.add('selected')
            }
        }
    })
    document.addEventListener('mouseup', event => {
        if (spanStart == null) {
            return
        }
        const selectedLexes = document.querySelectorAll('div.editable table.lex.selected')
        if (selectedLexes.length < 2) {
            for (const lex of selectedLexes) {
                lex.classList.remove('selected')
            }
        } else {
            const spanFrom = selectedLexes[0].dataset['from']
            const spanTo = selectedLexes[selectedLexes.length - 1].dataset['to']
            goBusy()
            api(
                'sentences/' + lang +'/' + encodeURIComponent(sentence),
                'add_span_bow',
                {
                    offset_from: spanFrom,
                    offset_to: spanTo
                },
                () => {
                    console.log(this.responseText)
                    window.location.reload()
                }
            )
        }
        spanStart = null
    })
}

function initMarkCorrect() {
    const input = document.querySelector('input#mark-correct')
    if (input == null) {
        return
    }
    input.onchange = event => {
        goBusy()
        api(
            'sentences/' + lang + '/' + encodeURIComponent(sentence),
            'mark_correct',
            {
                correct: input.checked
            },
            () => {
                window.location.reload()
            }
        )
    }
}

function initReset() {
    const a = document.querySelector('a#reset-link')
    if (a === null) {
        return
    }
    a.onclick = e => {
        e.preventDefault()
        if (busy) {
            return
        }
        if (window.confirm("Reset your derivation to auto derivation?")) {
            goBusy()
            api(
                'sentences/' + lang + '/' + encodeURIComponent(sentence),
                'reset',
                {},
                () => {
                    window.location.reload()
                }
            )
        }
    }
}

function isMarkedCorrect() {
    const input = document.querySelector('input#mark-correct')
    return input.checked
}

function goBusy() {
    busy = true
    document.querySelector('input#mark-correct').disabled = true
}

let busy = false
initSuperBOWs()
initSpanBOWs()
initMarkCorrect()
initReset()
