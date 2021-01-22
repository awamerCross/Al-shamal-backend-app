<?php

	use App\Models\Ads;
	use App\Models\Category;
	use App\Models\SiteSetting;


	function public_data()
	{

		$setting = SiteSetting ::where( 'key', '!=', 'about_ar' )
		                       -> where( 'key', '!=', 'about_en' )
		                       -> where( 'key', '!=', 'terms_ar' )
		                       -> where( 'key', '!=', 'terms_en' )
		                       -> where( 'key', '!=', 'privacy_ar' )
		                       -> where( 'key', '!=', 'privacy_en' )
		                       -> get();

		$data = [];
		foreach ( $setting as $s ) {
			$data[ $s -> key ] = $s -> value;
		}

		return $data;


	}


	function offerSide()
	{

		$offers = Ads ::where( 'offer', 1 ) -> inRandomOrder() -> limit( 5 ) -> get();

		return $offers;
	}

	// calc ad total rate
	function ad_rate( $reviews )
	{

		$total   = 0;
		$counter = 0;
		foreach ( $reviews as $review ) {
			$total += $review -> rate;
			$counter++;

		}

		return $total != 0 ? (float)$total / $counter : 0;

	}

	//calc ad accepted rate
	function accepted_reviews( $reviews )
	{

		return count( $reviews );

	}

	function hallCategories()
	{
		return Category ::select( 'id', 'name_ar', 'name_en' ) -> where( 'type', 1 ) -> get();
	}



