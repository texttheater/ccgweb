if (isUserLoggedIn) {
    document.querySelectorAll('table.lex').forEach(table => {
        const td = table.querySelector('td.cat')
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
                input.onchange = event => {
                    const req = new XMLHttpRequest()
                    req.open('POST', 'api.php')
                    const formData = new FormData()
                    formData.append('api_resource', 'sentences/' + encodeURIComponent(sentence) + '/' + encodeURIComponent(userName))
                    formData.append('api_action', 'add_super_bow')
                    formData.append('offset_from', table.dataset['from'])
                    formData.append('offset_to', table.dataset['to'])
                    formData.append('tag', input.value)
                    req.onload = function() {
                        console.log(this.responseText)
                    }
                    req.send(formData)
                }
            }
        }
    })
}
