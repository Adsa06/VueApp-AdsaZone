<!-- Parte del Script-->
<script setup>
// Imports
import { ref, onMounted } from 'vue';
import card from 'primevue/card';
import { clientID } from '@/paypal';


// Variables
const cartItems = ref([
   { name: 'Product A', price: 5.00 },
   { name: 'Product B', price: 5.00 }
]);

// Funciones
function cargarBotonesPaypal() {
   // Dynamically load the PayPal SDK if it isn't already loaded.
   if (!document.getElementById('paypal-sdk')) {
      const script = document.createElement('script');
      script.id = 'paypal-sdk';
      script.src = 'https://www.paypal.com/sdk/js?client-id=' + clientID + '&currency=EUR';
      script.onload = initializePaypalButton;
      document.head.appendChild(script);
   } else {
      initializePaypalButton();
   }
}

function initializePaypalButton() {
   window.paypal.Buttons({
      createOrder: (data, actions) => {
         return actions.order.create({
            purchase_units: [{
               amount: { value: 40 }
            }]
         });
      },
      onApprove: (data, actions) => {
         return actions.order.capture().then(details => {
            console.log('Transaction completed by ' + details.payer.name.given_name);
            // Here you can clear the cart or update your backend as needed.
         });
      },
      onError: (err) => {
         console.error('PayPal Checkout error', err);
         // Implement error handling as needed.
      }
   }).render('#paypal-button-container');
}

onMounted(() => {
   cargarBotonesPaypal();
})

</script>

<!-- Parte del HTML-->
<template>
   <div class="p-grid">
      <!-- Left Column: PayPal Button -->
      <div class="p-col-12 p-md-6">
         <div id="paypal-button-container"></div>
      </div>

      <!-- Right Column: Shopping Cart -->
      <div class="p-col-12 p-md-6">
         <card header="Your Shopping Cart">
            <ul>
               <li v-for="(item, index) in cartItems" :key="index">
                  {{ item.name }} - ${{ item.price }}
               </li>
            </ul>
            <p>Total: ${{ totalAmount }}</p>
         </card>
      </div>
   </div>
</template>

<!-- Parte del CSS-->
<style scoped></style>
