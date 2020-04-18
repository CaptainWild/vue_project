<template>
    <v-card
        class="mx-auto"        
    > 
    <v-card-subtitle>{{title}}</v-card-subtitle>   
    <canvas 
        class='elevation-1 flex-grow-1 flex-shrink-0' 
        style="min-width:100px; max-width:100%;"
        ref="canvas" 
        id="drawing-pad" 
        :width="width" 
        :height="height"
    ></canvas>
    <v-card-actions>
        <v-btn
            x-small
            block
            dark
            outlined
            color= "green"
            @click="resetCanvas"
        >clear</v-btn>
    </v-card-actions>       
    </v-card>
</template>

<script>
export default {
    props: {
        height: Number,
        title: {type: String, default: 'Signature'} ,
        value: String,
        width: Number,        
    },        
    data: () => ({  
        canvas: null,
        context: null,
        isDrawing: false,
        startX: 0,
        startY: 0,
        points: []
    }),
    mounted() {
        var vm = this
        vm.canvas = vm.$refs.canvas
        vm.context = vm.canvas.getContext("2d");
        
        vm.canvas.addEventListener('mousedown', vm.mousedown);
        vm.canvas.addEventListener('mousemove', vm.mousemove);
        document.addEventListener('mouseup', vm.mouseup);

        //touch eventlisteners
        vm.canvas.addEventListener('touchstart', vm.touchstart);
        vm.canvas.addEventListener('touchend', vm.touchend);
        vm.canvas.addEventListener('touchmove', vm.touchmove)

        document.body.addEventListener('touchstart',vm.freezebody,{passive:false});
        document.body.addEventListener('touchend', vm.freezebody,{passive:false});
        document.body.addEventListener('touchmove', vm.freezebody,{passive:false});
    },
    methods: {
        freezebody(e) {
            var vm = this

            if(e.target == vm.canvas){
                e.preventDefault();
            }
        },

        touchstart(e) {
            var mousePos = this.getTouchPosition(e)
            var touch = e.touches[0];
            
            var mouseEvent = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
            });
            
            this.canvas.dispatchEvent(mouseEvent);
        },

        touchend(e) {
            var mouseEvent = new MouseEvent("mouseup",{});

            this.canvas.dispatchEvent(mouseEvent);
        },

        touchmove(e) {
            var touch = e.touches[0];

            var mouseEvent = new MouseEvent("mousemove",{
                clientX: touch.clientX,
                clientY: touch.clientY
            });

            this.canvas.dispatchEvent(mouseEvent);
        },

        mousedown(e) {
            var vm = this
            var rect = vm.canvas.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            vm.isDrawing = true;
            vm.startX = x;
            vm.startY = y;
            vm.points.push({
                x: x,
                y: y
            });

        },

        mousemove(e) {
            var vm = this
            var rect = vm.canvas.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;

            if(vm.isDrawing) {
                vm.context.beginPath();
                vm.context.moveTo(vm.startX, vm.startY);
                vm.context.lineTo(x,y);
                vm.context.lineWidth = 3;
                vm.context.lineCap = 'round';
                vm.context.strokeStyle = "rgba(0,0,0,1)";
                vm.context.stroke();

                vm.startX = x;
                vm.startY = y;

                vm.points.push({
                    x: x,
                    y: y
                })
            }
        },

        mouseup(e) {
            var vm = this
            vm.isDrawing = false;
            if(vm.points.length > 0) {
                this.$emit('input',vm.canvas.toDataURL());
            } else {
                //meh
            }
        },

        resetCanvas() {
            var vm = this
            vm.canvas.width = vm.canvas.width;
            vm.points.length = 0; // reset points array
            this.$emit('input','');
        },

        getTouchPosition(e) {
            var vm = this
            var rect = vm.canvas.getBoundingClientRect();
            
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            }
        }
    }
}
</script>
<style>    
    canvas {
        background: silver;
    }
</style>