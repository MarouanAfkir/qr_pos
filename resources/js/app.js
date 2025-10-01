import Vue from "vue/dist/vue.esm.js"; // runtime+compiler build for Vue 2

window.axios = require("axios");
window.Vue = Vue;

import VueApexCharts from "vue-apexcharts";

Vue.component("apexchart", VueApexCharts);

// Example global component
import Pos from "./components/Pos.vue";
Vue.component("pos", Pos);

import PosCashierDaily from "./components/PosCashierDaily.vue";
Vue.component("pos-daily-report", PosCashierDaily);

import OrdersAdmin from "./components/OrdersAdmin.vue";
Vue.component("orders-admin", OrdersAdmin);

new Vue({
    el: "#app",
});
