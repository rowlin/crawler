<template>
    <div class="modal" :class="{'is-active' : active}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ title }}</p>
          <button class="delete modal-close-btn" @click="closeModal" aria-label="close"> X</button>
        </header>
        <section class="modal-card-body">
          <div>
            <label for="select_template">Select Template</label>
            <select id="select_template" class="input"  @change="selectTemplate" v-model="current_template" >
              <option :value="null" >Create new Template</option>
              <option v-for="(template , index)  in $root.templates" :value="template.id" :key="index">
                {{ template.name}}
              </option>
            </select>
          </div>


          <div>
            <label for="name">Name</label>
            <input type="text" id="name" class="input" v-model="template.name">
          </div>
          <div v-if="hasError('name')">
            <sup class="red" >{{ getErrorMessage('name') }}</sup>
          </div>

          <label for="my-editor">Code</label>
          <div class="mb-5" ref="box">
            <prism-editor id="my-editor" class="height-200 input" :width="matchWidth" v-model="template.code" :highlight="highlighter" line-numbers></prism-editor>
            <div v-if="hasError('code')">
              <sup class="red" >{{ getErrorMessage('code') }}</sup>
            </div>
          </div>


          <div class="columns">
            <button type="button" class="button m-2 is-half" @click="closeModal">
              Cancel
            </button>



            <button type="button" v-if="current_template !== null" @click="updateTemplate" class="button m-2 is-primary">
              Update
            </button>

            <button type="button" v-if="current_template === null" @click="createNewTemplate" class="button m-2 is-primary">
              Create
            </button>

          </div>

        </section>
      </div>
    </div><!--active-->
</template>

<script>
import { PrismEditor } from 'vue-prism-editor';
import 'vue-prism-editor/dist/prismeditor.min.css'; // import the styles
import { highlight, languages } from 'prismjs';
import 'prismjs/components/prism-clike';
import 'prismjs/components/prism-javascript';
import 'prismjs/themes/prism-tomorrow.css'; // import syntax highlighting styles
export default {
  name: "ModalTemplates",
  created(){
    this.getTemplates();
  },
  data: () =>{
    return{
      current_template : null,
      error:[],
      template: {
        code : "",
        name : ""
      }
    }
  },
  mounted() {
    this.error =[];
  },
  props:['active'  , 'title'],
  components:{PrismEditor},
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
    highlighter(code) {
      return highlight(code, languages.js); // languages.<insert language> to return html with markup
    },
    matchWidth() {
      this.width =  this.$refs.box.clientWidth + 'px';
    },
    getTemplates(){
      let current = this;
      axios.get('/api/templates' ).then(
         res => {
           current.$root.templates = res.data;
         }
      )
    },
    async createNewTemplate(){
      let  current  = this;
      await axios.post('/api/templates' , this.template).then(
          res => {
            current._toast( res.data.message , 'is-success')
            current.getTemplates();
          },
          err => {
            current.error = err.response.data.details.violations;
            current._toast( err.response.data.message , 'is-danger')
          }
      )

    },
    async deleteTemplate(){
      let  current  = this;
      await axios.delete('/api/template/' + this.current_template).then(
          res => {
            current._toast( res.data.message , 'is-success')
            current.getTemplates();
          },
          err => {
            current._toast( err.response.data.message , 'is-danger')
          }
      )

    },
    selectTemplate(){
      if(this.current_template === null){
        this.template = {
          code : "" ,
          name : ""
        }
      }else{
        this.template = this.$root.templates.find(el => el.id  === this.current_template)
      }
    },
    async updateTemplate(){
      let  current  = this;
      await axios.patch('/api/template/' + this.current_template  , this.template).then(
          res => {
            current._toast( res.data.message , 'is-success')
            current.getTemplates();
          },
          err => {
            current.error = err.response.data.details.violations;
            current._toast( err.response.data.message, 'is-danger')
          }
      )
    },
    closeModal(){
      this.$emit('closeModal');
    },

    hasError(name){
      if(this.error.length > 0 && this.error.find(data => data.field === name)) return true
      else return false
    },

    getErrorMessage(name) {
      if(this.error.length > 0 && this.error.find(data => data.field === name))
        return  this.error.find(data => data.field === name).message
    }

  }

}
</script>

<style scoped>


</style>
