<template>
  <div>
    <div v-for="job in $root.jobs.items"  :key="job.id" class="card mt-3">
      <div class="card-header">
        <div class="card-header-title is-flex is-justify-content-space-between">
            <div>
            <i v-if="job.active" class='fas fa-person-running green-icon p-2'></i>
            <i v-else class="fas fa-stop red p-2"></i>
            {{ job.name}} [{{ job.url }}]
            </div>
            <div v-if="showMore !== job.id &&  showResult === null">
              <button class="button"  @click="run(job.id)"><i class="fas fa-play"></i></button>
              <button class="button is-info"  @click="setShowMore(job.id)">...</button>
            </div>
            <div v-else>
              <button class="button"  @click="showMore = null ; showResult = null">Cancel</button>
              <button class="button is-success"  @click="update(job)">Save</button>
            </div>
        </div>
      </div>
      <div class="card-content">
        <div class="content columns m-2">
          <div class="collumn " v-for="(response , index) in job.responses" :key="index">
            <div class="p-2 has-text-centered" :class="{green : (response.code === 200 & response.result.length > 3),
                          yellow : (response.code === 200 & response.result.length <= 3),
                          red : (response.code !== 200)}"
            @click="changeShowResult(job.id , response.id)"
            >
              {{ response.code}}
            </div>
            <div class="rotate-45" @click="changeShowResult(job.id , response.id)">{{ getDate(response.date)}}</div>
            </div>
        </div>

          <div v-if="showResult !== null & showMore === job.id">
              <pre>
                {{ result }}
              </pre>
          </div>
          <div  v-if="showMore === job.id & showResult === null" >
            <label for="name">Name:</label>
            <input type="text" id="name" class="input" v-model="job.name">
            <label for="url">Url:</label>
            <input type="text" id="url" class="input" v-model="job.url">
            <div class="columns">
              <div class="column">
                <label for="active" class="checkbox">Active</label>
                <input type="checkbox" id="active" v-model="job.active">
                <br>
                <label for="cron">Cron:</label>
                <input type="text" class="input" id="cron" v-model="job.cron">

              </div>
              <div class="column">
                  <img src="/images/cron.png" alt="Crontab example">
              </div>
            </div>

            <div class="columns" >
                 <div class="column">
                  <label for="bot_notify">Bot for  notify</label>
                  <select  id="bot_notify" class="input" v-model="job.channel.bots.id">
                    <option value="" >Select bot</option>
                    <option v-for="(bot , index)  in $root.bots" :key="index" :value="bot.id">
                      {{ bot.name }}
                    </option>
                  </select>
                 </div>
                  <div class="column">
                  <label for="channel_notify">Channel for notify</label>
                  <select  id="channel_notify" v-model="job.channel.channels.id" class="input">
                    <option value="">Select channel</option>
                    <option v-for="(channel , index)  in $root.channels" :key="index" :value="channel.id">
                      {{ channel.name }}
                    </option>
                  </select>
                  </div>
              </div>
          </div>

        <div v-if="showMore === job.id & showResult === null "  ref="box" >
          <prism-editor id="my-editor" :width="matchWidth" v-model="job.code" :highlight="highlighter" line-numbers></prism-editor>
          <div class="is-flex is-justify-content-end">
            <button class="button is-danger m-2" @click="deleteJob(job.id)">
              <i class="fas fa-trash-alt p-2"></i>Delete
            </button>
          </div>
        </div>
      </div>
    </div>
    <br/>
  </div>
</template>

<script>
import { PrismEditor } from 'vue-prism-editor';
import 'vue-prism-editor/dist/prismeditor.min.css'; // import the styles

import { highlight, languages } from 'prismjs';
import 'prismjs/components/prism-clike';
import 'prismjs/components/prism-javascript';
import 'prismjs/themes/prism-tomorrow.css'; // import syntax highlighting styles
export default {
  name: "CardList",
  data : () => {
    return {
      showResult:null,
      showMore: null,
      width: '1040px',
    }
  },
  mixins:[ '_toast' , 'getJobs'],
  components:{PrismEditor},
  async mounted() {
    await this.getJobs()
   },
  computed:{
    result(){
      if(this.showMore && this.showResult)
        try {
        let res =  JSON.stringify(JSON.parse(this.$root.jobs.items.find(e => e.id === this.showMore)
              .responses.find(r => r.id === this.showResult).result), null, 2)
          if(typeof res === 'undefined'){
            res = this.$root.jobs.items.find(e => e.id === this.showMore)
                .responses.find(r => r.id === this.showResult).result;
          }
            return  res;
        }catch(e){
          if(typeof e.message !== 'undefined')
            return  e.message ;
          else return  'Parse error';
        }
    }

  },
  methods:{
    highlight(code) {
      return highlight(
          code,
          {
            ...languages['markup'],
            ...languages['js'],
            ...languages['css'],
          },
          'markup'
      )
    },
    matchWidth() {
      this.width =  this.$refs.box.clientWidth + 'px';
    },
    highlighter(code) {
      return highlight(code, languages.js); // languages.<insert language> to return html with markup
    },
    changeShowResult(job_id ,  response_id) {
        if (response_id !== null){
          this.showMore = job_id
          this.showResult = response_id
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
            else
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
