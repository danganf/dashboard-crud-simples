<?php

namespace App\Http\Controllers;

use App\MyClass\Traits\OpenViewController;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use OpenViewController;

    private $title    = 'Cliente';
    private $pathView = 'customer';
    private $subtitle;

    public function index( Request $request, CustomerRepository $customerRepository ){

        $sectors = $factoryApis->get('customer');

        $this->subtitle = 'Cliente';

        return $this->openView([
            'sectors'        => !empty( $sectors ) ? $sectors['RESULT'] : [],
            'filters'        => $filtersTmp,
            'paginator'      => buildUrlPaginator($filtersTmp,$sectors),
        ]);
    }

    public function new(FactoryApis $factoryApis){

        $isInput    = route_is_input();
        $routeSufix = $isInput ? '_input' : '';

        $this->subtitle = 'Novo setor';
        return $this->openView([
            'printers'   => $factoryApis->get('printer'),
            'btn'        => route('register.sector.index'),
            'isInput'    => $isInput,
            'routeSufix' => $routeSufix,
        ], 'view');
    }

    public function edit($id,FactoryApis $factoryApis){
        $this->subtitle = 'Editar setor';

        $data = $factoryApis->get('sector',$id);

        if( empty( $data ) ) {
            abort(404, 'Setor não encontrado');
        }

        $isInput    = route_is_input();
        $routeSufix = $isInput ? '_input' : '';

        return $this->openView(
            array_merge( $data , [
                'printers'   => $factoryApis->get('printer'),
                'isInput'    => $isInput,
                'routeSufix' => $routeSufix,
                'btn'        => route('register.sector.index')
            ]),
            'view'
        );
    }

}
