import './styles/app.scss';

import 'plyr/dist/plyr.css';

import './ts/talk'

import {createApp} from 'vue';

createApp({})
    .component('Example', require('@/vue/Example.vue').default)
    .mount('#app');
