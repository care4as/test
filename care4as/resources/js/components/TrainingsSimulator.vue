<template>
    <div class="container">
      <div class="d-flex" id='engulfingRow'>
        <div class="p-1 m-3 columOffer" style=''>
          <div class="row m-0">
            Angebot1 Bestandskunden
          </div>
          <div class="row m-0">

          </div>
        </div>
        <div class="p-1 m-3 columOffer" >
          <div class="row m-0">
            Angebot2 VVL
          </div>
          <div class="row m-0">

          </div>
        </div>
        <button type="button" class="btn-primary">+</button>
      </div>
    </div>
</template>

<style media="screen">
  .columOffer
  {
    width: 250px;
    background-color: green;
  }
  .btn-primary
  {
    background-color: white;
    border: 2px solid blue;
    color: blue;
    height: 40px;
    width: 40px;
    align-self: center;
  }
</style>
<script>
    export default {
        mounted() {
            console.log('Simulator mounted.')
        }
    }
</script>
