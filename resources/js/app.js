/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { InfoIcon, LoaderIcon, SearchIcon, TvIcon } from "vue-feather-icons";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('search-component', require('./components/SearchComponent.vue').default);
Vue.component('episodes-component', require('./components/EpisodesComponent.vue').default);

Vue.component('info-icon', InfoIcon);
Vue.component('loader-icon', LoaderIcon);
Vue.component('search-icon', SearchIcon);
Vue.component('tv-icon', TvIcon);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data() {
        return {
            modal: false,
        }
    },

    mounted() {
        const modal = document.getElementById('info-modal');

        if(modal) {
            modal.classList.remove('hidden');
        }
    },

    watch: {
        modal(value) {
            plausible(value ? 'Show info modal' : 'Close info modal');
        }
    },
});
