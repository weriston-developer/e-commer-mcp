<template>
  <div class="flex flex-col h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <ChatHeader />
    
    <div class="flex-1 overflow-y-auto px-4 py-6">
      <div class="max-w-6xl mx-auto">
        <ChatMessages :messages="messages" />
      </div>
    </div>
    
    <ChatInput 
      :loading="loading" 
      @send-message="handleSendMessage" 
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import ChatHeader from './ChatHeader.vue';
import ChatMessages from './ChatMessages.vue';
import ChatInput from './ChatInput.vue';

const messages = ref([]);
const loading = ref(false);

const handleSendMessage = async (messageText) => {
  if (!messageText.trim()) return;
  
  // Add user message
  messages.value.push({
    id: Date.now(),
    type: 'user',
    text: messageText,
    timestamp: new Date()
  });
  
  loading.value = true;
  
  try {
    const response = await axios.post('/api/chat', {
      message: messageText
    });
    
    // Add assistant response
    messages.value.push({
      id: Date.now() + 1,
      type: 'assistant',
      text: response.data.resposta,
      products: response.data.produtos || [],
      timestamp: new Date()
    });
  } catch (error) {
    console.error('Error sending message:', error);
    messages.value.push({
      id: Date.now() + 1,
      type: 'assistant',
      text: 'Desculpe, ocorreu um erro ao processar sua mensagem.',
      timestamp: new Date()
    });
  } finally {
    loading.value = false;
  }
};
</script>
