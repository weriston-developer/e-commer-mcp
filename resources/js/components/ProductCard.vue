<template>
  <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
      <img 
        v-if="product.imagem_url" 
        :src="product.imagem_url" 
        :alt="product.nome"
        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
      />
      <div v-else class="text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>
    
    <div class="p-5">
      <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[2.5rem]">{{ product.nome }}</h3>
      <p v-if="product.tamanho" class="text-sm text-gray-600 mb-3 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
        {{ product.tamanho }}
      </p>
      <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
        <span class="text-xl font-bold text-blue-600">R$ {{ formatPrice(product.preco) }}</span>
        <button class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
          Ver detalhes
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  product: {
    type: Object,
    required: true
  }
});

const formatPrice = (price) => {
  return parseFloat(price).toFixed(2).replace('.', ',');
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
