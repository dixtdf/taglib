import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: '[name].js',  // 对应入口文件
        chunkFileNames: '[name].js',  // 对应代码分块
        assetFileNames: '[name][extname]',  // 对应静态资源文件
      }
    }
  }
})
