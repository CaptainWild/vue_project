<template>
<div>
     <v-data-table
    :headers="headers"
    :items="desserts"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Risk Assessments</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog"  max-width="1200px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on">New</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field label="Main Activity"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="5">
                    <v-text-field label="Location"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="3">
                    <v-text-field label="Project"></v-text-field>
                  </v-col>                
                  <v-col cols="12" sm="6" md="9">
                      <v-data-table
                            v-model="selected"
                            :headers="headers1"
                            :items="desserts1"
                            item-key="name"
                            show-select
                            class="elevation-1"
                        >         
                        <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                <v-btn
                                    v-on="on"
                                    text
                                    icon
                                    dark
                                    color="primary"
                                >
                                    <v-icon>mdi-account-group</v-icon>
                                </v-btn>
                            </template>
                            <span>Members</span>
                            </v-tooltip>                        
                        </template>                   
                        </v-data-table>
                  </v-col>
                <v-col cols="12" sm="6" md="3">
                    <v-text-field label="Assessment Date"></v-text-field>
                    <v-text-field label="Last Review Date"></v-text-field>
                    <v-text-field label="Next Review Date"></v-text-field>
                </v-col>  
                <!-- <v-col cols="12">
                    <v-data-table                        
                        :headers="headers2"
                        :items="desserts2"                        
                        class="elevation-1"
                    ></v-data-table>
                </v-col> -->
                 <v-col cols="12" md="3">
                        <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >         Hazard Identification                  
                            </v-card-subtitle>
                            <v-card-text>                              
                                 <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="1b. Work Activity"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field dense label="1c. Hazard"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field dense label="1d. Human and Cultural Factors"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                       <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >Risk Evaluation                 
                            </v-card-subtitle>
                             <v-card-text>  
                                 <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="2a. Existing Risk Control"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                        <v-select
                                            dense
                                            :items="severtiyMatrix"
                                            label="2b. Severity"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                          <v-select
                                            dense
                                            :items="likelihoodMatrix"
                                            label="2c. Likelihood"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12">
                                          <v-select
                                            dense
                                            :items="priorityRisk"
                                            label="2d. Risk Priority"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                 </v-row>
                             </v-card-text>
                       </v-card>
                    </v-col>                               
                    <v-col cols="12" md="5">
                        <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >Risk Control                 
                            </v-card-subtitle>
                            <v-card-text>                              
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="3a. Additional Risk Control"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                        <v-select dense
                                            :items="severtiyMatrix"
                                            label="3b. Severity"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                          <v-select dense
                                            :items="likelihoodMatrix"
                                            label="3c. Likelihood"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                          <v-select dense
                                            :items="priorityRisk"
                                            label="3d. Risk Priority"
                                            clearable
                                        ></v-select>
                                    </v-col>                                  
                                    <v-col cols="12" md="6" sm="12">
                                        <v-text-field dense label="Implementation Person"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                        <v-text-field dense rows="1" label="Remarks"></v-text-field>
                                    </v-col>                                  
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12">
                        <v-data-table                        
                            :headers="headers2"
                            :items="desserts2"                        
                            class="elevation-1"
                        ></v-data-table>
                    </v-col>  
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.action="{ item }">
      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-btn
            v-on="on"
            text
            icon
            dark
            color="primary"
            @click="dialog2 = true"
          >
            <v-icon>mdi-hazard-lights</v-icon>
          </v-btn>
      </template>
      <span>Hazard Identification</span>
      </v-tooltip>
    
      <v-tooltip bottom>
      <template v-slot:activator="{ on }">  
        <v-btn 
          v-on="on"
          text 
          icon 
          dark
          color="error"
          @click="setDeleteProject(item)"
        >
          <v-icon>mdi-delete</v-icon>
        </v-btn>
        </template>
        <span>Delete</span>
      </v-tooltip>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
    </v-data-table>

     <v-dialog v-model="dialog2"  max-width="1200px">
           <v-card>
            <v-card-title>
              <span class="headline">Risk Assessment</span>
            </v-card-title>            
            <v-card-text>
                <v-container>
                    <v-row>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field label="Main Activity" readonly value="Activity Sample"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field label="Location" readonly value="Shan Road" ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field label="Project" readonly value="Project 1"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                       <v-text-field label="Assessment Date"></v-text-field>
                    </v-col>
                    
                    <v-col cols="12" md="3">
                        <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >         Hazard Identification                  
                            </v-card-subtitle>
                            <v-card-text>                              
                                 <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="1b. Work Activity"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field dense label="1c. Hazard"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field dense label="1d. Human and Cultural Factors"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                       <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >Risk Evaluation                 
                            </v-card-subtitle>
                             <v-card-text>  
                                 <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="2a. Existing Risk Control"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                        <v-select
                                            dense
                                            :items="severtiyMatrix"
                                            label="2b. Severity"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                          <v-select
                                            dense
                                            :items="likelihoodMatrix"
                                            label="2c. Likelihood"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12">
                                          <v-select
                                            dense
                                            :items="priorityRisk"
                                            label="2d. Risk Priority"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                 </v-row>
                             </v-card-text>
                       </v-card>
                    </v-col>                               
                    <v-col cols="12" md="5">
                        <v-card>
                            <v-card-subtitle
                            class="warning"
                            primary-title
                            >Risk Control                 
                            </v-card-subtitle>
                            <v-card-text>                              
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field dense label="3a. Additional Risk Control"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                        <v-select dense
                                            :items="severtiyMatrix"
                                            label="3b. Severity"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                          <v-select dense
                                            :items="likelihoodMatrix"
                                            label="3c. Likelihood"
                                            clearable
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="12">
                                          <v-select dense
                                            :items="priorityRisk"
                                            label="3d. Risk Priority"
                                            clearable
                                        ></v-select>
                                    </v-col>                                  
                                    <v-col cols="12" md="6" sm="12">
                                        <v-text-field dense label="Implementation Person"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6" sm="12">
                                        <v-text-field dense rows="1" label="Remarks"></v-text-field>
                                    </v-col>                                  
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12">
                        <v-data-table                        
                            :headers="headers2"
                            :items="desserts2"                        
                            class="elevation-1"
                        ></v-data-table>
                    </v-col>                 
                    </v-row>
                </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialog2 = false">Cancel</v-btn>
              <v-btn color="blue darken-1" text>Save</v-btn>
            </v-card-actions>
          </v-card>
     </v-dialog>
