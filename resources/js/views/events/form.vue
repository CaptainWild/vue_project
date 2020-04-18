<template>
   <v-row justify="center">
    <v-dialog v-model="formDialog" scrollable persistent max-width="450px">
    <v-form
        ref="form"
        v-model="valid"
        @submit.prevent="save"
        lazy-validation
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{formTitle}}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>               
                <v-col cols="12">
                    <ProjectPullDown
                        v-model="event.project_id"
                        :projectIcon="true"
                        :readonly = false
                        :clearable = true
                    ></ProjectPullDown>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        :rules="[v => !!v || 'Title is required']"
                        v-model="event.title" 
                        label="Title"
                        prepend-icon="mdi-asterisk"
                        clearable
                        required
                    ></v-text-field>              
                </v-col>              
                <v-col cols="12" sm="6" md="6">
                    <DatePicker
                        :dateLabel= "startDateLabel"
                        :dateIcon = true
                        v-model ="event.start_date"
                        :readonly = false
                    ></DatePicker>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <DatePicker
                        :dateLabel= "endDateLabel"
                        :dateIcon = false
                        v-model ="event.end_date"
                        :readonly = false
                    ></DatePicker>
                </v-col>
                <v-col cols="12">
                    <v-textarea 
                        auto-grow 
                        clearable 
                        rows="1"
                        v-model="event.description" 
                        label="Description"
                        prepend-icon="mdi-text-subject"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <TimePicker
                        :timeLabel= "startTimeLabel"
                        :timeIcon = true
                        v-model ="event.start_time"
                        :readonly = false
                    ></TimePicker>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <TimePicker
                        :timeLabel= "endTimeLabel"
                        :timeIcon = false
                        v-model ="event.end_time"
                        :readonly = false
                    ></TimePicker>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <v-checkbox 
                        v-model ="event.all_day" 
                        label="All Day"
                    ></v-checkbox> 
                </v-col>
                <v-col cols="12" sm="6" md="8">
                     <v-select
                        v-model="event.recurrence_id"
                        :items="recurrenceItems"
                        item-value="id"
                        item-text="name"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <v-color-picker
                        width="400"
                        v-model="color"
                        raised
                        :hide-canvas = true
                        :hide-inputs = true
                        :hide-mode-switch= true 
                        mode.sync = "hex"                        
                    ></v-color-picker>
                </v-col>
                <v-col cols="12">
                    <v-file-input                        
                        v-model="attachments"
                        counter
                        small-chips
                        label="Attachments"
                        multiple
                        placeholder="Select your files"
                        prepend-icon="mdi-paperclip"                        
                        :show-size="1000"   
                    >
                    <template v-slot:selection="{ index, text }">
                        <v-chip
                            v-if="index < 2"
                            dark
                            label
                            small
                        >
                            {{ text }}
                        </v-chip>

                        <span
                            v-else-if="index === 2"
                            class="overline grey--text text--darken-3 mx-2"
                        >
                            +{{ attachments.length - 2 }} File(s)
                        </span>
                    </template>
                    </v-file-input>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <v-select
                        label="Notification"
                        prepend-icon="mdi-bell"
                        v-model="event.notification_type_id"
                        :items="notifiableItems"
                        item-value="id"
                        item-text="name"
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <v-text-field
                        v-model="event.notification_day" 
                        label="Day(s) before"
                        clearable
                    ></v-text-field>  
                </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn dark color="error darken-1" raised @click="$emit('close-dialog')">Close</v-btn>
            <v-btn 
                :loading="formLoading"
                dark 
                color="success darken-1" 
                raised 
                type="submit"
            >Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
    </v-dialog>
  </v-row>
</template>

<script>
import DatePicker from '@/js/components/DatePicker';
import Form from '@/js/core/form';
import ProjectPullDown from '@/js/views/projects/pulldown';
import TimePicker from '@/js/components/TimePicker';

export default {
    components: {
        DatePicker,
        ProjectPullDown,
        TimePicker
    },    

    props: {
        event: {
            type: Object, 
            default: function () {
                return {
                    project_id: 0,
                    title: '',
                    description: '',
                    start_date: null,
                    end_date:  null,
                    start_time: null,
                    end_time: null,
                    all_day: 0,
                    color: '',
                    recurrence_id: 0,
                    notification_type_id: 0,
                    notification_day: '',
                }
            }
        },
        formDialog: Boolean,
        value: {type: String, default: new Date().toISOString().slice(0,10) } 
    },

    watch : {
        'event.all_day': function(newVal,oldVal) {
            if(newVal) {
                this.event.start_time = null
                this.event.end_time = null
            }
        },    
        'event.color': function (newVal,oldVal)  {
            if(newVal)
                this.color = newVal;
            else
                this.color = '';
        },     
        value: function (newVal, oldVal) {         
            if (newVal !== oldVal && this.event.id == undefined) {
                this.event.start_date = newVal
                this.event.end_date = newVal
            }
        },
        
    },

    computed: {
        formTitle () {
            return this.event.id == undefined ? 'New Event' : 'Edit Event'
        },
    },

    data: () => ({        
        attachments: [],
        color: '',
        valid: true,
        dialog: false,
        formLoading: false,
        recurrenceItems: [{id:0,name:"Does not repeat"},{id:1,name:"Daily"},{id:2,name:"Weekly"},{id:3,name:"Monthly"},{id:4,name:"Yearly"}],
        notifiableItems: [{id:0,name:"None"},{id:1,name:"Email"}],
        startDateLabel: 'From Date',
        startTimeLabel: 'From Time',
        endDateLabel: 'To Date',
        endTimeLabel: 'To Time'        
    }),

    methods: {
        save() {            
            if (this.$refs.form.validate()) {
                this.formLoading = true;

                let eventForm = new FormData();
                
                var action = "createEvent";                
                if(this.event.id != undefined) {
                    action = "updateEvent";
                    eventForm.append('id',this.event.id);
                    eventForm.append('_method', 'PATCH');
                }

                eventForm.append('project_id',this.event.project_id);
                eventForm.append('title',this.event.title);
                eventForm.append('description',this.event.description);
                eventForm.append('start_date',this.event.start_date);
                eventForm.append('end_date',this.event.end_date);
                eventForm.append('start_time',this.event.start_time);
                eventForm.append('end_time',this.event.end_time);   
                eventForm.append('all_day',this.event.all_day);
                eventForm.append('color',this.color);   
                
                for( var i = 0; i < this.attachments.length; i++ ){
                    let file = this.attachments[i];
                    eventForm.append('attachments[' + i + ']', file);
                }    
            
                this.$store.dispatch(action,eventForm)
                    .then(response => {   
                        this.formLoading = false                          
                        this.$emit('close-dialog')
                        setTimeout(() => {                
                            this.$store.commit('closeSnackbar');
                        },2000);              
                    })
                    .catch(error=> {
                        this.formLoading = false 
                        console.log(error);
                    });     
            }
            
        }
    }

}
</script>