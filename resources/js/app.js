require('./bootstrap');

import VueRouter from 'vue-router'
import Gate from "./Gate";

import swal from 'sweetalert2'
import VueMask from 'v-mask'
import { VueMaskDirective } from 'v-mask'
import money from 'v-money'

import Clientes from './components/pages/clientes/ClientesLista.vue';
import Produtos from './components/pages/produtos/ProdutosLista.vue';
import Vendas from './components/pages/vendas/VendasLista.vue';

window.Vue = require('vue');
window.swal = swal;
window.Event = new Vue();
Vue.prototype.$gate = new Gate(window.user);

Vue.use(VueMask);
Vue.use(money, {
  decimal: '.',
  thousands: '',
  prefix: '',
  suffix: '',
  precision: 2,
  masked: false
});

Vue.directive('mask', VueMaskDirective);
 
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

Vue.use(VueRouter)

let routes = [
  { path: '/', name : 'clientes', component: Clientes },
  { path: '/home', name : 'home', component: Clientes },
  { path: '/clientes', name : 'clientes', component: Clientes },
  { path: '/produtos', name : 'produtos', component: Produtos },
  { path: '/vendas', name : 'vendas', component: Vendas },
  { path: '*', component: Clientes }
];

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
});

Vue.component('app', require('./components/App.vue'));
const app = new Vue({
    el: '#app',
    router,
    props: ['baseUrl']
}); 

var baseUrl = app.$el.baseURI;
window.BaseUrl = baseUrl;