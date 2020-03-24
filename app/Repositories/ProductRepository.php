<?php

namespace App\Repositories;

use Danganf\MyClass\Json\Contracts\JsonAbstract;
use Danganf\Repositories\Contracts\RepositoryAbstract;

class ProductRepository extends RepositoryAbstract
{
    public function __construct(){
        parent::__construct( __CLASS__ );
        return $this;
    }

    public function filter( $filterArray = [] ){

        $limit = array_get( $filterArray, 'limit', 0 );
        $limit = !empty( $limit ) ? $limit : 25;

        $order  = array_get( $filterArray, 'sort'   , 'id' );
        $order .= ' '.array_get( $filterArray, 'dir', 'asc' );

        $where  = '';

        if( !empty( trim( array_get( $filterArray, 'search', '' ) ) ) ){
            $this->setFilter($where, "sku='".$filterArray['search']."' or name like '%".$filterArray['search']."%'");
        }
        if( !empty( trim( array_get( $filterArray, 'sku', '' ) ) ) ){
            $this->setFilter($where, "sku='".$filterArray['sku']."'");
        }
        if( !empty( trim( array_get( $filterArray, 'name', '' ) ) ) ){
            $this->setFilter($where, "name like '%".$filterArray['name']."%'");
        }
        if( !empty( trim( array_get( $filterArray, 'status', '' ) ) ) ){
            $filterValue = convert_sn_bool( array_get( $filterArray, 'status', '' ) );
            if( !is_null( $filterValue ) ) {
                $this->setFilter($where, 'status=' . $filterValue);
            }
        }

        $querie = $this->getModel()->OrderByRaw( $order );

        if( !empty( $where ) ){
            $querie = $querie->whereRaw( trim( $where ) );
        }

        $result = $querie->paginate( $limit );

        return $result->isNotEmpty() ? $result->toArray() : [];

    }

    public function createOrUpdate(JsonAbstract $jsonValues, $sku=null)
    {
        $return = FALSE;
        $query  = $this->getModel()->whereRaw("sku='".$jsonValues->get('sku')."'");

        if( !empty( $sku ) ) {
            $query->where( 'sku', '!=', $sku );
        }

        if( $query->count() == 0 ){
            $instanceModel = $this->getModel();
        }

        if( isset( $instanceModel ) ){

            $flag = TRUE;
            if( !empty( $sku ) ) {
                $this->findBy( 'sku', $sku);
                if( $this->fails() ){
                    $flag = FALSE;
                    $this->setMsgError( \Lang::get('default.register_not_exist') );
                }
            }
            if( $flag ) {
                foreach ($jsonValues->toArray() as $key => $value) {
                    $this->set( $key, $value );
                }
                $this->save();
                $return = TRUE;
            }

        } else {
            $this->setMsgError( \Lang::get('default.uk_exists') );
        }

        return $return;
    }

    public function stockIn( $sku, $qtd )
    {
        $return = FALSE;
        $qtd    = (int) $qtd;
        if( $qtd > 0 ) {
            $this->findBy('sku', $sku);
            if (!$this->fails()) {
                $this->getModel()->increment('stock', $qtd);
                $return = TRUE;
            }
        }
        return $return;
    }
}