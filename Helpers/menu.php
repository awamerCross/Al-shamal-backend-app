<?php

function menu()
{

    $colors = [ '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#7FB3D5', '#e67e22', '#229954', '#f39c12', '#F6CD61',
        '#FE8A71', '#199EC7', '#C39BD3', '#5b239c', '#73603e' ];
    $menu   = [
//        [
//            'name'  => 'المشرفين',
//            'count' => User ::where( 'role_id', '!=', 0 ) -> count(),
//            'icon'  => '<i class="fa fa-users"></i>',
//            'color' => $colors[ array_rand( $colors ) ]
//        ],
////            [
////                'name'  => 'المستخدمين',
////                'count' => User ::where( 'role_id', 0 ) -> count(),
////                'icon'  => '<i class="fa fa-users"></i>',
////                'color' => $colors[ array_rand( $colors ) ]
////            ],
//        [
//            'name'  => 'الاقسام',
//            'count' => Category ::  count(),
//            'icon'  => '<i class="fa fa-list"></i>',
//            'color' => $colors[ array_rand( $colors ) ]
//        ],
//
//        [
//            'name'  => 'الاخبار',
//            'count' => News :: count(),
//            'icon'  => '<i class="fa fa-location-arrow"></i>',
//            'color' => $colors[ array_rand( $colors ) ]
//        ],
//
//			[
//				'name'  => 'المدن',
//				'count' => City::count(),
//				'icon'  => '<i class="fa fa-location-arrow"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//			[
//				'name'  => 'الاعلانات بانتظار الموافقه',
//				'count' => Ads ::where('status','pending')->count(),
//				'icon'  => '<i class="fa fa-suitcase"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//            [
//                'name'  => 'الاعلانات المفعله',
//                'count' => Ads ::where('status','active')->count(),
//                'icon'  => '<i class="fa fa-suitcase"></i>',
//                'color' => $colors[ array_rand( $colors ) ]
//            ],
//            [
//                'name'  => 'الاعلانات المؤرشفة',
//                'count' => Ads ::where('status','archived')->count(),
//                'icon'  => '<i class="fa fa-suitcase"></i>',
//                'color' => $colors[ array_rand( $colors ) ]
//            ],
//
//			[
//				'name'  => 'البانرات',
//				'count' => Banner:: count(),
//				'icon'  => '<i class="fa fa-picture-o"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//
//			[
//				'name'  => 'الابلاغات',
//				'count' => ReportComment ::count(),
//				'icon'  => '<i class="fa fa-exclamation-triangle"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//			[
//				'name'  => 'Events',
//				'count' => Event ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],[
//				'name'  => 'Awards',
//				'count' => Award ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//			[
//				'name'  => 'Jobs',
//				'count' => Job ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],
//			[
//				'name'  => 'E-Learning',
//				'count' => Elearn ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],[
//				'name'  => 'Discussion Group',
//				'count' => Practical ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],[
//				'name'  => 'Home Slider',
//				'count' => HomeSlider ::count(),
//				'icon'  => '<i class="fa fa-list"></i>',
//				'color' => $colors[ array_rand( $colors ) ]
//			],

    ];

    return $menu;
}
