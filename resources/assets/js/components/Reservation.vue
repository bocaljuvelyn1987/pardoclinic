<template>
    <div class="container">
          <div class="row mt-5" v-if="$gate.isUser()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Appointments</h3>
                        <div class="card-tools">
                                 <button class="btn btn-success" @click="newModal">Add Reservation <i class="fas fa-money-check fa-fw"></i></button>
                         </div>
                     </div>
                      <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>Pet Name</th>
                        <th>Pet Breed</th>
                        <th>Pet Age</th>
                        <th>Pet Gender</th>
                        <th> Service </th>
                        <th>Status</th>
                        <th> Time </th>
                        <th>Registered At</th>
                  
                  </tr>


                  <tr v-for="reservation in reservations.data" :key="reservation.id">
                    <td>{{reservation.petname}}</td>
                    <td>{{reservation.petbreed}}</td>
                    <td>{{reservation.petage }}</td>
                    <td>{{reservation.petgender}}</td>
                    <td>{{reservation.service}}</td>
                    <td>{{reservation.status.name}}</td>
                    <td>{{reservation.time}}</td>
                    <td>{{reservation.created_at | myDate}}</td>

                    <td>
                       <!--  <a href="#" @click="editModal(user)">
                            <i class="fa fa-eye" style="color:blue;"></i>
                        </a> -->
                      <!--   /
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </a> -->

                    </td>
                  </tr>
                </tbody></table>
              </div>
              <div class="card-footer">
                  <pagination :data="reservations" @pagination-change-page="getResults"></pagination>
              </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="createReservation()">
                        <div class="modal-body">
                            <select name="petname" class="form-control" :class="{'is-invalid': form.errors.has('petname') }" v-model="form.petname">
                                <option value="" disabled selected>------------ Choose pet ---------------</option>
                                <option v-for="pet in pets" :key="pet.id" :value="pet.petname">{{pet.petname}}</option>
                            </select>
                            <has-error :form="form" field="petname"></has-error><br>
                            <input type="text" name="petbreed" :class="{'is-invalid': form.errors.has('petbreed') }" class="form-control" v-model="form.petbreed" placeholder="Enter pet breed">
                            <has-error :form="form" field="petbreed"></has-error><br>
                            <input type="number" name="petage" :class="{'is-invalid': form.errors.has('petage') }" class="form-control" v-model="form.petage" placeholder="Enter pet age">
                             <has-error :form="form" field="petage"></has-error><br>
                            <select name="petgender" :class="{'is-invalid': form.errors.has('petgender') }" class="form-control" v-model="form.petgender">
                                <option value="" disabled selected>Select Gender </option>
                                <option value="Male"> Male </option>
                                <option value="Female"> Female </option>
                            </select>
                             <has-error :form="form" field="petgender"></has-error>
                            <br>
                            <input type="date" name="date" v-model="form.date" class="form-control" placeholder="Enter date of reservation">
                            <br>
                            <select class="form-control" name="time" v-model="form.time">
                                <option value="1:00pm-2:00pm">1:00pm - 2:00pm</option>
                                <option value="2:00pm-3:00pm">2:00pm - 3:00pm</option>
                                <option value="3:00pm-4:00pm">3:00pm - 4:00pm</option>
                                <option value="4:00pm-5:00pm">4:00pm - 5:00pm</option>
                                <option value="5:00pm-6:00pm">5:00pm - 6:00pm</option>
                                <option value="6:00pm-7:00pm">6:00pm - 7:00pm</option>  
                            </select>
                            <br>
                            <div class="checkbox">
                                <label><input type="checkbox" value="Vaccination" v-model="form.service" name="service[]">&nbsp;&nbsp;Vaccination</label>
                            </div>
                            <div class="checkbox">
                              <label><input type="checkbox" value="Haircut" name="service[]" v-model="form.service"> &nbsp;&nbsp;Haircut</label>
                            </div>
                            <div class="checkbox">
                              <label><input type="checkbox" value="Bathing" name="service[]" v-model="form.service">&nbsp;&nbsp;Bathing</label>
                            </div>
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
      return{
        pets:{},
        reservations:{},
        form: new Form({
                id:'',
                petname:'',
                petbreed:'',
                petage:'',
                petgender:'',
                service:[],
                name:'',
                date:''
            })
        }
    },
    mounted(){
        if(this.$gate.isUser()){
            axios.get('api/getPets').then(({data})=> (this.pets = data));
            this.loadReserve();
            this.createdReservation();
        }
    },

    methods:{
       getResults(page = 1) {
                        axios.get('api/reservations?page=' + page)
                            .then(response => {
                                this.reservations = response.data;
                            });
        },
      newModal(){
            this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
      },
      createReservation(){
        this.form.post('api/reservations')
        .then(()=>{
            this.$Progress.start();
            Fire.$emit('createdReservation');
            $("#addNew").modal('hide');

            toast({
              type: 'success',
              title: 'Reservation Created in successfully'
            });
            this.$Progress.finish();
        })
      },
     loadReserve(){
      axios.get('api/reservations').then(({data}) => (this.reservations = data))
     },
     createdReservation(){
      this.loadReserve();
      Fire.$on('createdReservation',()=>{
        this.loadReserve();
      })
     }
    }
  };
</script>