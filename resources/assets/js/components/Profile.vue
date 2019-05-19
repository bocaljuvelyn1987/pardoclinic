<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer{
    padding: 0;
}

</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg')">
                    <h3 class="widget-user-username">{{this.form.name}}</h3>
                    <h5 class="widget-user-desc">{{this.form.type}}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="/images/logopetnics.png" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">{{countCustomer}}</h5>
                        <span class="description-text">Customer</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">{{countPost}}</h5>
                        <span class="description-text">Post</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">{{rates}}</h5>
                        <span class="description-text">Rate</span>
                        </div>
                        <div class="description-block"  >
                           <form @submit.prevent = "setRating()" v-show="added ===false">
                                     <div class="star-rating" >
                                    <star-rating v-model="form.rating" :increment="0.5" text-class="custom-text" :size="10" name="rating" style="margin-left:10%;"></star-rating>
                                    <br>
                                 <button type="submit" class="btn btn-primary">Publish</button>
                                 </div>
                            </form>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#activity" data-toggle="tab">Activity</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane active show" id="activity">
                                <h3 class="text-center">About Us</h3>
                                <p>At Mission of Pet Centre Animal Clinic is the safety of your pets is in the hands of veterinarian who examine your pets. All kidding aside,
                                      we pride ourselves on our unparalleled
                                      coordinated approach to caring for your pets.
                                      In decades of serving the community, our
                                                top-tier group of veterinarians has saved
                                         countless lives through the integrative
                                        approach that we’ve pioneered.
                                       </p>
                                <br><br>
                                 <h3 class="text-center">History</h3>
                                  <p> Your pet's health and well being is very important to us and we will take every step to give your pet the best possible care. </p>
                            </div>
                            <!-- Setting Tab -->
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->
        </div>
    </div>
</template>



<script>
    export default {
        data(){
            return {
                countCustomer:0,
                 countPost:0,
                added: false,
                customers:[],
                posts:[],
                rates:0,
                 form: new Form({
                    rating: 0,
                })
            }
        },
        mounted() {

            this.getRating();
            this.createdRating();
            axios.get('api/countCustomer').then(({data}) => this.countCustomer = data);
            axios.get('api/countPost').then(({data}) => this.countPost = data);
        },

        methods:{
              setRating(){

            this.form.post('api/rating').then((response) => {
                this.$Progress.start();
            
            Fire.$emit('createdRating');
              toast.fire({
                            type: 'success',
                            title: 'Post added into account successfully'
                        })
                     this.$Progress.finish();
            })
            this.added = true;
         },

         getRating(){
             axios.get('api/getrate').then(({data}) => this.rates = data);
         },
         createdRating(){
            this.getRating();
            Fire.$on('createdRating',()=>{
                this.getRating();
            })
         }
        },

        created() {
            axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));
        }
    };
</script>
