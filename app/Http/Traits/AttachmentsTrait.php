<?php
namespace App\Http\Traits;

use Storage;
use App\Attachment;

trait AttachmentsTrait {
    
    /**
     * store event attachments in s3
     * note: improve later by placing a try catch and return error or success result
     * @param string $ref_table
     * @param int $ref_id
     * @param object $files
     * @return void
     */
    public function storeAttachment($ref_table, $ref_id, $files,$src_mod ='') 
    {
        $folder = "/attachments/{$ref_table}/{$ref_id}";
        $attachments = array();
        
        foreach($files as $file) {
                   
            $s3 = Storage::disk('s3')->put($folder, $file);

            $attributes['created_by']      = auth()->id();
            $attributes['file_name']       = $file->getClientOriginalName();        
            $attributes['folder_name']     = $folder;
            $attributes['full_path']       = $s3;
            $attributes['mime']            = $file->getMimeType();
            $attributes['reference_id']    = $ref_id;
            $attributes['reference_table'] = $ref_table;
            $attributes['src_mod']         = $src_mod;

            $attachment = Attachment::create($attributes);
            $attachments[] = $attachment;
        }

        return $attachments;
    }

}