<template>
    <div class="container unit-translucent p-2" >
        <div class="row justify-content-center" v-if="!this.admin">
          <div class="col-md-12" v-if="this.avatar">
            <div class="row center_items" >
              <h5>Schiffe versenken</h5>
            </div>
            <hr clas ="w-50">
            <div class="row center_items" id="boardRow">
              <div class="col-3 center_items">
                <div class="card bg-light text-dark p-2">
                  <div class="w-100 center_items">
                    <img :src="avatar.url" class="img-fluid rounded-circle border border-dark"alt="AvatarImage">
                  </div>
                  <div class="center_items">
                    {{avatar.name}}
                  </div>
                  <div class="center_items">
                    {{avatar.motto}}
                  </div>
                </div>
              </div>
              <div class="col-9 center_items p-0">
                <div class="wrapper1">
                  <div class="d-flex bg-light"><div id="" class="outerField center_items">
                    0
                  </div><div id="" class="outerField center_items">
                    A
                  </div><div id="" class="outerField center_items">
                    B
                  </div><div id="" class="outerField center_items">
                    C
                  </div><div id="" class="outerField center_items">
                    D
                  </div><div id="" class="outerField center_items">
                    E
                  </div><div id="" class="outerField center_items">
                    F
                  </div><div id="" class="outerField center_items">
                    G
                  </div><div id="" class="outerField center_items">
                    H
                  </div><div id="" class="outerField center_items">
                    I
                  </div><div id="" class="outerField center_items">
                    J
                  </div></div> <div class="d-flex bg-light"><div id="1" class="outerField center_items">
                    1
                  </div>
                  <div id="1/1" class="innerField center_items">
                    <button type="button" name="button" class="btn">1</button>
                  </div>
                  <div id="1/2" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div><div id="1/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="1/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="2" class="outerField center_items">
                    2
                  </div> <div id="2/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="2/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="3" class="outerField center_items">
                    3
                  </div> <div id="3/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="3/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="4" class="outerField center_items">
                    4
                  </div> <div id="4/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="4/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="5" class="outerField center_items">
                    5
                  </div> <div id="5/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="5/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="6" class="outerField center_items">
                    6
                  </div> <div id="6/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="6/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="7" class="outerField center_items">
                    7
                  </div> <div id="7/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="7/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="8" class="outerField center_items">
                    8
                  </div> <div id="8/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="8/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="9" class="outerField center_items">
                    9
                  </div> <div id="9/1" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/2" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/3" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/4" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/5" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/6" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/7" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/8" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/9" class="innerField center_items"><button type="button" name="button" class="btn"></button></div><div id="9/10" class="innerField center_items"><button type="button" name="button" class="btn"></button></div></div><div class="d-flex bg-light"><div id="10" class="outerField center_items">
                    10
                  </div>
                  <div id="10/1" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/2" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/3" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div><div id="10/4" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div><div id="10/5" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/6" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/7" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div><div id="10/8" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/9" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                  <div id="10/10" class="innerField center_items">
                    <button type="button" name="button" class="btn"></button>
                  </div>
                </div>
                    <!-- <div class="d-flex bg-light">
                      <div class="outerField center_items" id="" v-for="m in letters">
                        {{m}}
                      </div>
                    </div> -->
                    <!-- <div class="d-flex bg-light" v-for="n in 10">
                      <div class="outerField center_items" :id="n">
                        {{n}}
                      </div>
                      <div class="innerField center_items" :id="n +'/' +i" v-for="i in 10">
                        <button type="button" name="button" class="btn"></button>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 center_items" v-else>
              <div class="row">
                <h5>Erstelle deinen Avatar</h5>
              </div>
              <div class="row">
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
      </div>
      <div class="row" v-else>
        <div class="col-2">
          <h5>Spiel erstellen</h5>
          <ul>
            <li>2er <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Submarine_Vepr_by_Ilya_Kurganov_crop.jpg/300px-Submarine_Vepr_by_Ilya_Kurganov_crop.jpg" class="img-fluid" alt="Uboot">  </li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Submarine_Vepr_by_Ilya_Kurganov_crop.jpg/300px-Submarine_Vepr_by_Ilya_Kurganov_crop.jpg" class="img-fluid" alt="Uboot">  </li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Submarine_Vepr_by_Ilya_Kurganov_crop.jpg/300px-Submarine_Vepr_by_Ilya_Kurganov_crop.jpg" class="img-fluid" alt="Uboot">  </li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Submarine_Vepr_by_Ilya_Kurganov_crop.jpg/300px-Submarine_Vepr_by_Ilya_Kurganov_crop.jpg" class="img-fluid" alt="Uboot">  </li>
            <li>3er <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg/220px-French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg" alt="Destroyer"> </li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg/220px-French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg" alt="Destroyer"></li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg/220px-French_destroyer_Forbin_%28D620%29_underway_in_the_Arabian_Sea_on_31_May_2009_%28090531-N-9988F-406%29.jpg" alt="Destroyer"></li>
            <li>4er <img src="https://upload.wikimedia.org/wikipedia/commons/4/4b/USS_Port_Royal_CG-73.jpg" alt="Cruiser"> </li>
            <li><img src="https://upload.wikimedia.org/wikipedia/commons/4/4b/USS_Port_Royal_CG-73.jpg" alt="Cruiser"> </li>
            <li>5er <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Japanese_battleship_Yamato_running_trials_in_Sukumo_Bay%2C_30_October_1941_%2880-G-704702%29.jpg/220px-Japanese_battleship_Yamato_running_trials_in_Sukumo_Bay%2C_30_October_1941_%2880-G-704702%29.jpg" alt="Battleship"> </li>
          </ul>
        </div>
        <div class="col-10 center-items">
          <div class="wrapper1">
            <div class="d-flex bg-light"><div id="" class="outerField center_items">
              0
            </div><div id="" class="outerField center_items">
              A
            </div><div id="" class="outerField center_items">
              B
            </div><div id="" class="outerField center_items">
              C
            </div><div id="" class="outerField center_items">
              D
            </div><div id="" class="outerField center_items">
              E
            </div><div id="" class="outerField center_items">
              F
            </div><div id="" class="outerField center_items">
              G
            </div><div id="" class="outerField center_items">
              H
            </div><div id="" class="outerField center_items">
              I
            </div><div id="" class="outerField center_items">
              J
            </div></div> <div class="d-flex bg-light"><div id="1" class="outerField center_items">
              1
            </div>
            <div id="1/1" class="innerField2 center_items">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Submarine_Vepr_by_Ilya_Kurganov_crop.jpg/300px-Submarine_Vepr_by_Ilya_Kurganov_crop.jpg" alt="">
            </div>
            <div id="1/2" class="innerField center_items">

            </div><div id="1/3" class="innerField center_items"></div><div id="1/4" class="innerField center_items"></div><div id="1/5" class="innerField center_items"></div><div id="1/6" class="innerField center_items"></div><div id="1/7" class="innerField center_items"></div><div id="1/8" class="innerField center_items"></div><div id="1/9" class="innerField center_items"></div><div id="1/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="2" class="outerField center_items">
              2
            </div> <div id="2/1" class="innerField center_items"></div><div id="2/2" class="innerField center_items"></div><div id="2/3" class="innerField center_items"></div><div id="2/4" class="innerField center_items"></div><div id="2/5" class="innerField center_items"></div><div id="2/6" class="innerField center_items"></div><div id="2/7" class="innerField center_items"></div><div id="2/8" class="innerField center_items"></div><div id="2/9" class="innerField center_items"></div><div id="2/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="3" class="outerField center_items">
              3
            </div> <div id="3/1" class="innerField center_items"></div><div id="3/2" class="innerField center_items"></div><div id="3/3" class="innerField center_items"></div><div id="3/4" class="innerField center_items"></div><div id="3/5" class="innerField center_items"></div><div id="3/6" class="innerField center_items"></div><div id="3/7" class="innerField center_items"></div><div id="3/8" class="innerField center_items"></div><div id="3/9" class="innerField center_items"></div><div id="3/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="4" class="outerField center_items">
              4
            </div> <div id="4/1" class="innerField center_items"></div><div id="4/2" class="innerField center_items"></div><div id="4/3" class="innerField center_items"></div><div id="4/4" class="innerField center_items"></div><div id="4/5" class="innerField center_items"></div><div id="4/6" class="innerField center_items"></div><div id="4/7" class="innerField center_items"></div><div id="4/8" class="innerField center_items"></div><div id="4/9" class="innerField center_items"></div><div id="4/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="5" class="outerField center_items">
              5
            </div> <div id="5/1" class="innerField center_items"></div><div id="5/2" class="innerField center_items"></div><div id="5/3" class="innerField center_items"></div><div id="5/4" class="innerField center_items"></div><div id="5/5" class="innerField center_items"></div><div id="5/6" class="innerField center_items"></div><div id="5/7" class="innerField center_items"></div><div id="5/8" class="innerField center_items"></div><div id="5/9" class="innerField center_items"></div><div id="5/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="6" class="outerField center_items">
              6
            </div> <div id="6/1" class="innerField center_items"></div><div id="6/2" class="innerField center_items"></div><div id="6/3" class="innerField center_items"></div><div id="6/4" class="innerField center_items"></div><div id="6/5" class="innerField center_items"></div><div id="6/6" class="innerField center_items"></div><div id="6/7" class="innerField center_items"></div><div id="6/8" class="innerField center_items"></div><div id="6/9" class="innerField center_items"></div><div id="6/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="7" class="outerField center_items">
              7
            </div> <div id="7/1" class="innerField center_items"></div><div id="7/2" class="innerField center_items"></div><div id="7/3" class="innerField center_items"></div><div id="7/4" class="innerField center_items"></div><div id="7/5" class="innerField center_items"></div><div id="7/6" class="innerField center_items"></div><div id="7/7" class="innerField center_items"></div><div id="7/8" class="innerField center_items"></div><div id="7/9" class="innerField center_items"></div><div id="7/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="8" class="outerField center_items">
              8
            </div> <div id="8/1" class="innerField center_items"></div><div id="8/2" class="innerField center_items"></div><div id="8/3" class="innerField center_items"></div><div id="8/4" class="innerField center_items"></div><div id="8/5" class="innerField center_items"></div><div id="8/6" class="innerField center_items"></div><div id="8/7" class="innerField center_items"></div><div id="8/8" class="innerField center_items"></div><div id="8/9" class="innerField center_items"></div><div id="8/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="9" class="outerField center_items">
              9
            </div> <div id="9/1" class="innerField center_items"></div><div id="9/2" class="innerField center_items"></div><div id="9/3" class="innerField center_items"></div><div id="9/4" class="innerField center_items"></div><div id="9/5" class="innerField center_items"></div><div id="9/6" class="innerField center_items"></div><div id="9/7" class="innerField center_items"></div><div id="9/8" class="innerField center_items"></div><div id="9/9" class="innerField center_items"></div><div id="9/10" class="innerField center_items"></div></div><div class="d-flex bg-light"><div id="10" class="outerField center_items">
              10
            </div>
            <div id="10/1" class="innerField center_items">

            </div>
            <div id="10/2" class="innerField center_items">

            </div>
            <div id="10/3" class="innerField center_items">

            </div><div id="10/4" class="innerField center_items">

            </div><div id="10/5" class="innerField center_items">

            </div>
            <div id="10/6" class="innerField center_items">

            </div>
            <div id="10/7" class="innerField center_items">

            </div><div id="10/8" class="innerField center_items">

            </div>
            <div id="10/9" class="innerField center_items">

            </div>
            <div id="10/10" class="innerField center_items">

            </div>
            </div>
          </div>
          <button type="button" name="button" @click="setShips()">Schiffe setzen</button>
          <button type="button" name="button">xxy</button>
          </div>
        </div>
        <div class="modal" id="menumodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      </div>

