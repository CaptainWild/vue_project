<template>
  <v-app>
    <v-navigation-drawer        
        v-model="primaryDrawer.model"
        :clipped="primaryDrawer.clipped"
        :floating="primaryDrawer.floating"
        :mini-variant="primaryDrawer.mini"
        :permanent="primaryDrawer.type === 'permanent'"
        :temporary="primaryDrawer.type === 'temporary'"
        overflow
        app 
    >      
        <v-img :aspect-ratio="16/5" src="https://cdn.vuetifyjs.com/images/parallax/material2.jpg">
            <v-row align="end" class="lightbox white--text pa-1 fill-height">
                <v-col cols="4" md="3" sm="4">
                   <v-avatar color="primary darken-2">
                    <v-icon dark>mdi-account-circle</v-icon>
                </v-avatar>
                </v-col>
                <v-col>
                    <div class="body-2">                      
                        {{user.name}}                        
                    </div>
                    <div v-if="user.role" class="overline">                        
                        {{user.role.name}}
                    </div>
                    <div class="caption">
                        <span> Last Login: {{user.last_login_at}} </span> 
                    </div>
                </v-col>
            </v-row>
        </v-img>
      <v-divider></v-divider>
        <v-list dense nav>        
        <template v-for="item in items">
            <v-row v-if="item.heading" :key="item.heading" align="center" >
                <v-col cols="6">
                    <v-subheader v-if="item.heading">
                        {{ item.heading }}
                    </v-subheader>
                </v-col>
                <v-col cols="6" class="text-center">
                    <a href="#!" class="body-2 black--text" >EDIT</a>
                </v-col>
            </v-row>
            
            <v-list-group                 
                v-show="$can.permit(item.slug)"    
                v-else-if="item.children"                 
                :key="item.text" 
                v-model="item.model" 
                :prepend-icon="item.model ? item.icon : item.icon" 
                :append-icon="item['icon-alt'] ? item['icon-alt'] : ''"
            >

                <template v-slot:activator>                   
                    <v-list-item-title>{{ item.text }}</v-list-item-title>                       
                </template>
                <v-list-item v-show="$can.permit(child.slug)" v-for="(child, i) in item.children" :key="i" router :to="child.link" >
                    <v-list-item-icon v-if="child.icon" >
                        <v-icon v-text="child.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-title v-text="child.text"></v-list-item-title>                 
                </v-list-item>
            </v-list-group>

            <v-list-item v-show="$can.permit(item.slug)" v-else :key="item.text" router :to="item.link" >
              <v-list-item-action>
                  <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
        </template>
        </v-list>
        
        <template v-slot:append>
            <div class='text-center'>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon @click="changePasswordDialog = true">
                            <v-icon>mdi-lock-open</v-icon>
                        </v-btn>
                    </template>
                <span>Change Password</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">   
                        <v-btn  v-on="on" icon @click="dialog = !dialog">
                            <v-icon>mdi-format-paint</v-icon>
                        </v-btn>
                    </template>
                    <span>Theme</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">   
                        <v-btn v-on="on" icon @click.prevent="logout">            
                            <v-icon>mdi-logout</v-icon>
                        </v-btn>      
                    </template>
                    <span>Logout</span>
                </v-tooltip>
                </div>            
        </template>
    </v-navigation-drawer>

    <v-app-bar
        :clipped-left="primaryDrawer.clipped"
        color="amber darken-1"
        app        
    >
        <v-app-bar-nav-icon  
            v-if="primaryDrawer.type !== 'permanent'"
            @click.stop="primaryDrawer.model = !primaryDrawer.model"
        ></v-app-bar-nav-icon>

        <v-toolbar-title 
            style="width: 300px" 
            class="ml-0 pl-4"
        >intelliSAFE</v-toolbar-title>
        
        <v-spacer></v-spacer>      
      
        <v-btn icon>
            <v-icon>mdi-bell</v-icon>
        </v-btn>
    </v-app-bar>

    <v-content>
        <v-container fluid>
            <snackbar-store />        
            <router-view></router-view>
        </v-container>
    </v-content>    
    <v-footer 
        :inset="footer.inset" 
        app
    >
        <span class="px-4">&copy; {{ new Date().getFullYear() }} - intelliSOLUTIONS</span>
    </v-footer>

    <v-dialog v-model="dialog" width="800px">
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <span>Scheme</span>
                        <v-switch 
                            v-model="$vuetify.theme.dark" 
                            primary 
                            label="Dark"
                        ></v-switch>
                    </v-col>
                    <v-col cols="12" md="6">
                        <span>Drawer</span>
                        <v-radio-group 
                            v-model="primaryDrawer.type" 
                            column
                        >
                            <v-radio 
                                v-for="drawer in drawers" 
                                :key="drawer" 
                                :label="drawer" 
                                :value="drawer.toLowerCase()" 
                                primary
                            ></v-radio>
                        </v-radio-group>
                        <v-switch 
                            v-model="primaryDrawer.clipped" 
                            label="Clipped" 
                            primary
                        ></v-switch>
                        <v-switch 
                            v-model="primaryDrawer.floating" 
                            label="Floating" 
                            primary
                        ></v-switch>
                        <v-switch 
                            v-model="primaryDrawer.mini" 
                            label="Mini" 
                            primary
                        ></v-switch>
                    </v-col>
                    <v-col cols="12" md="6">
                        <span>Footer</span>
                        <v-switch v-model="footer.inset" label="Inset" primary></v-switch>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialog = !dialog">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    
    <userPasswordDialog
        :key="user.id"
        :changePasswordDialog.sync="changePasswordDialog"
        :primaryDrawer.sync = "primaryDrawer.model"
    ></userPasswordDialog>
  </v-app>
