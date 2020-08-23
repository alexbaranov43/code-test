<template>
  <div id="post-form">
    <!-- Flash Message Upon Success -->
    <flash message=""></flash>
    <h1>Post A Product</h1>
      <!-- Form for Product Submission -->
      <form @submit.prevent="submit" method="POST">
          <div class="form-group">
            <input type="hidden" name="_token" :value="csrf">
              <label for="name">Name</label>
              <!-- Hidden User ID Input -->
              <input type="hidden" class="form-control" id="user_id" name="user_id" v-model="fields.user_id" rows="5">
              <!-- Name Text Input -->
              <textarea class="form-control" id="name" name="name" v-model="fields.name" rows="1" required></textarea>

              <label for="description">Description</label>
              <!-- Description Text Input -->
              <textarea class="form-control" id="description" name="description" v-model="fields.description" rows="5" required></textarea>

              <label for="image">Image</label>
              <!-- Image Text Input -->
              <textarea class="form-control" id="image" name="image" v-model="fields.image" rows="1" required></textarea>
                            
              <label for="price">Price</label>
              <!-- Price Text Input -->
              <textarea class="form-control col-md-2" id="price" name="price" v-model="fields.price" rows="1" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit Product</button>
      </form>
  </div>
</template>

<style lang="stylus" scoped>

</style>

<script>
export default {
    mounted() {
        $.ajaxSetup({
            headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    },
  data() {
    return {
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      products: {},
      showDismissibleAlert: false,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
  methods: {
    submit() {
      if (this.loaded) {
        //set the user id to the passed attribute
        this.fields.user_id = this.$attrs.user_id
        console.log(this.$attrs.user_id)
        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios.post('products/post', this.fields).then(response => {
          this.fields = {}; //Clear input fields.
          this.loaded = true;
          this.success = true;
        // Flash message success
          flash('Product Successfully Added.', 'success');
        }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            // flash message failure
            flash('Error in loading your product', 'failure')
            this.errors = error.response.data.errors || {};
          }
        });
      }
    },
  }
}
</script>