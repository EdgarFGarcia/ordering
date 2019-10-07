<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Teepluss\Theme\Facades\Theme;

class PublicController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public $theme;

	public function __construct() {

		//change theme if user is logged
//        dd(Auth::check());
		if(Auth::check()){
//            return '';
			$this->theme = Theme::uses('portal')->layout('default');
		} else {
			$this->theme = Theme::uses('default')->layout('default');
		}
        
    }
	
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
