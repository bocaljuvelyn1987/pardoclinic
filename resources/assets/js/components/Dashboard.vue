<template>
    <div class="container">
           <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info"><i class="fas fa-users" style="font-size:49px;color:brown;"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light">{{countCustomer}}</h3>
                                        <h5 class="text-muted m-b-0">Customers</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="fas fa-clipboard" style="font-size:49px;color:red;"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">{{countPost}}</h3>
                                        <h5 class="text-muted m-b-0">Post</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="fas fa-wallet" style="color:indigo; font-size:49px;"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">{{countQr}}</h3>
                                        <h5 class="text-muted m-b-0">QR Codes</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="fas fa-calendar" style="font-size:49px;color:#0fc2ef;"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">{{countAppointment}}</h3>
                                        <h5 class="text-muted m-b-0">Appointments</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     
            </div>
           <full-calendar locale="en"></full-calendar>
    </div>
</template>

<script>

    export default {
       
          data () {
    return {
        countCustomer:0,
        countPost:0,
        countAppointment:0,
        countQr:0,
        reserve:[],
      demoEvents: [{
        date: '2016/11/12', // Required
        title: 'Test' // Required
      }, {
        date: '2016/12/15',
        title: 'Test',
        desc: 'description',
        customClass: 'disabled highlight' // Custom classes to an calendar cell
      }]
    }
  }, 
   components : {
    'full-calendar': require('vue-fullcalendar')    
  },
        mounted() {
            axios.get('api/countCustomer').then(({data}) => this.countCustomer = data);
            axios.get('api/countPost').then(({data}) => this.countPost = data);
            axios.get('api/countQr').then(({data}) => this.countQr = data);
            axios.get('api/countAppointment').then(({data}) => this.countAppointment = data);
            axios.get('api/loadReserve').then(({data}) => this.reserve = data);

        }
    };
</script>
