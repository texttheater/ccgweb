function initViews() {
    const parses = document.querySelectorAll('div.parse')
    for (const parse of parses) {
        const buttons = parse.querySelectorAll('button.view-button')
        const views = parse.querySelectorAll('div.view')
        for (const button of buttons) {
            button.onclick = () => {
                for (b of buttons) {
                    b.classList.remove('btn-primary')
                    b.classList.add('btn-default')
                }
                button.classList.remove('btn-default')
                button.classList.add('btn-primary')
                for (view of views) {
                    if (view.dataset.viewType == button.dataset.viewType) {
                        view.classList.add('view-active')
                    } else {
                        view.classList.remove('view-active')
                    }
                }
            }
        }
    }
}

initViews()
