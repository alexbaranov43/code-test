<template>
  <div class="container">
    <flash message=""></flash>
    <div class="col-md-12 row justify-content-center">
      {{products}}
      <div class="card col-md-5 justify-content-center" v-for="product in productsInfo"  v-bind:key="product.id">
        
        <img v-bind:src="product.image">
        <h1>{{product.name}}</h1>
        <p>{{product.description}}</p>
        <p>${{product.price}}</p>
        <p>Posted By: {{product.user_name}}</p>
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
        }
      },
  mounted() {
    products: {}
  },
  methods: {
    getProducts() {
      let url = '/products/index';
      axios.get(url).then((response)=>{
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
    }
  },
  created() {
    this.getProducts();
  }
}
</script>