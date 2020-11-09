
require('./bootstrap');
window.Vue = require('vue');
import store from './store/index'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';
import Vue from "vue";
import router from './router/router';
import Testcard from './components/testcard/Testcard.vue';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
  
Vue.use(VueAxios, axios);
Vue.use(VueRouter);

axios.interceptors.request.use(function(config) {
   config.headers.common = {
     Authorization: `Bearer ${localStorage.getItem("authToken")}`,
     "Content-Type": "application/json",
     Accept: "application/json"
   };
 
   return config;
 });

 
 Vue.component('navigator',Header);
 Vue.component('footer-view',Footer);
 Vue.component('test-card',Testcard);
 
 const app = new Vue({
    ...App,
    router,
     el: '#app',
     store
  });

 