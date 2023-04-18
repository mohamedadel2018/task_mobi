import {createRouter, createWebHistory } from "vue-router";
import store from './Vuex.js'

import registerComponent from './components/Auth/registerComponent.vue';
import dashboardComponent from './components/layout/dashboardComponent.vue';
import login from './components/Auth/login.vue';
import userComponent from './components/users/userComponent.vue';
import projectsComponent from './components/projects/projectsComponent.vue';
import showproject from './components/projects/showproject.vue';
import tasksComponent from './components/tasks/tasksComponent.vue';
import showtask from './components/tasks/showtask.vue';


// for make user token in every request && after refresh page
import axios from "axios";
axios.defaults.headers.common['Authorization'] = 'Bearer '  +  localStorage.getItem('userToken') ;

axios.interceptors.response.use(
    response => {
        return response;
    },
    err =>{
        const {
            config,
            response: {status, data}
        } = err;
  
        if(status === 401 || data.message === 'Expired token' ){
          // router.push({path :'/login'});
            store.commit('removeUserToken');
            store.getters.isLoged = false;
        }
    }
  );

  
const routes = [
    {
        path: "/",
        name: "dashboardComponent",
        component: dashboardComponent,
        redirect: { name: 'tasksComponent' }
    },
    {
        path: "/register",
        name: "registerComponent",
        component: registerComponent,
    },
    {
        path: "/login",
        name: "login",
        component: login,
    },
    {
        path: "/users",
        name: "userComponent",
        component: userComponent,
    },
    {
        path: "/projects",
        name: "projectsComponent",
        component: projectsComponent,
    },
    {
        path: '/showproject/:id',
        name: 'showproject',
        component: showproject,
    },
    {
        path: "/tasks",
        name: "tasksComponent",
        component: tasksComponent,
    },
    {
        path: '/showtask/:id',
        name: 'showtask',
        component: showtask,
    }
];



// const routes =  [
//       {
//         path: '/',
//         component: dashboardComponent,
//         meta: {
//             middleware: "auth"
//         },
//         children: [
          
//             {
//                 path: "/login",
//                 name: "login",
//                 component: login,
             

//             },
//             {
//                 path: "/register",
//                 name: "registerComponent",
//                 component: registerComponent,
//             },

//             {
//                 path: "/users",
//                 name: "userComponent",
//                 component: userComponent,
//             },

//             {
//                         path: "/projects",
//                         name: "projectsComponent",
//                         component: projectsComponent,
//             },
        
//             {
//                 path: '/showproject/:id',
//                 name: 'showproject',
//                 component: showproject,
//             }

//         ]
//       },
//       {
//         path: "/",
//         name: "dashboardComponent",
//         component: dashboardComponent,
//     },
//     ];
  


  

const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router;