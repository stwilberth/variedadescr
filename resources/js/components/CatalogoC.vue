<template>
<div class="row">
  <div class="form-group col-md-6">
    <label for="catalogo">*Catálogo: {{catalogo}}</label>
    <select class="browser-default custom-select" name="catalogo" v-model="catalogo" required>
        <option 
            v-bind:value="item.id" 
            :key="item.id" 
            v-for="item in catalogo_Lista">{{item.nombre}}
        </option>
    </select>
  </div>
  <div class="form-group col-md-6">
    <label for="marca">*Marca: {{marca}}</label>
    <select class="browser-default custom-select" name="marca" 
        v-model="marca" 
        v-bind:disabled="!catalogo"
        required>
        <option 
            v-bind:value="item.id" 
            v-for="item in marcaLista" 
            :key="item.id">
            {{item.nombre}}
        </option>
    </select>
  </div>

  <div class="form-group col-md-6">
    <label for="modelo">*{{tipo}}:</label>
    <input type="text" class="form-control" name="modelo" id="modelo" 
        v-model="modelo" 
        v-bind:disabled="!catalogo" required/>
  </div>
</div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted catalogo jeje");
    },
    props: ['marcasLista', 'catalogoLista', 'marcaSelected', 'modeloSelected', 'catalogoSelected'],
    data: function () {
        return {
            catalogo: this.catalogoSelected,
            marca: this.marcaSelected,
            modelo: this.modeloSelected
        }
    },
    computed: {
        marcaLista: function () {
            var myThis = this;
            var marcasTodas = JSON.parse(this.marcasLista);
            var marcasFiltradas = marcasTodas.filter(function (marca) {
                return marca.catalogo == myThis.catalogo;
            })
            return marcasFiltradas;
        },
        catalogo_Lista: function () {
            return JSON.parse(this.catalogoLista);
        },
        tipo: function () {
            var myThis = this;
            var tipo;
            switch (Number(myThis.catalogo)) {
                case 1:
                    tipo = "Modelo";
                    break;
                case 2:
                    tipo = "Fragancia";
                    break;
                default:
                    tipo = "Tipo";
                    break;
            }
            return tipo;
        }
    }
};
</script>
