<template>
    <div>
            <section class="content-wrapper" >
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <h3>projects  </h3>
                    </div>
                </div>


                <div class="container">

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                               <el-button class="m-2" type="primary"   @click="dialogaddVisible = true">Add Project</el-button>


                               <el-dialog v-model="dialogaddVisible" title="ADD PROJECT">
                                    <el-form :model="addprojects">
                                    <el-form-item label="title" :label-width="formLabelWidth">
                                        <el-input v-model="addprojects.title" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['title']">
                                        <span class="block"> {{errors['title'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="Description" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="addprojects.description" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['description']">
                                        <span class="block"> {{errors['description'][0]}} </span>
                                    </span>
                                    </el-form-item>


                                    <el-form-item label="Start Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="addprojects.start_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['start_date']">
                                        <span class="block"> {{errors['start_date'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    <el-form-item label="End Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="addprojects.end_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['end_date']">
                                        <span class="block"> {{errors['end_date'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    <el-form-item label="Project Member" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="addprojects.project_members"
                                        multiple
                                        placeholder="Select"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in $store.state.users"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id"
                                        />
                                        </el-select>
                                        
                                    </el-form-item>


                                    <el-form-item label="Notes" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="addprojects.notes" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['notes']">
                                        <span class="block"> {{errors['notes'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    </el-form>

                                    <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogaddVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="add(addprojects)">
                                                Add
                                        </el-button>
                                    </span>
                                    </template>
                                </el-dialog>



                        </div>
                    </div>
                    <el-table height="550" class="text-md" :data="projects.data.filter(data => !search || data.title.toLowerCase().includes(search.toLowerCase()))"  
                        v-loading="loadingprojects">
                        <el-table-column label="ID" prop="id" />
                        <el-table-column label="title" prop="title" />
                        <el-table-column label="start Date" prop="start_date" />
                        <el-table-column label="End Date" prop="end_date" />
                        <el-table-column label="Date">
                            <template #default="scope">
                                    {{ scope.row.created_at }}
                            </template>
                        </el-table-column>
                        <el-table-column align="right">
                        <template #header>
                            <el-input v-model="search" size="small" placeholder="Type name to search" />
                        </template>

                        <template #default="scope">


                            <router-link :to="{ path: '/showProject/' + scope.row.id}"> 
                                <el-button
                                size="small"
                                 class="mr-1"><i class="far fa-eye"></i></el-button>
                        </router-link>




                            <el-button size="small" class="mr-1" type="warning" @click="handleEdit(scope.$index, scope.row)"
                            >Edit</el-button>   

                                <el-dialog v-model="dialogeditVisible" title="Edit Project">
                                    <el-form :model="editprojects">
                                    <el-form-item label="title" :label-width="formLabelWidth">
                                        <el-input v-model="editprojects.title" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['title']">
                                        <span class="block"> {{errors['title'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="Description" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="editprojects.description" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['description']">
                                        <span class="block"> {{errors['description'][0]}} </span>
                                    </span>
                                    </el-form-item>


                                    <el-form-item label="Start Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="editprojects.start_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['start_date']">
                                        <span class="block"> {{errors['start_date'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    <el-form-item label="End Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="editprojects.end_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['end_date']">
                                        <span class="block"> {{errors['end_date'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    <el-form-item label="Project Member" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="editprojects.project_members"
                                        multiple
                                        placeholder="Select"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in $store.state.users"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id"
                                        />
                                        </el-select>
                                        
                                    </el-form-item>


                                    <el-form-item label="Notes" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="editprojects.notes" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['notes']">
                                        <span class="block"> {{errors['notes'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    </el-form>

                                    <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogeditVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="update(editprojects.id)">
                                                Confirm
                                        </el-button>
                                    </span>
                                    </template>
                                </el-dialog>


                            <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)"
                            >Delete</el-button>

                          
                        </template>
                        </el-table-column>
                </el-table>

                

                <ul class="mb-4 mt-4 text-xs  d-flex justify-content-end" v-if="projects.data != null" >
                        <paginate
                        :page-count="projects.data.length"
                        :click-handler="getResults"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'className'" >
                        </paginate>
                    </ul>


            </div>

                </div>
            </section>
    </div>

</template>
   
<script>
  import Paginate from 'vuejs-paginate-next';


export default {
    name: 'projectsComponent',
    components: {
      paginate: Paginate,
    },
    data() {
        return {
            projects:{},
            search:'',
            addprojects: {},
            editprojects: {
                project_members:{},
            },
            dialogeditVisible: false,
            dialogaddVisible: false,
            loadingprojects: true,
            errors:{},

            formLabelWidth: '20%',
            size: 'default'
        };
    },

   

    methods: {
        async  getprojects()
        {
            
          await  axios.get('api/projects').then(res => {
                    this.projects = res.data;
                    this.loadingprojects = false;
            }).catch(err =>  { console.log(err); })

          
            this.$store.dispatch('getUsers');
        },


        async  add(addprojects)
        {
            await  axios.post('api/projects',addprojects).then(res => {
                   this.getprojects();
                    this.addprojects = {};
                    this.dialogaddVisible = false;
                    this.$notify({
                    title: 'Success',
                    message: 'Project Added successfully.',
                    type: 'success'
                    });
            }).catch(err =>  {  this.errors = err.response.data.errors;})
        },

       async update(id)
        {
            await axios.put(`api/projects/${id}`,this.editprojects).then(res => {

                this.$notify({
                    title: 'success',
                    message: 'Project Update successfully.',
                    type: 'success'
                    });
                    this.dialogeditVisible = false;
                    this.editprojects = {};
                   this.getprojects();
            }).catch(err =>  {
                this.errors = err.response.data.errors; });
        },

        async getResults(page = 1) {
            await  axios.get(`api/projects?page=${page}`).then(res => {
                    this.projects = res.data;
                    this.loadingprojects = false;
            }).catch(err =>  { console.log(err); });
           
        },


      handleDelete(index, row) {
            // console.log(index, row);
                this.$confirm('Are you Sure You Wand Delete this project', 'Warning', {
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        type: 'warning'
                                        }).then(() => {

                                                 axios.delete(`api/projects/${row.id}`).then(res => {

                                                  this.$notify({
                                                      title: 'Success',
                                                      message: 'project Deleted Successfully',
                                                      type: 'success'
                                                      });
                                                    this.getprojects();

                                                    }).catch(err => {console.log(err)
                                                    this.$notify({
                                                      title: 'Error',
                                                      message: 'Error please try Agian later.',
                                                      type: 'error'
                                                      });
                                                     });

                                        }).catch(() => {
                                        this.$message({
                                            type: 'info',
                                            message: 'Delete canceled'
                                        });
                                        });
                                   
                },


        handleEdit(index, row) {
            this.editprojects = row;
            this.dialogeditVisible = true;
        },
       


  
    },
    created(){
        this.getprojects();
        
    },  
    computed:{
        isLoged(){
            return this.$store.getters.isLoged;
        },
      
    }
};
</script>

<style lang="css" scoped>
ul {
    display: flex !important;
}

.page-link{
    display: 'table-cell' !important;
}

</style>