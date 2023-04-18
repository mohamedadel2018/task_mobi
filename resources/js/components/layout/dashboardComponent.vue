<template>
    <div>
        <div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light " v-if="$store.getters.isLoged">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary levatione-4" v-if="$store.getters.isLoged" >
  <!-- Brand Logo -->
  <a href="#" class="brand-link" style="cursor: default;">
    <img :src="'/images/users/user-null.jpg'" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light text-bold" ><b>Task Mobi</b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 mb-3 d-flex">
    
      <div class="info">
      <h6>
     
     <div class="custom-control custom-switch mt-2 mb-0  d-flex justify-content-center">
        <input type="checkbox" class="custom-control-input darkMode text-lg" id="customSwitch1">
        <label class="custom-control-label" for="customSwitch1"><i class="fas fa-adjust"></i></label>
      </div>

      </h6>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column  nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        
             <!-- <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="fas fa-users"></i>
                <p>
                  @lang('app.users')
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item">
                       <router-link  to="/"  class="nav-link active" >  <i class="fas fa-user-cog"></i>  Go to Foo </router-link>
                    </li>      
              </ul>
              </li> -->


              <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="fas fa-users mr-2"></i>
                <p>
                   Users
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item">
                       <router-link  to="/users"  class="nav-link active" >  <i class="fas fa-user-cog"></i>  Users</router-link>
                    </li>      
              </ul>
              </li>



              <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="fas fa-tasks mr-2"></i> 
                <p>
                   projects
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item">
                       <router-link  to="/projects"  class="nav-link active" >   <i class="fas fa-tasks mr-2"></i>   projects</router-link>
                    </li>      
              </ul>
              </li>



              
              <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="fas fa-tasks mr-2"></i> 
                <p>
                   tasks
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item">
                       <router-link  to="/tasks"  class="nav-link active" >   <i class="fas fa-tasks mr-2"></i>   Tasks</router-link>
                    </li>      
              </ul>
              </li>


              <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <p>
                    Logout
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a>
                    </li>      
              </ul>
              </li>


        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
  <div>
         <router-view />
  </div>
<!-- Content Wrapper. Contains page content -->

<!-- /.content-wrapper -->
<footer class="main-footer not-print" v-if="$store.getters.isLoged">
  <strong>Copyright &copy; .</strong>

</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
    </div>
</template>

<script>


export default {
    name: 'dashboardComponent',

    data() {
        return {
          

        };
    },

    
    methods: {

        async logout(){
            await axios.post('/api/logout').then(({data})=>{
                this.$store.commit('removeUserToken');
            }).catch(err => { console.log(err)});
            this.$router.push({path:'/login'});
        },


        // async checklogin(){
        //   await axios.get('api/user').then(res => {
        //         console.log(res.data);
        //     })
        // },
    },

    created() {
        // this.checklogin(); 
    },
};
</script>

<style lang="scss" scoped>

</style>