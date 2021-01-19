    <template>
        <div>
            <div class="container">
                <div class="row">
                    <content-spinner v-show="loading"></content-spinner>
                    <div class="col-md-12">
                        <br>
                        <div class="row">
                            <div v-for="(order,index) in orders" :key="index" class="orders_grid">
                                <div class="container">
                                    <div style="title">
                                        <span class="col-4">Status: {{order.status}}</span>
                                        <span class="col-4">TOTAL: {{order.cart_total}}</span>
                                    </div>
                                    <div class="carts_grid">
                                        <div v-for="(cart,index) in order.carts" :key="index" class="product-box">
                                            <img :src="cart.product.image" :alt="cart.product.name">
                                            <h5>
                                                <span v-html="cart.product.name"></span><br>
                                            </h5>
                                            <hr>
                                            <span class="small-text text-muted">Quantity: {{cart.quantity}}
                                                <span class="small-text text-muted float-right">$ {{cart.product.price * cart.quantity}}</span>
                                            </span>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
    import { mapState } from 'vuex'
    export default {
        data() {
            return {
                user : localStorage.getItem('felStore.user'),
                orders : []
            }
        },
        computed: {
            ...mapState(['loading'])
        },
        beforeMount() {
            let user = JSON.parse(this.user)

            this.$http.get(`api/orders`)
                 .then(response => this.orders = response.data)         
        }
    }
    </script>
    
    <style scoped>
        .small-text { font-size: 14px; }
        .product-box { border: 1px solid #cccccc; padding: 10px 15px; }
        .orders_grid {
            display:grid;
            grid-template-columns: auto;
            margin-bottom: 50px;
        }
        .carts_grid {
            display:grid;
            grid-template-columns: auto auto auto
        }
    </style>