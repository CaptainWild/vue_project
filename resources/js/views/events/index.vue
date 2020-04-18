<template>
    <div>
    <v-row class="fill-height">
        <v-col>
        <v-sheet height="64">
            <v-toolbar flat>       
                <v-btn class="mr-4" @click="setToday">
                    Today
                </v-btn>
                <v-btn fab text small @click="prev">
                    <v-icon small>mdi-chevron-left-circle-outline</v-icon>
                </v-btn>
                <v-btn fab text small @click="next">
                    <v-icon small>mdi-chevron-right-circle-outline</v-icon>
                </v-btn>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-menu bottom right>
                    <template v-slot:activator="{ on }">
                    <v-btn v-on="on">
                        <span>{{ typeToLabel[type] }}</span>
                        <v-icon right>mdi-menu-down</v-icon>
                    </v-btn>
                    </template>
                    <v-list>
                    <v-list-item @click="type = 'day'">
                        <v-list-item-title>Day</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="type = 'week'">
                        <v-list-item-title>Week</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="type = 'month'">
                        <v-list-item-title>Month</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="type = '4day'">
                        <v-list-item-title>4 days</v-list-item-title>
                    </v-list-item>
                    </v-list>
                </v-menu>
            </v-toolbar>
        </v-sheet>
        <v-sheet height="600">
            <v-calendar
                ref="calendar"
                v-model="focus"
                color="primary"
                :events="events"
                :event-color="getEventColor"
                :event-margin-bottom="3"
                :now="today"
                :type="type"
                @click:event="showEvent"
                @click:more="viewDay"
                @click:date="event"
                @change="updateRange"
            ></v-calendar>
            <v-menu
                v-model="selectedOpen"
                :close-on-content-click="false"
                :close-on-click="false"
                :activator="selectedElement"
                offset-x
            >
            <v-card
                color="grey lighten-4"
                min-width="350px"
                flat                
            >
                <Attachments
                    :reference_id = "selectedEvent.id"
                    :attachmentDialog.sync= "dialogAttachment"
                    reference_table = "events"
                    folder_name = "/attachments/events"
                ></Attachments>
                <v-toolbar
                    :color="selectedEvent.color"
                    dark
                >
    
                    <v-btn 
                        icon
                        @click="event"
                    ><v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn 
                        icon
                        @click="deleteEventDialog = true"
                    ><v-icon>mdi-delete</v-icon></v-btn>
                    <v-btn 
                        icon
                        v-show="attachments"
                        @click="dialogAttachment = true"
                    ><v-icon>mdi-attachment</v-icon></v-btn>
                </v-toolbar>
                <v-card-text>
                    <span v-html="selectedEvent.details"></span>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        text
                        color="secondary"
                        @click="getEvents"
                    >Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="error"
                        @click="cancelEventDialog = true"
                        v-show="cancelled"
                    >Cancel</v-btn>
                </v-card-actions>
            </v-card>
            </v-menu>
        </v-sheet>
        </v-col>
        <v-btn
            bottom
            color="primary"
            dark
            fab
            fixed
            right
            @click="event"
            v-show="add"            
        >
        <v-icon>mdi-plus</v-icon>
        </v-btn>
    </v-row>
    
    <EventForm 
        :event = "selectedEvent"
        v-model = "formDate"
        :formDialog = "formDialog"
        @close-dialog = "getEvents"
    ></EventForm>

    <CancelConfirmDialog 
        :event = "selectedEvent"
        v-model = "cancelEventDialog"
        @reinitialize-events = "getEvents"
    ></CancelConfirmDialog>
    
    <DeleteConfirmDialog 
        :event = "selectedEvent"
        v-model = "deleteEventDialog"
        @reinitialize-events = "getEvents"
    ></DeleteConfirmDialog>

    </div>
</template>

<script>
import CancelConfirmDialog from '@/js/views/events/cancelConfirmDialog';
import EventForm from '@/js/views/events/form';
import DeleteConfirmDialog from '@/js/views/events/deleteConfirmDialog';
import Attachments from '@/js/views/attachments/list';

export default {
    components: {
        Attachments,
        CancelConfirmDialog,
        EventForm,
        DeleteConfirmDialog        
    },

    data: () => ({
        add: true,
        attachments: true,
        cancelled: true,        
        cancelEventDialog: false,
        dialogAttachment: false,
        deleteEventDialog: false,
        end: null,
        focus: new Date().toISOString().slice(0,10),
        formDate: null,
        formDialog: false,                                
        today: new Date().toISOString().slice(0,10),
        type: 'month',
        typeToLabel: {
            month: 'Month',
            week: 'Week',
            day: 'Day',
            '4day': '4 Days',
        },                
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        start: null,
    }),

    watch: {
        type(val) {
            if(val == 'day')
                this.add = false
            else
                this.add = true
        }
    },

    computed: {
        title () {
            const { start, end } = this
            if (!start || !end) {
                return ''
            }

            const startMonth = this.monthFormatter(start)
            const endMonth = this.monthFormatter(end)
            const suffixMonth = startMonth === endMonth ? '' : endMonth

            const startYear = start.year
            const endYear = end.year
            const suffixYear = startYear === endYear ? '' : endYear

            const startDay = start.day + this.nth(start.day)
            const endDay = end.day + this.nth(end.day)

            switch (this.type) {
                case 'month':
                    return `${startMonth} ${startYear}`
                case 'week':
                case '4day':
                    return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
                case 'day':
                    return `${startMonth} ${startDay} ${startYear}`
            }
            return ''
        },
        monthFormatter () {
            return this.$refs.calendar.getFormatter({
            timeZone: 'UTC', month: 'long',
            })
        },
        events() {
            return this.$store.getters.events;
        }
    },

    mounted () {
        this.$refs.calendar.checkChange()
    },

    methods: {
        getEvents () {            
            this.formDate = null
            this.selectedEvent = {}
            this.selectedOpen = false
            this.formDialog = false
            this.deleteEventDialog = false
            this.cancelEventDialog = false
            this.$store.dispatch('fetchEvents',{'start': this.start.date,'end': this.end.date})
                .catch (error => { console.log(error)});
        },
        event ({date}) {
            this.formDate = date
            if(date == undefined) {
                this.formDate = new Date().toISOString().slice(0,10)
            }

            this.formDialog = true
        },
        viewDay ({ date }) {
            this.focus = date
            this.type = 'day'
        },
        getEventColor (event) {
            return event.color
        },
        setToday () {
            this.focus = this.today
        },
        prev () {
            this.$refs.calendar.prev()
        },
        next () {
            this.$refs.calendar.next()
        },
        showEvent ({ nativeEvent, event }) {
            
            this.attachments = false
            if(event.attachments.length)
                this.attachments = true

            this.cancelled = false
            if(!event.is_cancelled)                   
                this.cancelled = true; 
                        
            const open = () => {                
                this.selectedEvent = event
                this.selectedElement = nativeEvent.target
                setTimeout(() => 
                    this.selectedOpen = true
                , 10)
            }
                        
            if (this.selectedOpen) {
                this.selectedOpen = false
                setTimeout(open, 10)
            } else {
                open()
            }

            nativeEvent.stopPropagation()
        },
        updateRange ({ start, end }) {
            this.start = start
            this.end = end           

            this.$store.dispatch('fetchEvents',{'start': this.start.date,'end': this.end.date,'type':this.type})
                .catch (error => { console.log(error)});
        },
        nth (d) {
            return d > 3 && d < 21
            ? 'th'
            : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
        },
    },
}
</script>