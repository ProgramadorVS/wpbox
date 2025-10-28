<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId            : '{{ config("services.facebook.app_id","")}}',
        autoLogAppEvents : true,
        cookie:   true, // enable cookies
        xfbml            : true,
        version          : 'v19.0'
      });
    };



  // Load the JavaScript SDK asynchronously
  (function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Facebook Login with JavaScript SDK
  function launchWhatsAppSignup() {
    // Conversion tracking code
    //fbq && fbq('trackCustom', 'WhatsAppOnboardingStart', {appId: 'your-facebook-app-id', feature: 'whatsapp_embedded_signup'});
    
    // Launch Facebook login
    FB.login(function (response) {
      if (response.authResponse) {
        const code = response.authResponse.code;

        console.log('authResponse');
        console.log(response.authResponse);

        console.log('User code received.');
        console.log(code);
        // The returned code must be transmitted to your backend, 
       // which will perform a server-to-server call from there to our servers for an access token
      } else {
        console.log('User cancelled login or did not fully authorize.');
      }
    }, {
      config_id: '{{ config("services.facebook.config_id","") }}', // configuration ID goes here
      response_type: 'code',    // must be set to 'code' for System User access token
      override_default_response_type: true, // when true, any response types passed in the "response_type" will take precedence over the default types
      extras: {
        setup: {
        
        }
      }
    });
  }
    
  </script>


  <button onclick="launchWhatsAppSignup()"" type="button" class="inline-flex items-center text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 mr-2 mb-2">
    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
    </svg>
    {{ __('Facebook - WhatsApp Setup')}}
</button>