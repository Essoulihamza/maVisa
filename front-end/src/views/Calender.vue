<template>
  <div class="container p-5 mt-5">
    <div>
      <h1 class="mb-5">Reservation Form:</h1>
      <div class="d-flex flex-column bg-light rouned p-5 g-4">
        <div class="calender w-100 p-5 border rounded-3">
          <FullCalendar :options="calendarOptions" />
        </div>
        <div class="w-100 p-5 d-flex flex-column align-items-center">
          <h2 class="mb-5">Choose A Timing:</h2>
          <div class="form-floating mb-3 w-50">
            <select class="form-select form-control" aria-label="Default select" v-model="selected_time">
              <option v-for="time in filtered_times" :key="time.id">{{ time }}</option>
            </select>
            <label>type de chambre</label>
          </div>
        </div>
      </div>
      <div>
        <button class="check btn py-2 px-5 rounded-3 fs-4 mx-3" @click="submit()">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";
import router from "@/router";

export default {
  data() {
    return {
      selected_time: '',
      time: '',
      times: ["08:30-10:00", "10:30-12:30", "02:30-04:00", "04:30-06:30"],
      filtered_times: [],
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        selectable: true,
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
        validRange: function (currentDate) {
          var startDate = new Date(currentDate.valueOf());
          var endDate = new Date(currentDate.valueOf());

          endDate.setMonth(endDate.getMonth() + 3);

          return {
            start: startDate,
            end: endDate,
          };
        },
        initialView: "dayGridMonth",
        weekends: false,
        events: [],
      },
    };
  },
  components: { FullCalendar },
  methods: {
    async submit() {
      let reservation_data = {
        id_client: localStorage.getItem('id'),
        reservation_date: localStorage.getItem("date"),
        reservation_time: this.selected_time
      }
      let response = await axios.post("http://mavisa.ma/reservation.php", reservation_data)
      console.log(response)
      if(response.data.message == 'Missing Required Fields') {
        alert('Missing Required Fields')
        return
      } else {
        router.push('/')
      }
    },
    async fetch_events() {
      await axios.get("http://mavisa.ma/getEvents.php")
        .then((response) => {
          this.calendarOptions.events = response.data.dates;
        });
    },
  },
  mounted() {
    this.fetch_events();
  },
};
</script>

<style>
.check {
  margin-top: 20px;
  padding: 0.4rem 2rem;
  background-color: rgb(66, 66, 66);
  transition: 0.5s ease-in-out;
  color: #fff;
}
.check:hover {
  background-color: rgb(0, 0, 0);
  color: white;
}
.calender {
  color: #000000;
  background-color: white;
  font-family: "Roboto", sans-serif;
}
.calender a {
  text-decoration: none !important;
  color: black !important;
  align-self: center;
  justify-self: center;
}
</style>