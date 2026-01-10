<script setup>
import { ref } from 'vue'

const file = ref(null)
const uploadedUrl = ref(null)
const message = ref('')

const handleFileUpload = (event) => {
  file.value = event.target.files[0]
}

const submitFile = async () => {
    if (!file.value) {
        message.value = "Please select a file first."
        return
    }

    const formData = new FormData()
    formData.append('image', file.value)

    try {
        // Pointing to localhost:8000 exposed by Docker
        const response = await fetch('http://localhost:8000/api/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        
        const data = await response.json()
        
        if (response.ok) {
            message.value = data.message || 'Success!'
            if (data.url) {
                uploadedUrl.value = data.url
            }
        } else {
            console.error('Server Error:', data)
            message.value = 'Upload failed: ' + (data.message || data.error || 'Unknown error')
        }
    } catch (error) {
        console.error('Network Error:', error)
        message.value = 'Upload failed: ' + error.message
    }
}
</script>

<template>
  <div class="container">
    <h1>Docker Image Upload Demo</h1>
    <br>
    <h5>Ngô Thị Thúy Nhi</h5>
    <h5>Nguyễn Phương Ngân</h5>
    <h5>Trịnh Hải Nam</h5>
    <h5>Trương Đức Gia Bảo</h5>
    <h5>Lê Xuân Thành Hưng</h5>
    <div class="upload-box">
      <input type="file" @change="handleFileUpload" accept="image/*" />
      <button @click="submitFile" :disabled="!file">Upload Image</button>
    </div>

    <p v-if="message" class="message">{{ message }}</p>

    <div v-if="uploadedUrl" class="preview">
      <h3>Uploaded Result:</h3>
      <!-- Note: localhost:8000 might not work if browser can't reach it correctly without CORS, 
           but Docker mapping 8000:8000 should work for browser -->
      <img :src="uploadedUrl" alt="Uploaded Image" />
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  text-align: center;
}

.upload-box {
  margin: 20px 0;
  padding: 20px;
  border: 2px dashed #ccc;
  border-radius: 8px;
}

button {
  background-color: #42b883;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  margin-left: 10px;
}

button:disabled {
  background-color: #a8d5c2;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  background-color: #3aa876;
}

.message {
  margin-top: 10px;
  font-weight: bold;
}

.preview img {
  max-width: 100%;
  margin-top: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>