<template>
<v-dialog v-model="ptwsLinkDialog" max-width="900" persistent>
  <v-card>
    <v-card-title class="headline">Project {{projectName}}</v-card-title>
    <v-card-subtitle>Inspection Date: {{inspectionDate}}</v-card-subtitle>
    <v-card-text>
        <v-data-table
            :headers="headers"
            :items="ptwList"        
            sort-by="created_at"
            sort-desc
            class="elevation-1"
            :loading="loading"
            :search="search"
        >
        <template v-slot:top>      
          <v-toolbar flat > 
              <v-toolbar-title>Permit To Works</v-toolbar-title>
              <v-divider
                class="mx-4"
                inset
                vertical
              ></v-divider>              
        </v-toolbar>
      </template>


        <template v-slot:item.ptwstatus.name="{ item }">
           <v-badge
              :content="item.attachments.length"
              :value="(item.ptw_status_id == 1 || item.ptw_status_id == 12) && item.attachments.length > 0"
              color="amber darken-1"              
            >
              <span class ="blue--text" v-if="item.ptw_status_id==8">{{item.ptwstatus.name}}</span>
              <span class ="green--text" v-else-if="item.ptw_status_id==1 || item.ptw_status_id==12 || item.ptw_status_id==6">{{item.ptwstatus.name}}</span>
              <span class ="orange--text" v-else-if="item.ptw_status_id==5">{{item.ptwstatus.name}}</span>
              <span class ="red--text" v-else-if="item.ptw_status_id==2 || item.ptw_status_id==7 || item.ptw_status_id==11 || item.ptw_status_id== 9 || item.ptw_status_id==10">{{item.ptwstatus.name}}</span>        
              <span v-else>{{item.ptwstatus.name}}</span>
            </v-badge>
        </template>

      <template v-slot:item.reference_no="{ item }">
        <span v-if="item.version_index > 0">{{ item.reference_no }}.{{item.version_index}}</span>
        <span v-else>{{ item.reference_no }}</span>
      </template>

      <template v-slot:item.project_id="{ item }">
        <span>{{ item.project.name }}</span>
      </template>

      <template v-slot:item.sub_contractor_id="{ item }">
        <span>{{ item.subcontractor.name }}</span>
      </template>

      <template v-slot:item.start_date="{ item }">
        <span>{{new Date(item.start_date).toLocaleDateString()}}</span>
      </template>

      <template v-slot:item.end_date="{ item }">
        <span>{{new Date(item.end_date).toLocaleDateString()}}</span>
      </template>

      <template v-slot:item.updated_at="{ item }">
        <span>{{new Date(item.updated_at).toLocaleDateString()}}</span>
      </template>
     
      <template v-slot:item.action="{ item }">
        
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-btn              
              v-on="on"
              text
              icon
              dark
              color="info"              
            ><v-icon>mdi-pdf-box</v-icon>
            </v-btn>
          </template>
          <span>Generate PDF</span>
        </v-tooltip>        
      </template>
      
      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>      
        </v-card-text>    
      <v-card-actions>
        <v-btn 
          color="secondary darken-1" 
          raised 
          @click="close"
        >Close</v-btn>       
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
    props: {
        inspectionDate: String,
        ptwsLinkDialog: Boolean,
        projectId: Number,
        projectName : String,        
    },
    
    data: () => ({  
        loading: true,
        search: '',
        headers: [
            { text: 'Ref. #', value: 'reference_no',},            
            { text: 'Permit to Work', value: 'hrw.name'},
            { text: 'Location', value: 'location'},
            { text: 'Status', value: 'ptwstatus.name'},
            { text: 'Start Date', value: 'start_date', filterable: true},
            { text: 'End Date', value: 'end_date'},
            { text: 'Status Date', value: 'updated_at'},
            { text: 'Actions', value: 'action', sortable: false, filterable: false },
        ],
    }),

    computed: {
        ptwList() {
            return this.$store.getters.projectPtws;
        }
    },

    created() {
        this.initialize()
    },
    
    methods : {
        close() {
            this.$emit('update:ptwsLinkDialog', false)
        },


        initialize() {
            this.$store.dispatch('fetchProjectPtwsByDate', 
                    { project_id: this.projectId, 
                        date: this.inspectionDate
                }).then(() => { this.loading = false})
        }
    }

}
</script>