<template>
  <div class="container-fluid f2" style="margin-top: -1.5rem;">

    <!-- Filter -->
    <div class="row center_items mt-4">
      <div class="col-10 m-0 p-0 bg-light" style="border-radius: 5px; font-family: 'Radio Canada', sans-serif !important;">
        <div style="display: flex; flex-wrap: column; margin: 15px; font-size: 1.6rem; color: black">
          <div style="font-weight: bold">
            Ansicht:
          </div>
          <div>
            <label for="team_selection"></label>
            <select @change="getUserData('Mobile')" name="team_selection" id="team_selection" class="custom_select" style="color: #495057;">
                <option value="all" style="font-size: 1rem;">Projekt</option>
                <option value="Daniel" style="font-size: 1rem;">Team Daniel</option>
                <option value="Frank" style="font-size: 1rem;">Team Frank</option>
                <option value="Sandra" style="font-size: 1rem;">Team Sandra</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="row center_items mt-4">
      <div class="col-10 m-0 p-0 bg-light" style="border-radius: 5px">
        <div class="row m-0">
          <div class="col-md-3 p-0">
            <div class="shadow" style="border-radius: 5px; margin: 15px; padding: 15px; background-color: #ffffff;">
              <div style="display:flex; height: 120px">
                <div style="flex-grow:1; display: flex; flex-direction: column;">
                  <div style="font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.6rem;">SSC</div>
                  <div style="font-family: 'Radio Canada', sans-serif; font-size: 1.3rem; font-weight: 300; display: grid; grid-template-columns: auto 1fr; column-gap: 15px; margin-top: auto; margin-bottom: auto;">
                    <div>Calls:</div>
                    <div>{{sscCalls}}</div>
                    <div>Saves:</div>
                    <div>{{sscSaves}}</div>
                  </div>
                </div>
                <div style="height: 100%; position: relative; display: inline-flex;">
                    <svg viewBox="0 0 1 1" style="width: 100%; height: 100%;"></svg>
                    <div v-bind:class= "[this.sscCR > 51.7 ? 'good-cr' : 'bad-cr']" style="border-radius: 100px; text-align: center; position: absolute; top:0; left:0; bottom:0; right:0; display: flex;">
                      <div style="margin: auto; font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.2em;">
                        {{sscCR }}%
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


          <!-- bsc cr -->
          <div class="col-md-3 p-0">
            <div class="shadow" style="border-radius: 5px; margin: 15px; padding: 15px; background-color: #ffffff;">
              <div style="display:flex; height: 120px">
                <div style="flex-grow:1; display: flex; flex-direction: column;">
                  <div style="font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.6rem;">BSC</div>
                  <div style="font-family: 'Radio Canada', sans-serif; font-size: 1.3rem; font-weight: 300; display: grid; grid-template-columns: auto 1fr; column-gap: 15px; margin-top: auto; margin-bottom: auto;">
                    <div>Calls:</div>
                    <div>{{bscCalls}}</div>
                    <div>Saves:</div>
                    <div>{{bscSaves}}</div>
                  </div>
                </div>
                <div style="height: 100%; position: relative; display: inline-flex;">
                    <svg viewBox="0 0 1 1" style="width: 100%; height: 100%;"></svg>
                    <div v-bind:class= "[this.bscCR > 20 ? 'good-cr' : 'bad-cr']" style="border-radius: 100px; text-align: center; position: absolute; top:0; left:0; bottom:0; right:0; display: flex;">
                      <div style="margin: auto; font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.2em;">
                        {{bscCR}}%
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


          <!-- portale cr -->
          <div class="col-md-3 p-0">
            <div class="shadow" style="border-radius: 5px; margin: 15px; padding: 15px; background-color: #ffffff;">
              <div style="display:flex; height: 120px">
                <div style="flex-grow:1; display: flex; flex-direction: column;">
                  <div style="font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.6rem;">Portale</div>
                  <div style="font-family: 'Radio Canada', sans-serif; font-size: 1.3rem; font-weight: 300; display: grid; grid-template-columns: auto 1fr; column-gap: 15px; margin-top: auto; margin-bottom: auto;">
                    <div>Calls:</div>
                    <div>{{portalCalls}}</div>
                    <div>Saves:</div>
                    <div>{{portalSaves}}</div>
                  </div>
                </div>
                <div style="height: 100%; position: relative; display: inline-flex;">
                    <svg viewBox="0 0 1 1" style="width: 100%; height: 100%;"></svg>
                    <div v-bind:class= "[this.portalCR > 60 ? 'good-cr' : 'bad-cr']" style="border-radius: 100px; text-align: center; position: absolute; top:0; left:0; bottom:0; right:0; display: flex;">
                      <div style="margin: auto; font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.2em;">
                        {{portalCR}}%
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <!-- optin quote -->
          <div class="col-md-3 p-0">
            <div class="shadow" style="border-radius: 5px; margin: 15px; padding: 15px; background-color: #ffffff;">
              <div style="display:flex; height: 120px">
                <div style="flex-grow:1; display: flex; flex-direction: column;">
                  <div style="font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.6rem;">Optin </div>
                  <div style="font-family: 'Radio Canada', sans-serif; font-size: 1.3rem; font-weight: 300; display: grid; grid-template-columns: auto 1fr; column-gap: 15px; margin-top: auto; margin-bottom: auto;">
                    <div>Calls:</div>
                    <div>{{calls}}</div>
                    <div>Optin:</div>
                    <div>{{optin}}</div>
                  </div>
                </div>
                <div style="height: 100%; position: relative; display: inline-flex;">
                    <svg viewBox="0 0 1 1" style="width: 100%; height: 100%;"></svg>
                    <div v-bind:class= "[this.optinQuota > 51.7 ? 'good-cr' : 'bad-cr']" style="border-radius: 100px; text-align: center; position: absolute; top:0; left:0; bottom:0; right:0; display: flex;">
                      <div style="margin: auto; font-family: 'Radio Canada', sans-serif; font-weight: bold; font-size: 1.2em;">
                        {{optinQuota}}%
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Agl  -->
        <div class="row m-0" style="margin-top: 15px !important; margin-bottom: 15px !important;">
          <div class="col-md-6">
            <div class="bg-white shadow" style="border-radius: 5px;">
              <div class="row center_items">
                <div style="margin-top: 15px; font-family: 'Radio Canada', sans-serif; font-size: 1.6rem; font-weight: bold">Angebotsleiter</div>
              </div>
              <div class="row center_items">
                <div class="d-flex center_items " id="aglchartcontainer" style="width: 100%;height: 300px; margin: 15px;">
                  <canvas id="aglChart" style="width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- top 5 -->
          <div class="col-6">
            <div class="bg-white shadow" style="border-radius: 5px; height: 100%; display: flex; flex-direction: column;">
              <div class="row center_items">
                <div style="margin-top: 15px; font-family: 'Radio Canada', sans-serif; font-size: 1.6rem; font-weight: bold">Top 5 SSC Impact</div>
              </div>
              <div class="row center_items;" style="display: flex; flex-direction: column; align-content: center; flex-grow: 1; justify-content: space-around; text-align: center; font-family: 'Radio Canada', sans-serif;">
                  <div style="color: #C9B037; text-shadow: -1px -1px 0 #000, 0 -1px 0 #000, 1px -1px 0 #000, 1px 0 0 #000, 1px 1px 0 #000, 0 1px 0 #000, -1px 1px 0 #000, -1px 0 0 #000; font-size: 2.4rem;" v-if="this.top5user.length > 0"><i class="fas fa-crown"></i> {{top5user[0]['surname']}} {{top5user[0]['lastname']}} ({{top5user[0]['ssc_impact'].toFixed(1).replace(".", ',')}}%)</div>
                  <div style="color: #B4B4B4; text-shadow: -1px -1px 0 #000, 0 -1px 0 #000, 1px -1px 0 #000, 1px 0 0 #000, 1px 1px 0 #000, 0 1px 0 #000, -1px 1px 0 #000, -1px 0 0 #000; font-size: 2.1rem" v-if="this.top5user.length > 1"><i class="fas fa-trophy"></i> {{top5user[1]['surname']}} {{top5user[1]['lastname']}} ({{top5user[1]['ssc_impact'].toFixed(1).replace(".", ',')}}%)</div>
                  <div style="color: #AD8A56; text-shadow: -1px -1px 0 #000, 0 -1px 0 #000, 1px -1px 0 #000, 1px 0 0 #000, 1px 1px 0 #000, 0 1px 0 #000, -1px 1px 0 #000, -1px 0 0 #000; font-size: 1.8rem" v-if="this.top5user.length > 2"><i class="fas fa-trophy"></i> {{top5user[2]['surname']}} {{top5user[2]['lastname']}} ({{top5user[2]['ssc_impact'].toFixed(1).replace(".", ',')}}%)</div>
                  <div style="color: #4ca1af; text-shadow: -1px -1px 0 #000, 0 -1px 0 #000, 1px -1px 0 #000, 1px 0 0 #000, 1px 1px 0 #000, 0 1px 0 #000, -1px 1px 0 #000, -1px 0 0 #000; font-size: 1.5rem" v-if="this.top5user.length > 3"><i class="fas fa-medal"></i> {{top5user[3]['surname']}} {{top5user[3]['lastname']}} ({{top5user[3]['ssc_impact'].toFixed(1).replace(".", ',')}}%)</div>
                  <div style="color: #4ca1af; text-shadow: -1px -1px 0 #000, 0 -1px 0 #000, 1px -1px 0 #000, 1px 0 0 #000, 1px 1px 0 #000, 0 1px 0 #000, -1px 1px 0 #000, -1px 0 0 #000; font-size: 1.5rem" v-if="this.top5user.length > 4"><i class="fas fa-medal"></i> {{top5user[4]['surname']}} {{top5user[4]['lastname']}} ({{top5user[4]['ssc_impact'].toFixed(1).replace(".", ',')}}%)</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="row mt-4 center_items " style="">
      <!-- liveticker -->
      <div class="col-10 p-0 bg-light center_items " style="border-radius: 5px;">
        <div class="col-md bg-white shadow" style="margin: 15px; border-radius: 5px;">
          <div class="row center_items">
            <div style="margin-top: 15px; font-family: 'Radio Canada', sans-serif; font-size: 1.6rem; font-weight: bold">Liveticker (Daten noch aus KDW Tool)</div>
          </div>
          <div class="row center_items">
            <div class="d-flex center_items " id="chartcontainer" style="width: 100%; height: 400px; margin:15px;">
              <canvas id="dailyQuota" style="width: 100%; height: 100% !important"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- performance table -->
      <div class="col-10 p-0 bg-light center_items " style="border-radius: 5px; margin-top:1.5rem;">
        <div class="col-md bg-white shadow " style="margin: 15px; border-radius: 5px;">
          <div class="row center_items">
            <div style="margin-top: 15px; font-family: 'Radio Canada', sans-serif; font-size: 1.6rem; font-weight: bold">Performance</div>
          </div>
          <div class="row center_items">
            <div style="width: 100%;">
              <table style="width: 100%; margin-top: 15px; margin-bottom: 15px;font-family: 'Radio Canada', sans-serif; text-align: center; border-collapse: collapse !important; border-radius: 0pxb; !important; border: 2px solid #2c3e50; font-weight: 300; font-size: 1.3rem" id="ptable" v-if="this.department == 'Mobile'">
               <tr style="background-color: #4ca1af; color: #2c3e50">
                 <th @click="sorted('surname')"  rowspan="2" style="cursor:pointer; text-align: left; border-bottom: 2px solid #2c3e50; border-right: 2px dotted #2c3e50;">Benutzer</th>
                 <th colspan="4" style="border-right: 2px dotted #2c3e50;">Smallscreen</th>
                 <th colspan="3" style="border-right: 2px dotted #2c3e50;">Bigscreen</th>
                 <th colspan="3" style="border-right: 2px dotted #2c3e50;">Portale</th>
                 <th colspan="2" style="border-right: 2px dotted #2c3e50;">Optin</th>
                 <th rowspan="2" @click="sorted('online')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Online</th>
               </tr>
               <tr style="background-color: #4ca1af; color: #2c3e50">
                 <th @click="sorted('ssc_cr')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">CR</th>
                 <th @click="sorted('ssc_calls')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Calls</th>
                 <th @click="sorted('ssc_orders')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Saves</th>
                 <th @click="sorted('ssc_impact')" style="cursor:pointer; border-right: 2px dotted #2c3e50; border-bottom: 2px solid #2c3e50;">Impact</th>
                 <th @click="sorted('bsc_cr')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">CR</th>
                 <th @click="sorted('bsc_calls')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Calls</th>
                 <th @click="sorted('bsc_orders')" style="cursor:pointer; border-right: 2px dotted #2c3e50; border-bottom: 2px solid #2c3e50;">Saves</th>
                 <th @click="sorted('portal_cr')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">CR</th>
                 <th @click="sorted('portal_calls')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Calls</th>
                 <th @click="sorted('portal_orders')" style="cursor:pointer; border-right: 2px dotted #2c3e50; border-bottom: 2px solid #2c3e50;">Saves</th>
                 <th @click="sorted('optin_cr')" style="cursor:pointer; border-bottom: 2px solid #2c3e50;">Quote</th>
                 <th @click="sorted('optin')" style="cursor:pointer; border-right: 2px dotted #2c3e50; border-bottom: 2px solid #2c3e50;">Stück</th>
               </tr>
               <tr v-bind:class= "[user.ssc_cr > 51 ? 'good-bg' : 'bad-bg']" v-for="user in sortedUsers">
                 <td style="text-align: left; border-right: 2px dotted #2c3e50;">{{user.surname}} {{user.lastname}}</td>
                 <td>{{parseFloat(user.ssc_cr).toFixed(1).replace(".", ',')}}%</td>
                 <td>{{user.ssc_calls}}</td>
                 <td>{{user.ssc_orders}}</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{parseFloat(user.ssc_impact).toFixed(1).replace(".", ',')}}%</td>
                 <td>{{parseFloat(user.bsc_cr).toFixed(1).replace(".", ',')}}%</td>
                 <td>{{user.bsc_calls}}</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{user.bsc_orders}}</td>
                 <td>{{parseFloat(user.portal_cr).toFixed(1).replace(".", ',')}}%</td>
                 <td>{{user.portal_calls}}</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{user.portal_orders}}</td>
                 <td>{{parseFloat(user.optin_cr).toFixed(1).replace(".", ',')}}%</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{user.optin}}</td>
                 <td v-if="checkIfOnline(user.online_till)" style="color: #2c3e50"><i class="fas fa-check-circle"></i></td>
                 <td v-else><i class="fas fa-times-circle"  style="color: #2c3e50"></i></td>
               </tr>
               <tr style="font-weight: bold; background-color: #4ca1af; color: #2c3e50; border-top: 2px solid #2c3e50;">
                 <td style="text-align: left; border-right: 2px dotted #2c3e50;">Projekt</td>
                 <td>{{sscCR}}%</td>
                 <td>{{sscCalls}}</td>
                 <td>{{sscSaves}}</td>
                 <td style="border-right: 2px dotted #2c3e50;"></td>
                 <td>{{bscCR}}%</td>
                 <td>{{bscCalls}}</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{bscSaves}}</td>
                 <td>{{portalCR}}%</td>
                 <td>{{portalCalls}}</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{portalSaves}}</td>
                 <td>{{optinQuota }}%</td>
                 <td style="border-right: 2px dotted #2c3e50;">{{optin}}</td>
                 <td></td>
               </tr>
             </table>

            </div>
          </div>
        </div>

      </div>
    </div>
  <!-- <div class="row mt-4 center_items">
    <div class="btn-group dropend">
      <button type="button" class="btn btn-secondary dropdown-toggle rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bars fa-3x"></i>
      </button>
      <div class="dropdown-menu">
        <div class="d-flex center_items m-2">
          <button type="button" name="button" class="p-2 m-2 iconbutton" @click="changeDepartment('Mobile')"><i class="fas fa-mobile-alt fa-7x"></i></button>
          <button type="button" name="button" class="p-2 m-2 iconbutton" @click="changeDepartment('DSL')"><i class="fas fa-desktop fa-7x"></i></button>
        </div>
      </div>
    </div>
  </div> -->
