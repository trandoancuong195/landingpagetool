<?php

namespace App\Http\Controllers;

use App\Models\LandingPage as LP;
use App\Models\Components as CP;
use Illuminate\Http\Request;
use Carbon\Carbon;
class LandingPage extends Controller
{
    //
    public function reviewLandingPage($slug)
    {
        $dt = Carbon::now();
        $idLP = LP::where('slug', $slug)
            ->first();
        $ids = [];
        if (isset($idLP->_id)) {
            $listComponent = CP::where('landing_page_id', $idLP->_id)->get()->toJson();
            $listComponent = json_decode($listComponent, true);
            foreach ($listComponent as &$value) {
                if ($value['type'] == 'product') {
                    foreach ($value['data'] as $product) {
                        if (!in_array($product['id'], $ids)) {
                            array_push($ids, $product['id']);
                        }

                    }

                }
                if ($value['type'] == 'banner') {
                    foreach ($value['data'] as &$banner) {
                        list($width, $height, $type, $attr) = getimagesize($banner['link_img']);
                        $banner['height'] = $height;
                    }
                }
            }
            if (!empty($ids)) {
                if($idLP->use_for_page == "tatmartv1"){
                    $url = config('constants.api_tatmart_v1').'products/get-list-product-landing-page?id=';
                    $response = $this->call_ntl_api_job($url,implode(",", $ids), '', config('constants.authorization_v1'));
                }
                elseif($idLP->use_for_page == "tatmartv2"){
                    $url = config('constants.api_tatmart_v2').'api/products?pid=';
                    $response = $this->call_ntl_api_job($url,implode(",", $ids), '', config('constants.authorization_v2'));
                }
                elseif($idLP->use_for_page == "mrtho"){
                    $url = config('constants.api_mr_tho');
                    $response = $this->call_ntl_api_job($url,implode(",", $ids), '', '');
                }
                if(!empty($response)){
                    $response = json_decode($response);
                    $arr = [];
                    foreach ($response->products as $p) {
                        if(isset($p->price) && isset($p->product))
                            $arr[$p->product_id] = ["product_id" => $p->product_id,"product" => $p->product, "price" => intval($p->price),"list_price" => intval($p->list_price)];
                    }
                    foreach ($listComponent as &$value) {
                        if ($value['type'] == 'product') {
                            foreach ($value['data'] as &$v) {
                                if(isset($arr[$v["id"]])){
                                    $v['price'] = $arr[$v["id"]]["price"];
                                    $v['name'] = $arr[$v["id"]]["product"];
                                    $v['promotion_price'] = $arr[$v["id"]]["list_price"];
                                }
                            }
                        }
                    }
                }
            }
            return view('frontend.landingpage', ['listComponent' => $listComponent,'status' => 0]);
        }
        return false;

    }


    public function showLandingPage($slug)
    {
        $dt = Carbon::now();
        $idLP = LP::where('slug', $slug)
            ->where('status','1')
//            ->where('end_time','>=',$dt)
//            ->where('start_time','<=',$dt)
            ->first();
        $ids = [];
        $listProduct = [];
        $flg=0;
        if (isset($idLP->_id)) {
            if( $idLP->end_time < $dt || $idLP->start_time>$dt){
                $flg = 1;
            }
            $listComponent = CP::where('landing_page_id', $idLP->_id)->get()->toJson();
            $listComponent = json_decode($listComponent, true);
            foreach ($listComponent as &$value) {
                if ($value['type'] == 'product') {
                    foreach ($value['data'] as $product) {
                        if (!in_array($product['id'], $ids)) {
                            array_push($ids, $product['id']);
                        }

                    }

                }
                if ($value['type'] == 'banner') {
                    foreach ($value['data'] as &$banner) {
                        list($width, $height, $type, $attr) = getimagesize($banner['link_img']);
                        $banner['height'] = $height;
                    }
                }
            }
            if (!empty($ids)) {
                if($idLP->use_for_page == "tatmartv1") $url = config('constants.api_tatmart_v1').'products/get-list-product-landing-page?id=';
                elseif($idLP->use_for_page == "tatmartv2") $url = config('constants.api_tatmart_v2').'api/products?pid=';
                elseif($idLP->use_for_page == "mrtho") $url = config('constants.api_mr_tho');
                $response = $this->call_ntl_api_job($url,implode(",", $ids), '', '');
                if(!empty($response)){
                    $response = json_decode($response);
                    $arr = [];
                    foreach ($response->products as $p) {
                        if(isset($p->price) && isset($p->product))
                            $arr[$p->product_id] = ["product_id" => $p->product_id,"product" => $p->product, "price" => intval($p->price),"list_price" => intval($p->list_price)];
                    }
                    foreach ($listComponent as &$value) {
                        if ($value['type'] == 'product') {
                            foreach ($value['data'] as &$v) {
                                if(isset($arr[$v["id"]])){
                                    $v['price'] = $arr[$v["id"]]["price"];
                                    $v['name'] = $arr[$v["id"]]["product"];
                                    $v['promotion_price'] = $arr[$v["id"]]["list_price"];
                                }
                            }
                        }
                    }
                }
            }
            return view('frontend.landingpage', ['listComponent' => $listComponent,'status' => $flg]);
        }
        return false;
    }

