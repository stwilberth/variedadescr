<template>
  <div class="row">
    <div class="col-md-12" style="margin-top:30px">
      <center>
        <a 
          v-show="slugData"
          v-bind:href="'/producto-edit/' + slugData"
          class="btn btn-primary"
          style="color: #fff">
          Edit
        </a>
        <a
          v-show="slugData"
          v-bind:href="'/image-edit/' + slugData"
          class="btn btn-primary"
          style="color: #fff">
          Add/edit Image
        </a>
        <a class="btn btn-success" href="/producto-create">Agregar Producto</a>
        <a class="btn btn-primary" href="/marcas">Editar Marcas</a>
        <a class="btn btn-primary" href="/inventario">Inventario</a>
        <a class="btn btn-primary" href="/users">Users</a>
      </center>
    </div>
  </div>
</template>
<script>
export default {
    mounted() {
        console.log("Component panel admin mounted");
    }, 
    props: ['slugData']
};
</script>