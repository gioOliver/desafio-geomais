<template>
  <div v-if="active" class="loader">
    <div class="spinner">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <p id="loading-text">{{ text }}</p> 
  </div>
</template>

<script>
export default {
  name: 'LoadingSpinner',
  props: {
    active: Boolean,
    text: String
  }
}
</script>

<style scoped>

.loader {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
}
.spinner {
  display: flex;
  justify-content: center;
  align-items: center;
}
.spinner div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #6916a0;
  border-radius: 50%;
  animation: loader 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #6916a0 transparent transparent transparent;
}

  .loader div:nth-child(1) {
    animation-delay: -0.45s;
  }
  .loader div:nth-child(2) {
    animation-delay: -0.3s;
  }
  .loader div:nth-child(3) {
    animation-delay: -0.15s;
  }
  @keyframes loader {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  #loading-text {
  text-align: center;
  margin-top: 35px;
  color: white; 
}
</style>