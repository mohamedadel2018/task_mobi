<template>
    <div>
            <section class="content-wrapper" >
                <div class="container-fluid">


                  
                <div class="row  mb-2">
                    <div class="col-md-3 mt-4">
                        <h3>singleProject  </h3>
                    </div>
                   
                        <div class="col-md-9 mt-4">
                        <el-breadcrumb class="d-flex justify-content-end">
                            <el-breadcrumb-item :to="{ path: '/projects' }">
                                projects
                            </el-breadcrumb-item>
                           
                            <el-breadcrumb-item>Single Project</el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>



                </div>

                <div class="container">

                
                    <div class="card card-purple">
                      <div class="card-header">
                             <div class="row">
                                  <div class="col-md-10">
                                      
                                  </div>
                                
                           </div>
                      </div>
                     
                       <div class="card-body" v-if="singleProject != {}" v-loading="loadingsingleProject">
                                   
                                
                              <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                     id
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleProject.id}}
                                </div>
                            </div>

                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Title
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleProject.title}}
                                </div>
                            </div>


                            
                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    description	
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleProject.description	}}
                                </div>
                            </div>

                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Start Date
                                </div>
                                <div class="col-md-9 ml-4 ">
                                    <el-tag class="ml-2" type="primary"> {{singleProject.start_date}}</el-tag>
                                </div>
                            </div>


                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    End Date
                                </div>
                                <div class="col-md-9 ml-4">
                                    <el-tag class="ml-2"  type="danger">  {{singleProject.end_date}}</el-tag>

                                </div>
                            </div>



                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Project members
                                </div>
                                <div class="col-md-9 ml-4">
                                  <div class=" row col-12">
                                    <div v-for="(profile,s) in singleProject.members" :key="s"  >
                                            
                                           
                                        <div class=" col-md-12">
                                            <div class="card card-primary card-outline">
                                                <div class="card-body box-profile">

                                                    <div class="text-center">

                                                    <img  class="profile-user-img img-fluid img-circle" :src="'/images/members/member-null.jpg'" alt="User profile picture">
                                                    </div>
                                                    <h3 class="profile-username text-center">{{profile.name}}</h3>

                                                    <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>ID</b>
                                                        <a class="float-right">

                                                            <span >{{profile.id}} </span>
                                                        </a>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <b>Email</b>
                                                        <a class="float-right text-sm"> <br>
                                                            <span v-if="profile.email != null">{{profile.email}} </span>
                                                            <span v-if="profile.email == null">Not Found </span>
                                                        </a>

                                                    </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->
         
                                            </div>
                                         </div>
                                            </div>
                                </div>
                            </div>



                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                   Created at 
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleProject.created_at}}
                                </div>
                            </div>







                            </div>
                        </div>
                        </div>
                      
             
                  </div>

            </section>
    </div>

</template>
   
<script>


export default {
    name: 'showsingleproject',

    data() {
        return {
            singleProject:{},
          
            dialogeditVisible: false,
            dialogaddVisible: false,
            loadingsingleProject: true,
            errors:{},

            formLabelWidth: '20%',
            size: 'default'
        };
    },

   

    methods: {
      async  getSingleproject()
        {

          await  axios.post(`/api/singleproject/${this.$route.params.id}`).then(res => {
                    this.singleProject = res.data;
                    this.loadingsingleProject = false;
            }).catch(err =>  { console.log(err); })

          
            this.$store.dispatch('getUsers');
        },




  
    },
    created(){
        this.getSingleproject();
        
    },  
    computed:{
        isLoged(){
            return this.$store.getters.isLoged;
        },
    }
};
</script>

<style lang="scss" scoped>

</style>