  <!-- Temmplate Details -->
  <div class="col-xl-5 mt-2">
    <div class="card shadow">
        <div class="card-header bg-white border-0">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">{{__('Configuración del Mensaje')}}</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
           <!-- Template header - None, Text, Media -->
            <div class="form-group">
                <label for="header"><strong>{{__('Tipo de Encabezado')}}</strong></label>
                <span class="badge badge-primary" style="color:#8898aa">{{ __('Opcional')}}</span><br />
                <small>{{__('Selecciona el tipo del encabezado.')}}</small>
                <select name="header" id="header" class="form-control" v-model="headerType">
                    <option value="none">{{__('Ninguno')}}</option>
                    <option value="text">{{__('Texto')}}</option>
                    <option value="image">{{__('Imagen')}}</option>
                    <option value="video">{{__('Video')}}</option>
                    <option value="pdf">{{__('PDF')}}</option>
                </select>
            </div>

            <!-- Template header text -->
            <div v-if="headerType=='text'" class="form-group">
                <label for="header_text"><strong>{{__('Texto del Encabezado')}}</strong></label>
                <div class="input-group">
                    <input v-model="headerText" type="text" name="header_text" id="header_text" class="form-control" placeholder="{{__('Texto del Encabezado')}}" value="{{ old('header_text') }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-primary btn-sm" @click="addHeaderVariable()">{{__('Agregar variable')}}</button>
                    </div>
                </div>

                <div class="mt-2">
                    <small>{{__('Puedes usar variables para personalizar el encabezado.')}}</small>
                </div>

                <div class="mt-2" v-if="headervariableAdded">
                    <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                        <label for="headerExampleVariable"><strong>{{__('Nombres de las Variables')}}</strong></label>
                        <br /><small>{{ __('Teclea los nombres de las variables.')}}</small>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                
                                <span class="input-group-text" id="basic-addon1">@{{ '{' }}{1}@{{ '}' }}</span>
                            </div>
                            <input v-model="headerExampleVariable" type="text" class="form-control" placeholder="{{ __('Escribe el nombre de la variable')}}" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template header image -->
            <div v-if="headerType=='image'" class="form-group">
                <label for="header_image"><strong>{{__('Imagen de Encabezado')}}</strong></label>
                <input @change="handleImageUpload" type="file"  accept="image/*" name="header_image" id="header_image" class="form-control" placeholder="{{__('Header image')}}" value="{{ old('header_image') }}">
            </div>

            <!-- Template header video -->
            <div v-if="headerType=='video'" class="form-group">
                <label for="header_video"><strong>{{__('Video de Encabezado')}}</strong></label>
                <input @change="handleVideoUpload" type="file" accept="video/*" name="header_video" id="header_video" class="form-control" placeholder="{{__('Header video')}}" value="{{ old('header_video') }}">
            </div>

            <!-- Template header pdf -->
            <div v-if="headerType=='pdf'" class="form-group">
                <label for="header_pdf"><strong>{{__('PDF de Encabezado')}}</strong></label>
                <input type="file" accept="application/pdf" name="header_pdf" id="header_pdf" class="form-control" placeholder="{{__('Header pdf')}}" value="{{ old('header_pdf') }}">
            </div>

            <hr />


            <!-- Body -->
            <div class="form-group">
                <label for="body"><strong>{{__('Contenido')}}</strong></label>
                <span class="badge badge-primary" style="color:#8898aa">{{ __('Requerido')}}</span>
                <p class="small">{{__('Escribe el cuerpo del mensaje.')}}</p>
                <textarea rows="5" v-model="bodyText" name="body" id="body" class="form-control" placeholder="{{__('Mensaje')}}" value="{{ old('body') }}"></textarea>
                <div class="text-right mt-4">
                    <button @click="addBold()" class="btn btn-outline-secondary btn-sm mx-2" type="button" title="Bold">
                        <strong>B</strong>
                    </button>
                    <button @click="addItalic()" class="btn btn-outline-secondary btn-sm mx-2" type="button" title="Italic">
                        <em>I</em>
                    </button>
                    <button @click="addCode()" class="btn btn-outline-secondary btn-sm mx-2" type="button" title="Code">
                        <code>&lt;&gt;</code>
                    </button>
                    <button @click="addVariable()" class="btn btn-secondary btn-sm mx-2" type="button">
                        {{ __('Agregar Variable') }}
                    </button>
                </div>
                <div class="mt-2" v-if="bodyVariables">
                    <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                        <label for="headerExampleVariable"><strong>{{__('Nombre de variables')}}</strong></label>
                        <br /><small>{{ __('Escribe los nombres de las variables.')}}</small>
                        <div v-for="(v, index) in bodyVariables" class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@{{v}}</span>
                            </div>
                            <input v-model="bodyExampleVariable[index]" type="text" class="form-control" placeholder="{{ __('Nombre de variable')}}" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <!-- Footer -->
            <div class="form-group">
                <label for="footer"><strong>{{__('Footer')}}</strong></label>
                <span class="badge badge-primary" style="color:#8898aa">{{ __('Opcional')}}</span>
                <p class="small">{{__('Escribe el pie de pagina del mensaje.')}}</p>
                <input v-model="footerText" type="text" name="footer" id="footer" class="form-control" placeholder="{{__('Footer')}}" value="{{ old('footer') }}">
            </div>

            <hr />
            
            <!-- Quick Reply Buttonns -->
            <div class="form-group">
                <label for="footer"><strong>{{__('Respuesta con Botones')}}</strong></label>
                <span class="badge badge-primary" style="color:#8898aa">{{ __('Opcional')}}</span>
                <p class="small">{{__('Crea botones para que respondan con clic')}}</p>
                
                <!-- Add the button -->
                <div class="text-right mt-2">
                    <button @click="addQuickReply()" class="btn btn-outline-primary btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Agregar Botón')}}</span>
                    </button> 
                </div>
                <div class="mt-2" v-if="quickReplies.length>0">
                    <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                        <label><strong>{{__('Botones')}}</strong></label>
                        <div v-for="(v, index) in quickReplies" class="form-group">
                            <div class="input-groups">
                                
                                <div class="row">
                                    <div class="col-10">
                                        <input v-model="quickReplies[index]" type="text" class="form-control mr-4 pr-4" placeholder="{{ __('Button text') }}">
                                    </div>
                                    <div class="col-2 mt-2">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" @click="deleteQuickReply(index)">
                                            <span class="btn-inner--icon"> X </span>
                                        </button>
                                    </div>
                                       
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <hr />
            
            <!-- Call to Action Buttonns -->
            <div class="form-group">
                <label for="footer"><strong>{{__('Botones de Acción')}}</strong></label>
                <span class="badge badge-primary" style="color:#8898aa">{{ __('Opcional')}}</span>
                <p class="small">{{__('Crear botones con una acción')}}</p>
                <!-- Add the button -->
                <div class="text-right mt-2">
                    <button :disabled="vistiWebsite.length>1" @click="addVisitWebsite()" class="btn btn-outline-primary btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Visita website - x2')}}</span>
                    </button> 
                    <button v-if="!hasPhone" @click="addCallPhone()" class="btn btn-outline-primary btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Llama a Teléfono')}}</span>
                    </button> 
                    <button v-if="hasPhone" @click="deletePhone()" class="btn btn-outline-danger btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Borrar Teléfono')}}</span>
                    </button> 
                    <button v-if="!copyOfferCode" @click="addCopyOfferCode()" class="btn btn-outline-primary btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Copiar texto')}}</span>
                    </button> 
                    <button v-if="copyOfferCode" @click="deleteCopyOfferCode()" class="btn btn-outline-danger btn-sm" type="button">
                        <span class="btn-inner--icon">{{ __('Borrar Copiar texto')}}</span>
                    </button>
                </div>
            </div>

            <div class="mt-2" v-if="vistiWebsite.length>0">
                <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                    <label><strong>{{__('Visita Pagina Web')}}</strong></label>
                    <div v-for="(v, index) in vistiWebsite" class="form-group">
                        <div class="input-groups">
                            
                            <div class="row">
                                <div class="col-4">
                                    <input v-model="vistiWebsite[index]['title']" type="text" class="form-control" placeholder="{{ __('Texto del Botón') }}">
                                </div>
                                <div class="col-7">  
                                    <input v-model="vistiWebsite[index]['url']" type="text" class="form-control" placeholder="{{ __('URL') }}">
                                </div>
                                <div class="col-1 mt-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" @click="deleteVisitWebsite(index)">
                                        <span class="btn-inner--icon"> X </span>
                                    </button>
                                </div>
                                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call phone number -->
            <div class="mt-2" v-if="hasPhone">
                <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                    <div class="form-group">
                        <label for="call_phone"><strong>{{__('Llama a Teléfono')}}</strong></label>
                        <div class="input-group">
                            <input v-model="callPhoneButtonText" type="text" name="call_phone_name" id="call_phone_name" class="form-control" placeholder="{{__('Nombre del Botón')}}" value="{{ old('call_phone_name') }}">
                        </div>
                        <div class="input-group mt-2">
                            <input v-model="dialCode" type="text" name="call_phone_dial_code" id="call_phone_dial_code" class="form-control" placeholder="{{__('Codigo Zona')}}" value="{{ old('call_phone_dial_code') }}">
                            <input v-model="phoneNumber" type="text" name="call_phone_number" id="call_phone_number" class="form-control" placeholder="{{__('Número Teléfonico')}}" value="{{ old('call_phone_number') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copy offer code -->
            <div class="mt-2" v-if="copyOfferCode">
                <div class="form-group p-4 "  style="background-color: #e9ecef; !important">
                    <div class="form-group">
                        <label for="offer_code"><strong>{{__('Copia Texto')}}</strong></label>
                        <div class="input-group">
                            <input v-model="offerCode" type="text" name="offer_code" id="offer_code" class="form-control" placeholder="{{__('Ejemplo Copia Texto')}}" value="{{ old('offer_code') }}">
                        </div>
                    </div>
                </div>
            </div>



            

           
        </div>
    </div>
</div>