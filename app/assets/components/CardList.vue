<template>
  <div>
    <div v-for="job in $root.jobs.items"  :key="job.id" class="card mt-3">
      <div class="card-header">
        <div class="card-header-title is-flex is-justify-content-space-between">
            <div>
            <i v-if="job.active" class='fas fa-person-running green-icon p-2'></i>
            <i v-else class="fas fa-stop red p-2"></i>
            {{ job.name}} [{{ job.url }}]
              <i class="p-2" style="color: red" @click="showSavedResponses = true ">Show saved responses</i>
            </div>
          <div >
          <button class="button"  @click="run(job.id)"><i class="fas fa-play"></i></button>
          <span v-if="showMore === job.id &&  showResult === null">
              <button class="button"  @click="showMore = null ; showResult = null">Cancel</button>
              <button class="button is-success"  @click="update(job)">Save</button>
          </span>
          <button class="button is-info"  @click="setShowMore(job.id)">...</button>
          </div>
        </div>
      </div>
      <div class="card-content">
        <div class="content columns m-2">
          <div class="collumn " v-for="(response , index) in job.responses" :key="index">
            <div class="p-2 has-text-centered fa-border" :class="{green : (response.code === 200 & response.result.length > 3),
                          yellow : (response.code === 200 & response.result.length <= 3),
                          red : (response.code !== 200)}"
            @click="changeShowResult(job.id , response.id)">
              <span style="color: #ffffff;">{{ response.code}}</span>
            </div>
            <div class="rotate-45" @click="changeShowResult(job.id , response.id)">{{ getDate(response.date)}}</div>
            </div>
        </div>
          <div v-if="showResult !== null & showMore === job.id">
            <show-result :job="job" :show-more="showMore" :show-result="showResult"></show-result>
            <!--buttons box for deleting-->
            <div class="is-flex is-justify-content-end">
                <button class="button is-danger m-2" @click="deleteJob(job.id)">
                  <i class="fas fa-trash-alt p-2"></i>Delete
                </button>
            </div>
          </div><!--v-if-->
          <div v-if="showMore === job.id & showResult === null" >
            <job-form :job="job" ></job-form>
          </div><!--v-if--->
          <div v-if="showSavedResponses">
            <show-responses :job_id="job.id"></show-responses>
          </div>
      </div>
    </div>
    <br/>
  </div>
</template>

<script>
import ShowResult from "./ShowResult";
import JobForm from "./JobForm";
import ShowResponses from "./ShowResponses";
export default {
  name: "CardList",
  data : () => {
    return {
      showResult: null,
      showMore: null,
      showSavedResponses: false,
    }
  },
  mixins:[ '_toast' , 'getJobs'],
  components:{ ShowResult , ShowResponses , JobForm},
  async beforeMount() {
    await this.getJobs()
   },

  methods:{
    changeShowResult(job_id ,  response_id) {
        if (response_id !== null){
          this.showMore = job_id
          this.showResult = response_id
          this.showSavedResponses = false;
      }
    },

    getDate(date){
      let d = new Date(date);
      return  d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " +
          d.getHours() + ":" + d.getMinutes();
    },
    setShowMore(id) {
      this.showResult = null;
      this.showMore = id
      this.showSavedResponses = false;
    },
    async run(id){
      let current = this;
      await axios.put(`/api/job/run/${id}`).then(
          res =>{
            current._toast(res.data.message ,'is-success' )
            current.$root.jobs = res.data.data
          },
          error => {
            current._toast(error.response.data.message ,'is-danger' )
          }
      )
      this.$nextTick();
    },
    async deleteJob(id){
     let current = this;
       await axios.delete('/api/job/' + id).then(
          res => {
            if(res.response) {
              current._toast(res.response.data.message, 'is-success')
              current.$root.jobs = res.response.data.data;
            }
               current.getJobs()
          },
          err => {
            current._toast(err.response.data.message , 'is-danger')
          }
      )
    },

    async update(job){
      let current = this
      delete job.responses; // that not needed
      await axios.patch(`api/job/${job.id}` , job).then(
          res => {
            if(res.data) {
              current._toast(res.data.message, 'is-success')
              current.$root.jobs = res.data.data;
              current.showMore = null;
            }
          },
          error =>{
            if(error.response) current._toast(error.response.data.message, 'is-danger')
            else current._toast("Oops : Something was wrong", 'is-danger')
          }
      )
    },
  }
}
</script>

<style scoped>
.red{
  background-color: red;
}

.yellow{
  background-color: yellow;
}
.green{
  background-color: green;
}

.green-icon{
  color: green;
}
.rotate-45 {
  transform: rotate(45deg);
  text-align: center;
  font-size: 13px;
  margin-top: 12px;
}
</style>
