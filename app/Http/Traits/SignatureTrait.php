<?php
namespace App\Http\Traits;

use Storage;
use Carbon\Carbon;

trait SignatureTrait {

    /**
     * decode signature and then save to s3
     * note: no catcher yet if the storage failed of putting the decoded signature
     * 
     * @param $folder, $id, $signed_path
     * @return String $full_path
     */
    private function decodeAndStore($folder,$id,$signed_path) {
        $sign_decoded = base64_decode(substr($signed_path,strpos($signed_path,',')+ 1));
        $full_path = "/{$folder}/{$id}/".auth()->id(). "_".Carbon::now()->timestamp.".png";
        $stored =  Storage::disk('s3')->put($full_path, $sign_decoded);
        
        return $full_path;
    }

}