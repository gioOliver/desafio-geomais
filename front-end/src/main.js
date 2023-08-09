import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import PersonForm from './components/PersonForm.vue'
import PeopleList from './components/PeopleList.vue'
import VueTheMask from 'vue-the-mask'
import 'bootstrap/dist/css/bootstrap.css';

Vue.config.productionTip = false
Vue.use(VueRouter)
Vue.use(VueTheMask)

const routes = [
  { path: '/', name:'home', component: PeopleList} ,
  { path: '/save', name:'save', component: PersonForm }
]

const router = new VueRouter({routes})

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
