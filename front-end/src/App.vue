<template>
<nav class="navbar navbar-expand-lg bg-light fixed-top" id="mainNav">
  <div class="container px-4 px-lg-5">
    <span class="navbar-brand">MyVisa</span>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
      aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
        <ul class="navbar-nav">
          <router-link class="nav-item" to="/">Home</router-link>
          <router-link class="nav-item" to="/track">Track</router-link>
        </ul>
      </div>
    </div>
</nav>
<router-view />
</template>


<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap');
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
nav ul a {
  text-decoration: none;
  color: black;
  transition: .5s ease-in-out;
  text-align: start;
  margin-left: 1rem;
}
nav ul a:hover {
  color: rgb(113, 113, 113);
  cursor: pointer;
}
nav ul li {
  text-align: start!important;
}

@media (max-width: 768px) {
  nav ul a{
    margin-left: 0;
  }
}
</style>