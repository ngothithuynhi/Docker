<script setup>
import { ref } from 'vue'

const imageUrl = ref('')
const uploadedUrl = ref(null)
const message = ref('')

const submitFile = async () => {
    if (!imageUrl.value) {
        message.value = "Please enter an image URL first."
        return
    }

    try {
        const response = await fetch('http://localhost:8000/api/upload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                image_url: imageUrl.value
            })
        })
        
        const data = await response.json()
        
        if (response.ok) {
            message.value = data.message || 'Success!'
            if (data.url) {
                uploadedUrl.value = data.url
            }
        } else {
            console.error('Server Error:', data)
            message.value = 'Submission failed: ' + (data.message || data.error || 'Unknown error')
        }
    } catch (error) {
        console.error('Network Error:', error)
        message.value = 'Submission failed: ' + error.message
    }
}
</script>

<template>
  <div class="container">
    <h1>Docker Image URL Demo</h1>
    <br>
    <h5>Ngô Thị Thúy Nhi</h5>
    <h5>Nguyễn Phương Ngân</h5>
    <h5>Trịnh Hải Nam</h5>
    <h5>Trương Đức Gia Bảo</h5>
    <h5>Lê Xuân Thành Hưng</h5>
    <div class="upload-box">
      <input type="text" v-model="imageUrl" placeholder="Enter Image URL here..." class="url-input" />
      <button @click="submitFile" :disabled="!imageUrl">Submit URL</button>
    </div>

    <p v-if="message" class="message">{{ message }}</p>

    <div v-if="uploadedUrl" class="preview">
      <h3>Result:</h3>
      <img :src="uploadedUrl" alt="Submitted Image" />
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
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.url-input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 60%;
  font-size: 16px;
}

button {
  background-color: #42b883;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
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