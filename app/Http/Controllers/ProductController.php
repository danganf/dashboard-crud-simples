<?php

namespace App\Http\Controllers;

use App\MyClass\FactoryApis;
use App\MyClass\PdvApi;
use App\MyClass\Traits\OpenViewController;
use Illuminate\Http\Request;
use IntercaseDefault\MyClass\CoreConfigData;

class ProductController extends Controller
{
    use OpenViewController;

    private $title    = 'Produtos';
    private $pathView = 'products';
    private $subtitle;

    public function indexInputs(Request $request, FactoryApis $factoryApis, CoreConfigData $coreConfigData){
        $this->subtitle = 'Insumos';
        $this->title    = 'Insumos';

        if( !$request->has('product_status') ) {
            //COLOQUEI AQUI PRA REPLICAR NO FRONT, NAS OPCOES FILTRADAS
            $request->merge(['product_status' => 'S']);
        }
        $factoryApis->setFilters([ 'is_input' => 'S' ]);
        return $this->index( $request, $factoryApis, 'inputs', $coreConfigData );
    }

    public function indexMain(Request $request, FactoryApis $factoryApis){
        $this->subtitle = 'Produtos';
        $factoryApis->setFilters([ 'is_input' => 'N' ]);
        return $this->index( $request, $factoryApis, 'main', null );
    }

    private function index(Request $request, FactoryApis $factoryApis, $action = 'main', $coreConfigData=null){

        $filtersTmp           = getVariablesFilter($request);
        $filtersTmp['offset'] = ( array_get( $filtersTmp, 'offset', 0) );
        $filtersTmp['limit']  = ( array_get( $filtersTmp, 'limit', 12) );
        $filtersTmp['order']  = ( array_get( $filtersTmp, 'order', 'name asc') );

        $factoryApis->setFilters($filtersTmp);
        $factoryApis->setPaginate();

        $products = $factoryApis->get('product');

        $filtersCategory = ['order'=>'name asc', 'limit' => 'ALL', 'is_input' => 'N'];
        if( strpos( getRouteName(), 'inputs') !== false  ){$filtersCategory['is_input'] = 'S';}

        return $this->openView( [
            'paginator_info' => assemblePaginatorInfo( array_get( $products, 'PAGINATOR', null ) ),
            'products'       => ( !empty( $products ) ? $products['RESULT'] : [] ),
            'filters'        => $filtersTmp,
            'action'         => $action,
            'paginator'      => buildUrlPaginator($filtersTmp,$products),
            'categories'     => $factoryApis->setFilters($filtersCategory)->get('category'),
            'sectories'      => $factoryApis->setFilters($filtersCategory)->get('sector'),
            'units'          => $factoryApis->setFilters(['order'=>'name asc', 'limit' => 'ALL'])->get('unit'),
            'tags'           => $factoryApis->setFilters($filtersCategory)->get('tag'),
            'prioritys'      => is_object( $coreConfigData ) ? $coreConfigData->getConfigJsonCatalogProductInputPriority() : []
        ]);
    }

    public function newInputs(FactoryApis $factoryApis, CoreConfigData $coreConfigData){
        $this->subtitle = 'Novo insumo';
        $this->title    = 'Novo insumo';
        return $this->new( $factoryApis, 'inputs', $coreConfigData );
    }

    public function newMain(FactoryApis $factoryApis, CoreConfigData $coreConfigData){
        $this->subtitle = 'Novo Produto';
        return $this->new( $factoryApis, 'main', $coreConfigData );
    }

    private function new(FactoryApis $factoryApis, $action='main', CoreConfigData $coreConfigData){

        $filtersCategory = ['order'=>'name asc', 'limit' => 'ALL', 'is_input' => 'N'];
        if( $action !== 'main'  ){$filtersCategory['is_input'] = 'S';}

        return $this->openView([
            'product'     => [],
            'tags'        => $factoryApis->setFilters( $filtersCategory )->get('tag'),
            'categories'  => $factoryApis->setFilters( $filtersCategory )->get('category'),
            'sectories'   => $factoryApis->setFilters( $filtersCategory )->get('sector'),
            'units'       => $factoryApis->setFilters(['order'=>'name asc', 'limit' => 'ALL'])->get('unit'),
            'providers'   => $action !== 'main' ? $factoryApis->setFilters(['fields' => 'id,name'])->get('provider@avaible') : [],
            'btn'         => route('catalog.products.index_'.$action),
            'sku'         => null,
            'url'         => getRouteName(),
            'action'      => $action,
            'isDuplicate' => FALSE,
            'prioritys'   => $coreConfigData->getConfigJsonCatalogProductInputPriority()
        ], 'view');
    }

    public function viewInput($sku, FactoryApis $factoryApis, CoreConfigData $coreConfigData){
        $this->subtitle = 'Dados do insumo';
        $factoryApis->setFilters([ 'is_input' => '1' ]);
        return $this->view( $sku, $factoryApis, 'inputs', $coreConfigData );
    }

    public function viewMain($sku, FactoryApis $factoryApis, CoreConfigData $coreConfigData){
        $this->subtitle = 'Dados do produto';
        $factoryApis->setFilters([ 'is_input' => '0' ]);
        return $this->view( $sku, $factoryApis, 'main', $coreConfigData );
    }

