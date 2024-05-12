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

function save(html) {
    fetch(`${location.pathname}/save`, { method: "POST", body: JSON.stringify({ html }) }).then(() => {
        // TODO
    })
}

function htmlDecode(input) {
    const doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}