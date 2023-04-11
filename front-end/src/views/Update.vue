<template>
  <div class="Form my-5">
    <h1 class="fs-2">Update Personal Informations:</h1>
  </div>
  <div class="px-4 px-lg-5 mt-5">
    <div class="form-wrapper gx-4 gx-lg-5 bg-light rounded-4 p-5">
      <form class="container px-5" @submit.prevent="submitHandle()">
        <div class="row justify-content-between">
          <div class="col-lg-6 col-md-12">
            <div class="form-floating mb-3">
              <input class="form-control" type="text" v-model="data.nom_complet"/>
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
              <select class="form-select form-control" aria-label="Default select" v-model="data.situation">
                <option>Single</option>
                <option>Married</option>
                <option>Widow</option>
              </select>
              <label>Familial Situation:</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" type="email" v-model="data.address"/>
              <label>Email:</label>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-floating mb-3">
              <select class="form-select form-control" aria-label="Default select" v-model="data.type_visa">
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
              <input class="form-control" type="date" v-model="data.date_arriver"/>
              <label>End Date:</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select form-control" aria-label="Default select" v-model="data.type_document">
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
        </div>
      </form>
      <h1 class="mb-3 fs-2">Update Resevation Dates:</h1>
      <p class="fs-5 text-center">Old Reservation Date: <span class="fw-bold">{{ data.reservation_date }}</span></p>
      <div class="d-flex flex-column bg-light rounded p-5 g-4">
        <div class="calender w-100 p-5 border rounded-3">
          <FullCalendar :options='calendarOptions' />
        </div>
        <div class="w-100 p-5 d-flex flex-column align-items-center">
          <h2 class="mb-5">Choose A Timing:</h2>
          <div class="form-floating w-50">
            <select class="form-select form-control" aria-label="Default select" v-model="selected_time">
              <option v-for="time in filtered_times" :key="time.id">{{ time }}</option>
            </select>
            <label>Type de Chambre</label>
          </div>
        </div>
      </div>
      <div>
        <button class="check btn py-1 px-4 rounded-3 fs-5 mb-3" @click="check()" v-if="check_visibility">Check</button>
        <button class="check btn py-1 px-4 rounded-3 fs-5 mb-3" @click="update()" v-if="update_visibility">Update</button>
      </div>
    </div>
  </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import axios from 'axios'
import router from '@/router'

export default {
  data() {
    return {
      check_visibility: true,
      update_visibility: false,
      data: {},
      token: "",  
      selected_time: '',
      time: '',
      times: ["08:30-10:00", "10:30-12:30", "02:30-04:00", "04:30-06:30"],
      filtered_times: [],
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        weekends: false,
        events: [],
        selectable: true    ,
        dateClick: async (info) => {
          localStorage.setItem("date", info.dateStr);
          await axios.get("http://mavisa.ma/reservation_filter.php?date=" + info.dateStr)
          .then((response) => {
            if (response.data != 0) {
              this.filtered_times.length = 0
              this.filtered_times = this.filtered_times.concat(
                this.times.filter((time) => !response.data.includes(time))
              );
              console.log(this.filtered_times);
            } else {
              console.log("this day contain no reservations");
              this.filtered_times = this.times.slice()
            }
          });
        },
        validRange: function(currentDate) {
          var startDate = new Date(currentDate.valueOf())
          var endDate = new Date(currentDate.valueOf())
          endDate.setMonth(endDate.getMonth() + 3)
          return {
            start: startDate,
            end: endDate
          }
        },
      }
    }
  },
  components: {FullCalendar},
  async mounted() {
    this.fetch_events()
    this.token = this.$route.params.token
    let temp = await axios.get('http://mavisa.ma/updateData.php?token=' + this.token)
    this.data = temp.data
    console.log(this.data)
  },
  methods: {
    async fetch_events() {
      await axios.get("http://mavisa.ma/getEvents.php")
      .then((response) => {
        this.calendarOptions.events = response.data.dates;
      });
    },
    async check() {
      let response = await axios.get('http://mavisa.ma/reservation_filter.php?date=' + this.data.reservation_date)
      if(response.data.message == "Missing Required Fields" || response.data.message == 'invalid reservation date') {
        console.log(response)
        alert('Missing Required Fields')
      } else {
        this.check_visibility = false
        this.update_visibility = true
      }
    },
    async update()  {
      if(localStorage.getItem('date') != undefined) {
        this.data.reservation_date = localStorage.getItem('date')
      }
      try {
        this.data.reservation_date = this.selected_time
        let res = await axios.put('http://mavisa.ma/update.php?token=' + this.token, this.data)
        console.log(res)
        if(res.data.errors != undefined) {
          alert(res.data.errors.join('\n'))
        } else if(res.data.message == 'Missing Required Fields') {
          alert(res.data.message)
        } else if(res.data.message == 'Post Updated Successfully') {
          alert('Updated Successfully')
          router.push("/")
        }
      } catch(e) {
        console.log(e)
      }
    }
  }
}
</script>