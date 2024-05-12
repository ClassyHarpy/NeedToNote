import './styles/app.scss';

Array.from(document.getElementsByClassName("alert")).forEach((element) => {
    setTimeout(() => {
        element.querySelector(".btn-close").click();
    }, 3000);
});
