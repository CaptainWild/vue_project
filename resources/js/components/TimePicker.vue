<template>
    <div>
        <v-menu
            ref="menu"
            v-model="timeMenu"
            :close-on-content-click="false"
            :nudge-right="40"
            :return-value.sync="time"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
        >
        <template v-slot:activator="{ on }">
          <v-text-field
            v-model="time"
            :label="timeLabel"
            :prepend-icon="computedTimeIcon"            
            readonly
            :disabled="disable"
            v-on="on"
            @input="$emit('input',$event.target.value)"
          ></v-text-field>
        </template>
        <v-time-picker
            v-if="timeMenu"
            v-model="time"
            @click:minute="$refs.menu.save(time)"
            :min = "minTime"
            :max = "maxTime"
            :disabled="disable"
        ></v-time-picker>
      </v-menu>
    </div>
</template>

<script>
export default {
    props: {
        timeLabel: String,
        timeIcon: Boolean,
        disable: Boolean,
        minTime: {type: String, default :""},
        maxTime: {type: String, default :""},     
        value: String
    },

    data () {
      return {
        time: null,
        timeMenu: false,
      }
    },

    created() {
      this.time = this.value
    },

    watch: {
        time: function (newVal) {
            this.$emit('input', newVal)
        },
        value: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.time = newVal
            }
        }
    },

    computed: {     
        computedTimeIcon() {
            if(this.timeIcon)
                return 'mdi-clock-outline';

            return '';
        }
    },

}
</script>