require('./bootstrap');

var i = 0;
counter  = function() {
    i++;
    if (i === 10) {
        document.getElementById('musketier').classList.remove('hidden-input')
    }
}
