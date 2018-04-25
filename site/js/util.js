function api(resource, action, params, onload) {
    const req = new XMLHttpRequest()
    req.onload = () => {
        onload(req)
    }

    if (action.toLowerCase() == 'get') {
        let url = 'api.php?api_resource=' + encodeURIComponent(resource)

        Object.keys(params).map(key => {
            url += '&' + key + '=' + encodeURIComponent(params[key])
        })

        req.open('GET', url)
        req.send()
    } else {
        const formData = new FormData()

        Object.keys(params).forEach(key => {
            console.log('appending param' + key)
            formData.append(key, params[key])
        })
        
        formData.append('api_resource', resource)
        formData.append('api_action', action)

        req.open('POST', 'api.php')
        req.send(formData)
    }
}
