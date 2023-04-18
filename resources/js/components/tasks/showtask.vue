<template>
    <div>
            <section class="content-wrapper" >
                <div class="container-fluid">


                  
                <div class="row  mb-2">
                    <div class="col-md-3 mt-4">
                        <h3>singleTask  </h3>
                    </div>
                   
                        <div class="col-md-9 mt-4">
                        <el-breadcrumb class="d-flex justify-content-end">
                            <el-breadcrumb-item :to="{ path: '/Tasks' }">
                                Tasks
                            </el-breadcrumb-item>
                           
                            <el-breadcrumb-item>Single Task</el-breadcrumb-item>
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
                     
                       <div class="card-body" v-if="singleTask != {}" v-loading="loadingsingleTask">
                                   
                                
                              <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                     id
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleTask.id}}
                                </div>
                            </div>

                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Title
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleTask.title}}
                                </div>
                            </div>


                            
                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    description	
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleTask.description	}}
                                </div>
                            </div>

                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Start Date
                                </div>
                                <div class="col-md-9 ml-4 ">
                                    <el-tag class="ml-2" type="primary"> {{singleTask.start_date}}</el-tag>
                                </div>
                            </div>


                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    End Date
                                </div>
                                <div class="col-md-9 ml-4">
                                    <el-tag class="ml-2"  type="danger">  {{singleTask.end_date}}</el-tag>

                                </div>
                            </div>



                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Priority Level
                                </div>
                                <div class="col-md-9 ml-4">
                                    <el-tag class="ml-2" type="danger" v-if="singleTask.priority_level == 1">Important</el-tag>
                                    <el-tag class="ml-2" type="warning" v-if="singleTask.priority_level == 2">Less Important</el-tag>
                                    <el-tag class="ml-2" v-if="singleTask.priority_level == 3">Normal</el-tag>

                                </div>
                            </div>


                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                   Status
                                </div>
                                <div class="col-md-9 ml-4">
                                    <el-tag class="ml-2" type="warning" v-if="singleTask.status == 1">to-do</el-tag>
                                    <el-tag class="ml-2"  v-if="singleTask.status == 2">Progress</el-tag>
                                    <el-tag class="ml-2" type="success" v-if="singleTask.status == 3"> <i class="fas fa-check"></i> Done</el-tag>
                                </div>
                            </div>


                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                    Task members
                                </div>
                                <div class="col-md-9 ml-4">
                                  <div class=" row col-12">
                                    <div v-for="(profile,s) in singleTask.members" :key="s"  >
                                            
                                           
                                        <div class=" col-md-12">
                                            <div class="card card-primary card-outline">
                                                <div class="card-body box-profile">

                                                    <div class="text-center">

                                                    <img  class="profile-user-img img-fluid img-circle" :src="'/images/members/member-null.jpg'" alt="User profile picture">
                                                    </div>
                                                    <h3 class="profile-username text-center">{{profile.name}}</h3>

                                                    <!-- <p class="text-muted text-center">Software Engineer</p> -->

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
                                   Files
                                </div>
                                <div class="col-md-9 ml-4" v-if="singleTask.files != null">
                                    <div   v-for="(file,k) in  singleTask.files" :key="k" >
                                            <!-- <img  class="col-md-3" :src="'/images/files/' + file.destination" :alt="file"> -->
                                            <a target="_blanck" :href="'/images/files/' + file.destination">  {{ file.destination }} </a>
                                            <el-button @click="deleteFile(file.id)"  class="ml-4" circle>  <i class="fas fa-trash-alt text-danger "></i> </el-button>
                                    </div>
                                </div>
                            </div>



                            <div class="row mt-4 text-bold">
                                <div class="col-md-2 ml-2">
                                   Created at 
                                </div>
                                <div class="col-md-9 ml-4">
                                    {{singleTask.created_at}}
                                </div>
                            </div>






                            <div class="row mt-4 ">
                                <div class="col-2 ml-2 text-bold">
                                </div>
                                <div class="col-md-8">
                                    <div class="col-12 text-center text-bold mb-4 text-primary">
                                        Comments
                                    </div>
                                    <el-card shadow="always">
                                      

                                        <el-timeline>
                                            <el-timeline-item   v-for="comment in  singleTask.comments" :key="comment.id" :timestamp="comment.created_at" placement="top">
                                            <el-card>
                                                <h4>{{comment.comment}}</h4>
                                                <span v-if="comment.commenter != null ">
                                                    <p> <el-avatar style="width: 40px; height: 40px" :src="'/images/members/member-null.jpg'"  />  <span class="m-0">  {{comment.commenter.name}}</span></p>
                                                    <div class="text-right" v-if="comment.commenter.id == $store.state.userAuth.id">
                                                        <el-button @click="deleteComment(comment.id)"  class="ml-4" circle>  <i class="fas fa-trash-alt text-danger "></i> </el-button>
                                                    </div>
                                                </span>
                                            </el-card>
                                            </el-timeline-item>
                                        </el-timeline>
                                            
                                    </el-card>
                                   

                                    <el-form-item label="Comment" class="mt-4">
                                        <el-input v-model="task_comment.comment" type="textarea"  placeholder="Write your comment here.."/>
                                            <span class="text-danger" v-if="errors['comment']">
                                                <span class="block"> {{errors['comment'][0]}} </span>
                                            </span>
                                    </el-form-item>
                                    <div class="row col-12 d-flex justify-content-end">
                                        <el-button  type="success"   @click="addComment(task_comment.comment)">Add a Comment</el-button>
                                    </div>
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
    name: 'showsingleTask',

    data() {
        return {
            singleTask:{},
            task_comment:{},
            dialogeditVisible: false,
            dialogaddVisible: false,
            loadingsingleTask: true,
            errors:{},
            comment:'',
            formLabelWidth: '20%',
            size: 'default'
        };
    },

   

    methods: {
      async  getSingleTask()
        {
          await  axios.post(`/api/singletask/${this.$route.params.id}`).then(res => {
                    this.singleTask = res.data;
                    this.loadingsingleTask = false;

                    this.$store.dispatch('getAuth');
            }).catch(err =>  { console.log(err); });
        },

        async deleteFile(fileId)
        {
            this.$confirm('Are you Sure You Wand Delete this Command', 'Warning', {
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        type: 'warning'
                                        }).then(() => {
                                         axios.post(`/api/deletefile/${fileId}`).then(res => {
                                                this.loadingsingleTask = true;
                                                this.getSingleTask();
                                               
                                                this.$notify({
                                                title: 'Success',
                                                message: 'File Deleted Successfully.',
                                                type: 'seccess'
                                                });
                                            }).catch(err =>  { console.log(err); });

                                        }).catch(() => {
                                        this.$message({
                                            type: 'info',
                                            message: 'Delete canceled'
                                        });
                                        });
        },


        async   deleteComment(commentId)
        {
            this.$confirm('Are you Sure You Wand Delete this file', 'Warning', {
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        type: 'warning'
                                        }).then(() => {
                                         axios.post(`/api/deleteComment/${commentId}`).then(res => {
                                                this.loadingsingleTask = true;
                                                this.getSingleTask();
                                               
                                                this.$notify({
                                                title: 'Success',
                                                message: 'Comment Deleted Successfully.',
                                                type: 'seccess'
                                                });
                                            }).catch(err =>  { console.log(err); });

                                        }).catch(() => {
                                        this.$message({
                                            type: 'info',
                                            message: 'Delete canceled'
                                        });
                                        });
        },



        async  addComment()
        {
          await  axios.post(`/api/addcommenttask/${this.$route.params.id}`,this.task_comment).then(res => {

                    this.singleTask.comments.unshift(res.data);
                                      this.$notify({
                                        title: 'Success',
                                        message: 'Comment Added Successfully.',
                                        type: 'seccess'
                                        });
                            this.task_comment = {};
                    this.loadingsingleTask = false;
            }).catch(err =>  { this.errors = err.response.data.errors;});

        },  
    },
    created(){
        this.getSingleTask();
        
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