    <template>
            <div>
                <header-title title="Welcome to my FARM"></header-title>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <ContentSpinner v-show="loading"></ContentSpinner>
                                <div class="col-md-4 product-box" v-for="(product,index) in products" :key="index">
                                    <router-link :to="{ path: '/products/'+product.id}">
                                        <img :src="product.image" :alt="product.name">
                                        <h5><span v-html="product.name"></span>
                                            <span class="small-text text-muted float-right">$ {{product.price}}</span>
                                        </h5>
                                        <button class="col-md-4 btn btn-sm btn-primary float-right">Buy Now</button>
                                    </router-link>
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
                data(){
                    return {
                        products : []
                    }
                },
                computed: {
                    ...mapState(['loading'])  // is reactive
                },
                beforeMount() {
                    this.$http.get("api/products").then(response => this.products = response.data)
                },
            }
        </script>
        <style scoped>
        .small-text {
            font-size: 14px;
        }
        .product-box {
            border: 1px solid #cccccc;
            padding: 10px 15px;
        }
        </style>