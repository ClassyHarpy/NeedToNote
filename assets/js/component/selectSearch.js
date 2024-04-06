class selectSearchClass {
    constructor() {
        this.#setListeners();
    }

    #setListeners() {
        Array.from(document.querySelectorAll(".select-search .select-search-btn")).forEach(element => {
            element.addEventListener("click", this.#onOpen);
            element.parentNode.querySelector(".select-search-input").addEventListener("input", this.#onSearch);
        });

        document.addEventListener("click", (event) => {
            // todo
            return;
            Array.from(document.querySelectorAll(".select-search .select-search-content")).forEach(element => {
                element?.classList.toggle("d-none");
            });
        })
    }

    #onOpen(event) {
        const target = event.currentTarget;
        
        if (event.target !== target) {
            return;
        }

        target.parentNode.querySelector(".select-search-content")?.classList.toggle("d-none");
    }

    #onSearch(event) {
        const target = event.currentTarget;
        const searchValue = target.value;
        const notFound =  target.parentNode.querySelector("[data-select-not-found]");

        // Logic not found
        notFound.classList.toggle("d-none");
        notFound.querySelector("span").innerText = searchValue;
        target.parentNode.querySelector(".select-search-items-inner").classList.toggle("d-none");
    }
}

const selectSearch = new selectSearchClass();