<script>
    "use strict";
    var chatList=null;
    var lastmessagetime="none";
    var chatMessages={};
    var pusherConn = null;
    var pusherConnForUpdates = null;
    var channel = null;
    var channelUpdate=null;
    var pusherActiveChat=null;
    var companyID="<?php echo auth()->user()->company_id; ?>";
    var serverTimezone = "<?php echo config('app.timezone'); ?>";
    var pusherAvailable=false;


 

    var initPusher=function(){
        if (typeof Pusher !== 'undefined') {
            // The variable is defined
            // You can safely use it here
            Pusher.logToConsole = false;

            pusherConn = new Pusher(PUSHER_APP_KEY, {
                cluster: PUSHER_APP_CLUSTER
            });
            pusherAvailable=true;

            pusherConnForUpdates = new Pusher(PUSHER_APP_KEY, {
                cluster: PUSHER_APP_CLUSTER
            });

            //Bind to new chat list update
            channelUpdate = pusherConnForUpdates.subscribe('chatupdate.'+companyID);
            channelUpdate.bind('general', chatListUpdate);

            

        } else {
            // Pusher
            js.notify("Error: Pusher is not defined. Chat will not load new messages. Please check documentation","danger");
        }
    }


    var connectToChannel=function(chatID){
        if(pusherActiveChat!=chatID && pusherAvailable){
            if(channel!=null){
                //Change chat, release old one
                channel.unsubscribe();
                channel.unbind('general', receivedMessageInPusher);
            }
            //Set active chat
            pusherActiveChat=chatID;

            //Bind to new chat
            channel = pusherConn.subscribe('chat.'+chatID);
            channel.bind('general', receivedMessageInPusher);

            

        }else{
            //Same chat, no changes
        }
    }


