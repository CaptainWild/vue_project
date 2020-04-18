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
                  
                  <v-col cols="12" md="4">

                    <v-col cols="12">
                      <v-select
                        dense
                        :items="companyMatrix"
                        label="Company"
                        clearable
                      ></v-select>
                    </v-col>

                    <v-col cols="12">
                      <v-select
                      dense
                      :items="departmentMatrix"
                      label="Department"
                      clearable
                      ></v-select>
                    </v-col>

                    <v-col cols="12">
                      <v-textarea
                      auto-grow
                      clearable
                      rows="1"
                      label="Process"
                      >
                      </v-textarea>
                    </v-col>

                    <v-col cols="12">
                      <v-textarea
                      auto-grow
                      clearable
                      rows="1"
                      label="Activity Location"
                      >
                      </v-textarea>
                    </v-col>

                  </v-col>

                  <v-col cols="12" md="8">
                    <v-card>
                    <v-card-title>TEAM MEMBERS</v-card-title>
                    <v-card-text> 
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
                              color="error"
                              @click="dialog3 = !dialog3"
                            >
                              <v-icon>mdi-delete</v-icon>
                            </v-btn>
                          </template>
                            <span>Members</span>
                        </v-tooltip>                        
                      </template>                   
                    </v-data-table>
                    </v-card-text> 
                  </v-card>
                  </v-col>

                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu1"
                        v-model="menu1"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Original Assessment date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu2"
                        v-model="menu2"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Last review date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu2 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu6"
                        v-model="menu6"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Next review date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu6= false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>

                  <!-- <v-col cols="12">
                      <v-data-table                        
                          :headers="headers2"
                          :items="desserts2"                        
                          class="elevation-1"
                      ></v-data-table>
                  </v-col> -->
                
                    
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-btn 
                  raised 
                  color="secondary darken-1" 
                  dark 
                  @click="close"
              >Close</v-btn>
              <v-spacer></v-spacer>                        
              <v-btn 
                  raised 
                  color="success darken-1" 
                  dark
                  type="submit"
              >Save</v-btn>
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
              @click="dialog4 = !dialog4"
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

 
    <v-card-actions>
    
      <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="dialog2 = false">Cancel</v-btn>
        <v-btn color="blue darken-1" text @click="dialog2 = !dialog2">Save</v-btn>
    </v-card-actions>


      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog3"  max-width="1200px">
      <v-card>
        <template v-slot:activator="{ on }">
            <v-btn
              icon
              v-on="on"
            >
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </template>

        <v-card-title>
          <span class="headline">Members</span>
        </v-card-title> 

        <v-card-text>                                   
          <v-container>
            <v-row>
             
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in desserts" :key="item.name">
                      <td>{{ item.name }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>

            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog3 = false">Close</v-btn>
          <v-btn color="blue darken-1" text>Ok</v-btn>
        </v-card-actions>

      </v-card>
    </v-dialog>

    <v-dialog
        v-model="dialog4"
        max-width="1000px"
      >
        
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>

                  <v-col cols="12" md="4">

                    <v-col cols="12">
                      <v-select
                        dense
                        :items="companyMatrix"
                        label="Company"
                        clearable
                      ></v-select>
                    </v-col>

                    <v-col cols="12">
                      <v-select
                      dense
                      :items="departmentMatrix"
                      label="Department"
                      clearable
                      ></v-select>
                    </v-col>

                    <v-col cols="12">
                      <v-textarea
                      auto-grow
                      clearable
                      rows="1"
                      label="Process"
                      >
                      </v-textarea>
                    </v-col>

                    <v-col cols="12">
                      <v-textarea
                      auto-grow
                      clearable
                      rows="1"
                      label="Activity Location"
                      >
                      </v-textarea>
                    </v-col>

                  </v-col>

                  <v-col cols="12" md="8">
                    <v-card>
                    <v-card-title>TEAM MEMBERS</v-card-title>
                    <v-card-text> 
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
                              color="error"
                              @click="dialog3 = !dialog3"
                            >
                              <v-icon>mdi-delete</v-icon>
                            </v-btn>
                          </template>
                            <span>Members</span>
                        </v-tooltip>                        
                      </template>                   
                    </v-data-table>
                    </v-card-text> 
                  </v-card>
                  </v-col>

                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu4"
                        v-model="menu4"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Original Assessment date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu4 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu5"
                        v-model="menu5"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Last review date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu5 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-menu
                        ref="menu6"
                        v-model="menu6"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                label="Next review date"
                                hint="YYY/MM/DD format"
                                persistent-hint
                                prepend-icon="mdi-calendar"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            no-title
                            @input="menu6= false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>

                  
                <!-- <v-col cols="12">
                    <v-data-table                        
                        :headers="headers2"
                        :items="desserts2"                        
                        class="elevation-1"
                    ></v-data-table>
                </v-col> -->
                

                <v-expansion-panels
                v-model="panel"
                :disabled="disabled"
                multiple
                >
                <v-expansion-panel>
                  <v-expansion-panel-header>HAZARD IDENTIFICATION</v-expansion-panel-header>
                  <v-expansion-panel-content>                            
                    <v-row>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Work Activity"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Hazard"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Hazard Remark"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Possible injury/ill-health"></v-text-field>
                      </v-col>
                    </v-row>
                  </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                  <v-expansion-panel-header>RISK EVALUATION</v-expansion-panel-header>
                  <v-expansion-panel-content>
                    <v-row>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Existing risk controls"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select
                            dense
                            :items="severtiyMatrix"
                            label="Severity"
                            clearable
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select
                          dense
                          :items="likelihoodMatrix"
                          label="Likelihood"
                          clearable
                      ></v-select>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select
                          dense
                          :items="priorityRisk"
                          label="Risk Priority"
                          clearable
                      ></v-select>
                      </v-col>
                    </v-row>    
                  </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                  <v-expansion-panel-header>RISK CONTROL</v-expansion-panel-header>
                  <v-expansion-panel-content>
                    <v-row>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Additional Controls"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select dense
                            :items="severtiyMatrix"
                            label="Severity"
                            clearable
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select dense
                          :items="likelihoodMatrix"
                          label="Likelihood"
                          clearable
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-select dense
                          :items="priorityRisk"
                          label="Risk Priority"
                          clearable
                        ></v-select>
                      </v-col>                                  
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Implementation Person"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-text-field dense label="Due Date"></v-text-field>
                      </v-col>
                      <v-col cols="12" md="3">
                        <v-text-field dense rows="1" label="Remarks"></v-text-field>
                      </v-col>                                  
                    </v-row>
                  </v-expansion-panel-content>
                </v-expansion-panel>
              </v-expansion-panels>
                    
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-btn 
                  raised 
                  color="secondary darken-1" 
                  dark 
                  @click="dialog4 = false"
              >Close</v-btn>

              <v-btn 
                  raised 
                  color="primary darken-1" 
                  dark 
                  @click="dialog5 = !dialog5"
              >View Summary</v-btn>

              <v-spacer></v-spacer>                        
              <v-btn 
                  raised 
                  color="success darken-1" 
                  dark
                  type="submit"
              >Save</v-btn>

            </v-card-actions> 

          </v-card>
      </v-dialog>

      <v-dialog
        v-model="dialog5"
        max-width="1200px"
      >
        
          <v-card>
            <v-card-title>
              <span class="headline">RA Summary</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>

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
              <v-spacer></v-spacer>                        
              <v-btn 
                  raised 
                  color="secondary darken-1" 
                  dark 
                  @click="dialog5 = false"
              >Close</v-btn>

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
        companyMatrix: ['1 - Company 1','2 - Company 2','3 - Company 3','4 - Company 4','5 - Company 5'],
        departmentMatrix: ['1 - Department 1','2 - Department 2','3 - Department 3','4 - Department 4','5 - Department 5'],
        selected: [],
        dialog: false,
        dialog2: false,
        dialog3: false,
        dialog4: false,
        dialog5: false,
        menu1: false,
        menu2: false,
        menu3: false,
        menu4: false,
        menu5: false,
        menu6: false,
        inset: false,
        disabled: false,
        panel: [0, 1, 2],

        items: [
          {
            title: 'Click Me',
          },
          {
            title: 'Click Me',
          },
          {
            title: 'Click Me',
          },
          {
            title: 'Click Me 2',
          },
        ],
        select: [
          { text: 'State 1' },
          { text: 'State 2' },
          { text: 'State 3' },
          { text: 'State 4' },
          { text: 'State 5' },
          { text: 'State 6' },
          { text: 'State 7' },
        ],

        headers2: [ 

            { text: 'No.', value: '1_a' },
            { text: 'Work Activity', value: '1_b' },
            { text: 'Hazard', value: '1_c'},
            { text: 'Possible injury/ill-health', value: '1_d'},
            
            { text: 'Existing Risk Controls', value: '2_a' },
            { text: 'S', value: '2_b' },
            { text: 'L', value: '2_c'},
            { text: 'RPN', value: '2_d'},

            { text: 'Additional Controls', value: '3_a' },
            { text: 'S', value: '3_b' },
            { text: 'L', value: '3_c'},
            { text: 'RPN', value: '3_d'},

            { text: 'Implementaion Person (Due Date)', value: '3_e'},
            { text: 'Remarks', value: '3_f'},
        ],
        headers1: [   
        { text: 'NAME', value: 'name' },
        { text: 'COMPANY', value: 'company' },
        { text: 'SUB-MATTER', value: 'sub_matter' },
        { text: 'EXPIRY DATE', value: 'expiry_date' },
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
            '1_b': 'Transport workers and materials to site & vice versa',
            '1_c': 'Physical Hazard Traffic accident',
            '1_d': 'Fatality to workers',

            '2_a': 'Vehicle driven by licensed personnel.Observe traffic rules $ regulations. Regular maintenance of vehicle.Ensure driver as sufficient rest',
            '2_b': '5',
            '2_c': '1',
            '2_d': '5',

            '3_a': 'Nil',
            '3_b': '5',
            '3_c': '1',
            '3_d': '5',
            '3_e': 'Site Safety Supervisor',
            '3_f': '',
        
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
            name: 'Steven',
            company: 'Fonda',   
            sub_matter: 'Sub mat',   
            expiry_date: '20/03/2020',        
          },
          {
            name: 'David',
            company: 'ABC',   
            sub_matter: 'Regarding',   
            expiry_date: '15/04/2020',            
          },
          {
            name: 'Chua Chee Yong',
            company: 'CMT',   
            sub_matter: 'matter 3',   
            expiry_date: '13/03/2020',            
          },
          {
            name: 'Rajeev',
            company: 'Context',   
            sub_matter: 'matter 4',   
            expiry_date: '20/04/2020',            
          },
          {
            name: 'Mukilan',
            company: 'Maha Engineering',   
            sub_matter: 'matter 5',   
            expiry_date: '25/04/2020',            
          },
        ],
        this.desserts = [
          {
            name: 'Freddy',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
          },
          {
            name: 'Ivy',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
          },
          {
            name: 'Ethen',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
          },
          {
            name: 'Cheng Min Hui',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
          },
          {
            name: 'Gary',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
          },
          {
            name: 'Jeremireh',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
          },
          {
            name: 'Louis',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
          },
          {
            name: 'Henen',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
          },
          {
            name: 'Dolly',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
          },
          {
            name: 'Kelvin',
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