</div>

</template>

<script>
    export default {
      data(){
        return{
          users: [1,2,3],
          currentSort:'ssc_cr',
          currentSortDir:'desc',
          SscGeVoCr: 0,
          sscCalls: 11,
          bscCalls: 11,
          bscSaves: 0,
          portalCalls: 0,
          portalSaves: 0,
          sscSaves: 0,
          calls:0,
          saves:0,
          optin: 0,
          department: 'Mobile',
          timer: null,
          testdata: [[0,15.38,30.3,33.33,36.25,40.91,45.99,45.18,49.48],[0,0,25,36.11,35,37.35,42.31,43.9,47.59],["08:01","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00"]],
          agl0stk: 0,
          agl1stk: 0,
          agl2stk: 0,
          agl3stk: 0,
          agl4stk: 0,
          agl5stk: 0,
          aglAllStk: 0,
          top5user: [],
        }
      },
      mounted() {
        var self = this;
        console.log('ptable Component mounted.')

        self.getUserData('Mobile')
        self.getDailyQouta('Mobile')
        this.timer =
        setInterval(function()
        {
          self.getUserData('Mobile')
          self.getDailyQouta('Mobile')
        }, 60000);
      },
      computed:{
        sortedUsers:function() {
          return this.users.sort((a,b) => {
            let modifier = 1;
            if(this.currentSortDir === 'desc') modifier = -1;
            if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
            if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
            return 0;
          });
        },
        GeVoCr: function(){
          if (this.calls != 0) {
            return Math.round((this.saves*100/this.calls)*100)/100
          }
          else {
            // return this.saves
            return 0
          }
        },
        optinQuota: function(){
          if (this.calls != 0) {
            return Math.round((this.optin*100/this.calls)*100)/100
          }
          else {
            // return this.saves
            return 0
          }
        },
        bscCR: function(){
          if (this.bscCalls != 0) {
            return Math.round((this.bscSaves*100/this.bscCalls)*100)/100
          }
          else {
            return 0
          }
        },
        portalCR: function(){
          if (this.portalCalls != 0) {
            return Math.round((this.portalSaves*100/this.portalCalls)*100)/100
          }
          else {
            return 0
          }

        },
        sscCR: function(){
          if (this.sscCalls != 0) {
            return Math.round((this.sscSaves*100/this.sscCalls)*100)/100
          }
          else {
            return 0
          }
        },
      },
      methods:{
        reload() {
          this.state = false;
          this.value++;
          this.$nextTick(() => this.state = true);
        },
        sorted(s) {
          //if s == current sort, reverse
          if(s === this.currentSort) {
            this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
          }
          this.currentSort = s;
        },
        getUserData(dep){

          var host = window.location.host;
          var department = this.department;
          var team = document.getElementById('team_selection').value;

          var parameters = [];
          parameters.push({
            "project" : department,
            "team" : team
          });
          parameters = JSON.stringify(parameters);

          // console.log(parameters);
          var currentdate = new Date();
          let timestamp = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getFullYear() + " @ "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();

          axios.get
          // ('http://'+host+'/care4as/care4as/public/users/getTrackingAlt/'+dep)
          // ('http://'+host+'/care4as/care4as/public/users/getTracking/'+parameters)
          ('http://'+host+'/users/getTracking/'+parameters)
          // ('http://'+host+'/users/getTrackingAlt/'+dep)
          .then(response => {
            // console.log(response.data)
            if(response.data)
            {
              console.log(response.data)
              var currentdate = new Date();
              console.log('update: '+timestamp)
                // console.log(response.data[1])
                this.users = response.data[1]
                this.sscCalls = response.data[2]['ssc_calls']
                this.sscSaves = response.data[2]['ssc_saves']
                this.bscSaves = response.data[2]['bsc_saves']
                this.bscCalls = response.data[2]['bsc_calls']
                this.portalCalls = response.data[2]['portal_calls']
                this.portalSaves = response.data[2]['portal_saves']
                this.calls = response.data[2]['calls']
                this.saves = response.data[2]['orders']
                this.optin = response.data[2]['optins']
                this.agl0stk = response.data[2]['al_0']
                this.agl1stk = response.data[2]['al_1']
                this.agl2stk = response.data[2]['al_2']
                this.agl3stk = response.data[2]['al_3']
                this.agl4stk = response.data[2]['al_4']
                this.agl5stk = response.data[2]['al_5']
                this.top5user = response.data[3]

                console.log("User:")
                console.log(this.users)

                this.users = response.data[1]
              // this.top5user = response.data[4]
              this.createAglChart();

            }
            else
            {
              console.log('No Data avaiable')
            }
            })
          .catch(function (err) {
            console.log('Error fetching Performance Table data')
            console.log(err.response);
          })
        },
        changeDepartment(dep)
        {
          this.department = dep
          this.getUserData(dep)
          this.getDailyQouta(dep)

          clearInterval(this.timer)
          this.timer =

          setInterval(function()
          {
            this.getUserData(dep)
            this.getDailyQouta(dep)
          }.bind(this), 60000);
          // console.log(this.department)
        },
        getDailyQouta(dep){
          var host = window.location.host;
          let department = dep
          // let testarray = [[0,15.38,30.3,33.33,36.25,40.91,45.99,45.18,49.48],[0,0,25,36.11,35,37.35,42.31,43.9,47.59],["08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00"]]
          // this.createChart('dailyQuota', testarray)
          // axios.get('http://'+host+'/care4as/care4as/public/kdw/getQuotas/'+department) // Richtige Daten
          axios.get('http://'+host+'/kdw/getQuotas/'+department)
          .then(response =>
          {
            // console.log('dailyQoutas')
            // console.log(response.data)
            this.createChart('dailyQuota', response.data)
          })
          .catch(
            function (err) {
              console.log('Error fetching Daily Quota:')
              console.log(err.response);
            })
          },
        createChart(chartId, chartData) {
        let chart = document.getElementById(chartId);
        if (typeof chart != 'undefined' || chart != null )
        {
          document.getElementById(chartId).remove()
          $('#chartcontainer').append('<canvas id="'+chartId+'" width="" height="" style="max-width: 100%;"></canvas>')
          // console.log('test')
        }
        const ctx = document.getElementById(chartId);
        let myChart = new Chart(ctx, {
          type: 'line',
          data: {
            datasets: [{
              label: 'CR',
              type: 'line',
              fill: true,
              data: chartData[0],
              backgroundColor: 'rgba(41, 241, 195, 0.5)',
              borderColor: 'rgba(41, 241, 195, 1)',
              borderWidth: 2,
            },
            {
              label: 'SSC-CR',
              type: 'line',
              fill: true,
              data: chartData[1],
              backgroundColor: 'rgba(255, 99, 132,0.2)',
              borderColor: 'rgba(255, 99, 132, 0.5)',
              borderWidth: 2
            }],
          labels: chartData[2],
          },
          options: {
            maintainAspectRatio: false,
            devicePixelRatio: 2,
            animation: {
              duration: 0,
            },
            scales: {
              yAxes: [{
                id: 'A',
                type:'linear',
                position: 'left',
                color: 'rgb(255,255,255)',
                ticks: {
                  beginAtZero: true,
                  min: 0,
                  max: 100,
                },
                scaleLabel: {
                  display: true,
                  labelString: 'CR',
                }
              }],
              xAxes:[{
                id:'B',
                beginAtZero: true,
              }]
            }
          }
        });
      },

      createAglChart(){
      let chartId = 'aglChart';

      let chart = document.getElementById(chartId);
        if (typeof chart != 'undefined' || chart != null )
        {
          document.getElementById(chartId).remove()
          $('#aglchartcontainer').append('<canvas id="'+chartId+'" width="" height="" style="max-width: 100%;"></canvas>')
          // console.log('test')
        }
      const ctx = document.getElementById(chartId);
      let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [
            {
              label: 'Stück',
              fill: true,
              data: [this.agl0stk, this.agl1stk, this.agl2stk, this.agl3stk, this.agl4stk, this.agl5stk],
              backgroundColor:
                [
                  'rgba(132,220,149,0.5)',
                  'rgba(194,237,153,0.6)',
                  'rgba(255, 253, 156,0.6)',
                  'rgba(255,199,141,0.6)',
                  'rgba(255,145,126,0.6)',
                  'rgba(255,91,111,0.35)',
                ],
              borderColor: [
                'rgb(0,97,0)',
                'rgba(78,99,0)',
                'rgba(156,101,0)',
                'rgba(156,67,2)',
                'rgba(156,34,4)',
                'rgb(156,0,6)',
                ],
              borderWidth: 2,
              hoverOffset: 0,
            },
          ],
        labels: ['Keine Stufe', 'Stufe 1', 'Stufe 2', 'Stufe 3', 'Stufe 4', 'Stufe 5'],
        },
        options: {
          maintainAspectRatio: false,
          devicePixelRatio: 2,
          legend: {
            position: 'bottom',
          },
          animation: {
              duration: 0,
            },
          tooltips: {
            displayColors: false,
            callbacks: {
              title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function(tooltipItem, data) {
                return 'Anzahl: ' + data['datasets'][0]['data'][tooltipItem['index']];
              },
              afterLabel: function(tooltipItem, data) {
                var total = 0;

                for (var i = 0; i < data['datasets'][0]['data'].length; i++) {
                    total += data['datasets'][0]['data'][i];
                }

                var count = data['datasets'][0]['data'][tooltipItem['index']];
                var percentage = (count / total) * 100;


                return 'Anteil: ' + percentage.toFixed(2).replace(".", ',') + '%';
              }
            }
          }
        }
      });
      },

      checkIfOnline(online_till)
      {
        let onlinetill = online_till

        if(onlinetill)
        {
          var t2 = onlinetill.split(/[- :]/);
          let onlinetill2 = new Date(t2[0],t2[1]-1,t2[2],t2[3]||0,t2[4]||0,t2[5]||0);
          if(  Date.now() <  Date.parse(onlinetill2))
          {
            // console.log('alles gut');
            return true;
          }
          else {
            // console.log(online_since);
              return false
          }
        }
        else {
             // console.log('online_till fehler')
            return false;
          }
        },
      }
    }
