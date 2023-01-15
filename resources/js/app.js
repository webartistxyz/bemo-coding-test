import './bootstrap';
import Vue from 'vue/dist/vue.js';
import App from './components/App.vue';
import VueDraggable from 'vuedraggable';
import vmodal from 'vue-js-modal';

Vue.use(vmodal)
Vue.use(VueDraggable)

var app = new Vue({
    render: h => h(App),
})

app.$mount('#app')
