<template>
  <div class="row">
    <div class="row">
      <div class="col">
        <div class="form-group" v-show="!cargando">
          <select
            class="browser-default custom-select"
            name="disponibilidad"
            v-model="disponibilidadSelect"
            @change="getData(disponibilidadSelect)"
          >
            <option
              v-bind:value="item.value"
              :key="item.value"
              v-for="item in disponibilidad"
            >{{item.nombre}}</option>
          </select>
        </div>
        <div v-show="cargando">
          <i class="fa fa-cog fa-spin fa-2x fa-fw"></i>
        </div>
      </div>
    </div>
    <div class="row">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Disponibilidad</th>
            <th scope="col">Stock ({{stockTotal}})</th>
            <th scope="col">Moneda</th>
            <th scope="col">Costo Unidad</th>
            <th scope="col">Precio Unidad</th>
            <th scope="col">Margen Unidad</th>
            <th scope="col">Costo Total ({{costoTotal}})</th>
            <th scope="col">Venta Total ({{precioTotal}})</th>
            <th scope="col">Margen Total ({{margenTotal}})</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(prod, index) in productos" :key="prod.id">
            <td>{{prod.nombre}}</td>
            <td>
              <div class="form-group" v-if="prod.edit">
                <select
                  class="browser-default custom-select"
                  name="disponibilidad"
                  v-model="prod.disponibilidad"
                >
                  <option value disabled>Disponibilidad</option>
                  <option
                    v-bind:value="item.value"
                    :key="item.value"
                    v-for="item in disponibilidad"
                  >{{item.nombre}}</option>
                </select>
              </div>
              <span v-else>{{disponibilidadName(prod.disponibilidad)}}</span>
            </td>
            <td>
              <span v-if="prod.edit">
                <input type="number" class="form-control" v-model="prod.stock" />
              </span>
              <span v-else>{{prod.stock}}</span>
            </td>
            <td>{{mostrarMoneda(prod.moneda)}}</td>
            <td>
              <span>{{prod.costo}}</span>
            </td>
            <td>
              <span v-if="prod.edit">
                <input type="number" class="form-control" v-model="prod.precio_venta" />
              </span>
              <span v-else>{{prod.precio_venta}}</span>
            </td>
            <td>¢{{montoColones(prod.precio_venta - prod.costo, prod.moneda)}}</td>
            <td>¢{{montoTotal(prod.costo, prod.moneda, prod.stock)}}</td>
            <td>¢{{montoTotal(prod.precio_venta, prod.moneda, prod.stock)}}</td>
            <td>¢{{montoTotal(prod.precio_venta - prod.costo, prod.moneda) * prod.stock}}</td>

            <td>
              <div v-show="cargando">
                <i class="fa fa-cog fa-spin fa-2x fa-fw"></i>
              </div>
              <div v-show="!cargando">
                <span class="btn btn-sm btn-success" @click="save(index)" v-show="prod.edit">Guardar</span>
                <span class="btn btn-sm btn-primary" @click="edit(index)" v-show="!prod.edit">Editar</span>
                <span
                  class="btn btn-sm btn-danger"
                  @click="cancelar(index)"
                  v-show="prod.edit"
                >Cancelar</span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from "axios"

// Props definition
const props = defineProps({
  productosData: {
    type: String,
    required: true
  }
})

// Data as refs
const productos = ref([])
const productosCopia = ref([])
const dolar = ref(580)
const margenTotal = ref(0)
const precioTotal = ref(0)
const costoTotal = ref(0)
const stockTotal = ref(0)
const cargando = ref(false)
const disponibilidadSelect = ref(0)
const disponibilidad = ref([
  { nombre: "Inmediata", value: 0, selected: "" },
  { nombre: "En una semana", value: 1, selected: "" },
  { nombre: "En dos semanas", value: 2, selected: "" },
  { nombre: "Agotado", value: 3, selected: "" }
])

// Methods
const inputData = () => {
  productosCopia.value = JSON.parse(props.productosData)
  productos.value = JSON.parse(props.productosData)
  for (let i = 0; i < productos.value.length; i++) {
    productos.value[i].edit = false
  }
}

const montoTotal = (monto, moneda, stock) => {
  var thes = this;
  var montoTotal = stock > 0 ? stock * monto : monto;
  return thes.montoColones(montoTotal, moneda);
}

const disponibilidadName = (key) => {
  var key = Number(key);
  var disponibilidadName = "";
  switch (key) {
    case 0:
      disponibilidadName = "Inmediata";
      break;
    case 1:
      disponibilidadName = "En una semana";
      break;
    case 2:
      disponibilidadName = "En dos semanas";
      break;
    case 3:
      disponibilidadName = "Agotado";
      break;
  }
  return disponibilidadName;
}

const montoColones = (monto, moneda) => {
  var thes = this;
  return moneda == 1 ? monto : monto * thes.dolar;
}

const edit = (index) => {
  var e = productos.value[index];
  e.edit = true;
  productos.value[index] = e;
  console.log("click");
}

const save = (index) => {
  var thes = this;
  cargando.value = true;
  var e = productos.value[index];
  e.edit = false;
  productos.value[index] = e;
  axios
    .post("/inventario-update/" + e.slug, {
      disponibilidad: e.disponibilidad,
      stock: e.stock,
      precio_venta: e.precio_venta
    })
    .then(function(response) {
        cargando.value = false;
        totales();
      console.log(response);
    })
    .catch(function(error) {
        productos.value = response.data;
        productosCopia.value = response.data;
        cargando.value = false;
      console.log(error);
    });
}

const cancelar = (index) => {
  //this.$set(this.productos, index, e)
  var e = productosCopia.value[index];
  e.edit = false;

  productos.value[index] = e;
  console.log("click");
}

const totales = () => {
  var thes = this;
  var costoTotal = 0;
  var precioTotal = 0;
  var stock = 0;
  var margenTotal = 0;
  for (let i = 0; i < thes.productos.length; i++) {
    const e = thes.productos[i];
    costoTotal += Number(thes.montoTotal(e.costo, e.moneda, e.stock));
    precioTotal += Number(thes.montoTotal(e.precio_venta, e.moneda, e.stock));
    stock += Number(e.stock);
  }
  margenTotal = precioTotal - costoTotal;
  thes.$set(thes, "costoTotal", costoTotal);
  thes.$set(thes, "precioTotal", precioTotal);
  thes.$set(thes, "stockTotal", stock);
  thes.$set(thes, "margenTotal", margenTotal);
}

const mostrarMoneda = (moneda) => {
  return moneda == 1 ? "Colones" : "Dólares";
}

const getData = (disponibilidad) => {
    cargando.value = true;
    var thes = this;
    axios
    .get("https://variedadescr.com/inventarito/" + disponibilidad)
    //.get("http://max.local/inventarito/" + disponibilidad)
    .then(response => {
        productos.value = response.data;
        totales();
        cargando.value = false;
    });
}

// Mounted hook
onMounted(() => {
  console.log("Component mounted inventario")
  inputData()
  totales()
})
</script>