</script>

<style media="screen">
.dot-green, .dot-red {
    height: 30px;
    width: 30px;
    /* background-color: green; */
    border-radius: 5px;
    /* display: inline-block; */
}
.dot-green{
  background-color: green;
}
.dot-red{
  background-color: red;
}

.app{
  width: 100%;
}

.good-cr{
  background-color: rgb(132,220,149,0.5);
  border: 5px solid rgb(0,97,0);
  color: rgb(0,97,0);
}

.bad-cr{
  background-color: rgb(255,91,111,0.35);
  border: 5px solid rgb(156,0,6);
  color: rgb(156,0,6);
}

.good-bg{
  border-radius: 0;
  border-collapse: collapse;
  background-color: rgb(132,220,149,0.5);
  color: rgb(0,97,0);
}


.bad-bg{
  border-radius: 0;
  border-collapse: collapse;
  background-color: rgb(255,91,111,0.35);
  color: rgb(156,0,6);
}

tr:hover {
    background-color: #4ca1af;
    border-radius: 0;
    border-collapse: collapse;
}

.custom_select{
  font-family: 'Radio Canada', sans-serif !important;
  background-color: #f8f9fa;
  border: 1px;
  -webkit-appearance: none;
  -moz-appearance: none;
  transition: all 300ms ease 0s;
}

.custom_select:hover{
  color: black !important;
  cursor: pointer;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
}



@import url('https://fonts.googleapis.com/css2?family=Radio+Canada:wght@300;400;500;600;700&display=swap');
</style>
