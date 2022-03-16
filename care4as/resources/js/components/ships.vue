<template>
    <div class="container unit-translucent p-2">
        <div class="row justify-content-center" v-if="this.avatar != 0">
            <div class="col-md-8">
              <div class="row">
                <h5>Schiffe versenken</h5>
              </div>
            </div>
        </div>
        <div class="row justify-content-center" v-else>
          <div class="col-8 center_items">
            <h5>Erstelle deinen Avatar</h5>
          </div>
          <div class="col-8">
            <div class="row center_items" style="height: auto;">
              <div class="col-12 center_items">
                <div class="wrapper1">
                  <label for="name">
                    Name</label><br>
                  <input type="text" name="Name" v-model="name" value="" id="name"><br>
                  <label for="motto">Motto</label><br>
                  <input type="motto" name="Motto" value="" v-model="motto" id="motto">
                </div>
              </div>
              <div class="col-12 center_items ">
                  <div class="wrapper1 p-4">
                    <label class="" for="pic">
                      <div class="border-white p-2 center_items text-center position-relative" style="height: 11em; width: 11em; border-radius:5%;">
                        <img src="https://www.nicepng.com/png/detail/741-7413169_placeholder-female.png" id="avatarPicMenu" class="position-absolute h-100 w-100" alt="Placeholder">
                        <p class="position-absolute text-dark">Wähle dein Bild</p>
                      </div>
                    </label>
                    <input type="file" name="Picture" value="" id="pic" style="display:none;" accept=".png,.jpg,.jpeg" @change="loadPreview($event)">
                  </div>
              </div>
            </div>
            <div class="row align-self-center">
              <div class="col-12 center_items ">
                  <div class="wrapper1">
                    <button type="button" name="button" class="btn-primary btn-sm btn-block p-2" @click="createUser()">Daten absenden</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

</template>

<script>
    export default {
      data(){
        return{
          user: '',
          data: null,
          isHidden: false,
          timer: '',
          avatar: 0,
          name:'aaa',
          motto:'bbb',
          host: window.location.host,
        }
      },
      mounted() {
          var self = this;
          console.log('Ships Component mounted.')

          setInterval(function()
          {

          }, 100);
        },
        methods:{
          createUser(){
            var host = window.location.host;
            console.log('createuser')

            var formData = new FormData();

            formData.append('name',this.name)
            formData.append('motto', this.motto)

            if(document.getElementById("pic").files.length > 0 )
            {
              let image = $('#pic').prop('files')[0];
              // console.log(image)
              formData.append('file', image)
            }

            axios.post('http://'+host+'/care4as/care4as/public/shipz/createUser', formData,{
            headers: {
              'Content-Type': 'multipart/form-data'
            }})
             .then(response => {
               this.avatar = 1
             })
             .catch(error => {
               console.error(error.response);
             });
          },
          loadPreview(event){
            let preview = $('#avatarPicMenu')
            // console.log(preview)
            let imgsrc = URL.createObjectURL(event.target.files[0]);
            preview.attr("src",imgsrc);
            preview.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
              }
          },
        }
    }
</script>
