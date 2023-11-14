import './styles/app.scss';

import 'plyr/dist/plyr.css';

import './ts/like'
import {createApp} from 'vue';

import {createPinia} from 'pinia';
import {getTranslator} from "@/ts/translator";
import i18n from "@/vue/plugins/i18n";

import VuePlyr from 'vue-plyr'
import 'vue-plyr/dist/vue-plyr.css'

getTranslator().then(translator => {
    const app = createApp(require('@/vue/App.vue').default)

    app.use(createPinia())
        .use(i18n, {translator})
        .use(VuePlyr, {
            plyr: {}
        })
        .component('Like', require('@/vue/components/Like/Like.vue').default)
        .component('BurgerButton', require('@/vue/components/BurgerButton/BurgerButton.vue').default)
        .component('youtube-player', require('@/vue/components/YoutubePlayer/YoutubePlayer.vue').default)
        .component('user-dropdown', require('@/vue/components/UserDropdown/UserDropdown.vue').default)
        .mount('#app');
})
