<template>
    <div class="container">
        <div class="row" v-if="!isLoggedIn && request_status === 'PENDING'" style="margin-bottom: 50px">
            <div class="col-md-6 offset-md-3">
                <div class="text-center register-login ">   <!-- bootstrap aligning -->
                    <h2>You need to login to continue</h2>
                    <button class="col-md-4 btn btn-primary float-left" @click="login">Login</button>
                    <button class="col-md-4 btn btn-danger float-right" @click="register">Create an account</button>
                </div>
            </div>
        </div>
        <div v-if="cart.length" class="row">
            <ContentSpinner v-show="loading && request_status === null"></ContentSpinner>
            <div class="col-md-7 offset-md-2">
                <div v-for="(c,index) in cart" :key="index" class="order-box">
                    <h2 class="title align-center" v-html="c.product.name"></h2>
                    <br>
                    <p class="text-muted">$ {{ c.quantity * c.product.price }}</p>
                    <p class="text-muted">Available Units: {{ c.product.units }}</p>
                    <p class="text-muted">Quantity: {{ c.quantity }}</p>
                    <br>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="jumbotron">
                    <p v-if="cart_total >= 9" class="text-success">You are ship FREE</p>
                    <p v-else class="text-muted">Shipping Fee: <span class="badge">$.50</span><br>
                        <span class="text-small text-muted">Free shipping > $9</span>
                    </p>
                    <p> Cart Total: {{ getTotalPrice }}</p>
                    <button @click="placeOrder" class="btn btn-md btn-success">
                        <i v-if="loading" class="fa fa-loading" aria-hidden="true"></i>
                        Continue
                    </button>
                </div>
            </div>
        </div>
        <div v-else class="text-center">
            <h2>Your cart is empty!</h2>
        </div>
        <div class="row" style="padding-top: 10px" :style="{ isLoggedIn: 'border: 5px dashed grey' }">
            <div class="col-md-7 offset-md-2">
                <div v-if="isLoggedIn && cart.length">
                    <div class="row">
                        <label for="address" class="col-md-3 col-form-label">Delivery Address</label>
                        <div class="col-md-9">
                            <input id="address" type="text" class="form-control" v-model="address" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.small-text { font-size: 18px; }
.order-box { border: 1px solid #cccccc; padding: 10px 15px; }
.title { font-size: 36px; }
</style>

<script>
import { mapState } from 'vuex'

export default {
    props : ['pid'],
    data(){
        return {
            cart: [],
            isLoggedIn : null,
            shipping_fee: .50,
            address: '',
            request_status: null,
        }
    },
    beforeMount() {
        
        this.isLoggedIn = localStorage.getItem('felStore.jwt')? true : false
        if (this.isLoggedIn) {
            this.$http.get(`/api/cart`).then(response => this.cart = response.data)
        }
        else {
            this.$http.get(`/api/cart-local`).then(response => this.cart = response.data)
        }

    },
    computed: {
        ...mapState(['loading']),

        getTotalPrice() { 
            let pay = this.cart_total >= 10? this.cart_total : this.cart_total + this.shipping_fee
            return pay.toFixed(2) 
        },
        cart_total() { 
            let total = 0
            this.cart.forEach(c => {
                total += c.product.price * c.quantity
            })
            return total
        }
    },
    methods : {
        login() { // after login, redirect back
            this.$router.push({name: 'login', params: {nextUrl: this.$route.fullPath}})
        },
        register() {
            this.$router.push({name: 'register', params: {nextUrl: this.$route.fullPath}})
        },
        placeOrder(e) {
            //need modal first
            e.preventDefault()
            this.request_status = 'PENDING'

            let data = {
                address: this.address,
                cart_total: this.cart_total,
                shipping_fee: this.cart_total < 10? this.shipping_fee : 0
            }
    
            this.$http.post('api/orders/', data)
                    .then(response => this.$router.push('/confirmation'))
                    // .fail(function() {alert('Failed to checkout. try again later')})
        },
        checkUnits(e){
            if (this.quantity > this.product.units) {
                this.quantity = this.product.units
            }
        }   
    }
}
</script>
<style scoped>
.register-login > h2 {
   font-size: calc(12px + 1vw)
}
</style>