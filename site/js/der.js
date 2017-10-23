if (isUserLoggedIn) {
    document.querySelectorAll('table.lex td.cat').forEach(td => {
        td.onfocus = event => {
            if (td.firstChild.nodeType == Node.TEXT_NODE) {
                const currentCat = td.textContent
                const input = document.createElement('input')
                input.type = 'text'
                input.value = currentCat
                td.removeChild(td.firstChild)
                td.appendChild(input)
                input.focus()
                input.onblur = event => {
                    const textNode = document.createTextNode(input.value)
                    td.removeChild(input)
                    td.appendChild(textNode)
                }
            }
        }
    })
}
