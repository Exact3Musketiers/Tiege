import '../sass/app.scss';
import './bootstrap';
import 'bootstrap';

import {createApp} from 'vue'
import UwuIfy from './components/Uwu-ify.vue';
import WikiChallengeStarter from './components/WikiChallengeStarter.vue';


createApp({
    components: { UwuIfy,WikiChallengeStarter }
}).mount('#app')
