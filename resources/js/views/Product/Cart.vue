<template>
    <div class="container">
        <div v-if="cart.length" class="row">
            <ContentSpinner v-show="loading && request_status === null"></ContentSpinner>
            <div class="grid-container" v-for="(c,index) in cart" :key="index">
                <div class="image">
                    <router-link :to="{ path: '/products/'+ c.product.id}">
                        <img :src="c.product.image" :alt="c.product.name">
                    </router-link>  
                </div>
                <div class="name">
                    <h5>{{ c.product.name}}</h5>
                </div>
                <div class="description jumbotron">
                    {{ c.product.description }}
                </div>
                <div class="input">
                    <InputNumber @value="update_quantity" :data ="{'value': Number(c.quantity),'units': c.product.units}"></InputNumber>
                </div>
                <div class="units">
                    <strong>Units: </strong> {{ c.product.units }}
                </div>
                <div class="message">
                    <p v-if="request_status === 'ERROR'" class="text-danger">failed</p>
                </div>
                <div class="price">
                    <strong>Price: </strong> ${{ c.product.price }}
                </div>
                <div class="action">
                    <button @click.prevent="update({'cart_id': c.id, 'index': index})" type="submit" class="btn btn-primary btn-sm">
                        <span v-if="request_status === 'PENDING-upd'+index" class="spinner-border spinner-border-sm"></span>
                        <span>Save</span> 
                    </button>
                    <button @click.prevent="remove({'cart_id': c.id, 'index': index})" type="submit" class="btn btn-danger btn-sm">
                        <span v-if="request_status === 'PENDING-rm'+index" class="spinner-border spinner-border-sm"></span>
                        <span>Remove</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-else class="text-center">
                <h2>Your cart is empty!</h2>
        </div>
    </div>
</template>
<script>
import { mapState } from 'vuex'

export default {
    data(){
        return {
            cart: [],
            user: localStorage.getItem('felStore.user'),
            request_status: null,
            quantity: 1
        }
    },
    beforeMount() {
        if(this.user)
            this.$http.get(`/api/cart`).then(response => this.cart = response.data)
        else
            this.$http.get(`/api/cart-local`).then(response => this.cart = response.data)
    },
    computed: {
        ...mapState(['loading'])
    },
    methods: {
        update(data) {
            let quantity = this.quantity
            let cart_id = data.cart_id
            let index = data.index

            this.request_status = 'PENDING-upd'+data.index
            if(this.user){
                this.$http.put(`api/cart/${cart_id}`, { quantity })
                .then(response => { 
                    this.cart = response.data
                    this.request_status = 'OK'
                })
                .catch(err => this.request_status = 'ERROR')
            }else {
               this.$http.put(`api/cart-local/${index}`, { quantity })
                .then(response => {
                    this.cart = response.data
                    this.request_status = 'OK'
                })
                .catch(err => this.request_status = 'ERROR')
            }
        },
        remove(data) {
            let cart_id = data.cart_id
            let index = data.index
            this.request_status = 'PENDING-rm'+data.index

            if(this.user !== null){
                this.$http.delete(`api/cart/${cart_id}`)
                .then(response => {
                    this.cart = response.data
                    this.request_status = 'OK'
                })
                .catch(err => this.request_status = 'ERROR')
            }else {
               this.$http.get(`api/cart-local/${index}`)
                .then(response => {
                    this.cart = response.data
                    this.request_status = 'OK'
                })
                .catch(err => this.request_status = 'ERROR') 
            }
        },
        update_quantity(value) {
            this.quantity = value
        }
    }
}
</script>
<style scoped>

.grid-container {
    display: grid;
    grid-gap: 5px;
    margin: 10px auto;
    padding-bottom: 10px;
    border-bottom: thin solid lightgray; /* BAAM! one time layout */
    grid-template-areas: 'image image image image name   name    description description description description'
                         'image image image image input  input   description description description description'
                         'image image image image action action description description description description'
                         'image image image image units  message   price       price price price';
}

@media screen and (max-width: 800px) {

.grid-container {
     grid-template-areas: 'image       image       name        name'
                          'image       image       input       input'
                          'image       image       action      action'
                          'image       image       units       price'
                          'description description description description ';
    }   
}
.image { grid-area: image }
.name { grid-area: name }
.input { grid-area: input }
.description { grid-area: description }
.units { grid-area: units }
.price { grid-area: price }
.action {grid-area: action }
.save  { grid-area: save }
.remove {grid-area: remove }
.message { grid-area: message }

</style>