    public function createLandingPage(Request $request){
        $dataLp = LP::where('_id', $request->idLP)->first();
        return view('backend.landingpage.createlandingpage',['dataLp'=>$dataLp]);
    }

    public function insertLandingPage(Request $request)
    {
        $validate = $request->validate(
            [
                'slug' => 'required',
                'name' => 'required',
                'use_for_page' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
        $landingpage = [
            'name' => $request->name,
            'slug' => $request->slug,
            'use_for_page' => $request->use_for_page,
            'start_time' =>$request->start_time?Carbon::parse($request->start_time)->format('d-m-Y H:i:s'):'',
            'end_time' => $request->end_time?Carbon::parse($request->end_time)->format('d-m-Y H:i:s'):'',
            'status' => $request->status?$request->status:0,
        ];
        // cant use updateOrCreate() function for this case
        if(isset($request->landingPageId)){
           // update landing page
            $lp = LP::find($request->landingPageId);
            $lp->name = $request->name;
            $lp->create_date = date("Y-m-d");
            $lp->use_for_page = $request->use_for_page;
            $lp->start_time = $request->start_time?Carbon::parse($request->start_time)->format('d-m-Y H:i:s'):'';
            $lp->end_time = $request->end_time?Carbon::parse($request->end_time)->format('d-m-Y H:i:s'):'';
            $lp->status = $request->status?$request->status:0;
            $lp->save();
            if(isset($request->gotolayout) && $request->gotolayout == 1)
                return redirect()->route('editcomponent', ['id' => $lp->_id]);
            return redirect()->route('listlandingpage');
        }else{
            //insert landing page
            $lp = LP::where('name', $request->name)->orWhere('slug', $request->slug)->first();
            if (isset($lp->name)) {
                return response()->json(['something was wrong']);
            } else{
                $lp = LP::create($landingpage);
                if(isset($request->gotolayout)  && $request->gotolayout == 1)
                return redirect()->route('editcomponent', ['id' => $lp->_id]);
                return redirect()->route('listlandingpage');
            }
        }
    }
    public function listLandingPage(){
        $lp = LP::paginate(10);
        return view('backend.admin',['listLp'=>$lp]);
    }

    public function statusLandingPage(Request $request){
        $lpId = $request->id ? $request->id : '';
        $stt = $request->status ? $request->status : 0;
        if($lpId != ''){
            $lp = LP::find($lpId);
            $lp->status = $stt;
            $lp->save();
        }
        return redirect()->route('listlandingpage');
    }

    private function call_ntl_api_job($url,$params = '', $method = 'GET', $auth = '')
    {
        $api_url = $url . $params;
        $headers = array(
            "Authorization: Basic YWRtaW5AdGF0bWFydC5jb206bGJyNXliNjdZNTh5OFNjMDFwR0QxNGIxa0pHMDgyeTQ=="

        );
        if (!empty($auth)) {
            $headers = ['Authorization: ' . $auth];
        }
        $curl = curl_init();
        if ($method == 'POST') {
            $params = json_encode($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } else if ($method == 'PUT') {
            $params = json_encode($params);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } else if ($method == 'DEL') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }


}
