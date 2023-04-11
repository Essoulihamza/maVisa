<template>
  <section class="registration d-flex flex-column align-items-center justify-content-center">
    <div class="home">
      <div class="form-floating mb-3">
        <input class="form-control" type="text" placeholder="Access Token" v-model="token"/>
        <label>Access Token</label>
      </div>
      <p class="bg-danger text-white rounded">{{ token_error }}</p>
      <p class="bg-warning text-white rounded">{{ token_not_found }}</p>
      <p class="bg-success text-white rounded">{{ token_found }}</p>
      <button class="track btn" @click="getData()">Track</button>
    </div>
  </section>
  <section class="data mb-5 rounded d-flex flex-column justify-content-center" v-if="visible">
    <h2>Happy To See You Back <span class="fw-bold text-white">{{ data.nom_complet }}</span></h2>
    <div class="fs-6 text-start mx-5 text-black">
      <p>Token: <span>{{ data.token }}</span></p> 
      <p>Birth Date: <span>{{ data.naissance }}</span></p> 
      <p>Nationality: <span>{{ data.nationalite }}</span></p>  
      <p>Familial Situation: <span>{{ data.situation }}</span></p>  
      <p>Email Address: <span>{{ data.address }}</span></p>  
      <p>Visa Type: <span>{{ data.type_visa }}</span></p>  
      <p>Check-In Date: <span>{{ data.date_depart }}</span></p>  
      <p>Check-Out Date: <span>{{ data.date_arriver }}</span></p>  
      <p>Document Type: <span>{{ data.type_document }}</span></p>  
      <p>Document Number: <span>{{ data.numero_document }}</span></p>  
      <p>Status: <span>In Progress</span></p> 
    </div>
    <div class="options d-flex justify-content-between mt-5">
      <button class="btn bg-success text-white rounded-5 update" @click="update">Update</button>
      <button class="btn bg-danger text-white rounded-5 update" @click="remove">Delete</button>
    </div>
  </section>
</template>

<script>
import axios from 'axios'
import router from '@/router'
export default {
  data() {
    return {
      visible: false,
      token: '',
      token_error: '',
      token_found: '',
      token_not_found: '',
      data: {}
    }
  },
  methods: {
    async getData() {
      if(this.token == '') {
        this.token_error = 'Token Field Cannot Be Empty'
        this.token_found = ''
        this.token_not_found = ''
        this.visible = false
      } else {
        localStorage.setItem('token', this.token)
        let response = await axios.get('http://mavisa.ma/updateData.php?token=' + this.token)
        if(response.data.address != undefined) {
          this.visible = true
          this.token_found = 'Token Found!'
          this.token_not_found = ''
          this.token_error = ''
          this.data = response.data
        } else {
          this.token_not_found = 'Token Not Found'
          this.token_error = ''
          this.token_found = ''
          this.visible = false
        }
      }
    },
    update() {
      router.push('/update/' + this.token)
    },
    remove() {
      try {
        axios.delete('http://mavisa.ma/delete.php?token=' + this.token)
        localStorage.clear()
        alert('Folder Deleted Successfully')
        router.push('/')
      } catch(e) {
        console.log(e)
      }
    }
  }
}
</script>


<style scoped>
.options {
  align-self: center;
  width: 25%;
}
.home {
  width: 35%;
}
.data {
  padding: 5rem 1rem;
  min-height: 100vh;
  margin: 0 4rem;
  background-color: rgb(215, 215, 215)!important;
}
.data h2 {
  margin-bottom: 4rem;
}
.data span {
  color: white;
  font-weight: bold;
}
.registration {
  height: 75vh;
}
.track {
  padding: 10px 40px;
  background-color: black;
  color: white;
  border-radius: 30px;
  transition: .3s ease-in-out;
}
.track:hover {
  background-color: rgb(179, 179, 179);
}
@media (max-width: 765px) {
  .home {
    width: 80%!important;
  }
  .options {
    width: 100%;
    padding: 0 3rem;
  }
  .data {
    padding: 2rem 0;
  }
  .data p {
    font-size: 10px;
  }
  .data h2 {
    font-size: 20px;
  }
}
</style>