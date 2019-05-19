
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/*import 'vuetify/dist/vuetify.min.css'*/
window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
import * as VueGoogleMaps from 'vue2-google-maps'
import 'vue-event-calendar/dist/style.css' //^1.1.10, CSS has been extracted as one file, so you can easily update it.
import fullCalendar from 'vue-fullcalendar'

import Vuetify from 'vuetify'
import StarRating from 'vue-star-rating'
Vue.component('full-calendar', fullCalendar)
Vue.component('star-rating',StarRating);

Vue.use(Vuetify)

import 'vuetify/dist/vuetify.min.css'
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAQ-3qQsQhnBCwQASZhxsDNsPAtzRSieLs',
    libraries: 'places', // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,drawing,visualization'
    // (as you require)
 
    //// If you want to set the version, you can do so:
    // v: '3.26',
  },
 
  //// If you intend to programmatically custom event listener code
  //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
  //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
  //// you might need to turn this on.
  // autobindAllEvents: false,
 
  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  // installComponents: true,
})

import Gate from "./Gate";
/*import Vuetify from "vuetify";
Vue.use(Vuetify);*/
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('notification',require('./components/Notification.vue'))

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/developer', component: require('./components/Developer.vue') },
    { path: '/users', component: require('./components/Users.vue') },
    { path: '/profile', component: require('./components/Profile.vue') },
    { path: '*', component: require('./components/NotFound.vue') },
    {path:'/reservation',component: require('./components/Reservation.vue')},
    {path:'/home',component:require('./components/Home.vue')},
    {path:'/post',component:require('./components/Post.vue')},
    {path:'/pets',component:require('./components/Pet.vue')},
    {path:'/appointments',component:require('./components/Appointment.vue')},
    {path:'/qrcode',component:require('./components/Qrcode.vue')},
    {path:'/maps',component:require('./components/Maps.vue')},
    {path:'/clinicprofile',component:require('./components/ClinicProfile.vue')},
    {path:'/myqr',component:require('./components/UserQr.vue')},
    {path:'/pending',component:require('./components/Pending.vue')},
    {path:'/approved',component:require('./components/Approve.vue')},
    {path:'/schedule',component:require('./components/Schedule.vue')}
    
  ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })



Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});
Vue.filter('timeago',function(posted){
  return moment(posted).fromNow();
})


window.Fire =  new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);


Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});


var pwaCard = document.querySelector('#pwa');
var pwaCardContent = pwaCard.querySelector('.card__content');
var pwaCardDetails = pwaCard.querySelector('.card__details');
var detailsShown = false;

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js')
    .then(function() {
      console.log('SW registered');
    });
}

pwaCard.addEventListener('click', function (event) {
  if (!detailsShown) {
    detailsShown = true;
    pwaCardContent.style.opacity = 0;
    pwaCardDetails.style.display = 'block';
    pwaCardContent.style.display = 'none';
    setTimeout(function () {
      pwaCardDetails.style.opacity = 1;
    }, 300);
  } else {
    detailsShown = false;
    pwaCardDetails.style.opacity = 0;
    pwaCardContent.style.display = 'block';
    pwaCardDetails.style.display = 'none';
    setTimeout(function () {
      pwaCardContent.style.opacity = 1;
    }, 300);
  }
});
