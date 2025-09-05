//@ts-check

document.addEventListener('DOMContentLoaded', () => {
    /**
     * @type {HTMLCollectionOf<Element>}
     */
    const backButtons = document.getElementsByClassName('back-button')

    if(backButtons.length !== 0){
        Array.from(backButtons).forEach(button => {
            /** @type {HTMLButtonElement} */
            const btn = /** @type {HTMLButtonElement} */ (button);
            btn.addEventListener('click', (event) => {
                event.preventDefault()
                history.back()
            })
        });
    }
})