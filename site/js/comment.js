function initComment() {
    const textarea = document.querySelector('textarea#comment')
    const indicator = document.querySelector('small#comment-indicator')
    let timeout
    let timeoutSet = false

    function markCommentSaving() {
        indicator.textContent = 'saving'
    }
    
    function markCommentSaved() {
        indicator.textContent = 'saved'
    }

    function markCommentError() {
        indicator.textContent = 'error'
    }
    
    function submitComment() {
        const text = textarea.value
        api(
            'sentences/' + lang + '/' + encodeURIComponent(sentence),
            'set_comment',
            {
                text: text
            },
            req => {
                if (req.status != 200) {
                    markCommentError()
                    return
                }

                const newText = textarea.value

                if (newText == text) {
                    markCommentSaved()
                } else {
                    markCommentSaving()
                    scheduleSubmitComment()
                }
            }
        )
    }
    
    function scheduleSubmitComment() {
        if (timeoutSet) {
            window.clearTimeout(timeout)
        }

        timeout = window.setTimeout( () => {
            timeoutSet = false
            submitComment()
        }, 1000)
        timeoutSet = true
    }

    textarea.oninput = event => {
        markCommentSaving()
        scheduleSubmitComment()
    }
}

initComment()
