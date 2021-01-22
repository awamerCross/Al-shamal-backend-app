<?php
namespace  App\Services;

class SettingService {

   public static function appInformations($app_info)
    {

       $data                        = [
           'app_name_ar'                   =>$app_info['app_name_ar'],
           'app_name_en'                   =>$app_info['app_name_en'],
           'add_ad_ar'                     =>$app_info['add_ad_ar'],
           'add_ad_en'                     =>$app_info['add_ad_en'],
           'phone'                         =>$app_info['phone'],
           'email'                         =>$app_info['email'],
           'twitter'                       =>$app_info['twitter'],
           'instagram'                     =>$app_info['instagram'],
           'facebook'                      =>$app_info['facebook'],
           'youtube'                       =>$app_info['youtube'],
           'policy_ar'                     =>$app_info['policy_ar'],
           'policy_en'                     =>$app_info['policy_en'],
           'terms_ar'                      =>$app_info['terms_ar'],
           'terms_en'                      =>$app_info['terms_en'],
           'about_ar'                      =>$app_info['about_ar'],
           'about_en'                      =>$app_info['about_en'],
           'whatsapp'                      =>$app_info['whatsapp'],
           'commission_ar'                 =>$app_info['commission_ar'],
           'commission_en'                 =>$app_info['commission_en'],
           'commission_percentage'         =>$app_info['commission_percentage'],
           'about_ar'                      =>$app_info['about_ar'],
           'about_en'                      =>$app_info['about_en'],
           'terms_ar'                      =>$app_info['terms_ar'],
           'terms_en'                      =>$app_info['terms_en'],
           'commission_ar'                 =>$app_info['commission_ar'],
           'commission_en'                 =>$app_info['commission_en'],
           'help_ar'                       =>$app_info['help_ar'],
           'help_en'                       =>$app_info['help_en'],
           'add_ad_ar'                     =>$app_info['add_ad_ar'],
           'add_ad_en'                     =>$app_info['add_ad_en'],

           'policy'                        =>$app_info['about_'.lang()],
           'about_ar'                         =>$app_info['about_ar'],
           'about_en'                         =>$app_info['about_en'],
           'policy'                        =>$app_info['about_'.lang()],
           'dawnlaod_app_text_ar'          =>$app_info['dawnlaod_app_text_ar'],
           'dawnlaod_app_text_en'          =>$app_info['dawnlaod_app_text_en'],
           'google_link'                   =>$app_info['google_link'],
           'apple_link'                    =>$app_info['apple_link'],
       ];
        return $data;
    }



}
