<script setup>
import { ref, onMounted } from 'vue'

const fileInput = ref(null)
const selectedFile = ref(null)
const message = ref('')
const images = ref([])

const fetchImages = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/images')
        const data = await response.json()
        if (data.images) {
            images.value = data.images
        }
    } catch (error) {
        console.error('Error fetching images:', error)
    }
}

onMounted(() => {
    fetchImages()
})

const handleFileChange = (event) => {
    selectedFile.value = event.target.files[0]
}

const submitFile = async () => {
    if (!selectedFile.value) {
        message.value = "Please select a file first."
        return
    }

    const formData = new FormData()
    formData.append('image_file', selectedFile.value)

    try {
        const response = await fetch('http://localhost:8000/api/upload', {
            method: 'POST',
            body: formData, // fetch automatically sets Content-Type to multipart/form-data
            headers: {
                'Accept': 'application/json'
            }
        })
        
        const data = await response.json()
        
        if (response.ok) {
            message.value = data.message || 'Success!'
            fileInput.value.value = ''
            selectedFile.value = null
            fetchImages() // Reload list
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
    <h1>Docker Image Upload Demo</h1>
    <br>
    <h5>Ngô Thị Thúy Nhi</h5>
    <h5>Nguyễn Phương Ngân</h5>
    <h5>Trịnh Hải Nam</h5>
    <h5>Trương Đức Gia Bảo</h5>
    <h5>Lê Xuân Thành Hưng</h5>

    <div class="upload-box">
      <input 
        type="file" 
        ref="fileInput" 
        @change="handleFileChange" 
        class="file-input" 
        accept="image/*"
      />
      <button @click="submitFile" :disabled="!selectedFile">Upload Image</button>
    </div>

    <p v-if="message" class="message">{{ message }}</p>

    <div class="gallery">
        <h2>Gallery</h2>
        <div class="image-grid">
            <div v-for="image in images" :key="image.id" class="image-card">
                <img :src="image.url" :alt="image.filename" />
                <p>{{ image.filename }}</p>
            </div>
        </div>
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
  flex-wrap: wrap;
}

.file-input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
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

.gallery {
  margin-top: 40px;
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.image-card {
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.image-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 4px;
}

.image-card p {
  margin-top: 10px;
  font-size: 12px;
  color: #666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>