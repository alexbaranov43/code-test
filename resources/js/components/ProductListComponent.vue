<template>
  <div class="container">
    <button class="btn btn-info" @click="getPersonalProducts()">See Personal Products</button>
    <button class="btn btn-info" @click="getProducts()">See All Products</button>
    <button class="btn btn-info" @click="getAvailableProducts()">See Available Products</button>
    <button class="btn btn-info" @click="getTakenProducts()">See Products I've Taken</button>
    <flash message=""></flash>
    <div class="col-md-12 row justify-content-center">
      <div class="card col-md-5 justify-content-center" v-for="product in productsInfo"  v-bind:key="product.id">
        
        <img v-bind:src="product.image">
        <h1>{{product.name}}</h1>
        <p>{{product.description}}</p>
        <p>${{product.price}}</p>
        <p>Posted By: {{product.user_name}}</p>
        <button v-if="product.can_edit" type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#modal' + product.id">Update</button>
        <button v-if="product.can_edit" class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>

        <!-- Modal -->
        <div class="modal fade" :id="'modal' + product.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update: {{product.name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="container">
               <!-- Form for Product Submission -->
              <form @submit.prevent="updateProduct(product.id)" method="PATCH">
                  <div class="form-group">
                      <label for="name">Name</label>
                      <!-- Hidden User ID Input -->
                      <input type="hidden" class="form-control" id="user_id" name="user_id" v-model="productInfo.user_id" rows="5">
                      <!-- Name Text Input -->
                      <textarea class="form-control" id="name" name="name" v-model="productInfo.name" :placeholder="product.name" rows="1" required></textarea>

                      <label for="description">Description</label>
                      <!-- Description Text Input -->
                      <textarea class="form-control" id="description" name="description" v-model="productInfo.description" :placeholder="product.description" rows="5" required></textarea>

                      <label for="image">Image URL</label>
                      <!-- Image Text Input -->
                      <textarea class="form-control" id="image" name="image" v-model="productInfo.image" :placeholder="product.image" rows="1"></textarea>
                                    
                      <label for="price">Price</label>
                      <!-- Price Text Input -->
                      <textarea class="form-control col-md-2" id="price" name="price" v-model="productInfo.price" :placeholder="product.price" rows="1" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Update Product</button>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fields: {},
      errors: {},
      productInfo: {},
      success: false,
      loaded: true,
      products: {},
      productsInfo: {},
      fullIndex: false,
      renderComponent: true,
        }
      },
  mounted() {
    products: {}
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  methods: {
      forceRerender() {
        // Remove my-component from the DOM
        this.renderComponent = false;

        this.$nextTick(() => {
          // Add the component back in
          this.renderComponent = true;
        });
    },
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
        // this.reloadAllProducts();
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
          }
        );
        // this.reloadPersonalProducts();
    },
    updateProduct(product_id) {
      console.log(this.productInfo);
        if (this.loaded){
              // console.log(product.user_id)
              // this.productInfo.user_id = product.user_id
              this.loaded = false;
              this.success = false;
              // set the user id to the passed attribute
              this.loaded = false;
              this.success = false;
              this.errors = {};
              axios.patch(`/products/${product_id}/update`, this.productInfo).then(response => {
                console.log(response)
                // this.fields = {}; //Clear input fields.
                this.loaded = true;
                this.success = true;
              if(this.fullIndex) {
                this.getProducts();
               } else {
                this.getPersonalProducts();
               }
              // Flash message success
                flash('Product updated successfully.', 'success');
              }).catch(error => {
                console.log(error)
                this.loaded = true;
                if (error.response.status === 422) {
                  // flash message failure
                  flash('Error in updating your product', 'failure')
                  this.errors = error.response.data.errors || {};
                }
              });
        }
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
    },
    reloadAllProducts() {
      setTimeout(() => {
        this.getProducts()
      }, 10000);
    },
    reloadPersonalProducts() {
      setTimeout(()=>{
        this.getPersonalProducts()
        }, 10000);
      },
  },
  created() {
  }
}
</script>