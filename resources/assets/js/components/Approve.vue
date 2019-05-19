<template>
   <!--  <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Approve Table</h3>
                      
                     </div>
             <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Petname</th>
                        <th>Phone Number </th>
                        <th> Time </th>
                        <th>Date Reservation </th>
                        <th>Service</th>
                  </tr>
                 <tr v-for="approve in approves.data" :key="approve.id">
                    <td>{{approve.user.name}}</td>
                    <td>{{approve.petname}}</td>
                    <td>{{approve.user.phone}}</td>
                    <td>{{approve.time}}</td>
                    <td>{{approve.date_reserve | myDate}} </td>
                    <td>{{approve.service}}</td>
                    <td>
                
                        <!-- <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </a>

                    </td>

                </tr>        
                </tbody></table>
              </div>
             <pagination :data="approves" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>

       
    </div> --> 
    <div class="container">

     <v-card>
    <v-card-title>
      Nutrition
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
      :items="approves"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.user.name }}</td>
        <td class="text-xs-left">{{ props.item.petname }}</td>
        <td class="text-xs-left">{{ props.item.user.phone }}</td>
        <td class="text-xs-left">{{ props.item.time }}</td>
        <td class="text-xs-left">{{ props.item.date_reserve | myDate }}</td>
        <td class="text-xs-left">{{ props.item.service }}</td>
      </template>
      <template v-slot:no-results>
        <v-alert :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
        </v-alert>
      </template>
    </v-data-table>
  </v-card>     
</div>
</template>
<script>
    export default{
        data(){
            return {
                approves:[],
                search: '',
        headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'user.name'
          },
          { text: 'Petname', value: 'petname' },
          { text: 'Phone', value: 'user.phone' },
          { text: 'Time', value: 'time' },
          { text: 'Date Reserve', value: 'date_reserve' },
          { text: 'Services', value: 'service' }
        ],
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
               
                this.loadApprove();
           
            }
        },
        methods:{
             getResults(page = 1) {
                        axios.get('api/getapprove?page=' + page)
                            .then(response => {
                                this.approves = response.data;
                            });
                },
           loadApprove(){
            axios.get('api/getapprove').then(({data}) => this.approves = data);
           }
        }
    };
</script>