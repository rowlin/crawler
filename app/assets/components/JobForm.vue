<template>
  <div>
    <div class="columns pt-2">
    <div class="column">
        <label for="name">Name:</label>
        <input type="text" id="name" class="input" v-model="job.name">
      </div>
      <div class="column">
        <label for="url">Url:</label>
        <input type="text" id="url" class="input" v-model="job.url">
      </div>
    </div>
      <div class="columns pt-1">
      <div class="column">
        <label for="cron">Cron:</label>
        <input type="text" class="input" id="cron" v-model="job.cron">

        <div class="columns pt-2">
          <div class="column">
            <label for="max_count">Max Count</label>
            <input type="text" class="input" id="max_count"  v-model="job.maxCount">
          </div>
          <div class="column pt-1">
            <div class="column">
              <label for="active" class="checkbox">Active</label>
              <input type="checkbox" id="active" v-model="job.active">
              <br>
              <label for="max_count">Show dublicate</label>
              <input type="checkbox" id="show_dublicate" class="checkbox"  v-model="job.showDublicate" :checked="job.showDublicate">
            </div>
          </div>
        </div>
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
    </div><!--columns-->

    <select class="select m-1" v-model="choose_template" @change="chooseTemplate()"  >
      <option value='' >Select Template </option>
      <option v-for="(template , index ) in $root.templates" :value="template.id" :key="index">
        {{ template.name}}
      </option>
    </select>
    <div class="container" ref="box">
      <prism-editor id="my-editor" :width="matchWidth"  v-model="job.code" :highlight="highlighter" line-numbers></prism-editor>
    </div>
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
  name: "JobForm",
  props: ['job'],
  components: {PrismEditor },
  data: () =>{
    return {
      choose_template : null,
      width: '1040px',
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
      chooseTemplate(){
        if(this.choose_template != null){
          this.job.code = this.$root.templates.find( el => ( el.id === this.choose_template))?.code;
        }
      }
  }
}
</script>

<style scoped>

</style>
