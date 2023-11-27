import './styles/app.scss';

import './ts/like'
import {createApp} from 'vue';

import {createPinia} from 'pinia';
import {getTranslator} from "@/ts/translator";
import i18n from "@/vue/plugins/i18n";

getTranslator().then(translator => {
    const app = createApp(require('@/vue/App.vue').default)

    app.use(createPinia())
        .use(i18n, {translator})
        .component('Like', require('@/vue/components/Like/Like.vue').default)
        .component('BurgerButton', require('@/vue/components/BurgerButton/BurgerButton.vue').default)
        .component('user-dropdown', require('@/vue/components/UserDropdown/UserDropdown.vue').default)
        .mount('#app');
})