</template>

<script>
    export default {

      props: ['user','admin'],

      data(){
        return{
          data: null,
          letters: [0,'A','B','C','D','E','F','G','H','I','J'],
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

          this.checkAvatar(this.user)

          setInterval(function()
          {
            // self.checkAvatar()
          }, 500);
        },
        methods:{
          createUser(){
            var host = window.location.host;

            var self = this
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
               this.checkAvatar(this.user)
             })
             .catch(error => {
               console.log(error.response);
               console.log(error);
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
          checkAvatar(id){
            axios.get
            ('http://'+this.host+'/care4as/care4as/public/shipz/checkUser/'+id+'')
            .then(response => {

              console.log(response.data)
              if(response.data !=2)
              {
                this.avatar = response.data
              }

            })
            .catch(err => {
              console.log('error checkAvatar')
              // console.log(testdata)
              console.log(err);
            })
          },
          setShips()
          {
            $('#menumodal').show()
          }
        }
    }
</script>
<style >
.outerField {
  border: 1px black solid;
  border-radius: 5px;
  height: 50px;
  width: 50px;
  background-color: orange;
  margin: 2px;
}
.innerField,.innerField2{
  border: 1px black solid;
  border-radius: 5px;
  margin: 2px;
  height: 50px;
  width: 50px;
}
.innerField:hover
{
  background-color: lightgrey;
}
.innerField2
{
  width: 102px;
}

</style>
