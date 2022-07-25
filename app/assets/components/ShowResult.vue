<template>
<div>
  <div class="columns">
    <div class="column is-three-quarters">
                <pre>
                  {{ result }}
                </pre>
    </div>
    <div class="column">
      <label>Sense : </label>
      <div class="field p-1"  v-for="(sense , index) in job.senseblacklist" :key="index">
        <div v-if="sense.id" >
          <input type="text" class="input is-small" style="width: 80%;" @change="toUpdate.push(index)" v-model="sense.sense">
          <i class="fa fa-check pointer" v-if="toUpdate.includes(index)" title="Update" @click="updateSense(sense)" ></i>
          <i class="fa fa-trash pointer" v-else title="Delete" @click="deleteSense(sense.id)" ></i>
        </div>
        <div v-else>
          <input type="text" class="input is-small" style="width: 80%;"  v-model="job.senseblacklist[index].sense">
          <i class="fa fa-check pointer green" title="Save"  @click="attachSense(job.id  , job.senseblacklist[index]  )" ></i>
        </div>
      </div><!--is-grouped-->
      <div class="p-2" @click="addSense(job.id)" >
        <i class="fa fa-circle blue" ></i> Add fsense
      </div>
    </div>
  </div><!--.columns-->
</div>
</template>

<script>
export default {
  name: "ShowResult",
  props:['job' , 'showMore' , 'showResult'],
  data : () => {
    return {
      toUpdate:[],
    }
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
    addSense(){
      let res = this.$root.jobs.items.find(e => e.id === this.showMore)
      if(res.senseblacklist){
        res.senseblacklist.push({name: ""})
      }
    },
    async updateSense(sense){
      let current = this
      await axios.post(`api/sense/${sense.id}` , sense).then(
          res => {
            if(res.data) {
              current._toast(res.data.message, 'is-success')
            }
          },
          error =>{
            if(error.response) current._toast(error.response.data.message, 'is-danger')
            else current._toast("Oops : Something was wrong", 'is-danger')
          }
      )
    },
    async deleteSense(id){
      let current = this
      await axios.delete(`api/sense/${id}` ).then(
          res => {
            if(res.data) {
              current._toast(res.data.message, 'is-success')
              current.getJobs()
            }
          },
          error =>{
            if(error.response) current._toast(error.response.data.message, 'is-danger')
            else current._toast("Oops : Something was wrong", 'is-danger')
          }
      )
    },
    async attachSense(job_id ,  sense){
      let current = this
      await axios.put(`api/sense/${job_id}` , sense).then(
          res => {
            if(res.data) {
              current._toast(res.data.message, 'is-success');
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

<style scoped >



</style>
