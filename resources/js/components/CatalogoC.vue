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
import { computed, ref } from 'vue'

export default {
    props: {
        marcasLista: String,
        catalogoLista: String,
        marcaSelected: [String, Number],
        modeloSelected: String,
        catalogoSelected: [String, Number]
    },
    setup(props) {
        // Variables reactivas
        const catalogo = ref(props.catalogoSelected)
        const marca = ref(props.marcaSelected)
        const modelo = ref(props.modeloSelected)

        // Computed properties
        const marcaLista = computed(() => {
            const marcasTodas = JSON.parse(props.marcasLista)
            return marcasTodas.filter(marca => marca.catalogo == catalogo.value)
        })

        const catalogo_Lista = computed(() => {
            return JSON.parse(props.catalogoLista)
        })

        const tipo = computed(() => {
            let tipoLabel
            switch (Number(catalogo.value)) {
                case 1:
                    tipoLabel = "Modelo"
                    break
                case 2:
                    tipoLabel = "Fragancia"
                    break
                default:
                    tipoLabel = "Tipo"
                    break
            }
            return tipoLabel
        })

        return {
            catalogo,
            marca,
            modelo,
            marcaLista,
            catalogo_Lista,
            tipo
        }
    }
}
</script>
