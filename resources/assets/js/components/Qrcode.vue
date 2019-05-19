<template>
      <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">QR TABLE</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Add QR <i class="fas fa-money-check fa-fw"></i></button>
                         </div>
                     </div>
             <div class="card-body table-responsive p-0">
               <v-card>
    <v-card-title>
     QR CODES
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="qrs"
      :search="search"
    >
      <template v-slot:items="props">
        <td class="text-xs-left">{{ props.item.user.name}}</td>
        <td class="text-xs-left"><qrcode-vue :value="props.item.reference" :size="size" level="H"></qrcode-vue></td>
        <td class="text-xs-left">{{ props.item.reference }}</td>
        <td class="text-xs-left">{{ props.item.created_at | myDate }}</td>
        <td class="text-xs-left"><button @click="modalOpen(props.item)"><i class="fa fa-eye" style="font-size:19px;"></i></button></td>
      </template>
      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>
              </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewLabel">Add QR</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="createQr()">
                        <div class="modal-body">
                           <!--  <select class="form-control" name="transaction_id" v-model="form.transaction_id">
                                <option value="">---Select Account Name---</option>
                                <option  v-for="account in accounts" :key="account.id" :value="account.id">{{account.account_name}}</option>
                            </select>
                            <br>
                            <input type="text" class="form-control" placeholder="Enter Passenger Name" name="passenger_name" v-model="form.passenger_name"><br>   -->   
                        <!--     <input type="file" name="image" placeholder="Image" class="form-control"> <br>
                            <textarea class="form-control" placeholder="Whats on your mind ?" :class="{'is-invalid': form.errors.has('content') }" style="height:200px;" name="content" v-model="form.content">
                            </textarea>
                            <has-error :form="form" field="content"></has-error> -->
                            
                            <select class="form-control" v-model="form.user" name="user">
                                <option value="" disabled selected>---Select Account Name---</option>
                                 <option  v-for="account in appointments.data" :key="account.user_id" :value="account.user_id">{{account.user.name}}</option>
                            </select>
                            <br>
                           
                           <!--  <select class="form-control" v-model="form.transaction" name="transaction">
                                <option value="" disabled selected>---Select Petname---</option>
                                 <option  v-for="account in appointments.data" :key="account.id" :value="account.id">{{account.petname}}</option>
                            </select> -->
                          
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate QRss</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>


      <div id="viewqr" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <qrcode-vue :value="form.reference" size="300" level="H" style="margin:0 auto; text-align:center;"></qrcode-vue>
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
import QrcodeVue from 'qrcode.vue';
    export default{
        data(){
            return{
                appointments:{},
                user_id:'',
                qrs:[],
                 size: 80,
                 form: new Form({
                    id: '',
                    reference: '',
                    transaction:'',
                    user:''
                 }),
                 search: '',
        headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: true,
            value: 'Name'
          },
          { text: 'QR Codes', value: 'QR Codes' },
          { text: 'Reference Key', value: 'reference' },
          { text: 'Created At', value: 'created' },
          { text: 'View', value: 'view' }
        ]
      }
            },

        mounted(){
          if(this.$gate.isAdmin()){
            this.loadAppointments();
            this.loadReservation();
            this.createdQr();
          }
        },
        components: {
             QrcodeVue
         },
        methods:{
             loadAppointments(){
                axios.get('api/getAppointments').then(({data})=> this.appointments = data)
            },

            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
                modalOpen(qr){
                  this.form.reference = qr.reference
                   $('#viewqr').modal('show');
                   
                },
            createQr(){
                this.form.post('api/qr').then((response)=>{
                     this.$Progress.start();
                    Fire.$emit('createdQr');
                     $('#addNew').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Qr added into account successfully'
                        })
                     this.$Progress.finish();
                })
            },
            loadReservation(){
                axios.get('api/loadReserve').then(({data}) => this.qrs = data)
            },

            createdQr(){
              this.loadReservation();
              Fire.$on('createdQr',()=>{
                this.loadReservation();
              })

            }
        }
    };
</script>