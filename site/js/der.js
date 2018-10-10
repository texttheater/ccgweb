// replaces element "from" with "to" in the tab order
function transferTabOrder(from, to) {
    to.tabIndex = from.tabIndex
    from.removeAttribute('tabindex')
}

// initializes the UI for creating supertag BOWs
function initSuperBOWs() {
    const tables = document.querySelectorAll('div.editable table.lex')
    for (const table of tables) {
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
                            window.location.reload()
                        }
                    )
                }
            }
        }
    }
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
        swiper.classList.add('span-swiper-active')
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

// initializes the UI for marking the derivation correct
function initMarkCorrect() {
    const button = document.querySelector('button#mark-correct')
    if (button == null) {
        return
    }
    button.onclick = event => {
        goBusy()
        button.classList.toggle('btn-default')
        button.classList.toggle('btn-success')
        api(
            'sentences/' + lang + '/' + encodeURIComponent(sentence),
            'mark_correct',
            {
                correct: button.classList.contains('btn-success')
            },
            () => {
                window.location.reload()
            }
        )
    }
}

// initializes the UI for resetting the derivation
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
    const button = document.querySelector('button#mark-correct')
    return button.classList.contains('btn-success')
}

function goBusy() {
    busy = true
    document.querySelector('button#mark-correct').disabled = true
}

// returns the constituents of a parse as a map from [from, to] pairs to
// nodes
function constituentMap(parse) {
    const result = new Map()
    for (const constituent of parse.querySelectorAll('table.constituent')) {
        const spanString = getSpan(constituent).join(',')
        result.set(spanString, constituent)
    }
    return result
}

// returns the span of a constituent as [from, to]
function getSpan(constituent) {
    if (constituent.classList.contains('lex')) {
        const from = parseInt(constituent.dataset.from)
        const to = parseInt(constituent.dataset.to)
        return [from, to]
    } else {
        const lexes = constituent.querySelectorAll('table.lex')
        const from = parseInt(lexes[0].dataset.from)
        const to = parseInt(lexes[lexes.length - 1].dataset.to)
        return [from, to]
    }

}

function diffMarkConstituent(constituent) {
    if (constituent.classList.contains('lex')) {
        constituent.classList.add('diff')
    } else {
        const rulecatTr = constituent.rows[1]
        const rulecatTd = rulecatTr.cells[0]
        rulecatTd.classList.add('diff')
    }
}

function diffMarkCat(constituent) {
    if (constituent.classList.contains('lex')) {
        const catTr = constituent.rows[1]
        const catTd = catTr.cells[0]
        catTd.classList.add('diff')
    } else {
        const rulecatTr = constituent.rows[1]
        const rulecatTd = rulecatTr.cells[0]
        const catDiv = rulecatTr.querySelector('div.cat')
        catDiv.classList.add('diff')
    }
}

// marks all judge constituents red that don't agree with some other user
function initDiff() {
    if (!isUserLoggedIn || userName != judge) {
        return
    }
    for (const jParse of document.querySelectorAll('div.parse')) {
        if (jParse.dataset.user_id != 'judge') {
            continue
        }
        const jMap = constituentMap(jParse)
        for (const uParse of document.querySelectorAll('div.parse')) {
            if (uParse.dataset.user_id == 'auto'
                || uParse.dataset.user_id == 'judge'
                || uParse.dataset.user_id == 'proj'
                || uParse.dataset.user_id == 'xl') {
                continue
            }
            const uMap = constituentMap(uParse)
            for ([jSpan, jConstituent] of jMap) {
                const jCat = jConstituent.dataset.cat
                if (!uMap.has(jSpan)) {
                    diffMarkConstituent(jConstituent)
                    continue
                }
                const uConstituent = uMap.get(jSpan)
                const uCat = uConstituent.dataset.cat
                if (uCat != jCat) {
                    diffMarkCat(jConstituent)
                }
            }
        }
    }
}

let busy = false
initSuperBOWs()
initSpanBOWs()
initMarkCorrect()
initReset()
initDiff()
