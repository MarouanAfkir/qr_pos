import Vue from "vue/dist/vue.esm.js"; // runtime+compiler build for Vue 2

window.axios = require("axios");
window.Vue = Vue;

// Example global component
import Pos from "./components/Pos.vue";
Vue.component("pos", Pos);
import OrdersAdmin from "./components/OrdersAdmin.vue";
Vue.component("orders-admin", OrdersAdmin);

new Vue({
    el: "#app",
});
