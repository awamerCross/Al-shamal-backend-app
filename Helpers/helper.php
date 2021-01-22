<?php
	use Illuminate\Support\Facades\App;
	use Illuminate\Support\Facades\Route;
	use Image as IM;
	use LaravelFCM\Facades\FCM;
	use LaravelFCM\Message\OptionsBuilder;
	use LaravelFCM\Message\PayloadDataBuilder;
	use LaravelFCM\Message\PayloadNotificationBuilder;
//    use Stevebauman\Location\Facades\Location;
    use App\Models\Visitor ;
//function vistiors($user_id)
//{
////    $location = Location::get(Request::ip());
//    Visitor::updateOrCreate([
//        'ip'            => Request::ip(),
////        'user_id'       => $user_id,
////        'city'          => $location->cityName    ,
////        'country'       => $location->countryName ,
////        'countryCode'   => $location->countryCode ,
////        'area'          => $location->regionName,
////        'regionName'    => $location->regionName,
////        'regionCode'    => $location->regionCode,
////        'latitude'      => $location->latitude,
////        'longitude'     => $location->longitude,
////        'zipCode'       => $location->zipCode,
//    ]);
//}

    function active ($url ,$type = 1 ){
        if ( \Request::is($url)){
            return 'color_orange';
        }else{
            if ($type == 2){
                return 'color_off';
            }
            return 'color_wight';
        }
    }

    function seo($key)
    {
        $seoRepo  = resolve(\App\Repositories\Eloquent\SeoRepository::class);
        return    $seoRepo->seoRow($key) ;
    }

	function Home()
	{

		$colors = [ '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#7FB3D5', '#e67e22', '#229954', '#f39c12', '#F6CD61',
		            '#FE8A71', '#199EC7', '#C39BD3', '#5b239c', '#73603e' ];
		$home   = [
			[
				'name'  => 'المشرفين',
				'count' => User ::where( 'role_id', '!=', 0 ) -> count(),
				'icon'  => '<i class="fa fa-users"></i>',
				'color' => $colors[ array_rand( $colors ) ]
			],
            [
                'name'  => 'الاقسام',
                'count' => Category ::  count(),
                'icon'  => '<i class="fa fa-list"></i>',
                'color' => $colors[ array_rand( $colors ) ]
            ],

			[
				'name'  => 'الاخبار',
				'count' => News :: count(),
				'icon'  => '<i class="fa fa-location-arrow"></i>',
				'color' => $colors[ array_rand( $colors ) ]
			],
		];

		return $blocks[] = $home;
	}


	function updateRole( $id )
	{
		//get all routes
		$routes      = Route ::getRoutes();
		$permissions = Permission ::where( 'role_id', $id ) -> pluck( 'permission' ) -> toArray();

		$m = null;
		foreach ( $routes as $value ) {
			if ( $value -> getName() !== null ) {

				//display main routes
				if ( isset( $value -> getAction()[ 'type' ] ) && $value -> getAction()[ 'type' ] == 'parent' &&
				     isset( $value -> getAction()[ 'icon' ] ) && $value -> getAction()[ 'icon' ] != null ) {

					echo '<div class = "col-xs-3">';
					echo '<div class = "per-box">';


					// main route
					echo ' <label>';
					echo '<input type = "checkbox" name = "permissions[]"';

					if ( in_array( $value -> getName(), $permissions ) )
						echo ' checked';

					echo '  value="' . $value -> getName()
					     . '">';
					echo ' <span class = "checkmark"></span>';
					echo '<span class = "name">' . $value -> getAction()[ "title" ] . '</span>';
					echo '</label>';
					//sub routes
					if ( isset( $value -> getAction()[ "child" ] ) ) {

						$childs = $value -> getAction()[ "child" ];
						$r2     = Route ::getRoutes();

						foreach ( $r2 as $r ) {
							if ( $r -> getName() !== null && in_array( $r -> getName(), $childs ) ) {

								echo ' <label>';
								echo '<input type = "checkbox" name = "permissions[]"';

								if ( in_array( $r -> getName(), $permissions ) )
									echo ' checked ';

								echo ' value="' . $r -> getName() . '">';
								echo ' <span class = "checkmark"></span>';
								echo '<span class = "name">' . $r -> getAction()[ "title" ] . '</span>';
								echo '</label>';
							}
						}
					}
					echo ' </div>';
					echo '</div>';

				}
			}
		}


	}

    function appInformations(){
        $result = \App\Models\SiteSetting::pluck('value', 'key');
        return $result;
    }

	#current route
	function currentRoute()
	{
		$routes = Route ::getRoutes();
		foreach ( $routes as $value ) {
			if ( $value -> getName() === Route ::currentRouteName() ) {
				echo $value -> getAction()[ 'title' ];
			}
		}
	}


	function convert2english( $string )
	{
		$newNumbers = range( 0, 9 );
		$arabic     = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
		$string     = str_replace( $arabic, $newNumbers, $string );
		return $string;
	}


	function generate_code()
	{
		$characters       = '0123456789';
		$charactersLength = strlen( $characters );
		$token            = '';
		$length           = 5;
		for ( $i = 0; $i < $length; $i++ ) {
			$token .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}
		return $token;
	}

	function upload_img( $img, $path )
	{
		$photo = $img;
		$name  = time() . generate_code() . '.png';
		IM ::make( $photo ) -> save( $path . $name );
		return $name;
	}

	function upload( $file, $path )
	{
		$name = time() . generate_code() . '.'.$file -> getClientOriginalExtension();
		$file -> move( $path, $name );
		return $name;
	}

	function upload_base64( $base64_img, $path )
	{
		$file     = base64_decode( $base64_img );
		$safeName = time() . generate_code() . '.' . 'png';
		file_put_contents( $path . $safeName, $file );
		return $safeName;
	}


	function room_name( $user_id, $owner_id, $ads_id )
	{
		return $user_id . '_' . $ads_id . '_' . $owner_id;
	}



	function Send_FCM( $device_id, $device_type = 'android', $sent_data )
	{
        $sent_data['title'] = 'Life Care';
		$optionBuilder = new OptionsBuilder();
		$optionBuilder -> setTimeToLive( 60 * 20 );
		$notificationBuilder = new PayloadNotificationBuilder( $sent_data[ 'title' ] );
		$notificationBuilder -> setBody( $sent_data[ 'body' ] ) -> setSound( 'default' );


		$option       = $optionBuilder -> build();
		$notification = $notificationBuilder -> build();
		$dataBuilder  = new PayloadDataBuilder();
		$dataBuilder -> addData( $sent_data );
		$data  = $dataBuilder -> build();
		$token = $device_id;


		if ( $device_type == 'android' ) {
			$downstreamResponse = FCM ::sendTo( $token, $option, null, $data );
		} else {
			$downstreamResponse = FCM ::sendTo( $token, $option, $notification, $data );
		}

		$downstreamResponse -> numberSuccess();
		$downstreamResponse -> numberFailure();
		$downstreamResponse -> numberModification();
	}

