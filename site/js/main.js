document.querySelectorAll('table.lex td.cat').forEach(td => {
    td.onclick = event => {
        if (td.firstChild.nodeType == Node.TEXT_NODE) {
            const currentCat = td.textContent
            const input = document.createElement('input')
            input.type = 'text'
            input.value = currentCat
            td.removeChild(td.firstChild)
            td.appendChild(input)
        }
    }
})
