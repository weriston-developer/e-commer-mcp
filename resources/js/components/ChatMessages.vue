<template>
  <div class="space-y-6">
    <div 
      v-for="message in messages" 
      :key="message.id"
      class="w-full"
    >
      <!-- Mensagem -->
      <div :class="[
        'flex mb-3',
        message.type === 'user' ? 'justify-end' : 'justify-start'
      ]">
        <div :class="[
          'rounded-2xl px-5 py-3 shadow-sm',
          message.type === 'user' 
            ? 'bg-blue-500 text-white max-w-md' 
            : 'bg-white text-gray-800 max-w-2xl'
        ]">
          <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ message.text }}</p>
        </div>
      </div>
      
      <!-- Grid de Produtos (aparece abaixo da mensagem do assistente) -->
      <div v-if="message.products && message.products.length > 0" class="mt-4">
        <ProductGrid 
          :products="message.products"
        />
      </div>
    </div>
    
    <div ref="messagesEnd"></div>
  </div>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue';
import ProductGrid from './ProductGrid.vue';

const props = defineProps({
  messages: {
    type: Array,
    required: true
  }
});

const messagesEnd = ref(null);

// Auto-scroll to bottom when new messages arrive
watch(() => props.messages.length, async () => {
  await nextTick();
  if (messagesEnd.value) {
    messagesEnd.value.scrollIntoView({ behavior: 'smooth' });
  }
});
</script>
