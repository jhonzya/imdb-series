/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import { InfoIcon, LoaderIcon, SearchIcon, TvIcon } from "vue-feather-icons";

Vue.component('search-component', require('./components/SearchComponent.vue').default);
Vue.component('episodes-component', require('./components/EpisodesComponent.vue').default);

Vue.component('info-icon', InfoIcon);
Vue.component('loader-icon', LoaderIcon);
Vue.component('search-icon', SearchIcon);
Vue.component('tv-icon', TvIcon);

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
});
