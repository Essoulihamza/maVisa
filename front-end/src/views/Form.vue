<template>
  <div class="Form my-5">
    <h1>Reservation Form</h1>
  </div>
  <div class="px-4 px-lg-5 mt-5">
    <div class="form-wrapper gx-4 gx-lg-5 mb-5 bg-light rounded-4 p-5">
      <form class="container px-5" @submit.prevent="submitHandle()">
        <div class="row justify-content-between">
          <div class="col-lg-6 col-md-12">
            <div class="form-floating mb-3">
              <input class="form-control" type="text" v-model="data.nom_complet" />
              <label>Full Name:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="date" v-model="data.naissance" />
              <label>Birth Date:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="text" v-model="data.nationalite"/>
              <label>Nationality:</label>
            </div>
            <div class="form-floating mb-3">
              <select class="cpt-4 form-select form-control" aria-label="Default select" 
              v-model="data.situation">
                <option>Single</option>
                <option>Married</option>
                <option>Widow</option>
              </select>
              <label>Familial Situation:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="email" v-model="data.address" />
              <label>Email:</label>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-floating mb-3">
              <select class="cpt-4 form-select form-control" aria-label="Default select" v-model="data.type_visa">
                <option>Long Stay Visa</option>
                <option>Long Short Visa</option>
              </select>
              <label>Visa Type:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="date" v-model="data.date_depart"/>
              <label>Start Date:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="date" v-model="data.date_arriver" />
              <label>End Date:</label>
            </div>
            <div class="form-floating mb-3">
              <select class="cpt-4 form-select form-control" aria-label="Default select" 
              v-model="data.type_document">
                <option>Identity Card</option>
                <option>Passport</option>
              </select>
              <label>Document Type:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="number" v-model="data.numero_document"/>
              <label>Document Number:</label>
            </div>
          </div>
          <div class="submit mt-5">
            <button>Reserve</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import router from "../router";
import axios from "axios";

export default {
  data() {
    return {
      data: {},
    };
  },
  methods: {
    async submitHandle() {
      try {
        let response = await axios.post("http://mavisa.ma/create.php",this.data, {
            headers: {
              "Accept": "Application/json",
            },
          }
        );
        if(response.data.errors != undefined) {
          alert(response.data.errors.join('\n'))
          return;
        } else if(response.data.message == 'Missing Required Fields') {
          alert(response.data.message)
          return
        } 
        localStorage.setItem("token", response.data.token);
        console.log(response)
        router.push("/token");
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style>
h1 {
  margin-top: 6rem;
}
button {
  padding: 10px 50px;
  background-color: rgb(88, 88, 88);
  transition: 0.5s ease-in-out;
  color: #fff;
  margin-top: 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background: rgb(116, 116, 116);
}
.submit {
  text-align: center;
}
.token-p {
  padding: 8px 0;
  background-color: green;
}
</style>