function notifyUser( $user, $not )
{
//		if ( availableUser( $user ) ) {

    //            dd($user->device);
    foreach ( $user -> devices as $device ) {
        if ( $device -> device_id && $device -> device_type )
            Send_FCM( $device -> device_id, $not, $device -> device_type );

    }
//		}

}

	function day_name( $date )
	{
		$days = [
			'Saturday'  => 'السبت',
			'Sunday'    => 'الأحد',
			'Monday'    => 'الاثنين',
			'Tuesday'   => 'الثلاثاء',
			'Wednesday' => 'الأربعاء',
			'Thursday'  => 'الخميس',
			'Friday'    => 'الجمعة',

		];

		$d    = new DateTime( $date );
		$name = $d -> format( 'l' );
		return App ::getLocale() == 'en' ? $name : $days[ $name ];

	}

	function isFavAd( $ad_id, $user_id )
	{

		return FavouriteAds ::where( 'user_id', $user_id ) -> where( 'ad_id', $ad_id ) -> first() ? 1 : 0;

	}

	function directDistance( $lat1, $lng1, $lat2, $lng2, $unit = 'M' )
	{
		if ( ( $lat1 == $lat2 ) && ( $lng1 == $lng2 ) ) {
			return 0;
		} else {
			$theta = $lng1 - $lng2;
			$dist  = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) + cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );
			$dist  = acos( $dist );
			$dist  = rad2deg( $dist );
			$miles = $dist * 60 * 1.1515;
			$unit  = strtoupper( $unit );

			if ( $unit == "K" ) {
				return ( $miles * 1.609344 );
			} else if ( $unit == "N" ) {
				return ( $miles * 0.8684 );
			} else if ( $unit == 'M' ) {
				return distanceFormat( $miles * 1609.34 );
			} else {
				return $miles;
			}
		}
	}

	function distanceFormat( $meters )
	{

		if ( $meters < 1000 )
			return App ::getLocale() == 'ar' ? round( $meters, 2 ) . ' متر' : round( $meters, 2 ) . ' meter';

		else
			return App ::getLocale() == 'ar' ? round( $meters / 1000, 2 ) . ' كم' : round( $meters / 1000,
			                                                                               2 ) . ' km';
	}


	function Translate($text,$lang){

		$api  = 'trnsl.1.1.20190807T134850Z.8bb6a23ccc48e664.a19f759906f9bb12508c3f0db1c742f281aa8468';

		$url = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$api
		                         .'&lang=ar' . '-' . $lang . '&text=' . urlencode($text));
		$json = json_decode($url);
		return $json->text[0];

	}

	function getYoutubeVideoId( $youtubeUrl )
	{
	    preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
		            $youtubeUrl, $videoId );
		return $youtubeVideoId = isset( $videoId[ 1 ] ) ? $videoId[ 1 ] : "";
	}

	#api response format
	function apiResponse($status, $msg, $data = null, $anotherKey = [])
	{
		$all_response['status']  = $status;
		$all_response['msg']     = $msg;
		$all_response['data']    = $data ?? (object)[];
		if (!empty($anotherKey)) {
			foreach ($anotherKey as $key => $value) {
				$all_response[$key] = $value;
			}
		}
		return response()->json($all_response);
	}

	function getTopParent($category){
		$parent =null;
		while($category->sub_parents){
			$parent = $category->sub_parents;
			$category = $parent;
		}
		return $parent;
	}


    function lang(){
        return App() -> getLocale();
    }

    function rate($ratings)
    {
       return (float) $ratings->sum('rate') / $ratings->count();
    }



