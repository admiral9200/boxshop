<?php
namespace app\Http\Controllers;

use App\Address;
use App\FreeProduct;
use App\FreeProductOrder;
use App\FreeProductParticipant;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FreeProductsController extends Controller
{
    private $form_rules = [
        'description'                 => 'required|max:255',
        'start_date'                  => 'required|date',
        'end_date'                    => 'required|date|after:start_date',
        'participation_cost'          => 'required|numeric|digits_between:1,10|min:0',
        'min_participants'            => 'required|numeric|digits_between:1,3|min:1',
        'max_participants'            => 'required|numeric|digits_between:1,3|min:1',
        'max_participations_per_user' => 'required|numeric|digits_between:1,2|min:1',
        'draw_number'                 => 'required|numeric|digits_between:1,2|min:1',
        'draw_date'                   => 'required|date|after:end_date',
    ];

    private $panel = [
                'center' => ['width' => '12'],
            ];
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();
        $filter = $request->get('filter');
        if ($filter && $filter != '') {
            switch (strtolower($filter)) {
                case 'active': $freeproducts = FreeProduct::getListWithPaginate(8, 1); break;
                case 'inactive': $freeproducts = FreeProduct::getListWithPaginate(8, 0); break;
                case 'participations':
                    //$userholdings = FreeProductParticipant::where('user_id', $user->id)->select('freeproduct_id')->get()->toArray();
                    //$freeproducts=FreeProduct::whereIn('id', $userholdings)->with('orders')->paginate(8);
                    $freeproducts = FreeProduct::with('orders')
                                    ->join('freeproduct_participants as p', function ($join) {
                                        $join->on('freeproducts.id', '=', 'p.freeproduct_id')
                                        ->where('p.user_id', '=', \Auth::user()->id);
                                    })
                                    //->where('p.user_id', '=', $user->id);
                                    ->select('freeproducts.*', 'p.status as status_holding')
                                    ->paginate(8);
                    //dd($freeproducts->toSql());
                    break;
                default: $freeproducts = FreeProduct::getListWithPaginate(8); break;
            }
        } else {
            $freeproducts = FreeProduct::getListWithPaginate(8);
        }
        $panel = $this->panel;
        $route = route('freeproducts.search');
        return view('freeproducts.index', compact('panel', 'freeproducts', 'filter', 'route'));
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
    public function update($id)
    {
        //
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
}