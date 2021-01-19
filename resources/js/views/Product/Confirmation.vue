  <template>
        <div>
            <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
                <h2>
                    <span class="title"><strong>Thank You!</strong></span><br>
                    <span class="medium-text">Your order has been placed.</span><br>
                    <router-link :to="{name: 'userboard'}" class="small-link">
                        See your orders <i class="fa fa-heart ml-3" aria-hidden="true"></i>
                    </router-link>
                </h2>
            </div>
        </div>
    </template>

    <script>
    export default {}
    </script>

    <style scoped>
    .medium-text { font-size: 36px; color: white }
    .small-link { font-size: 24px; text-decoration: underline; color: white; }
    .product-box { border: 1px solid #cccccc; padding: 10px 15px; }
    .hero-section { height: 80vh }
    </style>