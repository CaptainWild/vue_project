<template>
    <div>
        <v-menu
            ref="dateMenu"
            v-model="dateMenu"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
        >
        <template v-slot:activator="{ on }">
            <v-text-field
                v-model="computedDateFormatted"
                :label="dateLabel"
                :prepend-icon="computedCalendarIcon"
                persistent-hint                
                readonly                
                v-on="on"
                :disabled='disable'
            ></v-text-field>
        </template>
        <v-date-picker 
            v-model="date" 
            no-title 
            @input="dateMenu = false"
            :min = "minDate"
            :max = "maxDate"
            :disabled = "disable"
        ></v-date-picker>
        </v-menu>
    </div>    
</template>

<script>
export default {
    props: {
        dateLabel: String,
        dateIcon: Boolean,
        disable: Boolean,        
        minDate: {type: String, default :""},
        maxDate: {type: String, default :""},        
        value: String
    },

    data() {
        return {
            dateMenu: false,
            date: null            
        }        
    },

    computed: {
        computedDateFormatted: {
            get() { 
                return this.formatDate(this.date)
            },
            set(val) {
                this.$emit('input',val)
            }
        },
        computedCalendarIcon() {
            if(this.dateIcon)
                return 'mdi-calendar';

            return '';
        }
    },

    created() {
      this.date = this.value
    },

    watch: {
        date: function (newVal) {
            this.$emit('input', newVal)
        },
        value: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.date = newVal
            }
        }
    },

    methods: {
        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },
        parseDate (date) {            
            if (!date) return null

            const [month, day, year] = date.split('/')
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },
    },
}
</script>