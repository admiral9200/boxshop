<?php

namespace app\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    private $form_rules = [
        'name'    => 'required|max:100',
        'slogan'  => 'required|max:150',
    ];

    private $panel = [
        'left'   => ['width' => '2'],
        'center' => ['width' => '10'],
    ];

    private $company_id = '1';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $panel = [
            'left'   => ['width' => '2'],
            'center' => ['width' => '10'],
        ];
        $company = Company::find(1);

        return view('company.index', compact('panel', 'company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['created_at', 'deleted_at']);
        $company = Company::find($id);
        $company->update($data);

        return redirect()->to('wpanel/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public static function defaultCompany()
    {
        return [
            'name'                => 'Bella',
            'website_name'        => 'hhtp://Bella.mn',
            'slogan'              => 'An Laravel eCommerce',
            'phone_number'        => '+1 (405) - 669.63.31',
            'cell_phone'          => '+1 (405) - 669.63.31',
            'address'             => 'Northwest',
            'state'               => 'Ulaanbaatar',
            'city'                => 'Ulaanbaatar city',
            'facebook'            => 'https://www.facebook.com/bella.mn',
            'facebook_app_id'     => 'Bella facebook appID',
            'twitter'             => 'https://twitter.com/bella.mn',
            'zip_code'            => '73116',
            'google_maps_key_api' => 'bella google appID',
            'email'               => 'toroo.byamba@gmail.com',
            'contact_email'       => 'toroo.byamba@gmail.com',
            'sales_email'         => 'toroo.byamba@gmail.com',
            'support_email'       => 'toroo.byamba@gmail.com',
            'description'         => ' eStore ready to use',
            'keywords'            => 'antvel, toroo, laravel, php',
            'about_us'            => 'I am Web Developer',
            'refund_policy'       => 'Refund Policy',
            'privacy_policy'      => 'Privacy Policy',
            'terms_of_service'    => 'Terms of Service',
        ];
    }
}
