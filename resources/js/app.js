require('./bootstrap');

    document.getElementById("sarcasmButt").addEventListener("click", sarcasmify)
    document.getElementById("copyButt").addEventListener("click", copyURL)

    function sarcasmify() {
        var text = document.getElementById("text").value.toLowerCase();
        var sarcasm = document.getElementById("sarcasm");
        var textArray = text.split('');

        for (let i = 0; i < textArray.length; i++) {

            if (Math.floor(Math.random() * 2) == 0) {
                textArray[i] = textArray[i].toUpperCase();
            }
        }

        sarcasm.value = textArray.join('')
    }

    function copyURL() {
        var input = document.getElementById("sarcasm");
        input.select(),
        input.setSelectionRange(0,99999),
        document.execCommand("copy")
    }
