<template>
    <div>
            <section class="content-wrapper" >
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <h3>Users  </h3>
                    </div>
                </div>

                <div class="container">
                    <el-table height="550" class="text-md" :data="users.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"  
                        v-loading="loadingUsers">
                        <el-table-column label="ID" prop="id" />
                        <el-table-column label="Name" prop="name" />
                        <el-table-column label="Email" prop="email" />
                        <el-table-column label="Date">
                            <template #default="scope">
                                    {{ scope.row.created_at }}
                                    <!-- {{ $filters.timeFormat(scope.row.created_at) }} -->
                            </template>
                        </el-table-column>
                        <el-table-column align="right">
                        <template #header>
                            <el-input v-model="search" size="small" placeholder="Type name to search" />
                        </template>

                        <template #default="scope">
                            <el-button size="small" @click="handleEdit(scope.$index, scope.row)"
                            >Edit</el-button>                       
                                <el-dialog v-model="dialogeditVisible" title="Edit User">
                                    <el-form :model="editusers">

                                    <el-form-item label="Name" :label-width="formLabelWidth">
                                        <el-input v-model="editusers.name" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['name']">
                                        <span class="block"> {{errors['name'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="Email" :label-width="formLabelWidth">
                                        <el-input v-model="editusers.email" autocomplete="off" />
                                        <span class="text-danger" v-if="errors['email']">
                                        <span class="block"> {{errors['email'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="password" :label-width="formLabelWidth">
                                        <el-input
                                        v-model="editusers.password"
                                        type="password"
                                        placeholder="Please input password"
                                        show-password />
                                        <span class="text-danger" v-if="errors['password']">
                                        <span class="block"> {{errors['password'][0]}} </span>
                                    </span>
                                    </el-form-item>

                                    <el-form-item label="password confirmation" :label-width="formLabelWidth">
                                        <el-input
                                        v-model="editusers.password_confirmation"
                                        type="password"
                                        placeholder="Please input  confirmation password"
                                        show-password />
                                        <span class="text-danger" v-if="errors['password_confirmation']">
                                        <span class="block"> {{errors['password_confirmation'][0]}} </span>
                                    </span>
                                    </el-form-item>
                                    </el-form>

                                    <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogeditVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="update(editusers.id)">
                                                Confirm
                                        </el-button>
                                    </span>
                                    </template>
                                </el-dialog>


                            <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                        </template>
                        </el-table-column>
                </el-table>

              


            </div>

                </div>
            </section>
    </div>

</template>
   
<script>


export default {
    name: 'TaskMobitechUserComponent',

    data() {
        return {
            users:{},
            search:'',
            editusers: {},
            dialogeditVisible: false,
            loadingUsers : true,
            formLabelWidth: '20%',
            errors:{},
        };
    },

    mounted() {
        
    },

    methods: {
       async getUsers()
        {
            
           await axios.get('api/users').then(res => {
                    this.users = res.data;
                    this.loadingUsers = false;
            }).catch(err =>  { console.log(err); })
        },

        update(id)
        {
            axios.put(`api/users/${id}`,this.editusers).then(res => {

                this.$notify({
                    title: 'success',
                    message: 'User Update Done.',
                    type: 'success'
                    });
                    this.dialogeditVisible = false;
                   this.getUsers();
            }).catch(err =>  {
                this.errors = err.response.data.errors;
                console.log(err); })
        },

         getResults(page = 1) {
            axios.get(`api/users?page=${page}`).then(res => {
                    this.users = res.data;
                    this.loadingUsers = false;
            }).catch(err =>  { console.log(err); });
        },


        handleDelete(index, row) {
            // console.log(index, row);
                this.$confirm('Are you Sure You Wand Delete this User', 'Warning', {
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        type: 'warning'
                                        }).then(() => {

                                            axios.delete(`api/users/${row.id}`).then(res => {

                                                  this.$notify({
                                                      title: 'Success',
                                                      message: 'User Deleted Successfully',
                                                      type: 'success'
                                                      });
                                                    this.getUsers();

                                                    }).catch(err => console.log(err));

                                        }).catch(() => {
                                        this.$message({
                                            type: 'info',
                                            message: 'Delete canceled'
                                        });
                                        });
                                   
                },


        handleEdit(index, row) {
            this.editusers = row;
            this.dialogeditVisible = true;
            console.log(index, row)
        },
       

         filterTableData(){
                tableData.filter(
                    (data) =>
                    !search.value ||
                    data.name.toLowerCase().includes(search.value.toLowerCase())
                )
            }

  
    },
    created(){
        this.getUsers();
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