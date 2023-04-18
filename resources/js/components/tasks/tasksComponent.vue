<template>
    <div>
            <section class="content-wrapper" >
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <h3>tasks  </h3>
                    </div>
                </div>


                <div class="container">

                    <div class="row">
                        <div  class="col-md-3 mt-2">
                            <span class="demonstration block">priority level Filter</span>
                                <el-select
                                @change="FilterFun('priority_level',filterVal.priority_level)"
                                v-model="filterVal.priority_level"
                                placeholder="Select Priority"
                                clearable
                                style="width: 240px">
                                <el-option
                                    v-for="item in priority_opt"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                />
                                </el-select>
                         </div>


                         <div  class="col-md-3 mt-2">
                            <span class="demonstration block">Status Filter</span>
                                <el-select
                                @change="FilterFun('status',filterVal.status)"
                                v-model="filterVal.status"
                                placeholder="Select Priority"
                                clearable
                                style="width: 240px">
                                <el-option
                                    v-for="item in status_opt"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                />
                                </el-select>
                         </div>


                         <div class="col-md-3 mt-2">
                            <span class="demonstration block">End Date</span>
                            <el-date-picker
                            @change="FilterFun('end_date',filterVal.end_date)"
                            v-model="filterVal.end_date"
                            type="daterange"
                            clearable
                            range-separator="To"
                            start-placeholder="Start Range End date"
                            end-placeholder="End Range End date"
                            :size="size"
                            value-format="YYYY-MM-DD HH:mm:ss"
                            />
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                               <el-button class="m-2" type="primary"   @click="dialogaddVisible = true">Add task</el-button>


                               <el-dialog v-model="dialogaddVisible" title="ADD task">
                                    <el-form :model="addtasks"
                                    :label-position="top" >
                                    <el-form-item label="title" :label-width="formLabelWidth">
                                        <el-input v-model="addtasks.title" autocomplete="off" />
                                    <span class="text-danger" v-if="errors['title']">
                                        <span class="block"> {{errors['title'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="Description" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="addtasks.description" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['description']">
                                        <span class="block"> {{errors['description'][0]}} </span>
                                    </span>
                                    </el-form-item>


                                    <el-form-item label="Start Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="addtasks.start_date"
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
                                            v-model="addtasks.end_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['end_date']">
                                        <span class="block"> {{errors['end_date'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    
                                    <el-form-item label="Priority Level" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="addtasks.priority_level"
                                        placeholder="Select Priority"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in priority_opt"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                        </el-select>
                                        <span class="text-danger" v-if="errors['priority_level']">
                                        <span class="block"> {{errors['priority_level'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    <el-form-item label="status" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="addtasks.status"
                                        
                                        placeholder="Select Status"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in status_opt"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                        </el-select>
                                        <span class="text-danger" v-if="errors['staus']">
                                        <span class="block"> {{errors['staus'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    <el-form-item label="task Member" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="addtasks.task_members"
                                        multiple
                                        placeholder="Select members"
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
                                        <el-input type="textarea" size="small"   v-model="addtasks.notes" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['notes']">
                                        <span class="block"> {{errors['notes'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    
                                    <el-form-item label=" Upload Files" :label-width="formLabelWidth">
                                        <input  id="upload-file" type="file" @change="processFile($event)" multiple>
                                        <span class="text-danger" v-if="errors['files']">
                                             <span class="block"> {{errors['files'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    </el-form>

                                    <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogaddVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="add(addtasks)">
                                                Add
                                        </el-button>
                                    </span>
                                    </template>
                                </el-dialog>



                        </div>
                    </div>
                    <el-table height="550" class="text-md"  fit :data="tasks.data.filter(data => !search || data.title.toLowerCase().includes(search.toLowerCase()))"  
                        v-loading="loadingtasks">
                        <el-table-column label="ID" prop="id" />
                        <el-table-column label="title" prop="title" />
                        <el-table-column label="start Date" prop="start_date" />
                        <el-table-column label="End Date" prop="end_date" />
                        <el-table-column label="Priority Level" >
                            <template #default="scope">
                                <el-tag class="ml-2" type="danger" v-if="scope.row.priority_level == 1">Important</el-tag>
                                <el-tag class="ml-2" type="warning" v-if="scope.row.priority_level == 2">Less Important</el-tag>
                                <el-tag class="ml-2" v-if="scope.row.priority_level == 3">Normal</el-tag>
                            </template>
                        </el-table-column>


                        <el-table-column label="Status" >
                            <template #default="scope">
                                <el-tag class="ml-2" type="warning" v-if="scope.row.status == 1">to-do</el-tag>
                                <el-tag class="ml-2"  v-if="scope.row.status == 2">Progress</el-tag>
                                <el-tag class="ml-2" type="success" v-if="scope.row.status == 3"> <i class="fas fa-check"></i> Done</el-tag>
                            </template>
                        </el-table-column>

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


                            <router-link :to="{ path: '/showtask/' + scope.row.id}"> 
                                <el-button
                                size="small"
                                 class="mr-1"><i class="far fa-eye"></i></el-button>
                        </router-link>




                            <el-button size="small" class="mr-1" type="warning" @click="handleEdit(scope.$index, scope.row)"
                            >Edit</el-button>   

                                <el-dialog v-model="dialogeditVisible" title="Edit task">
                                    <el-form :model="edittasks">
                                    <el-form-item label="title" :label-width="formLabelWidth">
                                        <el-input v-model="edittasks.title" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['title']">
                                        <span class="block"> {{errors['title'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="Description" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="edittasks.description" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['description']">
                                        <span class="block"> {{errors['description'][0]}} </span>
                                    </span>
                                    </el-form-item>


                                    <el-form-item label="Start Date" :label-width="formLabelWidth">
                                        <el-date-picker
                                            v-model="edittasks.start_date"
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
                                            v-model="edittasks.end_date"
                                            type="datetime"
                                            placeholder="Pick a Date"
                                            :size="size"
                                            value-format="YYYY-MM-DD HH:mm:ss"
                                        />

                                      <span class="text-danger" v-if="errors['end_date']">
                                        <span class="block"> {{errors['end_date'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    <el-form-item label="Priority Level" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="edittasks.priority_level"
                                        placeholder="Select"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in priority_opt"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                        </el-select>
                                        <span class="text-danger" v-if="errors['priority_level']">
                                        <span class="block"> {{errors['priority_level'][0]}} </span>
                                         </span>
                                    </el-form-item>


                                    <el-form-item label="status" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="edittasks.status"
                                        placeholder="Select"
                                        style="width: 240px">
                                        <el-option
                                            v-for="item in status_opt"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        />
                                        </el-select>
                                        <span class="text-danger" v-if="errors['status']">
                                        <span class="block"> {{errors['status'][0]}} </span>
                                         </span>

                                    </el-form-item>


                                    <el-form-item label="task Member" :label-width="formLabelWidth">
                                    <el-select
                                        v-model="edittasks.task_members"
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


                                    <el-form-item label="Upload Files" :label-width="formLabelWidth">
                                        <input  id="upload-file" type="file" @change="processFile($event,2)" multiple>
                                        <span class="text-danger" v-if="errors['files']">
                                             <span class="block"> {{errors['files'][0]}} </span>
                                         </span>
                                    </el-form-item>



                                    <el-form-item label="Notes" :label-width="formLabelWidth">
                                        <el-input type="textarea" size="small"   v-model="edittasks.notes" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['notes']">
                                        <span class="block"> {{errors['notes'][0]}} </span>
                                         </span>
                                    </el-form-item>

                                    </el-form>

                                    <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogeditVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="update(edittasks.id)">
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
                
                <ul class="mb-4 mt-4 text-xs  d-flex justify-content-end" v-if="tasks.data != null" >
                        <paginate
                        :page-count="tasks.data.length"
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
    name: 'tasksComponent',
    components: {
      paginate: Paginate,
    },
    data() {
        return {
            tasks:{},
            search:'',
            addtasks: {
                attachments:[],
            },
            edittasks: {
                task_members:{},
            },
            dialogeditVisible: false,
            dialogaddVisible: false,
            loadingtasks: true,
            filterVal: {},
            errors:{},

            formLabelWidth: '20%',
            size: 'default',

             fileList:{} ,

            status_opt :[{
                value:1,
                label:'to-do',
            },{
                value:2,
                label:'Progress',
            },{
                value:3,
                label:'Done',
            }],




            priority_opt :[{
                value:1,
                label:'Important',
            },{
                value:2,
                label:'Less important',
            },{
                value:3,
                label:'Normal',
            }],
        };
    },

   

    methods: {
        async  gettasks()
        {
            
          await  axios.get('api/tasks').then(res => {
                    this.tasks = res.data;
                    this.loadingtasks = false;
            }).catch(err =>  { console.log(err); })

          
            this.$store.dispatch('getUsers');
        },


        async  add(addtasks)
        {
            await  axios.post('api/tasks',addtasks,{ 'content-type': 'multipart/form-data'}).then(res => {
                   this.gettasks();
                    this.addtasks = {};
                    this.dialogaddVisible = false;
                    document.getElementById('upload-file').value = [];
                    this.$notify({
                    title: 'Success',
                    message: 'task Added successfully.',
                    type: 'success'
                    });
            }).catch(err =>  {  this.errors = err.response.data.errors; })
        },

       async update(id)
        {
            await axios.put(`api/tasks/${id}`,this.edittasks).then(res => {

                this.$notify({
                    title: 'success',
                    message: 'Task Update successfully.',
                    type: 'success'
                    });
                    this.dialogeditVisible = false;

                   this.gettasks();
            }).catch(err =>  {
                this.errors = err.response.data.errors; });
        },

        async getResults(page = 1) {
            await  axios.get(`api/tasks?page=${page}`).then(res => {
                    this.tasks = res.data;
                    this.loadingtasks = false;
            }).catch(err =>  { console.log(err); });
           
        },


      handleDelete(index, row) {
            // console.log(index, row);
                this.$confirm('Are you Sure You Wand Delete this task', 'Warning', {
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        type: 'warning'
                                        }).then(() => {

                                                 axios.delete(`api/tasks/${row.id}`).then(res => {

                                                  this.$notify({
                                                      title: 'Success',
                                                      message: 'task Deleted Successfully',
                                                      type: 'success'
                                                      });
                                                    this.gettasks();

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
            this.edittasks = row;
            this.dialogeditVisible = true;
        },
       

        FilterFun(filed,data){
            this.loadingtasks = true;
            axios.post('api/tasksFilter',{filed,data})
                .then(res => {
                    this.tasks = res.data;
                    this.loadingtasks = false;
                }).catch(err => {console.log(err);});
        },

        processFile(event,type) {
             let file = event.target.files;
             var files = new Array()
            var files =  Object.values(file).forEach(val => {
              let reader = new FileReader();
            //   console.log('val',val);
             if(val.size < 80068148)
            {
                    reader.onloadend = (event) => {
                        if(type == 1)
                        {
                            this.addtasks.attachments.push([reader.result,val.name]);
                        }
                        elseif(type == 2)
                        {
                            this.edittasks.attachments.push([reader.result,val.name]);
                        }
                    }
                     reader.readAsDataURL(val);
             }
            else
            {
                this.$notify({
                title: 'Warinig',
                message: 'Sorry, the image cannot be larger than 8MB.',
                type: 'warning'
                });
            }
            });

        },
  
    },
    created(){
        this.gettasks();
        
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