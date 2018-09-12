<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderNotification;
use Auth;

class ExtendController extends Controller
{
  protected $website = [];
  protected $default_pagination_limit = 20;

  public function __construct()
  {

    $this->middleware(function ($request, $next) {
    	$user = Auth::guard('admin')->user();
    	$notifications;
    	if ($user->hasRole('Vendor')) {
    		$notifications= Auth::guard('admin')->user()->OrderNotifications()->where('viewed', 0)->get();
    		$this->website['notifications'] = $notifications;
    	}
    	else {
    		$notifications = OrderNotification::where('viewed', 0)->where('notifiable_id', null)->get();
    		$this->website['notifications'] = $notifications;
    	}
        
        return $next($request);
    });
    
  }
}