</template>
<script>
import userPasswordDialog from '@/js/views/auth/changePasswordDialog';
import snackbarStore from '@/js/components/SnackbarStore';
export default {
    components: {
        userPasswordDialog,
        snackbarStore    
    },
    computed: {
        user(){
            return this.$store.getters.getProfile;
        }
    },
    created() {        
        if(this.user.force_password)
            this.changePasswordDialog = true
    },
    methods: {
        logout: function () {
            this.$store.dispatch('authLogout')
                .then(() => {
                    this.primaryDrawer.model = false;
                    this.$router.push('/')
                })
        }
    },      
    data: () => ({
      drawers: ['Default (no property)', 'Permanent', 'Temporary'],
      primaryDrawer: {
        model: null,
        type: 'default (no property)',
        clipped: false,
        floating: false,
        mini: false,
      },
      items: [        

        // { icon: 'mdi-chart-line-stacked', text: 'High-Risk Works', link: '/hrws' },
        // { icon: 'mdi-speedometer', text: 'Risk Assessments', link: '/ras'  },
        // { icon: 'mdi-chevron-up','icon-alt': 'mdi-chevron-down', 
        //     text: 'Risk Matrix' ,
        //     model:false,
        //     children: [
        //         { icon: 'mdi-margin', text: 'Likelihood' },
        //         { icon: 'mdi-alert-rhombus-outline', text: 'Severtiy' },
        //         { icon: 'mdi-mapbox', text: 'Risk Matrix Mapping' },                
        //     ],
        // },               
        // { icon: 'mdi-calendar', text: 'Meetings', link: '/events' },
        // { icon: 'mdi-archive', text: 'Archives', link: '/archives' },
        // { icon: 'mdi-view-dashboard-outline', text: 'Dashboard' },
        // { icon: 'mdi-chart-arc', text: 'Reports' },

        { icon: 'mdi-clipboard-check-outline', text: 'Permit to Works', link: '/ptws', slug: 'ptw_menu'},       
        { icon: 'mdi-file-find-outline', text: 'Inspections', link: '/inspections', slug: 'inspection_menu'},                        
        { icon: 'mdi-safety-goggles', text: 'Safe Work Procedures', link: '/swps', slug: 'swp_menu' },
        { icon: 'mdi-format-list-checks','icon-alt': 'mdi-chevron-down', 
            text: 'Checklist PTW' ,
            model:false,
            children: [
                { icon: 'mdi-clipboard-list-outline', text: 'Checklist Setup', link: '/checklists', slug: 'checklist_menu' },
                { icon: 'mdi-file-search-outline', text: 'Inspection Checklists', link: '/inspectionchecklists', slug: 'inspection_checklist_menu' },
            ],
            'slug': 'checklist_ptw_menu'
        },     
        { icon: 'mdi-file-settings-variant-outline','icon-alt': 'mdi-chevron-down',
            text: 'PTW Setup',
            model: false,
            children: [
                { icon: 'mdi-excavator', text: 'Equipment', link: '/equips', slug: 'equipment_menu' },
                { icon: 'mdi-worker', text: 'Manpower', link: '/workers' , slug: 'manpower_menu'},
                { icon: 'mdi-file-document-box-multiple', text: 'Projects', link: '/projects', slug: 'project_menu' },
                { icon: 'mdi-table', text: 'Risk Matrix', slug: '' },
                { icon: 'mdi-domain', text: 'Trades', link: '/trades', slug: '' },    
                { icon: 'mdi-contacts', text: 'Sub-Contractors', link: '/subcontractors', slug: 'subcontractor_menu' },                                           
            ],
            slug: 'ptw_setup_menu'
        },     
        { icon: 'mdi-settings-outline','icon-alt': 'mdi-chevron-down',
            text: 'Admin Setup',
            model: false,
            children: [                                                
                { icon: 'mdi-account-group-outline', text: 'Users', link: '/users', slug: 'user_menu' },
                { icon: 'mdi-account-network', text: 'Roles', link: '/roles', slug: 'role_menu'  },
                { icon: 'mdi-account-details', text: 'Permissions', link: '/permissions', slug: 'permission_menu' },                
            ],
            slug:''
        },        
      ],      
      footer: {
        inset: false,
      },
      dialog: false,
      changePasswordDialog: false,      
    }),
}
</script>