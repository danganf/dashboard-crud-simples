<?php

namespace App\Http\Controllers;

use App\MyClass\FactoryApis;
use App\MyClass\Traits\OpenViewController;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use OpenViewController;

    private $title    = 'Vendas';
    private $pathView = 'order';
    private $subtitle;

    public function index( Request $request, FactoryApis $factoryApis ){

        $this->subtitle = 'Meus Pedidos';

        $filtersTmp          = getVariablesFilter($request);
        $filtersTmp['limit'] = ( array_get( $filtersTmp, 'limit', 10) );
        $filtersTmp['sort']  = ( array_get( $filtersTmp, 'sort', 'id') );
        $filtersTmp['dir']   = ( array_get( $filtersTmp, 'dir', 'desc') );

        $factoryApis->setFilters( $filtersTmp );
        $result = $factoryApis->get('order');

        return $this->openView([
            'results'     => array_pull( $result, 'data', [] ),
            'statusLabel' => array_pull( $result, 'status_label', [] ),
            'filters'     => $filtersTmp,
            'paginator'   => $result,
        ]);
    }

}
