
function initQuill(element) {

    var quill = new Quill(element, {
        modules: {
            toolbar: [
                ['italic', 'underline'],
                [{ script: 'super' }, { script: 'sub' }]
            ]
        },
        formats: ['italic', 'underline', 'script', 'symbol'],
        placeholder: '',
        theme: 'snow' // or 'bubble'
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        var delta = quill.getContents()
        console.log(delta);
        var str = $(element).find('.ql-editor p').html()
        console.log(str);
        // var str = ""
        // delta.ops.forEach(el => {
        //     if (el.attributes !== undefined) {
        //         // if (el.attributes.bold) str += "<b>";
        //         if (el.attributes.italic) str += "<i>";
        //         if (el.attributes.underline) str += "<u>";
        //     }
        //     str += el.insert;
        //     if (el.attributes !== undefined) {
        //         if (el.attributes.underline) str += "</u>";
        //         if (el.attributes.italic) str += "</i>";
        //         // if (el.attributes.bold) str += "</b>";
        //     }
        // });
        // $('.add-form #title').val(str)
        $(element).next().val(str)
    });

    // add additional symbol toolbar for greek letters
    var additional = $('<span class="ql-formats">')
    var symbols = ['α', 'β', 'π', 'Δ']
    symbols.forEach(symbol => {
        var btn = $('<button type="button" class="ql-symbol">')
        btn.html(symbol)
        btn.on('click', function () {
            // $('.symbols').click(function(){
            quill.focus();
            var symbol = $(this).html();
            var caretPosition = quill.getSelection(true);
            quill.insertText(caretPosition, symbol);
            // });
        })
        additional.append(btn)
    });

    $('.ql-toolbar').append(additional)
}

function getLang() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (urlParams.has('lang')) return urlParams.get('lang');
    return 'de';
}


function lang(en, de = null) {
    var language = getLang();
    if (de === null || language == 'end') return en;
    return de;
}