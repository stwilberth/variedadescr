<template>
  <div class="row">
    <div class="col-md-12" style="margin-top:30px">
      <center>
        <a 
          v-show="props.slugData"
          :href="`/producto-edit/${props.slugData}`"
          class="btn btn-primary"
          style="color: #fff">
          Edit
        </a>
        <a
          v-show="props.slugData"
          :href="`/image-edit/${props.slugData}`"
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

<script setup>
import { onMounted } from 'vue'

// Definición de props
const props = defineProps({
  slugData: {
    type: String,
    required: false
  }
})

onMounted(() => {
  console.log("Component panel admin mounted")
})
</script>