<template>
    <div>
      <v-card>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            clearable
          ></v-text-field>                
        </v-card-title>
      </v-card>      
    <v-data-table
        :headers="headers"
        :items="tradeList"        
        sort-by="id"
        sort-desc
        class="elevation-1"
        :loading="loading"
        :search="search"
    >
    <template v-slot:top>      
        <v-toolbar flat > 
          <v-toolbar-title>
              Trades
          </v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          
          <v-spacer></v-spacer> 
                         
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on" >
                    New
                </v-btn>
            </template>
            
            <v-card>
              <v-form @submit.prevent="save" ref="form"  >
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field 
                            v-if="dialog" autofocus
                            ref="title"
                            required                              
                            clearable 
                            v-model="trade.name" 
                            label="*Name"
                            type="text"
                            :error-messages="trade.errors.get('name')"
                            @keydown="trade.errors.clear('name')"                              
                          ></v-text-field>
                      </v-col>                             
                      <v-col cols="12">
                          <v-textarea 
                            auto-grow 
                            clearable 
                            v-model="trade.description" 
                            label="Description">
                          </v-textarea>
                      </v-col>
                      <!-- <v-col cols="12">                        
                          <v-checkbox 
                            v-model ="trade.is_active" 
                            label="Active"
                          ></v-checkbox>  
                      </v-col> -->
                    
                    </v-row>
                </v-container>
              </v-card-text>

                <v-card-actions>                  
                  <v-btn raised color="secondary darken-1" dark @click="close">
                    Cancel
                  </v-btn>
                  <v-spacer></v-spacer>
                  <v-btn 
                    raised 
                    color="success darken-1" 
                    dark 
                    type="submit"
                    :disabled="trade.errors.any()"                  
                    :loading="loading"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-btn 
            class="mb-2 ml-1" 
            color="success darken-1"
            fab 
            dark 
            small
            @click="initialize" 
            :loading="loading"
          >
            <v-icon dark>mdi-refresh</v-icon>
          </v-btn> 
      </v-toolbar>
    </template>
<!-- 
    <template v-slot:item.is_active="{ item }">
      <v-chip :color="getStatus('color',item.is_active)" dark>{{ getStatus('text',item.is_active) }}</v-chip>
    </template> -->

    <template v-slot:item.action="{ item }">
      <v-btn
        text
        icon
        dark
        color="primary"
        @click="editTrade(item)"
      >
        <v-icon> mdi-file-edit</v-icon>
      </v-btn>
      
      <v-btn 
        text 
        icon 
        dark
        color="error"
        @click="setDeleteTrade(item)"
      >
        <v-icon>mdi-delete</v-icon>
      </v-btn>        

    </template>
    <template v-slot:loading>
      <span>Fetching Data...</span>
    </template>
  </v-data-table>

  <DeleteRemarkDialog 
      v-if = "deleteRemarkConfirmDialog"
      :trade = "trade"      
      :deleteRemarkConfirmDialog.sync = "deleteRemarkConfirmDialog"
  ></DeleteRemarkDialog> 

  </div>
</template>
<script>
import Form from '@/js/core/form';
import DeleteRemarkDialog from '@/js/views/trades/deleteRemarkDialog';

  export default {
    components: {
      DeleteRemarkDialog,
    },
    data: () => ({ 
        search: '',       
        loading: true,
        dialog: false,
        deleteRemarkConfirmDialog: false,
        headers: [
            { text: 'Id', value: 'id' },
            { text: 'Name', value: 'name',},            
            { text: 'Description', value: 'description', align: 'left' },
            // { text: 'Status', value: 'is_active' },
            { text: 'Actions', value: 'action', sortable: false ,filterable: false},
        ],
        trades: [],
        tradeIndex: -1,
        trade: new Form({
            name: '',
            description: '',
            is_active: 0,
        }),  
    }),

    computed: {
        formTitle () {
            return this.tradeIndex === -1 ? 'New Trade' : 'Edit Trade'
        },
        status() {
          return this.$store.getters.tradeStatus;
        },
        tradeList () {  
          this.trades = this.$store.getters.trades;
          return this.trades;          
        }     
    },

    watch: {
      dialog (val) {                
        val || this.close()        
      },  
      deleteRemarkConfirmDialog(val) {
          if(!val) {
              this.closeDeleteRemarkConfirmDialog()
              this.initialize()
          }
      }    
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () { 
        this.loading = true
        this.$store.dispatch('fetchTrades',this.trade)
          .then(()=> {
            this.loading = false
          });               
      },

      editTrade (item) {        
        this.tradeIndex       = this.trades.indexOf(item);
        
        this.trade.id       = item.id;
        this.trade.name     = item.name;
        this.trade.description = item.description;
        // this.trade.is_active= item.is_active;

        this.dialog = true;
      },

      setDeleteTrade (item) {        
        this.tradeIndex = this.trades.indexOf(item);

        this.trade.id         = item.id;
        this.trade.name       = item.name;
        this.trade.description= item.description;

        this.deleteRemarkConfirmDialog = true;
      },
    
      close () {
        this.dialog = false
        this.$refs.form.reset()
        this.trade.reset()
        this.tradeIndex = -1        
      },

      closeDeleteRemarkConfirmDialog() {
        this.deleteRemarkConfirmDialog = false
        this.trade.reset()
        this.tradeIndex = -1
      },

      save () { 
        this.loading = true       
        var action = 'createTrade';
        if (this.tradeIndex > -1) {
          action = 'updateTrade'
        } 

        this.$store.dispatch(action,this.trade)
          .then(response => {               
            this.close()
            this.initialize()            
            setTimeout(() => {                
                this.$store.commit('closeSnackbar');
            },2000);              
          })
          .catch(()=> {
            
          });      
      },

      // getStatus (attr,status) {
      //     if(attr == 'color') {
      //       return status ? 'success' : 'error';  
      //     } else if ( attr == 'text') {
      //       return status ? 'Active' : 'Inactive';
      //     }
      //   }  
    },
  }
</script>