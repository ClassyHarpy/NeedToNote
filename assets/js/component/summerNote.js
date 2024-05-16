$(document).ready(function () {
    const saveButton = () => {
        const ui = $.summernote.ui;
        const button = ui.button({
            contents: 'Save',
            click: () => save($('#summernote').summernote('code'))
        });

        return button.render();
    }

    $('#summernote').summernote({
        tabsize: 2,
        height: "100%",
        focus: true,
        disableResizeEditor: true,
        toolbar: [
            [
                'style', ['style']
            ],
            [
                'font',
                [
                    'bold', 'underline', 'clear'
                ]
            ],
            [
                'color', ['color']
            ],
            [
                'para',
                [
                    'ul', 'ol', 'paragraph'
                ]
            ],
            [
                'table', ['table']
            ],
            [
                'insert',
                [
                    'link'
                ]
            ],
            [
                'view',
                [
                    'help'
                ]
            ],
            ['actions',
                ['save']
            ]
        ],
        buttons: {
            save: saveButton,
        }
    });

    $('#summernote').summernote('code', htmlDecode($('#summernote').data("html")));
})

const alert = '<div class="alert alert-info alert-dismissible d-flex align-items-center fade show" role="alert"><svg class="bi flex-shrink-0 me-2" height="24px" width="24px" role="img"><use xlink:href="#info"/></svg><div>Successfully saved!</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

function save(html) {
    fetch(`${location.pathname}/save`, { method: "POST", body: JSON.stringify({ html }) }).then(() => {
        document.getElementById("flashes").innerHTML += alert;
    }).finally(() => {
        Array.from(document.getElementsByClassName("alert")).forEach((element) => {
            setTimeout(() => {
                element.querySelector(".btn-close").click();
            }, 3000);
        });
    })
}

function htmlDecode(input) {
    const doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}