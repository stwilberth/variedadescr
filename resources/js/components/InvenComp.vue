<template>
  <div class="row">
    <div class="row">
      <div class="col">
        <div class="form-group" v-show="!cargando">
          <select
            class="browser-default custom-select"
            name="disponibilidad"
            v-model="disponibilidadSelect"
            v-on:change="getData(disponibilidadSelect)"
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

<script>
import axios from "axios";
export default {
  mounted() {
    console.log("Component mounted inventario");
    this.inputData();
    this.totales();
  },
  props: ["productosData"],
  data: function() {
    return {
      productos: [],
      productosCopia: [],
      dolar: 580,
      margenTotal: 0,
      precioTotal: 0,
      costoTotal: 0,
      stockTotal: 0,
      cargando: false,
      disponibilidadSelect: 0,
      disponibilidad: [
        { nombre: "Inmediata", value: 0, selected: "" },
        { nombre: "En una semana", value: 1, selected: "" },
        { nombre: "En dos semanas", value: 2, selected: "" },
        { nombre: "Agotado", value: 3, selected: "" }
      ]
    };
  },
  // computed: {
  // },
  methods: {
    inputData: function() {
      this.productosCopia = JSON.parse(this.productosData);
      this.productos = JSON.parse(this.productosData);
      for (let i = 0; i < this.productos.length; i++) {
        this.productos[i].edit = false;
      }
    },
    montoTotal: function(monto, moneda, stock) {
      var thes = this;
      var montoTotal = stock > 0 ? stock * monto : monto;
      return thes.montoColones(montoTotal, moneda);
    },
    disponibilidadName: function(key) {
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
    },
    montoColones: function(monto, moneda) {
      var thes = this;
      return moneda == 1 ? monto : monto * thes.dolar;
    },
    edit: function(index) {
      var e = this.productos[index];
      e.edit = true;
      this.$set(this.productos, index, e);
      console.log("click");
    },
    save: function(index) {
      var thes = this;
      this.$set(this, "cargando", true);
      var e = this.productos[index];
      e.edit = false;
      this.$set(this.productos, index, e);
      axios
        .post("/inventario-update/" + e.slug, {
          disponibilidad: e.disponibilidad,
          stock: e.stock,
          precio_venta: e.precio_venta
        })
        .then(function(response) {
            thes.$set(thes, "cargando", false);
            thes.totales();
          console.log(response);
        })
        .catch(function(error) {
            thes.$set(thes, "productos", response.data);
            thes.$set(thes, "productosCopia", response.data);
            thes.$set(thes, "cargando", false);
          console.log(error);
        });
    },
    cancelar: function(index) {
      //this.$set(this.productos, index, e)
      var e = this.productosCopia[index];
      e.edit = false;

      this.$set(this.productos, index, e);
      console.log("click");
    },
    totales: function() {
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
    },
    mostrarMoneda: function(moneda) {
      return moneda == 1 ? "Colones" : "Dólares";
    },
    getData: function(disponibilidad) {
        this.$set(this, "cargando", true);
        var thes = this;
        axios
        .get("https://variedadescr.com/inventarito/" + disponibilidad)
        //.get("http://max.local/inventarito/" + disponibilidad)
        .then(response => {
            thes.$set(thes, "productos", response.data);
            thes.totales();
            this.$set(this, "cargando", false);
        });
    }
  }
};
</script>
