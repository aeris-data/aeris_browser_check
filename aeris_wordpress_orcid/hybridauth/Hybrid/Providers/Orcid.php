<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

/**
 * Hybrid_Providers_Foursquare provider adapter based on OAuth2 protocol
 * 
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_Foursquare.html
 */
class Hybrid_Providers_Orcid extends Hybrid_Provider_Model_OAuth2
{ 
	public $response;
	private $orcid;
	private $orcid_name;

	/**
	* IDp wrappers initializer 
	*/
	function initialize() 
	{
		parent::initialize();

		// Provider apis end-points
		$this->api->api_base_url  = "https://orcid.org/oauth";
		$this->api->scope = "/authenticate" ;
		$this->api->authorize_url = "https://orcid.org/oauth/authorize";
		$this->api->token_url     = "https://orcid.org/oauth/token"; 
		$this->api->response_type = "code";

		//$this->api->sign_token_name = "oauth_token";
	}
	/**
	* begin login step 
	*/
	function loginBegin()
	{
		// redirect the user to the provider authentication url
		Hybrid_Auth::redirect( $this->api->authorizeUrl( array( "scope" => $this->api->scope, "response_type" => "code"  ) ) ); 
		//call access token //

	}

	function getSessionData() {

		return Hybrid_Auth::getSessionData();
	}
	/**
	* finish login step 
	*/

	function loginFinish()
	{
		$error = (array_key_exists('error',$_REQUEST))?$_REQUEST['error']:"";

		// check for errors
		if ( $error ) { 
			throw new Exception( "Authentication failed! {$this->providerId} returned an error: " . htmlentities( $error ), 5 );
		}

		// try to authenticate user
		$code = (array_key_exists('code',$_REQUEST))?$_REQUEST['code']:"";

		try {
			$this->authenticate( $code ); 
		}

		catch( Exception $e ){
			throw new Exception( "Authentication failed! {$this->providerId} returned an error", 5 );
		}

		// check if authenticated
		if ( ! $this->api->access_token ){ 
			throw new Exception( "Authentication failed! {$this->providerId} returned an invalid access_token", 5 );
		}

		// store tokens
		$this->token( "access_token" , $this->api->access_token  );
		$this->token( "refresh_token", $this->api->refresh_token );
		$this->token( "expires_in"   , $this->api->access_token_expires_in );
		$this->token( "expires_at"   , $this->api->access_token_expires_at );

		// set user connected locally
		$this->setUserConnected();
	}

	function authenticate( $code )
	{	
		
		$params = array(
			"client_id"     => $this->api->client_id, 
			"client_secret" => $this->api->client_secret,
			"grant_type"    => "authorization_code",
			"code"          => $code
		);

		$http_headers = array();
		$http_headers['Authorization'] = 'Basic ' . base64_encode( $this->api->client_id .  ':' . $this->api->client_secret);
		
		$response = $this->request( $this->api->token_url, http_build_query($params, '', '&'), 'POST', $http_headers );

		$response = $this->parseRequestResult( $response );


		if( ! $response || ! isset( $response->access_token ) ) {
			throw new Exception( "The Authorization Service has return: " . $response->error );
		}

		if( isset( $response->access_token  ) ) $this->api->access_token            = $response->access_token;
		if( isset( $response->refresh_token ) ) $this->api->refresh_token           = $response->refresh_token; 
		if( isset( $response->expires_in    ) ) $this->api->access_token_expires_in = $response->expires_in; 
		if( isset( $response->orcid    ) ) 		Hybrid_Auth::storage()->set("hauth_session_orcid",$response->orcid);
		if( isset( $response->name    ) ) 		Hybrid_Auth::storage()->set("hauth_session_orcid_name",$response->name); 




		// calculate when the access token expire 
		if( isset( $response->expires_in ) ) {
			$this->api->access_token_expires_at = time() + $response->expires_in; 
		}

		else {
		    $this->api->access_token_expires_at = time() + 3600; 
		}

		$this->response = $response;

		return $response;  
	}
	
	private function request( $url, $params = array(), $type="POST", $http_headers = null )
	{
		if( $type == "GET" ) {
			$url = $url . ( strpos( $url, '?' ) ? '&' : '?' ) . http_build_query($params, '', '&');
		}

		$this->http_info = array();
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL            , $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt($ch, CURLOPT_TIMEOUT        , $this->api->curl_time_out );
		curl_setopt($ch, CURLOPT_USERAGENT      , $this->api->curl_useragent );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->api->curl_connect_time_out );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , $this->api->curl_ssl_verifypeer );
		curl_setopt($ch, CURLOPT_HTTPHEADER     , $this->api->curl_header );

        if (is_array($http_headers)) {
            $header = array();
            foreach($http_headers as $key => $parsed_urlvalue) {
                $header[] = "$key: $parsed_urlvalue";
            }

			curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        }
		else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->api->curl_header );
		}
		
		if($this->api->curl_proxy){
			curl_setopt( $ch, CURLOPT_PROXY        , $this->api->curl_proxy);
		}

		if( $type == "POST" ){
			curl_setopt($ch, CURLOPT_POST, 1); 
			if($params) curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		}

		$response = curl_exec($ch);

		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ch));

		curl_close ($ch);

		return $response; 
	}

	private function parseRequestResult( $result )
	
	{
		if( json_decode( $result ) ) return json_decode( $result );

		parse_str( $result, $output );

		$result = new StdClass();

		foreach( $output as $k => $v )
			
			$result->$k = $v;

		return $result;
	}
	/**
	* load the user profile from the IDp api client
	*
	* https://github.com/reddit/reddit/wiki/OAuth2
	* https://github.com/adoy/PHP-OAuth2/blob/master/src/OAuth2/Client.php#L315
	*/
	public function getUserProfile()
	{ 
		$this->user->profile->identifier  = Hybrid_Auth::storage()->get("hauth_session_orcid"); 
		$this->user->profile->displayName = Hybrid_Auth::storage()->get("hauth_session_orcid_name"); 
		$this->user->profile->profileURL  = "http://http://orcid.org/" . $this->api->orcid;  


		if( $this->user->profile->identifier ){
			
			return $this->user->profile;
		}
	}

}