var receivedMessageInPusherNO = function(data) {
    // data.contact es solo el ID
    const contactId = typeof data.contact === 'object' ? data.contact.id : data.contact;

    // Pide el contacto actualizado al backend
    axios.get('/api/wpbox/chat-contact/' + contactId)
        .then(function(response) {
            const updatedContact = response.data.data;

            // Actualiza el contacto en los arrays
            const index = chatList.all.findIndex(item => item.id === updatedContact.id);
            if (index !== -1) {
                Vue.set(chatList.all, index, updatedContact);

                // También actualiza en contacts si está filtrado
                const contactsIndex = chatList.contacts.findIndex(item => item.id === updatedContact.id);
                if (contactsIndex !== -1) {
                    Vue.set(chatList.contacts, contactsIndex, updatedContact);
                }
            }

            chatList.reorderContacts();

            // Si es el chat activo, actualiza mensajes y el objeto activo
            if (chatList.activeChat.id === updatedContact.id) {
                if (!chatMessages[updatedContact.id]) {
                    chatMessages[updatedContact.id] = [];
                }
                chatMessages[updatedContact.id].push(data.message);
                chatList.messages = chatMessages[updatedContact.id];

                // Actualiza el objeto activoChat con los nuevos datos (grupos, fields, etc)
                chatList.activeChat = updatedContact;

                // Forzar actualización de Vue
                chatList.$forceUpdate();

                // Scroll automático
                setTimeout(() => {
                    $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
                }, 100);
            }

            // Reproducir sonido si es mensaje nuevo
            if (chatList.activeChat.id !== updatedContact.id) {
                playSound();
            }
        });
};



    var receivedMessageInPusher = function(data) {
    // Actualizar lista de contactos
    const index = chatList.all.findIndex(item => item.id === data.contact.id);
    if (index !== -1) {
        chatList.all[index].last_message = data.message.value;
        chatList.all[index].last_reply_at = data.message.created_at;
        chatList.all[index].is_last_message_by_contact = 1;
    }

    chatList.reorderContacts();

    // Si es el chat activo, actualizar mensajes
    if (chatList.activeChat.id === data.contact.id) {
        if (!chatMessages[data.contact.id]) {
            chatMessages[data.contact.id] = [];
        }
        chatMessages[data.contact.id].push(data.message);
        chatList.messages = chatMessages[data.contact.id];
        
        // Forzar actualización de Vue
        chatList.$forceUpdate();
        
        // Scroll automático
        setTimeout(() => {
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }, 100);
    }
    
    // Reproducir sonido si es mensaje nuevo
    if (chatList.activeChat.id !== data.contact.id) {
        playSound();
    }
};

    var chatListUpdate=function(data){
        
        
        if(data.contact!==chatList.activeChat.id){
            
            getChatsJS();
        }else{
            //Same chat
            
        }
    };


    


    

    var getChatJS=function(contact_id){
        if(chatMessages[contact_id]){
            //Previous messages
            chatList.messages=chatMessages[contact_id];
        }
        axios.get('/api/wpbox/chat/'+contact_id).then(function (response) {
            var messages=response.data.data;
            messages=messages.reverse();
            chatMessages[contact_id]=messages;
            chatList.messages=chatMessages[contact_id];
        }).catch(function (error) {
            
        });

        connectToChannel(contact_id);
        
        
    }

    var getChatsJS=function(){
        axios.get('/api/wpbox/chats/'+lastmessagetime).then(function (response) {
            if(response.data.status){
                var initialChatLoad=chatList.contacts.length==0;
                chatList.contacts=response.data.data;
                chatList.all=response.data.data;

                if(chatList.contacts.length>0){
                    
                    if(chatList.activeChat.id==null){
                        /*getChatJS(chatList.contacts[0].id);
                        chatList.contacts[0].isActive=true;
                        chatList.activeChat=chatList.contacts[0];*/
                    }else{
                        //Stays the same last active chat
                        const index = chatList.contacts.findIndex(item => item.id === chatList.activeChat.id);
                        if (index !== -1) {
                            chatList.contacts[index].name = chatList.contacts[index].name+" ";
                            chatList.contacts[index].isActive = true;
                        }
                    }
                    lastmessagetime=chatList.contacts[0].last_reply_at; 
                    
                    //Play Sound
                    if(!initialChatLoad){
                        playSound();
                    }
                    

                }
            }
            
        }).catch(function (error) {
            
        });
    }

    function playSound() {
        var audio = new Audio('/vendor/meta/pling.mp3');
        audio.play();
    }

    function escapeSingleQuotesInJSON(jsonString) {
        // Use a regular expression to find and replace single quotes inside string values
        const escapedJSONString = jsonString.replace(/"([^"]*?)":\s*"([^"]*?)"/g, function(match, key, value) {
            const escapedValue = value.replace(/'/g, "\\'");
            return `"${key}": "${escapedValue}"`;
        });

        return escapedJSONString;
    }

    

    window.onload = function () {
      
      moment.locale('es')
       
        initPusher();
        getChatsJS();

        //Emojy
        new EmojiPicker({
            trigger: [
                {
                    selector: '#emoji-btn',
                    insertInto: ['#message'] // If there is only one '.selector', than it can be used without array
                }
            ],
           
            closeButton: true,
            specialButtons: 'green' // #008000, rgba(0, 128, 0);
        });

        //VUE Chat list
        Vue.config.devtools=true;
        
        chatList = new Vue({
        el: '#chatList',
        data: {
           
            //templates: @json($templates),
            //replies: @json($replies),
            users: @json($users),
            contactos: @json($contactos),
            
            currentUserID: "{{auth()->user()->id}}",
            contacts: [],
            all:[],
            grupos: @json($grupos), // Pasamos los grupos al Vue
            
            activeChat:{},
            contactGroups: {}, // Mapa de contactId a groupId
            messages:[],
           
            activeMessage:"",
            selectedImage: null,
            selectedFile: null,
            filterText: '',
            filterTemplates: '',
            mobileChat:window.innerWidth<768,
            conversationsShown:true,
            tab:"all",
        },

        

        errorCaptured(err, component, info) {
            console.error('An error occurred:', err);
            console.error('Component in which error occurred:', component);
            console.error('Additional information:', info);
            return false; // this ensures that we still get the default behavior
        },
       computed: {
            filteredReplies() {
                const filterText = this.filterText.toLowerCase();
                return this.replies.filter(item => item.name.toLowerCase().includes(filterText));
            },
            filteredTemplates() {
                const filterTemplates = this.filterTemplates.toLowerCase();
                return this.templates.filter(item => item.name.toLowerCase().includes(filterTemplates));
            },




            newCount(){
             return this.all.filter(contact => contact.is_last_message_by_contact).length;
              },
            mineCount(){
                return this.all.filter(contact => contact.user_id==this.currentUserID).length;
            },
            allCount(){
                return this.all.length;
            },
            activeContact() {
            return this.contactos.find(contacto => contacto.id === this.activeChat.id) || {};
        },
        },
        methods: {


            reorderContacts() {
                this.contacts.sort((a, b) => {
                    // Si alguno no tiene last_reply_at, ponlo al final
                    if (!a.last_reply_at) return 1;
                    if (!b.last_reply_at) return -1;
                    return new Date(b.last_reply_at) - new Date(a.last_reply_at);
                });
                this.all.sort((a, b) => {
                    if (!a.last_reply_at) return 1;
                    if (!b.last_reply_at) return -1;
                    return new Date(b.last_reply_at) - new Date(a.last_reply_at);
                });
            },




        groupNewCount(groupId) {
              // Filtra los contactos del grupo que tengan mensajes sin contestar
                 const grupo = this.grupos.find(g => g.id === groupId);
             if (!grupo) return 0;
                 // Solo cuenta los contactos del grupo que estén en this.all y tengan is_last_message_by_contact
                 return grupo.contacts.filter(contactGrupo =>
                     this.all.some(contacto =>
                     contacto.id === contactGrupo.id && contacto.is_last_message_by_contact
                    )
                      ).length;
            },

            mineMessages:function(){
                this.tab="mine";
                this.filterContacts();
            },
            allMessages:function(){
                this.tab="all";
                this.filterContacts();
            },
            newMessages:function(){
                this.tab="new";
                this.filterContacts();
            },
            getGroupsForContact(contactId) {
            const contacto = this.contactos.find(c => c.id === contactId);
            return contacto ? contacto.groups : [];
        },

        getGroupNameForActiveChat() {
            if (!this.activeChat) return 'SIN GRUPO';

            const groupId = this.contactGroups[this.activeChat.id];

            if (groupId) {
                const group = this.grupos.find(group => group.id === groupId);
                return group ? group.name : 'SIN GRUPO';
            }

            const contacto = this.contactos.find(c => c.id === this.activeChat.id);
            if (!contacto || !contacto.groups) return 'SIN GRUPO';

            const group = contacto.groups[0];
            return group ? group.name : 'SIN GRUPO';
        },


        assignGroup(groupId, contactId) {
            axios.post('/api/contacts/' + contactId + '/toggle-cambiar-grupo', {
                group_id: groupId
            })
            .then(response => {
                console.log('Grupo actualizado.');
                this.$set(this.contactGroups, contactId, groupId);


                    // Actualizar el grupo en el objeto contactos
                    const contacto = this.contactos.find(c => c.id === contactId);
                if (contacto) {
                    const group = this.grupos.find(g => g.id === groupId);
                    if (group) {
                        contacto.groups = [group]; // Suponiendo que un contacto puede pertenecer a un solo grupo
                    }
                }



            })
            .catch(error => {
                console.error('Error updating Grupo:', error);
            });
        },
 
  updateObservacion() {
    axios.post('/api/contacts/' + this.activeChat.id + '/toggle-cambiar-observacion', {
        observaciones: this.activeContact.observaciones
    })
    .then(response => {
        console.log('Observacion guardada.');
    })
    .catch(error => {
        console.error('Error Observacion ', error);
    });
},

        toggleEnabledBot() {
            axios.post('/api/contacts/' + this.activeChat.id + '/toggle-enabled-bot', {
                enabled_bot: this.activeChat.enabled_bot
            })
            .then(response => {
                console.log('Bot enabled status updated successfully.');
            })
            .catch(error => {
                console.error('Error updating bot enabled status:', error);
            });
        },
 
            groupMessages: function(groupId) {
                  this.tab = `group_${groupId}`;
                    this.filterContacts(groupId);
                },
filterContacts() {
    if (this.tab == "all") {
        this.contacts = this.all.filter(contact => contact.has_chat == 1);
    } else if (this.tab == "mine") {
        this.contacts = this.all.filter(contact => contact.user_id == this.currentUserID && contact.has_chat == 1);
    } else if (this.tab == "new") {
        this.contacts = this.all.filter(contact => contact.is_last_message_by_contact && contact.has_chat == 1);
    } else if (this.tab.startsWith("group_")) {
        const groupId = parseInt(this.tab.split('_')[1]);
        if (groupId) {
            const grupo = this.grupos.find(grupo => grupo.id === groupId);
            if (grupo) {
                this.contacts = grupo.contacts
                    .map(contactGrupo =>
                        this.all.find(contacto =>
                            contacto.id === contactGrupo.id && contacto.has_chat == 1
                        )
                    )
                    .filter(Boolean)
                    .sort((a, b) => {
                        if (!a.last_reply_at) return 1;
                        if (!b.last_reply_at) return -1;
                        return new Date(b.last_reply_at) - new Date(a.last_reply_at);
                    });
            } else {
                this.contacts = [];
            }
        }
    }
},
            formatIt: function(message){
                const linkRegex = /https?:\/\/[^\s/$.?#].[^\s]*/g;
      
                // Replace links with placeholders for rendering
                const replacedText = message.replace(linkRegex, '<a href="$&" class="text-bold">$&</a>');

                return replacedText;
            },
            getAssignedUser: function(contact){
                if(contact.user_id){
                    const user = Object.keys(this.users).find(user => user == contact.user_id);
                    return this.users[user] ? this.users[user] : '-';
                }
                return 'Sin Asignar Agente';
            },
            assignUser: function(user_id, contact_id){
                axios.post('/api/wpbox/assign/'+contact_id, {user_id: user_id}).then(function (response) {
                    if(response.data.status){
                        chatList.activeChat.user_id=user_id;
                        const indexUpdate = chatList.all.findIndex(item => item.id == contact_id);
                        console.log(indexUpdate);
                        if (indexUpdate !== -1) {
                            chatList.all[indexUpdate].user_id = user_id;
                        }
                        chatList.filterContacts();
                    }else{  
                        js.notify(response.data.errMsg,"danger");
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            getReplyNotification(contact){
                var timeSinceLastClientReply= moment.tz(contact.last_client_reply_at,serverTimezone).add(24, 'hours');
                const minutesDifference = timeSinceLastClientReply.diff(moment.now(), 'minutes');
                var statusOfReply={
                    "class":"badge-danger",
                    "text":"{{ __('You can no longer reply')}}!"
                };
                if(minutesDifference>0){
                    if(minutesDifference>60){
                        statusOfReply.class="badge-success";
                        statusOfReply.text=moment.duration(minutesDifference, 'minutes').humanize();
                    }else{
                        statusOfReply.class="badge-warning";
                        statusOfReply.text=moment.duration(minutesDifference, 'minutes').humanize();
                    }
                    statusOfReply.text+=" {{ __('left to reply')}}";
                }
                return statusOfReply;
            },
setCurrentChat(contact_id) {
    if (this.mobileChat) {
        this.conversationsShown = false;
    }

    // Desactiva todos los contactos
    if (Array.isArray(this.contacts)) {
        this.contacts.forEach(c => c.isActive = false);
    }
    if (Array.isArray(this.all)) {
        this.all.forEach(c => c.isActive = false);
    }

    // Busca el contacto
    let contactInContacts = Array.isArray(this.contacts) ? this.contacts.find(c => c.id === contact_id) : null;
    let contactInAll = Array.isArray(this.all) ? this.all.find(c => c.id === contact_id) : null;

    // Si no lo encuentra, salir y no hacer nada
    if (!contactInContacts && !contactInAll) {
        console.warn(`Contacto con ID ${contact_id} no encontrado.`);
        return;
    }

    // Activa el contacto si existe
    if (contactInContacts) contactInContacts.isActive = true;
    if (contactInAll) contactInAll.isActive = true;

    // Asigna como contacto activo
    this.activeChat = contactInAll || contactInContacts;

    // Llama tu función para cargar mensajes
    if (typeof getChatJS === 'function') {
        getChatJS(contact_id);
    }

    // Scroll al final del chat
    if (typeof this.scrollToBottomOfChat === 'function') {
        setTimeout(() => {
            this.scrollToBottomOfChat();
        }, 1000);
    }
},
            getChats:function (){
                getChatsJS();
            },
            momentIt: function (date) {
                return moment.tz(date,serverTimezone).fromNow();
            },
            momentHM: function (date) {
                return moment.tz(date,serverTimezone).format('HH:mm');;
            },
            momentDay:function (date) {
                return moment.tz(date,serverTimezone).format('dddd, D MMM, YYYY');
            },
            scrollToBottomOfChat() {
                const scrollableDiv = this.$refs.scrollableDiv;
                if( scrollableDiv && scrollableDiv.scrollHeight){
                    scrollableDiv.scrollTop = scrollableDiv.scrollHeight;
                   
                }
            },
            parseJSON:function(jsonString){
                if(jsonString==null||jsonString==""){
                    return [];
                }
                return JSON.parse(jsonString);
            },
            setMessage(message){
                this.$bvModal.hide('modal-replies');    
                message=message.replace("\{\{name\}\}",this.activeChat.name);   
                message=message.replace("\{\{phone\}\}",this.activeChat.phone);   
                this.activeMessage=message;
            },
            setVueMessage(message){
                this.activeMessage=this.activeMessage+message;
            },
            

sendChatMessage() {
    const message = this.activeMessage;
    if (!message.trim()) return;
    
    this.activeMessage = "";
    
    // 1. Enviar el mensaje al servidor primero
    axios.post('/api/wpbox/send/'+this.activeChat.id, {message})
        .then(response => {
             this.reorderContacts();
            if (response.data?.status) {
                // 2. Esperar 2 segundos para que el servidor procese
                setTimeout(() => {
                    // 3. Forzar actualización completa del chat
                    this.setCurrentChat(this.activeChat.id);
                    
                    // 4. Scroll al final después de la actualización
                    setTimeout(() => {
                        this.scrollToBottomOfChat();
                    }, 100);
                    
                }, 2000); // 2 segundos de espera
            } else {
                js.notify(response.data.errMsg, "danger");
            }
        })
        .catch(error => {
            js.notify("Error al enviar mensaje", "danger");
        });
},


            showConversations(){
                const indexRemove = this.contacts.findIndex(item => item.id === this.activeChat.id);
                if (indexRemove !== -1) {
                    this.contacts[indexRemove].name = this.contacts[indexRemove].name+" ";
                    this.contacts[indexRemove].isActive = false;
                }   
                this.activeChat={};
                this.conversationsShown=true;
            },
            openImageSelector() {
                // Trigger the file input click event
                this.$refs.imageInput.click();
            },
            openFileSelector() {
                // Trigger the file input click event
                this.$refs.fileInput.click();
            },
            handleImageChange(event) {
                // Get the selected image file
                this.selectedImage = event.target.files[0];

                if (!this.selectedImage) {
                    alert('Please select an image first.');
                    return;
                }else{
                     // Create a FormData object to send the image to the API
                    const formData = new FormData();
                    formData.append('image', this.selectedImage);
                    axios.post('/api/wpbox/sendimage/'+chatList.activeChat.id, formData);
                }
            },
            handleFileChange(event) {
                // Get the selected file
                this.selectedFile = event.target.files[0];

                if (!this.selectedFile) {
                    alert('Please select a file first.');
                    return;
                }else{
                     // Create a FormData object to send the image to the API
                    const formData = new FormData();
                    formData.append('file', this.selectedFile);
                    axios.post('/api/wpbox/sendfile/'+chatList.activeChat.id, formData);
                }
            },
            },
        })

     
    };


</script>