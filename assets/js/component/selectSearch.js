class selectSearchClass {
    constructor() {
        this.#setListeners();
    }

    #setListeners() {
        Array.from(document.querySelectorAll(".select-search .select-search-btn")).forEach(element => {
            element.addEventListener("click", this.#onOpen);
            element.parentNode.querySelector(".select-search-input").addEventListener("input", this.#onSearch);
        });

        Array.from(document.querySelectorAll(".select-search [data-select-id]")).forEach(element => {
            element.addEventListener("click", this.#onSelect);
        });

        Array.from(document.querySelectorAll(".select-search [data-select-not-found]")).forEach((element) => {
            element.addEventListener("click", this.#createMainNote.bind(this));
        })

        document.addEventListener("click", (event) => {
            // todo
            return;
            Array.from(document.querySelectorAll(".select-search .select-search-content")).forEach(element => {
                element?.classList.toggle("d-none");
            });
        })
    }

    #onSelect(event) {
        const target = event.currentTarget;
        const selectSearch = target.parentNode.parentNode.parentNode.parentNode.querySelector(".select-search-btn span");
        const selectInput = target.parentNode.parentNode.parentNode.parentNode.querySelector(".select-search-btn input[type='text']")
        const dropdown = target.parentNode.parentNode.parentNode;

        dropdown.classList.toggle("d-none");
        selectSearch.innerText = target.innerText;
        selectInput.value = target.dataset.selectId;
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
        const notFound = target.parentNode.querySelector("[data-select-not-found]");
        const items = target.parentNode.querySelectorAll("[data-select-id]");
        let foundCount = 0;

        Array.from(items).forEach((item) => {
            if (!item.innerText.includes(searchValue)) {
                item.classList.add("d-none");
            } else {
                foundCount++
                item.classList.remove("d-none");
            };
        })

        if (!foundCount) {
            notFound.classList.remove("d-none");
            notFound.querySelector("span").innerText = searchValue;

            target.parentNode.querySelector(".select-search-items-inner").classList.add("d-none");
        } else {
            notFound.classList.add("d-none");
            target.parentNode.querySelector(".select-search-items-inner").classList.remove("d-none");
        }
    }

    #createMainNote(event) {
        const target = event.currentTarget;
        const url = target.dataset.selectNotFound;
        const title = target.querySelector("span").innerText;

        fetch(url, { method: "POST", body: JSON.stringify({ title }) })
            .then((response) => response.json())
            .then((response) => {
                alert(response.response);

                const mainNoteElement = document.createElement("h6");
                const parent = target.parentNode.parentNode.parentNode;

                const selectSearch = parent.querySelector(".select-search-btn span");
                const selectInput = parent.querySelector(".select-search-btn input[type='text']")
                const dropdown = parent.querySelector(".select-search-content");

                mainNoteElement.dataset.selectId = response.id;
                mainNoteElement.className = "select-search-item fw-light text-black p-2 rounded";
                mainNoteElement.innerText = title;
                mainNoteElement.addEventListener("click", this.#onSelect);

                dropdown.classList.toggle("d-none");
                selectSearch.innerText = title;
                selectInput.value = response.id;

                target.parentNode.querySelector(".select-search-items-inner").appendChild(mainNoteElement);
            }).catch(console.error)
    }
}

const selectSearch = new selectSearchClass();