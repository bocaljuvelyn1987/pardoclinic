<template>
  <div class="container mt-5" >
    <h1> MY QR </h1>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" v-for="qr in qrs.data" :key = "qr.id" >
                <div class="tile" style="margin-top:80px;">
                    <div class="wrapper">
                        <div class="header">{{qr.id}}</div>

                        <div class="banner-img" style="margin:0 auto; text-align:center;">
                            <qrcode-vue :value="qr.reference" size="100" level="H" ></qrcode-vue>
                        </div>
                        <div class="footer">
                            <a href="#" class="Cbtn Cbtn-primary" @click="modalOpen(qr)">View</a>
                        </div>
                    </div>
                </div> 
            </div>

            <div id="viewqr" class="modal fade" role="dialog" style="padding-top:50%;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body" style="text-align:center; margin:0 auto;" >
        <div style="margin:30px 0px;">
       <qrcode-vue :value="reference" size="100" level="H" ></qrcode-vue>
     </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  </div>
</template>
<script type="text/javascript">
import QrcodeVue from 'qrcode.vue';
export default{
    data(){
      return{
          qrs:{},
          reference:''
      }
    },
    components:{
      QrcodeVue
    },
    mounted(){
       if(this.$gate.isUser()){
          axios.get('api/userQr').then(({data}) => this.qrs = data);
       }
    },
    methods:{
        modalOpen(qr){
            this.reference = qr.reference;
             $('#viewqr').modal('show');
        }
    }
};
  
</script>
<style type="text/css" scoped>
/*  Reset & General
---------------------------------------------------------------------- */
* { margin: 0px; padding: 0px; }
body {
  background: #ecf1f5;
  font:14px "Open Sans", sans-serif; 
  text-align:center;
}

.tile{
  width: 100%;
  background:#fff;
  border-radius:5px;
  box-shadow:0px 2px 3px -1px rgba(151, 171, 187, 0.7);
  float:left;
    transform-style: preserve-3d;
    margin: 10px 5px;

}

.header{
  border-bottom:1px solid #ebeff2;
  padding:19px 0;
  text-align:center;
  color:#59687f;
  font-size:600;
  font-size:19px; 
  position:relative;
}

.banner-img {
  padding: 5px 5px 0;
}

.banner-img img {
  width: 100%;
  border-radius: 5px;
}

.dates{
  border:1px solid #ebeff2;
  border-radius:5px;
  padding:20px 0px;
  margin:10px 20px;
  font-size:16px;
  color:#5aadef;
  font-weight:600;  
  overflow:auto;
}
.dates div{
  float:left;
  width:50%;
  text-align:center;
  position:relative;
}
.dates strong,
.stats strong{
  display:block;
  color:#adb8c2;
  font-size:11px;
  font-weight:700;
}
.dates span{
  width:1px;
  height:40px;
  position:absolute;
  right:0;
  top:0;  
  background:#ebeff2;
}
.stats{
  border-top:1px solid #ebeff2;
  background:#f7f8fa;
  overflow:auto;
  padding:15px 0;
  font-size:16px;
  color:#59687f;
  font-weight:600;
  border-radius: 0 0 5px 5px;
}
.stats div{
  border-right:1px solid #ebeff2;
  width: 33.33333%;
  float:left;
  text-align:center
}

.stats div:nth-of-type(3){border:none;}

div.footer {
  text-align: right;
  position: relative;
  margin: 20px 5px;
}

div.footer a.Cbtn{
  padding: 10px 25px;
  background-color: #DADADA;
  color: #666;
  margin: 10px 2px;
  text-transform: uppercase;
  font-weight: bold;
  text-decoration: none;
  border-radius: 3px;
}

div.footer a.Cbtn-primary{
  background-color: #5AADF2;
  color: #FFF;
}

div.footer a.Cbtn-primary:hover{
  background-color: #7dbef5;
}

div.footer a.Cbtn-danger{
  background-color: #fc5a5a;
  color: #FFF;
}

div.footer a.Cbtn-danger:hover{
  background-color: #fd7676;
}
</style>