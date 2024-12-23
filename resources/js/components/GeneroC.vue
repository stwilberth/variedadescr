<template>
    <div class="form-group col-md-6">
    <label for="genero">Género:</label>
    <select class="custom-select" name="genero" id="genero">
            <option value="1">Mujer</option>
            <option value="2" selected>Hombre</option>
            <option value="3">Unisex</option>
    </select>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
