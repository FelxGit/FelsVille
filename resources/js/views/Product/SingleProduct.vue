 <template>
        <div class="container">
            <div class="row">
                <content-spinner v-show="loading && submitStatus === null"></content-spinner>
                <div class="col-md-8 offset-md-2">
                    <img :src="product.image" :alt="product.name">
                    <h3 class="title" v-html="product.name"></h3>
                    <p class="text-muted">{{product.description}}</p>
                    <h4>
                        <span class="small-text text-muted float-left">$ {{product.price}}</span>
                        <span class="small-text float-right">Available Quantity: {{product.units}}</span>
                    </h4><br/><br/>
                    <form @submit.prevent="submit">
                        <div class="form-group text-right">
                            <label for="quantity">Quantity: 
                                <input type="number" v-model.trim="$v.quantity.$model" @change="checkUnits" id="quantity" name="quantity" class="form-control" style="display: inline; width: calc(30px + 5vw)" :class="{ 'is-invalid': $v.quantity.$error }"/> <!-- did quantity errored? display class -->
                            </label>
                            <div style="grid-column-start: " v-if="submitStatus==='ERROR' && $v.quantity.$error" class="invalid-feedback"> <!-- if have error -->
                                <span v-if="!$v.quantity.required">Quantity is required</span> <!-- display sorts -->
                                <span v-if="!$v.quantity.minValue">Minimum value is 1</span>
                            </div>
                        </div>
                        <button type="submit" :disabled="submitStatus === 'PENDING'" class="btn btn-md btn-primary float-right">
                            Add <i class="fa fa-shopping-cart"></i>
                        </button>
                        <p v-if="submitStatus === 'OK'">ADDED TO CART</p>
                        <p v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                        <p v-if="submitStatus === 'PENDING'">adding...</p>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <script>
    import { mapState } from 'vuex'
    import { required, minValue, maxValue } from 'vuelidate/lib/validators' // should not put hard validation for 1 input, so this for testing only

    export default {
        data(){
            return {
                product : [],
                quantity: 1,
                submitStatus: null
            }
        },
        beforeMount(){
            let url = `/api/products/${this.$route.params.id}`            
            this.$http.get(url).then(response => this.product = response.data)
        },
        validations: {
            quantity: {
                required,
                minValue: 1
            }

        },
        computed: {
            ...mapState(['loading'])
        },
        methods:{
            submit(e) {
                e.preventDefault()

                this.$v.$touch()  //validate all
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                } else {
                    // do your submit logic here
                    this.submitStatus = 'PENDING'

                    this.addToCart()
                    .then(response => {
                        console.log(response.data)
                        this.submitStatus = 'OK'
                    })
                }
            },
            addToCart() {

                let product_id = this.product.id
                let quantity = this.quantity
                if(localStorage.getItem('felStore.user') == null){
                    return this.$http.get('api/cart-local/'+ product_id + '/' + quantity)
                }else{
                    return this.$http.post('api/cart', { product_id, quantity })
                }
            },
            checkUnits(e) {
                if (this.quantity > this.product.units) {
                    this.quantity = this.product.units
                }
            }
        }
    }
    </script>

    <style scoped>
    .small-text { font-size: 18px; }
    .title { font-size: 36px; }
    .grid {
        display: grid;
        grid-template-areas: '..........' /* 10 */ /* #text-right for inline element */
    }
    </style>