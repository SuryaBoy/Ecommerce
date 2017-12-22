<?php 

use Session;

if (! function_exists('store_link_in_session')){
	
	function store_link_in_session(){
	    $links = session()->has('links') ? session('links') : [];
	    $currentLink = $_SERVER['REQUEST_URI']; // Getting current URI like 'category/books/'
	    array_unshift($links, $currentLink); // Putting it in the beginning of links array
	    session(['links' => $links]); // Saving links array to the session
	}
}

    // helper functions
    function upload_file(\Illuminate\Http\UploadedFile $image, $path='public', $prefix = "") {
        // modify the image name and upload it and return modified image name.
        $image_name_with_extension          = $image->getClientOriginalName();
        $modified_image_name_with_extension = date('YmdHis') . "-" . str_random(5) . "-" . str_replace(" ", "-", $image_name_with_extension);

        if($image->storeAs($path, $modified_image_name_with_extension)) {

            // to return relative path to so that we dont exclutind public from the path
            $path = str_replace("public/","",$path);
            return "$path/".$modified_image_name_with_extension;
        }

        else {
            return redirect()->back()->with('failure_message', 'Sorry, something went wrong while uploading the image. Please try again later!');
        }
    }

