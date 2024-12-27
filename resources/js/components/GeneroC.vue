<template>
    <div class="form-group col-md-6">
        <label for="genero">Género:</label>
        <select v-model="selectedGenero" class="custom-select" name="genero" id="genero" @change="emitChange">
            <option v-for="(genero, index) in generos" 
                    :key="index" 
                    :value="genero.value">
                {{ genero.text }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedGenero: 2, // valor por defecto: Hombre
            generos: [
                { value: 1, text: 'Mujer' },
                { value: 2, text: 'Hombre' },
                { value: 3, text: 'Unisex' }
            ]
        }
    },
    methods: {
        emitChange() {
            this.$emit('genero-change', this.selectedGenero)
        }
    }
}
</script>
