// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/variedadescr/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/variedadescr/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/laragon/www/variedadescr/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/js/app.js"
      ],
      refresh: true
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => ["swiper-container", "swiper-slide"].includes(tag)
        }
      }
    })
  ],
  resolve: {
    alias: {
      "$": "jQuery",
      "vue": "vue/dist/vue.esm-bundler.js"
    }
  },
  build: {
    outDir: "public/build"
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFx2YXJpZWRhZGVzY3JcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXGxhcmFnb25cXFxcd3d3XFxcXHZhcmllZGFkZXNjclxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovbGFyYWdvbi93d3cvdmFyaWVkYWRlc2NyL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XHJcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xyXG5pbXBvcnQgdnVlIGZyb20gJ0B2aXRlanMvcGx1Z2luLXZ1ZSc7XHJcblxyXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xyXG4gICAgcGx1Z2luczogW1xyXG4gICAgICAgIGxhcmF2ZWwoe1xyXG4gICAgICAgICAgICBpbnB1dDogW1xyXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHAuanMnXHJcbiAgICAgICAgICAgIF0sXHJcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXHJcbiAgICAgICAgfSksXHJcbiAgICAgICAgdnVlKHtcclxuICAgICAgICAgICAgdGVtcGxhdGU6IHtcclxuICAgICAgICAgICAgICAgIGNvbXBpbGVyT3B0aW9uczoge1xyXG4gICAgICAgICAgICAgICAgICAgIGlzQ3VzdG9tRWxlbWVudDogKHRhZykgPT4gWydzd2lwZXItY29udGFpbmVyJywgJ3N3aXBlci1zbGlkZSddLmluY2x1ZGVzKHRhZylcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0pLFxyXG4gICAgXSxcclxuICAgIHJlc29sdmU6IHtcclxuICAgICAgICBhbGlhczoge1xyXG4gICAgICAgICAgICAnJCc6ICdqUXVlcnknLFxyXG4gICAgICAgICAgICAndnVlJzogJ3Z1ZS9kaXN0L3Z1ZS5lc20tYnVuZGxlci5qcycsXHJcbiAgICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBidWlsZDoge1xyXG4gICAgICAgIG91dERpcjogJ3B1YmxpYy9idWlsZCcsXHJcbiAgICB9XHJcbn0pOyAiXSwKICAibWFwcGluZ3MiOiAiO0FBQTJRLFNBQVMsb0JBQW9CO0FBQ3hTLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFFaEIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxNQUNKO0FBQUEsTUFDQSxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixpQkFBaUI7QUFBQSxVQUNiLGlCQUFpQixDQUFDLFFBQVEsQ0FBQyxvQkFBb0IsY0FBYyxFQUFFLFNBQVMsR0FBRztBQUFBLFFBQy9FO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLEVBQ0w7QUFBQSxFQUNBLFNBQVM7QUFBQSxJQUNMLE9BQU87QUFBQSxNQUNILEtBQUs7QUFBQSxNQUNMLE9BQU87QUFBQSxJQUNYO0FBQUEsRUFDSjtBQUFBLEVBQ0EsT0FBTztBQUFBLElBQ0gsUUFBUTtBQUFBLEVBQ1o7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
