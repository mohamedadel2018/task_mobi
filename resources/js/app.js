require('./bootstrap');

// import Vue from 'vue';

import { createApp } from 'vue';

// import router File
import router from "./router.js";

// import VueX File
import store from './Vuex.js'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'


import Paginate from "vuejs-paginate-next";




import moment from 'moment';





router.beforeEach(function (to, from, next) {
  console.log('to',to);
    console.log('beforeEach', to.path + ' - Auth: ' + store.getters.isLoged)
    if ((to.path !== '/login' && to.path !== 'login'  && to.path !== '/register') && !store.getters.isLoged   ) {
        next({ path: '/login' })
    } else if ((to.path === '/login' || to.path === 'login'  || to.path !== '/register') && store.getters.isLoged) {
      next()
    } else {
      next()
    }
  });
  
  
  
// Whenerver Server Gives 401 Status Code, it logouts and redirect to login page
// router.push(function (request, next) {
// next(function (response) {
//       if (response.status === 401) {
//         let msg = response.body.returnMessage
//         localStorage.setItem('logoutReason', msg)
//         auth.logout()
//       }
//     })
//   });

  
//   axios.interceptors.response.use(
//     response => {
//       return response
//     },
//     error => {
//       if (error.response.status === 401) {
//         this.$router.push({ name: 'login' })
//         localStorage.removeItem('userToken')
//         store.getters.isLoged = false;
//       }
  
//       return Promise.reject(error)
//     }
//   )





axios.interceptors.response.use(
  response => {
      return response;
  },
  err =>{
      const {
          config,
          response: {status, data}
      } = err;

      // console.log('status',status);
      if(status === 401 || data.message === 'Expired token' ){
        // router.push({path :'/login'});
          store.commit('removeUserToken');
          store.getters.isLoged = false;
      }
  }
);





import dashboardComponent from './components/layout/dashboardComponent.vue';
import registerComponent from './components/Auth/registerComponent.vue';
import login from './components/Auth/login.vue';
import userComponent from './components/users/userComponent.vue';
import projectsComponent from './components/projects/projectsComponent.vue';
import showproject from './components/projects/showproject.vue';
import tasksComponent from './components/tasks/tasksComponent.vue';
import showtask from './components/tasks/showtask.vue';




createApp({
    components: {
        registerComponent,
        dashboardComponent,
        login,
        userComponent,
        projectsComponent,
        showproject,
        tasksComponent,
        showtask,
    }
    
}).use(router).use(store).use(ElementPlus).use(Paginate).mount('#app');


