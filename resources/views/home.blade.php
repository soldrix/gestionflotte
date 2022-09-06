@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="container d-flex flex-wrap pt-5 justify-content-center"  >
        @for($i=0;$i < 15; $i++)
        <div class="col-2 d-flex flex-column  p-2 rounded m-2" style="background: #e4e4e4">
            <img src="https://i.picsum.photos/id/1071/3000/1996.jpg?hmac=rPo94Qr1Ffb657k6R7c9Zmfgs4wc4c1mNFz7ND23KnQ" alt="" class="rounded">
            <button class="btn btn-primary w-75 align-self-center mt-3">
                En savoir plus
            </button>
        </div>
        @endfor
    </div>
</div>
@endsection
