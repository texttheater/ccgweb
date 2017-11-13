// replaces element "from" with "to" in the tab order
function transferTabOrder(from, to) {
    to.tabIndex = from.tabIndex
    from.removeAttribute('tabindex')
}

// initializes the UI for creating supertag BOWs
function initSuperBOWs() {
    document.querySelectorAll('div#parses_mine table.lex').forEach(table => {
        const td = table.querySelector('td.cat')
        td.onfocus = event => {
            if (busy) {
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
                    busy = true
                    api(
                        'sentences/eng/' + encodeURIComponent(sentence) + '/' + encodeURIComponent(userName),
                        'add_super_bow',
                        {
                            offset_from: table.dataset['from'],
                            offset_to: table.dataset['to'],
                            tag: input.value
                        },
                        () => {
                            console.log(this.responseText)
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
    const lexes = document.querySelectorAll('div#parses_mine table.lex')
    let spanStart = null
    for (const lex of lexes) {
        const swiper = lex.querySelector('td.span-swiper')
        swiper.onmousedown = event => {
            if (busy) {
                return
            }
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
        const selectedLexes = document.querySelectorAll('div#parses_mine table.lex.selected')
        if (selectedLexes.length < 2) {
            for (const lex of selectedLexes) {
                lex.classList.remove('selected')
            }
        } else {
            const spanFrom = selectedLexes[0].dataset['from']
            const spanTo = selectedLexes[selectedLexes.length - 1].dataset['to']
            busy = true
            api(
                'sentences/eng/' + encodeURIComponent(sentence) + '/' + encodeURIComponent(userName),
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

let busy = false
initSuperBOWs()
initSpanBOWs()