</div>
</template>

<script>
export default {
    data: () => ({
        severtiyMatrix: ['1 - Negligible','2 - Minor','3 - Moderate','4 - Major','5 - Catastrophic'],
        likelihoodMatrix: ['1 - Rare','2 - Remote','3 - Occasional','4 - Frequent','5 - Almost Certain'],
        priorityRisk: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25],
        selected: [],
        dialog: false,
        dialog2: false,
        headers2: [   
            { text: '1a. No.', value: '1_a' },
            { text: '1b. Work Activity', value: '1_b' },
            { text: '1c. Hazard', value: '1_c'},
            { text: '1d. Human and Cultural Factor', value: '1_d'},
            
            { text: '2a. Existing Risk Control', value: '2_a' },
            { text: '2b. Severity', value: '2_b' },
            { text: '2c. Likelihood', value: '2_c'},
            { text: '2d. Risk Priority', value: '2_d'},

            { text: '3a. Additional Risk Control', value: '3_a' },
            { text: '3b. Severity', value: '3_b' },
            { text: '3c. Likelihood', value: '3_c'},
            { text: '3d. Risk Priority', value: '3_d'},

            { text: '3e. Due Date', value: '3_e'},
            { text: '3f. Remarks', value: '3_f'},
        ],
        headers1: [   
        { text: 'Team', value: 'team' },
        { text: 'Team Leader', value: 'team_lead' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      headers: [
        {
          text: 'Dessert (100g serving)',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { text: 'Calories', value: 'calories' },
        { text: 'Fat (g)', value: 'fat' },
        { text: 'Carbs (g)', value: 'carbs' },
        { text: 'Protein (g)', value: 'protein' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      desserts: [],
      desserts1: [],
      desserts2: [
           {
            '1_a': '1',
            '1_b': 'test b',
            '1_c': 'test c',
            '1_d': 'test d',

            '2_a': 'test 2a',
            '2_b': '3',
            '2_c': '4',
            '2_d': '12',

            '3_a': 'test 3a',
            '3_b': '4',
            '3_c': '5',
            '3_d': '20',
            '3_e': '2020-02-18',
            '3_f': 'test f',
        
          },
      ],
      editedIndex: -1,
      editedItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Risk Assessment' : 'Edit Risk Assessment'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.desserts1 = [
          {
            team: 'Team A',
            team_lead: 'Giannis Antetunkmpo',            
          },
          {
            team: 'Team B',
            team_lead: 'LeBron James',            
          },
        ],
        this.desserts = [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
          },
        ]
      },

      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      },
    },
}
</script>

<style>

</style>