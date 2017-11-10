function transferTabOrder(from, to) {
    to.tabIndex = from.tabIndex
    from.removeAttribute('tabindex')
}

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
                    'sentences/' + encodeURIComponent(sentence) + '/' + encodeURIComponent(userName),
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
    const draggable = table.querySelector('span.span-draggable')
    draggable.ondragstart = event => {
        const dragImage = event.target.cloneNode(true)
        dragImage.style.display = 'none'
        document.body.appendChild(dragImage)
        event.dataTransfer.setDragImage(dragImage, 0, 0)
        event.dataTransfer.effectAllowed = 'none' // does not work in Chromium >:(
    }
})
