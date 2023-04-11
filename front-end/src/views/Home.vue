<template>
  <section class="hero d-flex flex-column gap-2 justify-content-center">
    <h1 class="mb-3">MyVisa</h1>
    <p class="text-dark">Applying for a visa has never been easier! Our online <br> application process is quick and easy to use.</p>
    <button class="btn" @click="redirect()">Get Started</button>
  </section>
</template>

<style scoped>
.hero {
  height: 100vh;
  background: linear-gradient(to bottom, white, #646464);
}
.hero h1 {
  font-size: 3rem;
}
.hero button {
  background-color: black;
  color: white;
  align-self: center;
  padding: 5px 20px;
  border-radius: 30px;
  transition: 1s ease-in-out;
}
.hero button:hover {
  border-radius: 0;
}
</style>

<script>
import router from '@/router'
export default {
  methods: {
    redirect() {
      let token = localStorage.getItem('token')
      if(token != undefined) {
        alert('You have already a reservation!')
      } else {
        router.push('/form')
      }
    }
  }
}
</script>