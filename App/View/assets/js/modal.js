//@ts-check

class Modal {

    static #elementsId = Object.freeze({
        CONTAINER :'modal-global-container',
        TITLE: 'modal-global-title',
        BODY: 'modal-global-body',
        CLOSE_BUTTON: 'modal-global-close-button',
        CONFIRM_BUTTON: 'modal-global-action-button'
    }) 


    static showModal(arg){
        
    }

    static #setInnerHtml(html, elemento){
        const el = this.#getById(elemento)

        if(!el)return

        el.innerHTML = html

    }

    static #isModalInDocument(){
        const elements = Object.values(this.#elementsId)

        return !elements.some(item => item === null)
    }

    static #getById(id){
        return document.getElementById(id)
    }

}



