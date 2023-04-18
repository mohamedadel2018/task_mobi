
import Vuex from 'vuex'
import router from "./router.js";

const store = new Vuex.Store({
    state: {
     userToken :  localStorage.getItem('userToken') || null,
     users: {},
     userAuth: {},
    },
    getters: {
        isLoged(state) {
          return !!state.userToken;
        }
      },

      mutations: {
       setUserToken(state,userToken)
       {
        console.log(userToken);
        state.userToken = userToken;
        localStorage.setItem('userToken',userToken);
        // axios.defaults.headers.common.Authorization = `Bearer ${userToken}`;
        console.log( 'userToken', localStorage.getItem('userToken')[0] );
        axios.defaults.headers.common['Authorization'] = 'Bearer '  +  localStorage.getItem('userToken') ;

       },
       removeUserToken(state)
       {
        state.userToken = null;
        localStorage.removeItem('userToken');
        axios.defaults.headers.common.Authorization = ``;
        router.push({path :'/login'});
       },

       setUsers(state,users){
            state.users = users;
       },

       setUserAuth(state,userAuth){
        state.userAuth = userAuth;
         },

       
      },
      actions:{

       async RegisterUser({commit},payload){
            return await axios.get('/api/register',payload).then(({res})=>{
                console.log(res);
                commit('setUserToken',res.data.token);
                router.push({name:'dashboard'})
            }).catch(err => {console.log(err) });
        },


        async  LoginUser({commit},payload){
            return await axios.get('/api/login',payload).then(({res})=>{
                console.log(res);
                commit('setUserToken',res.data.token);

                router.push({name:'dashboard'})
            }).catch(err => {console.log(err) });
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        },
        async  getUsers({commit}){
            return  await  axios.get('api/users').then(res => {
                // this.state.users = res.data;
                commit('setUsers', res.data);
            }).catch(err =>  { console.log(err); });
        },
      async  getAuth({commit}){
         return await axios.get('/api/user').then(res => {
                // this.state.users = res.data;
                commit('setUserAuth', res.data);
            }).catch(err =>  { console.log(err); });
        }
    }
      
   
  });
  
  export default store;