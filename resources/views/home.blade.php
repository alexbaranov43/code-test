@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                    <br><br>
                    @if (Auth::user()->is_subscribed)
                    <div style="padding-bottom: 20px">
                        <button class="btn btn-info" id="post-product-button" onclick="showForm()">Post A Product</button>
                        <button class="btn btn-success" id="view-products" onclick="showForm()" style="display: none">View Products</button>
                    </div>
                    @endif
                    <div id="post-product" style="display: none;">
                    <post-product-component :user_id="{{Auth::user()->id}}"></post-product-component>
                    </div>
                    <div id="product-list">
                    <product-list-component></product-list-component>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('view_scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


var renderComponent = true;

function showForm() {
  var postProduct = document.getElementById("post-product");
  var postProductButton = document.getElementById("post-product-button");
  var productList = document.getElementById("product-list")
  var viewProducts = document.getElementById("view-products");
  if (postProduct.style.display === "none") {
    postProduct.style.display = "block";
    viewProducts.style.display = "block";
    productList.style.display = "none"
    postProductButton.style.display = "none";
  } else if (postProduct.style.display === "block") {
    postProduct.style.display = "none";
    viewProducts.style.display = "none";
    postProductButton.style.display = "block";
    productList.style.display = "block"
  }
}

</script>
@endsection
