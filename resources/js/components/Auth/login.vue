<template>
    <div class="container h-100  m-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Login</h1>
                        <hr/>
                        <form action="javascript:void(0)" class="row" method="post">
                            <div class="row col-12" v-if="validationErrors.length != 0">
                                <div class="alert alert-danger pl-0">
                                    <ul class="mb-0">
                                        <li v-for="(error, key) in validationErrors" :key="key">{{ error[0] }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" v-model="auth.email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" v-model="auth.password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Don't have an account? <router-link :to="{path:'/register'}">Register Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"login",
    data(){
        return {
            auth:{
                email:"",
                password:""
            },
            validationErrors:{
                length : 0,
            },
            processing:false
        }
    },
    methods:{
      
      async login(){
            this.processing = true
            await axios.post('api/login',this.auth).then(res =>{
                // console.log(res);
                this.$store.commit('setUserToken', res.data.token);
                this.$router.push({path: '/users'});
            }).catch(err =>{
                if(err.response != null)
                {
                    this.validationErrors = err.response.data.errors;
                }

                }).finally(()=>{
                this.processing = false
            })
        },


        async checklogin(){
           await axios.get('api/user').then(res => {
                console.log(res.data);
            })
        },
    },
    
    computed:{
        isLoged(){
            return this.$store.getters.isLoged;
        }
    }
}
</script>


<style scoped>
.m-100{
    margin-top:150px;
}
</style>