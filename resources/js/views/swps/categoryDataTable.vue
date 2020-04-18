<template>
    <div>        
    <v-card>
        <v-card-title>
            <v-select
                :items="categoryList"
                v-model="swp_category_id" 
                label="Safe Work Procedure Categories"
                clearable
                item-text="name"
                item-value="id"
                :loading="loading"
                @change="initialize"
                @click:clear="clearSwpList"
            ></v-select>
        </v-card-title>
    </v-card>      
    <v-data-table
        :headers="headers"
        :items="swpList"        
        sort-by="ref_no"
        sort-desc
        class="elevation-1"
        :loading="loading"
        show-select
        v-model="swps"
        @item-selected="rowSelected"
        @toggle-select-all="toggleAll"
    >
      <template v-slot:top>      
          <v-toolbar flat > 
            <v-toolbar-title>
                Safe Work Procedures
            </v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>
            
            <v-spacer></v-spacer> 
           
        </v-toolbar>
      </template>

      <template v-slot:loading>
        <span>Fetching Data...</span>
      </template>
    </v-data-table>
    </div>  
</template>

<script>
import Form from '@/js/core/form';

export default {
    props: [
        'value',
        'swpIds',
        'swpCategoryId'
    ],
    data: () => ({ 
        loading: true,           
        headers: [
            { text: 'Reference No.', value: 'ref_no', align: 'left' },
            { text: 'Activity', value: 'activity',},          
        ],
        swps: [],     
        category: new Form({ id:'', activity: ''}),
        swp_category_id: ''
    }),
    
    computed: {
        categoryList() {
            return this.$store.getters.categories;
        },           
        swpList () {  
            return this.$store.getters.swpCategories;
        },
        
    },
  
    created () {
        this.getCategories()

        this.swp_category_id = this.swpCategoryId
        if(this.swpCategoryId != 0) {
            this.initialize()
        }
    },

    methods: {
        clearSwpList() {
            this.$store.commit('RESET_SWP_CATEGORY');
        },

        initialize () { 
            if(this.swp_category_id != undefined) {
                this.category.id = this.swp_category_id
                this.loading = true
                this.$store.dispatch('fetchSwpCategories',this.category)
                .then(()=> {
                    this.loading = false
                    this.selectedSwps()
                });       
            }                  
        },
 
        getCategories() {
            this.loading = true
            this.$store.dispatch('fetchCategories',this.category)
            .then(()=> {
                this.loading = false
            }); 
        },

        rowSelected (row) {     
            if(row.value){
                this.swpIds.push(row.item.id)
            } else {
                this.swpIds.splice(this.swpIds.indexOf(row.item.id),1)
            }      
           
        },

        selectedSwps() {
            if(this.$store.getters.ptw.id != undefined) {
                var swps = this.$store.getters.ptw.swps
                if(swps.length > 0 ) {
                    for(var swp of swps) {
                        this.swps.push(swp)
                        this.swpIds.push(swp.id)
                    }
                }                
            }
        },
           
        toggleAll(items) {
            var swps = this.swpIds 
            if(items.value) {
                for(var swp of swps) {
                    if(!this.swpIds.includes(swp.id)) {
                        this.swpIds.push(swp.id)
                    }                    
                }                
            } else {
                this.swpIds.splice(0,this.swpIds.length)
            }
        }
    },
}
</script>
