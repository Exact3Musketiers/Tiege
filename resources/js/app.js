import UwuIfy from './components/Uwu-ify.vue';
import WikiChallengeStarter from './components/WikiChallengeStarter.vue';
import { createApp } from 'vue'
import './bootstrap';


createApp({
    components: { UwuIfy },
}).mount('#uwu')

createApp({
    components: { WikiChallengeStarter },
}).mount('#wiki')
