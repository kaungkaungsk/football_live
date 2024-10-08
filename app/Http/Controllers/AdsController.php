<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\BannerAd;
use App\Models\InterstitialAd;
use App\Models\OpenAd;
use App\Traits\CipherTrait;
use Exception;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    use CipherTrait;


    public function getAdsData()
    {
        $slideAds = Advertisement::all();
        foreach ($slideAds as $ad) {
            $ad->image = $ad->image ?? $ad->image_link;
        }

        $interstialAds = InterstitialAd::all();
        foreach ($interstialAds as $ad) {
            $ad->media = $ad->media_path ?? $ad->media_link;
        }

        $bannerAds = BannerAd::all();
        foreach ($bannerAds as $ad) {
            $ad->media = $ad->media_path ?? $ad->media_link;
        }

        $openAds = OpenAd::all();
        foreach ($openAds as $ad) {
            $ad->image = $ad->image ?? $ad->image_link;
        }

        $data = [
            'slide_ad' => $slideAds,
            'interstitial_ad' => $interstialAds,
            'banner_ad' => $bannerAds,
            'open_ad' => $openAds,
        ];

        // return json_encode($data);
        return $this->encryptData(json_encode($data));
    }

    public function postClickCount(Request $request)
    {
        try {
            $adId = $request->ad_id;

            switch ($request->ad_type) {
                case 'slide_ad':
                    $ad = Advertisement::find($adId);
                    $ad->increment('click_count');
                    $ad->save();
                    break;
                case 'open_ad':
                    $ad = OpenAd::find($adId);
                    $ad->increment('click_count');
                    $ad->save();
                    break;
                case 'banner_ad':
                    $ad = BannerAd::find($adId);
                    $ad->increment('click_count');
                    $ad->save();
                    break;
                case 'interstitial_ad':
                    $ad = InterstitialAd::find($adId);
                    $ad->increment('click_count');
                    $ad->save();
                    break;
            }


            return response('Success', 200);
        } catch (Exception) {
            return response('Fail', 400);
        }
    }
}
