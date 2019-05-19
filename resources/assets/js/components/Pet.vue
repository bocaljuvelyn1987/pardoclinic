  <template>
    <div class="container">
          <div class="row mt-5" v-if="$gate.isUser()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Pets</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"  @click="newModal">Add Pet <i class="fas fa-money-check fa-fw"></i></button>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th> Image </th>
                        <th>Petname</th>
                        <th>Created At </th>
                        <th>Modify</th>
                  </tr>
                 <tr v-for="pet in pets.data" :key="pets.id">
                    <td> <img :src="'/'+pet.image" width="150px"> </td>
                    <td>{{pet.petname}}</td>
                    <td>{{pet.created_at | myDate}} </td>
                    <td>
                       <a href="#" @click="viewPet(pet)">
                            <i class="fa fa-eye" style="color:blue;"></i>
                        </a>
                        <!-- <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                        /
                        -->
                       | 
                         <a href="#" @click="deletePet(pet.id)">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </a>

                    </td>

                </tr>


                  
                </tbody></table>
                <pagination :data="pets" @pagination-change-page="getResults"></pagination>
              </div>


        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="createPet()">
                        <div class="modal-body">
                            <input type="file" class="form-control" name="image"   v-if="uploadReady"  @change="getImage" accept="image/*;capture=camera"><br>
                             <img :src="form.image" alt="User Avatar" width="200" height="200" v-if="getimage===true">
                            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('petname') }" placeholder="Enter petname" v-model="form.petname" name="petname" >
                            <has-error :form="form" field="petname"></has-error>
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <!-- <button  type="submit" class="btn btn-success">Update</button> -->
                        <button  type="submit" class="btn btn-primary">Create</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>
               <div id="viewqr" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body" style="text-align:center; margin:0 auto;" >
       <img :src="'/'+form.image" width="80%" ><br><br>
       <h1>{{form.petname}}</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    </div>
</template>
<script>
  export default {
    data(){
      return{
        pets:{},
        uploadReady:true,
        getimage:false,
        form: new Form({
                id:'',
                petname : '',
                image:'',
              
            })
        }
    },
    mounted(){
        if(this.$gate.isUser()){
            this.loadPets();
            this.createdPet();
        }
    },
    methods:{
      getResults(page = 1) {
                        axios.get('api/pets?page=' + page)
                            .then(response => {
                                this.pets = response.data;
                            });
                },
      newModal(){
            this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
      },
      deletePet(id){
          swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/pets/'+id).then(()=>{
                                        swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('createdPet');
                                }).catch(()=> {
                                    swal("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
      },
      clear(){
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true
        })
      },
      viewPet(pet){
        this.form.image = pet.image
        this.form.petname = pet.petname;
         $('#viewqr').modal('show');
      },
      createPet(){
        this.form.post('api/pets')
                .then((response)=>{
                    this.$Progress.start();
                    Fire.$emit('createdPet');
                     $('#addNew').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Pet added into account successfully'
                        })
                     
                     this.$Progress.finish();
                });
                this.getimage=false
                 this.clear();

      },
    /*   getProfilePhoto(){

                let image = (this.form.image.length > 200) ? this.form.image : "img/profile/"+ this.form.image ;
                return image;
            },*/
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
          this.getimage = true
      },
      loadPets(){
        axios.get('api/pets').then(({data}) => this.pets = data);
      },
      createdPet(){
        this.loadPets();
        Fire.$on('createdPet',()=>{
            this.loadPets();
        })
      }

    
  }
};
</script>