<template>
  <div class="container">
    <button v-if="this.fullIndex" @click="getPersonalProducts()">See Personal Products</button>
    <button v-if="this.fullIndex == false" @click="getProducts()">See All Products</button>
    <flash message=""></flash>
    <div class="col-md-12 row justify-content-center">
      <div class="card col-md-5 justify-content-center" v-for="product in productsInfo"  v-bind:key="product.id">
        
        <img v-bind:src="product.image">
        <h1>{{product.name}}</h1>
        <p>{{product.description}}</p>
        <p>${{product.price}}</p>
        <p>Posted By: {{product.user_name}}</p>
        <button v-if="product.can_edit" class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: {},
      products: {},
      productsInfo: {},
      fullIndex: true,
        }
      },
  mounted() {
    products: {}
  },
  methods: {
    getProducts() {
      let url = '/products/index';
      axios.get(url).then((response)=>{
        this.fullIndex = true;
        this.products = response.data
        this.productsInfo = response.data.data
      }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            // flash message failure
            flash('Error in loading products', 'failure')
            this.errors = error.response.data.errors || {};
          }
        });
    },
    getPersonalProducts() {
      let url = '/products/index/personal';
        axios.get(url).then((response)=>{
          this.products = response.data
          this.productsInfo = response.data.data
          this.fullIndex = false
        }).catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
              // flash message failure
              flash('Error in loading products', 'failure')
              this.errors = error.response.data.errors || {};
            }
          });
    },
    deleteProduct(product_id) {
      let url = `products/${product_id}/destroy`;
      axios.delete(url).then((response)=>{
        if(this.fullIndex) {
          this.getProducts();
        } else {
          this.getPersonalProducts();
        }
      }).catch(error=> {
            this.loaded = true;
            if (error.response.status === 422) {
              // flash message failure
              flash('Error in loading products', 'failure')
              this.errors = error.response.data.errors || {};
            }
      })
    }
  },
  created() {
    this.getProducts();
  }
}
</script>