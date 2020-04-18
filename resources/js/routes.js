import Vue from 'vue';
import VueRouter from 'vue-router';
import {store} from '@/js/stores/store';

Vue.use(VueRouter);

const ifNotAuthenticated = (to, from, next) => {
    if (!store.getters.isAuthenticated) {
        next();
        return
    }
    next('/ptws')
}

const ifAuthenticated = (to, from, next) => {
    if (store.getters.isAuthenticated) {
        next();
        return
    }
    next('/')
}

import NotFound from '@/js/views/404';
import Login from '@/js/views/Login';
import Home from '@/js/views/Home';

import Archives from '@/js/views/archives/index';
import Checklists from '@/js/views/checklists/index';
import Equips from '@/js/views/equips/index';
import Events from '@/js/views/events/index';
import Hrws from '@/js/views/hrws/index';
import Inspections from '@/js/views/inspections/index';
import InspectionChecklists from '@/js/views/inspectionchecklists/index';
import Ptws from '@/js/views/ptws/index';
import PtwCheckers from '@/js/views/ptws/checker';
import Ras from '@/js/views/ras/index';
import Swps from '@/js/views/swps/index';

//General Setup Menu
import Projects from '@/js/views/projects/index';
import Permissions from '@/js/views/permissions/index';
import SubContractors from '@/js/views/subcontractors/index';
import Trades from '@/js/views/trades/index';
import Users from '@/js/views/auth/users';
import Workers from '@/js/views/workers/index';
import Roles from '@/js/views/roles/index';



const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login,
            beforeEnter: ifNotAuthenticated,
        },
        {
            path: '/',
            name: 'home',
            component: Home,
            beforeEnter: ifAuthenticated,
            children: [
                {
                    path: '/archives',
                    name: 'archives',
                    component: Archives
                },
                {
                    path: '/checklists',
                    name: 'checklists',
                    component: Checklists
                },
                {
                    path: '/equips',
                    name: 'equips',
                    component: Equips
                },                
                {
                    path: '/events',
                    name: 'events',
                    component: Events
                },
                {
                    path: '/hrws',
                    name: 'hrws',
                    component: Hrws
                },
                {
                    path: '/inspections',
                    name: 'inspections',
                    component: Inspections
                },
                {
                    path: '/inspectionchecklists',
                    name: 'inspectionchecklists',
                    component: InspectionChecklists
                },
                {
                    path: '/permissions',
                    name: 'permissions',
                    component: Permissions
                },
                {
                    path: '/projects',
                    name: 'projects',
                    component: Projects
                },
                {
                    path: '/roles',
                    name: 'roles',
                    component: Roles
                },
                {
                    path: '/ptws',
                    name: 'ptws',
                    component: Ptws
                },
                {
                    path: '/ptwcheckers',
                    name: 'ptwcheckers',
                    component: PtwCheckers
                },
                {
                    path: '/subcontractors',
                    name: 'subcontractors',
                    component: SubContractors
                },
                {
                    path: '/ras',
                    name: 'ras',
                    component: Ras
                },
                {
                    path: '/swps',
                    name: 'swps',
                    component: Swps
                },
                {
                    path: '/trades',
                    name: 'trades',
                    component: Trades
                },
                {
                    path: '/users',
                    name: 'users',
                    component: Users
                },
                {
                    path: '/workers',
                    name: 'workers',
                    component: Workers
                },
                // {
                //     path: '/inspections',
                //     name: 'inspections',
                //     component: Inspections
                // }                         
            ]
        },
        { path: '*', component: NotFound }       
        // {
        //     path: '/',
        //     name: 'layout',
        //     component: AdminLayout,
        //     beforeEnter: ifAuthenticated,
        //     children: [
        //         {
        //             path: 'dashboard',
        //             name: 'dashboard',
        //             component: Dashboard
        //         }
        //     ]
        // },            
        // {
        //     path: '/register',
        //     name: 'register',
        //     component: Register,
        //     beforeEnter: ifNotAuthenticated,
        // },
        // {
        //     path: '/password/reset/',
        //     name: 'password-email',
        //     component: PasswordEmail,
        //     beforeEnter: ifNotAuthenticated,
        // },
        // {
        //     path: '/password/reset/:token',
        //     name: 'password-reset',
        //     component: PasswordReset,
        //     beforeEnter: ifNotAuthenticated,
        // },          
    ]
});

export default router;