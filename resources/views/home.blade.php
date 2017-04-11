@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="app">
            <vuetable
                    api-url="localhost:8000/api/order"
                    :fields="columns"
            ></vuetable>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    'id',
                    'product_id',
                    'customer_name',
                    'quantity',
                    'price'
                ]
            }
        })
    </script>
    @endsection



