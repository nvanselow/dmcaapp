<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PrepareNoticeRequest;
use App\Provider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class NoticesController extends Controller {


    /**
     * Create a new notices controller instance.
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all notices
     *
     * @return string
     */
    public function index()
    {
        return 'all notices';
    }

    /**
     * Show a page to create a new notice
     *
     * @return Response
     */
    public function create()
    {
        // get list of providers
        $providers = Provider::lists('name', 'id');

        // load a view to create a new notice
        return view('notices.create', ['providers' => $providers]);
    }


    /**
     * Ask the user to confirm the DMCA that will be delivered.
     *
     * @param PrepareNoticeRequest $request
     * @param Guard $auth
     * @return \Illuminate\View\View
     */
    public function confirm(PrepareNoticeRequest $request, Guard $auth)
    {

        $template = $this->compileDmcaTemplate($data = $request->all(), $auth);

        session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));


    }

    /**
     * Compile the DMCA template from the form data
     *
     * @param array $data
     * @param Guard $auth
     * @return mixed
     */
    public function compileDmcaTemplate($data, Guard $auth)
    {
        $data = $data + [
                'name' => $auth->user()->name,
                'email' => $auth->user()->email
            ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    public function store()
    {

        $data = session()->get('dmca');




    }
}
