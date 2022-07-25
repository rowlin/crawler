<template>
  <div class="mt-3">
    <h3>Sent responses list :</h3>
      <ul style="list-style: none">
        <li v-for="(resp , index)  in savedResponsesponses" class="is-hoverable">
          <span class="p-2">{{ index }}</span>
          <a :href="resp.name" target="_blank">{{ resp.name }}</a>
          <span  style="float: right"> <i class="fa fa-trash pointer" @click="deleteSavedResponses(resp.id)"></i></span>
        </li>
      </ul>
  </div>
</template>

<script>
export default {
  name: "ShowResponses",
  props: ['job_id'],
  data: () => {
    return {
     savedResponsesponses : []
    }
  },

  mounted() {
    this.getSavedResponses()
  },
  methods:{
    async getSavedResponses() {
      var current =  this;
      await axios.get('/api/responses/' + this.job_id).then(
          res => {
            current.savedResponsesponses = res.data;
          },
          err => {
            current._toast('Oops : something was wrong' , 'is-danger')
          }
      )
    },
    async deleteSavedResponses(id) {
      var current = this;
      await axios.delete('/api/responses/' + id).then(
          res => {
            current._toast(res.data.message, 'is-success')
            current.getSavedResponses();
          },
          err => {
            current._toast('Oops : Something was wrong', 'is-danger')
          }
      );
    }


  }
}
</script>

<style scoped lang="scss">


</style>
