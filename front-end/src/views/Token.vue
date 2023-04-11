<template>
  <div class="home mt-5 d-flex flex-column align-items-center">
    <h1 class="my-5">Home Page</h1>
    <div class="container bg-light rounded">
      <div class="d-flex align-items-center justify-content-center">
      <p class="fs-4 text-center justify-content-center mb-0">Your token is {{ token ? token : "not defined yet" }}</p>
      <button class="copy btn py-2 px-5 rounded-3 fs-4 mx-3" @click="copyToClipboard()">Copy</button>
    </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import router from "../router";
export default {
  data() {
    return {
      token: localStorage.getItem("token"),
    };
  },
  async mounted() {
    let response = await axios.get('http://mavisa.ma/updateData.php?token=' + this.token)
    localStorage.removeItem('date')
    localStorage.setItem('id', response.data.id)
  },
  methods: {
    async copyToClipboard() {
      try {
        await navigator.clipboard.writeText(this.token);
        alert("Token Copied To Clipboard!");
        router.push("/calender");
      } catch (err) {
        console.error("Failed to copy text: ", err);
      }
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap');
.container {
  padding: 5rem 0;
}
.copy {
  padding: .5REM 2rem;
  background-color: rgb(66, 66, 66);
  transition: .5s ease-in-out;
  color: #fff;
}
.copy:hover {
  background-color: black;
}
</style>
