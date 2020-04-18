/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */
import './bootstrap';
import Vue from 'vue';
import Vuetify from 'vuetify';
import {store} from '@/js/stores/store';
import Gate from '@/js/core/gate';

//Route information for Vue Router
import Routes from '@/js/routes.js';

//Component Files
import App from '@/js/views/App';

//Passport Components
import PassportClients from '@/js/components/passport/Clients';
import PassportAuthorizedClients from '@/js/components/passport/AuthorizedClients';
import PassportPersonalAccessTokens from '@/js/components/passport/PersonalAccessTokens';
//??
Vue.component('passport-clients',PassportClients);
Vue.component('passport-authorized-clients',PassportAuthorizedClients);
Vue.component('passport-personal-access-tokens',PassportPersonalAccessTokens);

Vue.use(Vuetify);

const app = new Vue({
    //el:'#app',
    created(){
        /*if (this.$store.getters.isAuthenticated) {    
            this.$store.dispatch('userRequest').then(response => {
                //console.log(response)
                Vue.prototype.$can = new Gate(response)
                console.log(this.$can.permit('ptw_menu'))
            })
        }*/
    },
    router: Routes,
    store,  
    vuetify: new Vuetify(),
    render: h => h(App),
});


app.$store.dispatch ("userRequest").then (profile => {
    Vue.prototype.$can = new Gate (profile);
    app.$mount ('#app')
}).catch(errors => {
    console.log(errors)    
    app.$mount ('#app')
});

//export default app;