    private function view($sku, FactoryApis $factoryApis, $action = 'main', CoreConfigData $coreConfigData){

        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        } else {
            $tmp = (int)array_get($product, 'config.is_input');
            if( ( $action == 'main' && $tmp == 1 ) || ( $action == 'inputs' && $tmp == 0 ) ){
                abort(404, 'Produto não encontrado');
            }
        }

        $filtersCategory = ['order'=>'name asc', 'limit' => 'ALL', 'is_input' => 'N'];
        if( $action !== 'main'  ){$filtersCategory['is_input'] = 'S';}

        $isDuplicate = strpos( getRouteName(), 'duplicate' ) === FALSE ? FALSE : TRUE;

        if( $isDuplicate )
            $this->title .= ' <small><strong>(DUPLICANDO)</strong></small>';

        return $this->openView([
            'product'     => $product,
            'tags'        => $factoryApis->setFilters( $filtersCategory )->get('tag'),
            'categories'  => $factoryApis->setFilters( $filtersCategory )->get('category'),
            'sectories'   => $factoryApis->setFilters( $filtersCategory )->get('sector'),
            'units'       => $factoryApis->setFilters(['order'=>'name asc', 'limit' => 'ALL'])->get('unit'),
            'providers'   => $action !== 'main' ? $factoryApis->setFilters(['fields' => 'id,name'])->get('provider@avaible') : [],
            'btn'         => route('catalog.products.index_' . $action ),
            'sku'         => $sku,
            'url'         => getRouteName(),
            'action'      => $action,
            'isDuplicate' => $isDuplicate,
            'prioritys'   => $coreConfigData->getConfigJsonCatalogProductInputPriority()
        ],'view');

    }

    public function images($sku, Request $request, FactoryApis $factoryApis){
        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        }

        $routeName = getRouteName();
        $action    = strpos( $routeName, 'inputs' ) === false ? 'main' : 'inputs';

        $this->title      = $product['name'];
        $this->subtitle[] = 'Imagens do produto';

        return $this->openView([
            'product'    => $product,
            'btn'        => route('catalog.products.index_'.$action),
            'sku'        => $sku,
            'url'        => $routeName,
            'action'     => $action,
        ],'view-images');
    }

    public function stockAction( $action, Request $request, FactoryApis $factoryApis ){

        if( in_array( $action, ['in','discard'] ) ){
            $this->subtitle = $action === 'in' ? 'Nova entrada' : 'Novo descarte';
            return $this->openView([
                'products' => $factoryApis->setFilters(['is_input' => 'N', 'type' => 'SIMPLES', 'product_status' => 'S', 'limit' => 'ALL'])->get('product'),
                'action' => $action,
            ], 'stock');
        }
        abort(404, 'Ação incorreta!');
    }

    public function bannerPromo($sku, Request $request, FactoryApis $factoryApis){
        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        } else {
            if( (int)array_get($product, 'config.is_input') !== 0 ){
                abort(404, 'Produto não encontrado');
            }
        }

        $this->title      = $product['name'];
        $this->subtitle[] = 'Banner promocional';

        return $this->openView([
            'product'    => $product,
            'btn'        => route('catalog.products.index_main'),
            'sku'        => $sku,
            'url'        => getRouteName(),
            'action'     => 'main'
        ],'view-banner-promo');
    }

    public function additional($sku, Request $request, FactoryApis $factoryApis){

        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        }

        $this->subtitle[] = $product['name'];
        $this->subtitle[] = 'Itens adicionais';

        return $this->openView([
            'product'        => $product,
            'btn'            => route('catalog.products.index_main'),
            'sku'            => $sku,
            'url'            => getRouteName(),
            'action'         => 'main'
        ],'view-additional');
    }

    public function productionSheet($sku, Request $request, FactoryApis $factoryApis){

        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        }

        $this->subtitle[] = 'Ficha de produção';
        $this->title      = $product['name'];

        return $this->openView([
            'product'        => $product,
            'btn'            => route('catalog.products.index_main'),
            'sku'            => $sku,
            'url'            => getRouteName(),
            'action'         => 'main'
        ],'view-production-sheet');
    }

    public function stockHistory($sku, Request $request, FactoryApis $factoryApis){
        $product = $factoryApis->get('product/find-by/sku',$sku);

        if( empty( $product ) ) {
            abort(404, 'Produto não encontrado');
        }

        $filtersTmp           = getVariablesFilter($request);
        $filtersTmp['offset'] = ( array_get( $filtersTmp, 'offset', 0) );
        $filtersTmp['limit']  = ( array_get( $filtersTmp, 'limit', 5) );
        $filtersTmp['order']  = ( array_get( $filtersTmp, 'order', 'id desc') );

        $factoryApis->setFilters($filtersTmp);
        $factoryApis->setPaginate();

        $stock = $factoryApis->get('product','stock@'.$sku);

        $this->title      = $product['name'];
        $this->subtitle[] = 'Movimentação do estoque';

        return $this->openView([
            'paginator_info' => assemblePaginatorInfo( array_get( $stock, 'PAGINATOR', null ) ),
            'stock'          => ( !empty( $stock ) ? $stock['RESULT'] : [] ),
            'btn'            => route('catalog.products.index_main'),
            'paginator'      => buildUrlPaginator($filtersTmp,$stock),
            'sku'            => $sku,
            'url'            => getRouteName(),
            'product'        => $product,
            'action'         => 'main'
        ],'view-stock-history');
    }
}
