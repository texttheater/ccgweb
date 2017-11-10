document.querySelectorAll('div#parses_mine table.lex').forEach(table => {
    const td = table.querySelector('td.cat')
    td.onfocus = event => {
        if (td.firstChild.nodeType == Node.TEXT_NODE) {
            const currentCat = td.textContent.trim()
            const input = document.createElement('input')
            input.type = 'text'
            input.value = currentCat
            td.removeChild(td.firstChild)
            td.appendChild(input)
            input.focus()
            input.onblur = event => {
                let newCat = input.value.trim()

                if (newCat == '') {
                    newCat = '\u00A0' // non-breaking space
                }

                const textNode = document.createTextNode(newCat)
                td.removeChild(input)
                td.appendChild(textNode)
            }
            input.onchange = event => {
                api(
                    'sentences/' + encodeURIComponent(sentence) + '/' + encodeURIComponent(userName),
                    'add_super_bow',
                    {
                        offset_from: table.dataset['from'],
                        offset_to: table.dataset['to'],
                        tag: input.value
                    },
                    function() {
                        console.log(this.responseText)
                    }
                )
            }
        }
    }
})
