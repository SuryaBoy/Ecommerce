<?php 

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

//for storing current link in session
if (! function_exists('store_link_in_session')){
    
    function store_link_in_session(){
        $links = session()->has('links') ? session('links') : [];
        $currentLink = $_SERVER['REQUEST_URI']; // Getting current URI like 'category/books/'
        array_unshift($links, $currentLink); // Putting it in the beginning of links array
        session(['links' => $links]); // Saving links array to the session
    }
}

//for uploading file 
if (! function_exists('upload_file')){

    // helper functions
    function upload_file(\Illuminate\Http\UploadedFile $image, $path='', $disk='public', $prefix = "") {
        // modify the image name and upload it and return modified image name.
        $image_name_with_extension          = $image->getClientOriginalName();
        $modified_image_name_with_extension = $prefix . date('YmdHis') . "-" . str_random(5) . "-" . str_replace(" ", "-", $image_name_with_extension);

        if($image->storeAs($path, $modified_image_name_with_extension, $disk)) {

            // to return relative path with modified name
            return "$path/".$modified_image_name_with_extension;
        }

        else {
            return redirect()->back()->with('failure_message', 'Sorry, something went wrong while uploading the image. Please try again later!');
        }
    }
}

//for deletion files
if(! function_exists('delete_file')){

    function delete_file($path,$disk="public"){

        Storage::disk($disk)->delete($path);
        return 1;
    }

}