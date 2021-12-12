<template>
 <div>
  <div class="container pt-5">
   <div class="row">
    <h5 class="text-primary">Chat</h5>
    <p class="text-muted">Send a message to your organization admin</p>
    <div class="col-12 col-sm-12 col-md-3 col-lg-4 col-xl-4 d-block mt-4">
    </div>
    <div class="row pe-5 ps-3 g-0 mt-3">
        <div class="users-list col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 p-4">
            <h6 class="mb-3">Conversations</h6>
            <li v-on:click.prevent="setRecipient(stud.id)" :class="data.receiver_id == stud.id ? 'recipient-active' : ''" class="cursor-pointer text-dark mt-1 fs-6" v-for="(stud, i) in admins" :key="i" :value="stud.id"> <avatar class="me-2" :username="stud.userinfo.first_name + ' ' + stud.userinfo.last_name" :rounded="true" :size="30" :color="'#fff'" :lighten="100"></avatar>{{stud.userinfo.first_name}} {{stud.userinfo.last_name}}</li>
        </div>
        <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
        <div class="card p-0">
            <div class="user-chatbox-container">
                <div id="message-container" class="message-container p-3">
                    <p class="text-center text-muted mt-5" v-if="messages == 0">Select a conversation</p>
                    <div class="msg" v-else v-for="(msg, i) in messages.messages" :key="i" :class="msg.sender_id == user.id ? 'row-reverse' : ''">
                        <!-- <small class="text-muted">{{msg.created_at | moment}}</small> -->
                        <div :class="msg.sender_id == user.id ? 'bubble-two' : 'bubble-one'" >
                            <p class="text-light">{{msg.content}}</p>
                        </div>
                    </div>
                    <!-- <div class="bubble-two d-flex justify-content-start my-2">
                        <p class="text-light">Hello!</p>
                    </div> -->
                </div>
                <div class="user-chatbox-message d-flex justify-content-center pb-3">
                    <input v-model="data.message" class="form-control ms-3 shadow-none" @keypress.enter="sendMessage" placeholder="Type your message here ..."/>
                    <button class="btn btn-primary ms-2 me-3 shadow-none rounded-circle" @click="sendMessage"><i class="bi bi-telegram fs-5"></i></button>
                </div>
            </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
</template>
<script>
import { mapState } from 'vuex'
import Avatar from 'vue-avatar' 
import moment from 'moment'
export default {
  components: {
   Avatar,
  },
  sockets: {
    connect() {
      console.log('socket connected')
    },
    customEmit(val) {
      console.log('this method was fired by the socket server. eg: io.emit("customEmit", data)')
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('MMM D, YYYY - hh:mm a');
    }
  },
 data(){
  return {
      isLoading: false,
      data: {
          receiver_id: '',
          message: ''
      }
  }
 },
 async mounted() {
  this.listener()
  await this.$store.dispatch('auth/checkUser')
  await this.$store.dispatch('members/allAdmins')
  this.scrollToBottom()
  document.title = 'Chat Section'
 },
 computed: {
    ...mapState('auth', ['user']),
    ...mapState('members', ['admins', 'messages']),
 },
 methods: {
     scrollToBottom(){
         const chatbox = document.getElementById('message-container');
         chatbox.scrollTop = chatbox.scrollHeight
     },
     listener(){
        this.$socket.client.on('message_sent', this.getCurrentMsg);
     },
     async getCurrentMsg(){
        await this.$store.dispatch('members/requestMessages', this.data);
        this.scrollToBottom()
     },
     async sendMessage(){
      if(this.data.receiver_id == '') return this.$toast.error('Recepient required')
      if(this.data.message == '') return this.$toast.error('Message is blank')

      this.isLoading = true
      const { status } = await this.$store.dispatch('members/sendMessage', this.data)
      if(status == 200){
          this.$socket.client.emit('message_sent');
          this.data.message = ''
      }
    },
    setRecipient(id){
        this.data.receiver_id = id
        this.$store.dispatch('members/requestMessages', this.data);
        
    }
 },
 watch: {}
}
</script>
<style>
.users-list {
    height: 100%;
    background-color: rgb(255, 255, 255);
    border: solid #f1f3f4 3px;
    overflow-y: auto;
}
.users-list li{
    background-color: #f1f3f4;
    border-radius: 10px;
    padding: 10px 20px;
}
.user-chatbox-container {
    min-height: 400px !important;
    max-height: 500px !important;
    background-color: #f1f3f4;
    position: relative;
}
.user-chatbox-message{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}
.message-container {
    
    overflow-y: auto;
    min-height: 320px;
    max-height: 320px;
}

.msg {
    display: flex;
    align-items: flex-end;
}

.row-reverse {
    flex-direction: row-reverse;
}

.bubble-one{
    height: max-content;
    width: max-content;
    max-width: 350px;
    padding: 10px 15px;
    background-color: rgb(112, 197, 197);
    min-height: 2rem;
    border-radius: 10px;
    margin-bottom: 5px;
    word-break: break-word !important;
}
.bubble-two{
    position: relative;
    margin-right: 15px;
    height: max-content;
    margin-bottom: 5px;

    width: max-content;
    max-width: 350px;
    padding: 10px 15px;
    background-color: rgb(58, 115, 238);
    min-height: 2rem;
    border-radius: 10px;
    word-break: break-word !important;
}


</style>
