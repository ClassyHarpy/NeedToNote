import './styles/app.scss';

Array.from(document.getElementsByClassName("alert")).forEach((element) => {
    setTimeout(() => {
        element.querySelector(".btn-close").click();
    }, 3000);
});

Array.from(document.getElementsByClassName("delete-note")).forEach((element) => {
    element.addEventListener("click", (event) => {
        if (!confirm("Are you shure you want to delete the notebook?")) {
            event.preventDefault();
        }
    })
});