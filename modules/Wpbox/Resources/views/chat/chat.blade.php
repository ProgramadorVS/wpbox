<div class="theChatHolder card shadow max-height-vh-90 overflow-auto overflow-x-hidden">
    <div class="card-header shadow-lg" id="theChatHeader">
        <div class="row">
 
            <!-- Columna para el avatar, imagen del país y botón -->
            <div v-cloak class="col-lg-2 col-2">
                <div class="d-flex align-items-center flex-column" v-cloak>
                    <span class="badge badge-primary">@{{ getGroupNameForActiveChat() }}</span>
                    <p></p>
                    <a :href="'/contacts/contacts/'+activeChat.id+'/edit'" class="profile-picture-container mb-2">
                        <div v-cloak v-if="activeChat&&activeChat.name&&activeChat.name[0]&&(activeChat.avatar==''||activeChat.avatar==null)"
                            class="avatar avatar-content bg-gradient-success" style="min-width:48px">
                            @{{activeChat.name[0]}}
                        </div>
                        <img v-cloak v-if="activeChat&&(activeChat.avatar!=''&&activeChat.avatar!=null)" alt="" :src="activeChat.avatar"
                            :data-src="activeChat.avatar" class="avatar" />
                           <span  id="userCountry" v-if="activeChat&&activeChat.country" :class="'fi-'+activeChat.country.iso2.toLowerCase()" class="fi  fis flag-icon"></span>
                        <b-tooltip  target="userCountry">@{{activeChat.country.name}}</b-tooltip> 
                    </a>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="enabledBotSwitch" v-model="activeChat.enabled_bot" @change="toggleEnabledBot">
                        <label class="form-check-label" for="enabledBotSwitch">Bot</label>
                    </div>
                   <!-- Botón showConversations -->
        
                </div>
            </div>

            <!-- Columna para el resto del contenido -->
            <div v-cloak class="col-lg-10 col-10">
                <div class="d-flex align-items-center" v-cloak>
                    <div class="ml-2">
                        <a :href="'/contacts/contacts/'+activeChat.id+'/edit'">
                            <h4 class="mb-0 d-block">
                                @{{activeChat.name}} 
                                <span class="badge badge-pill" :class="(getReplyNotification(activeChat)).class">
                                    @{{ (getReplyNotification(activeChat)).text }}
                                </span>
                            </h4>
                                     
                     
                        </a>
                       
                        <span class="text-sm text-dark opacity-8">@{{activeChat.phone}}</span>

                        <!-- Mostrar los campos personalizados -->
                        <div class="custom-fields d-flex flex-wrap mt-2">
                            <div v-for="field in activeContact.fields" :key="field.id" v-if="field.pivot.value" class="mr-3">
                                <span class="badge badge-dark">@{{ field.name }}:</span> 
                                <span>@{{ field.pivot.value }}</span>
                            </div>
                        </div>
<!-- Versión escritorio: todo en una fila -->
<div class="d-flex align-items-center mt-2" v-if="!mobileChat">
    <!-- Dropdown para AGENTES -->
    <b-dropdown size="sm" id="dropdown-right" right :text="getAssignedUser(activeChat)" variant="primary" class="mr-2">
        <b-dropdown-item v-for="(user, key) in users" :key="key" @click="assignUser(key, activeChat.id)">
            @{{user}}
        </b-dropdown-item>
    </b-dropdown>

    <!-- Dropdown para grupos existentes -->
    <b-dropdown size="sm" id="dropdown-groups" right :text="getGroupNameForActiveChat()" variant="primary" class="mr-2">
        <b-dropdown-item v-for="group in grupos" :key="group.id" @click="assignGroup(group.id, activeChat.id)">
            @{{group.name}}
        </b-dropdown-item>
    </b-dropdown>

    <!-- Observaciones del contacto con badge -->
    <span class="badge badge-dark mr-1">Observ:</span>
    <b-form-input
        id="observaciones"
        v-model="activeContact.observaciones"
        maxlength="40"
        placeholder="Sin observaciones"
        size="sm"
        style="max-width: 250px;"
        @blur="updateObservacion"
    ></b-form-input>
</div>

<!-- Versión móvil: dropdowns arriba, observaciones abajo -->
<div v-else>
    <div class="d-flex align-items-center mb-2">
        <b-dropdown size="sm" id="dropdown-right-mobile" right :text="getAssignedUser(activeChat)" variant="primary" class="mr-2">
            <b-dropdown-item v-for="(user, key) in users" :key="key" @click="assignUser(key, activeChat.id)">
                @{{user}}
            </b-dropdown-item>
        </b-dropdown>
        <b-dropdown size="sm" id="dropdown-groups-mobile" right :text="getGroupNameForActiveChat()" variant="primary" class="mr-2">
            <b-dropdown-item v-for="group in grupos" :key="group.id" @click="assignGroup(group.id, activeChat.id)">
                @{{group.name}}
            </b-dropdown-item>
        </b-dropdown>
    </div>
    <div class="d-flex align-items-center">
        <span class="badge badge-dark mr-1">Observ:</span>
        <b-form-input
            id="observaciones-mobile"
            v-model="activeContact.observaciones"
            maxlength="40"
            placeholder="Sin observaciones"
            size="sm"
            style="max-width: 250px;"
            @blur="updateObservacion"
        ></b-form-input>
    </div>
</div>

                       <!--  @include('wpbox::chat.actions') -->

                     
                         <!-- Botón showConversations -->
 <!-- Botón showConversations -->
<button @click="showConversations" v-cloak v-if="mobileChat" 
class="btn btn-outline" 
:style="{ position: 'fixed', top: '160px', right: '10px', zIndex: 1000 }">
<svg xmlns="http://www.w3.org/2000/svg" fill="#2dce89" class="w-6 h-6" style="width: 24px; height:24px">
<path fill-rule="evenodd"
    d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
    clip-rule="evenodd" />
</svg>
</button>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
    <div class="card-body overflow-auto overflow-x-hidden scrollable-div" ref="scrollableDiv" id="chatMessages">
        @include('wpbox::chat.message')
    </div>
</div>

