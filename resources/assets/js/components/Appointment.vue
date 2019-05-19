<template>
       <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Appointments</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th> Petname </th>
                       <!--  <th> Generate QR </th> -->
                  </tr>


                  <tr v-for="appointment in appointments.data" :key="appointments.id">

                    <td>{{appointment.id}}</td>
                    <td>{{appointment.user.name}}</td>
                    <td> {{appointment.petname}}</td>
                   
                 <!--    <td>
                       
                        
                       <button class="btn  btn-primary">Generate QR</button>
                    </td> -->
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="appointments" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                appointments:{}
            }
        },
        mounted(){
            this.loadAppointments();
        },
        methods:{
          getResults(page = 1) {
                        axios.get('api/getAppointments?page=' + page)
                            .then(response => {
                                this.appointments = response.data;
                            });
            },
            loadAppointments(){
                axios.get('api/getAppointments').then(({data})=> this.appointments = data)
            }
        }
    };
</script>