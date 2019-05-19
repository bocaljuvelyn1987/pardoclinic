<template>
<div class="container bootstrap snippet" >
    <div class="col-sm-12" style="margin-top:50px" v-for="post in posts.data" :key="post.id" >
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left image">
                    <router-link to="/profile"><img src="/images/logopetnics.png" class="img-circle avatar" alt="user profile image"></router-link>

                </div>
                <div class="pull-left meta">

                    <div class="title h5">
                        <router-link to="/profile"><b>{{post.user.name}}</b></router-link>
                        
                    </div>

                    <h6 class="text-muted time">{{created_at | timeago}}</h6>
                </div>
            </div> 
            <br>
            <div class="post-description"> 
              <img :src="post.image" width="100%;"><br>
              <br>
                <h3>{{post.content}}</h3>
               
            </div>
            
        </div>
    </div>
     
</div>



</template>
<script>
  export default {
    data () {

      return {
        posts: {},
        form: new Form({
            id:'',
            name : '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: ''
            })
        }
    },
    mounted(){
        if(this.$gate.isUser()){
           Fire.$emit('createdPost');
           this.loadPosts();
           this.createdPost();
        }
    },
    methods : {
        newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        loadPosts(){

             axios.get('api/getPosts').then(({data})=> (
              this.posts = data));
        },
        createdPost(){
        this.loadPosts();
        Fire.$on('createdPost',()=>{
            this.loadPosts();
        })
      }
        
    }
  };
</script>

<style type="text/css" scoped>
  .panel-shadow {
    box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
}
.panel-white {
  border: 1px solid #dddddd;
}
.panel-white  .panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #ddd;
}
.panel-white  .panel-footer {
  background-color: #fff;
  border-color: #ddd;
}

.post .post-heading {
  height: 95px;
  padding: 20px 15px;
}
.post .post-heading .avatar {
  width: 60px;
  height: 60px;
  display: block;
  margin-right: 15px;
}
.post .post-heading .meta .title {
  margin-bottom: 0;
}
.post .post-heading .meta .title a {
  color: black;
}
.post .post-heading .meta .title a:hover {
  color: #aaaaaa;
}
.post .post-heading .meta .time {
  margin-top: 8px;
  color: #999;
}
.post .post-image .image {
  width: 100%;
  height: auto;
}
.post .post-description {
  padding: 15px;
}
.post .post-description p {
  font-size: 14px;
}
.post .post-description .stats {
  margin-top: 20px;
}
.post .post-description .stats .stat-item {
  display: inline-block;
  margin-right: 15px;
}
.post .post-description .stats .stat-item .icon {
  margin-right: 8px;
}
.post .post-footer {
  border-top: 1px solid #ddd;
  padding: 15px;
}
.post .post-footer .input-group-addon a {
  color: #454545;
}
.post .post-footer .comments-list {
  padding: 0;
  margin-top: 20px;
  list-style-type: none;
}
.post .post-footer .comments-list .comment {
  display: block;
  width: 100%;
  margin: 20px 0;
}
.post .post-footer .comments-list .comment .avatar {
  width: 35px;
  height: 35px;
}
.post .post-footer .comments-list .comment .comment-heading {
  display: block;
  width: 100%;
}
.post .post-footer .comments-list .comment .comment-heading .user {
  font-size: 14px;
  font-weight: bold;
  display: inline;
  margin-top: 0;
  margin-right: 10px;
}
.post .post-footer .comments-list .comment .comment-heading .time {
  font-size: 12px;
  color: #aaa;
  margin-top: 0;
  display: inline;
}
.post .post-footer .comments-list .comment .comment-body {
  margin-left: 50px;
}
.post .post-footer .comments-list .comment > .comments-list {
  margin-left: 50px;
}
</style>