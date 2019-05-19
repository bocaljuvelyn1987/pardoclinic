<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Add Post <i class="fas fa-money-check fa-fw"></i></button>
                         </div>
                     </div>
             <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>User</th>
                        <th>Post</th>
                        <th>Created At </th>
                        <th>Modify</th>
                  </tr>
                 <tr v-for="post in posts.data" :key="posts.id">
                    <td>{{post.user.name}}</td>
                    <td>{{post.content}}</td>
                    <td>{{post.created_at | myDate}} </td>
                    <td>
                
                        <a href="#" @click="deletePost(post.id)">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </a>

                    </td>

                </tr>


                  
                </tbody></table>
              </div>
             <pagination :data="posts" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add Post</h5>
                            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="createPost()">
                        <div class="modal-body">
                           <!--  <select class="form-control" name="transaction_id" v-model="form.transaction_id">
                                <option value="">---Select Account Name---</option>
                                <option  v-for="account in accounts" :key="account.id" :value="account.id">{{account.account_name}}</option>
                            </select>
                            <br>
                            <input type="text" class="form-control" placeholder="Enter Passenger Name" name="passenger_name" v-model="form.passenger_name"><br>   -->   
                            <img :src="form.image" alt="User Avatar" width="100%"  v-if="getimage===true">
                            <input type="file" name="image" class="form-control"   v-if="uploadReady"  @change="getImage"><br>
                            
                            <textarea class="form-control" placeholder="Whats on your mind ?" :class="{'is-invalid': form.errors.has('content') }" style="height:200px;" name="content" v-model="form.content">
                            </textarea>
                            <has-error :form="form" field="content"></has-error>
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Post</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                posts:{},
                editmode: false,
                uploadReady:true,
                getimage:false,
                form: new Form({
                    id: '',
                    content:'',
                    image:'',
                })
            }
        },
        mounted(){
            if(this.$gate.isAdminOrAuthor()){
                axios.get("api/posts").then(({data})=> (this.posts = data));
                this.loadPost();
                this.createdPost();
            }
        },
        methods:{
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            getImage(e){
          let file = e.target.files[0];
          let reader = new FileReader();

          let limit = 1024*1024*2;
          if(file['size']>limit){
            swal({
              type: 'error',
              title:'Oopss..',
              text:'You are uploading a large file',
            })
           
            return false;
          }
          reader.onloadend = file => {
            this.form.image=reader.result;
          }
          reader.readAsDataURL(file);
           this.getimage = true;

      },
              getResults(page = 1) {
                        axios.get('api/posts?page=' + page)
                            .then(response => {
                                this.posts = response.data;
                            });
                },
                 clear(){
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true
        })
      },
            createPost(){
                this.form.post('api/posts')
                .then((response)=>{
                    this.$Progress.start();
                    Fire.$emit('createdPost');
                     $('#addNew').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Post added into account successfully'
                        })
                     this.$Progress.finish();
                });
                this.getimage = false;
                this.clear();
            },

            loadPost(){
                if(this.$gate.isAdminOrAuthor()){
                axios.get("api/posts").then(({ data }) => (this.posts= data));
                }
            },
            createdPost(){
                this.loadPost();
                Fire.$on('createdPost',()=> {
                    this.loadPost();
                })
            },
            deletePost(id){
                swal({
                  title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                     if (result.value) {
                                this.form.delete('api/posts/'+id).then(()=>{
                                        swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('createdPost');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                });
            }
        }
    };
</script>