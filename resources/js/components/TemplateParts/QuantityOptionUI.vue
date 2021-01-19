<template>
    <div class="qty">
        <span @click="qnty('-')" class="minus bg-dark">-</span>
        <input :value="getQuantity" type="number" class="count" name="qty" readonly>
        <span @click="qnty('+')" class="plus bg-dark">+</span>
    </div>
</template>
<script>
export default {
    name: 'quantity-option-ui',
    props: {
        data: {
        // prop can only be initialize by the data() once, in some case, you may use computed property as replacement of data()
            type: Object,
            default:() => {}
        },
    },
    data() {
        return {
            quantity: 0,
            old_prop: null
        }
    },
    methods: {
        qnty(operator){
            if(operator === '+' && this.getQuantity < this.data.units){
                this.quantity++
                this.$emit('value', this.getQuantity)
            }
            else if(operator === '-' && this.getQuantity > 1 ){
                this.quantity--
                this.$emit('value', this.getQuantity)
            }else{
                this.$emit('value',this.getQuantity)
            }
        }        
    },
    computed: {
        getQuantity() {
            if(this.old_prop != this.data.value){  //re init
                this.quantity = 0
                this.old_prop = this.data.value
            }
            return this.data.value + this.quantity
        }
    }
}
</script>
<style scoped>
.qty {
    margin:0px;
}
.qty .count {
    color: #000;
    display: inline-block;
    vertical-align: top;
    font-size: 25px;
    font-weight: 700;
    line-height: 30px;
    padding: 0 2px
    ;min-width: 35px;
    text-align: center;
}
.qty .plus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    }
.qty .minus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    background-clip: padding-box;
}
div {
    text-align: auto;
}
.minus:hover{
    background-color: #717fe0 !important;
}
.plus:hover{
    background-color: #717fe0 !important;
}
/*Prevent text selection*/
span{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
input{  
    border: 0;
    width: 2%;
}
nput::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input:disabled{
    background-color:white;
}
         
</style>