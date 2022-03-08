import UwuIfy from './components/Uwu-ify.vue';
import { createApp } from 'vue'
require('./bootstrap');

// var i = 0;
// counter  = function() {
//     i++;
//     if (i === 10) {
//         document.getElementById('musketier').classList.remove('hidden-input')
//     }
// }

createApp({
    components: { UwuIfy },
}).mount('#uwu')

