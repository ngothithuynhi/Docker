<template>
    <div class="wrapper">
      <div class="header-wrapper">
        <header>
          <TopCork></TopCork>
        </header>

        <MenuCork></MenuCork>
      </div>
      <div class="page-wrapper">
        <div class="page-content">
          <div class="row">
            <router-view></router-view>
          </div>
        </div>
      </div>
      <BotCork></BotCork>
    </div>
</template>
<script>
import "../../assets/js/jquery.min.js";
import "../../assets/plugins/simplebar/js/simplebar.min.js";
import "../../assets/plugins/metismenu/js/metisMenu.min.js";
import "../../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js";
import "../../assets/js/index.js";
export default {
    name: '#app',
    components:{
        TopCork, BotCork, MenuCork
    }
}
</script>
<style>
@import "../../assets/plugins/simplebar/css/simplebar.css";
@import "../../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css";
@import "../../assets/css/bootstrap.min.css";
@import "../../assets/css/bootstrap-extended.css";
@import "../../assets/css/app.css";
@import "../../assets/css/icons.css";
@import "../../assets/css/dark-theme.css";
@import "../../assets/css/semi-dark.css";
@import "../../assets/css/header-colors.css";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
@import "../../assets/images/favicon-32x32.png";    
</style>