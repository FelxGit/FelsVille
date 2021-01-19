import Home from '../views/Home.vue'
import SingleProduct from '../views/Product/SingleProduct.vue'
import Checkout from '../views/Product/Checkout.vue'
import Confirmation from '../views/Product/Confirmation.vue'
import Cart from '../views/Product/Cart.vue'
import UserBoard from '../views/User/Userboard.vue'

//router-view is base on the state url
const appRoutes = [
    { path: '/', component: Home, name: 'home'},
    { path: '/cart', component: Cart, name: 'cart' },
    { path: '/products/:id', name: 'single-products', component: SingleProduct },
    { path: '/confirmation', name: 'confirmation', component: Confirmation },
    { path: '/checkout', name: 'checkout', component: Checkout },
    { path: '/dashboard', name: 'userboard', component: UserBoard }
];

export { appRoutes }; 

/***
 * prop, or a more like laravel route parameter
 * 
    { path: '/user/:id', component: User, props: true },
*/

/***
 * children, or a more like laravel route resource
 * 
{ 
    path: '/product',
    name: 'product.index',  
    component: ProductIndex,
    children: [
        create, store, show, edit, update, pdelete
    ]
}
*/

/***
 * meta, or a more like laravel middleware?
 * 
    meta: {
        requiresAuth: true,
        is_user: true
    }
}
*/
