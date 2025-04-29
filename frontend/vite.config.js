import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': '/src', // Нічого міняти не треба якщо src залишився всередині
    },
  },
  server: {
    port: 5173, // або інший
    cors: true,
    proxy: {
      '/backend': 'http://localhost', // проксируємо запити до вашого бекенду
    },
  },
})
