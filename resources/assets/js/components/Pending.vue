<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Table</h3>
                      
                     </div>
             <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Petname</th>
                        <th>Date Reservation </th>
                        <th> Time </th>
                        <th>Service</th>
                        <th> Current Status </th>
                        <th> Change Status </th>
                  </tr>
                 <tr v-for="pending in pending.data" :key="pending.id">
                    <td>{{pending.user.name}}</td>
                    <td>{{pending.petname}}</td>
                    <td>{{pending.date_reserve | myDate}} </td>
                    <td>{{pending.time}}</td>
                    <td>{{pending.service}}</td>
                    <td style="color:#f79102;">{{pending.status.name}}</td>
                    <td>
                
                        <a href="#" @click="approvedStatus(pending.id)" class="btn btn-primary">
                            Approved
                        </a>
                       
                    </td>

                </tr>


                  
                </tbody></table>
              </div>
             <pagination :data="pending" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                pending:{},
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
                this.loadPending();
                this.createdPost();
            }
        },
        methods:{
             getResults(page = 1) {
                        axios.get('api/getpending?page=' + page)
                            .then(response => {
                                this.pending = response.data;
                            });
                },
           loadPending(){
            axios.get('api/getpending').then(({data}) => this.pending = data);
           },
           approvedStatus(id){
              swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approved it!'
                  }).then((result)=> {
                      if(result.value){
                        this.form.post('api/approve/'+id).then(()=>{
                           swal(
                              'Approved!',
                              'Your reservation has been approved.',
                              'success'
                              )                          
                        }).catch(()=>{
                          swal("Failed!", "There was something wronge.", "warning");
                        })
                      }
                  })
           }
        }
    };
</script>