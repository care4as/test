@extends('general_layout')

@section('additional_css')
<style media="screen">



.box {
  position: relative;
  height:  400px;
  width: 380px;
  display: block;
  background: linear-gradient(0deg, black, #444444);
}

.glowing::before{
  content: '';
  position: absolute;
  left: -2px;
  top: -2px;
  background: linear-gradient(45deg, #e8f74d, #ff6600d9, #00ff66, #13ff13, #ad27ad, #bd2681, #6512b9, #ff3300de, #5aabde);
  background-size: 400%;
  width: calc(100% + 5px);
  height: calc(100% + 5px);
  z-index: -1;
  animation: glower 20s linear infinite;
}

@keyframes glower {
  0% {
    background-position: 0 0;
  }

  50% {
    background-position: 400% 0;
  }

  100% {
    background-position: 0 0;
  }
}
</style>
@endsection

@section('content')
<div class="row" style="justify-content: center;align-items: center;">
  <div class="box glowing">
      hallo
  </div>
</div>
@endsection
