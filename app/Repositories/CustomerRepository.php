<?php

namespace App\Repositories;

use Danganf\MyClass\Json\Contracts\JsonAbstract;
use Danganf\Repositories\Contracts\RepositoryAbstract;

class CustomerRepository extends RepositoryAbstract
{
    public function __construct()
    {
        parent::__construct( __CLASS__ );
    }

    public function filter( $filterArray = [] ){

        $limit = array_get( $filterArray, 'limit', 0 );
        $limit = !empty( $limit ) ? $limit : 25;

        $where  = '';

        if( !empty( trim( array_get( $filterArray, 'document', '' ) ) ) ){
            $this->setFilter($where, "document='".$filterArray['document']."'");
        }
        if( !empty( trim( array_get( $filterArray, 'name', '' ) ) ) ){
            $this->setFilter($where, "name like '%".$filterArray['name']."%'");
        }
        if( !empty( trim( array_get( $filterArray, 'email', '' ) ) ) ){
            $this->setFilter($where, "email like '%".$filterArray['email']."%'");
        }
        if( !empty( trim( array_get( $filterArray, 'status', '' ) ) ) ){
            $filterValue = convert_sn_bool( array_get( $filterArray, 'status', '' ) );
            if( !is_null( $filterValue ) ) {
                $this->setFilter($where, 'status=' . $filterValue);
            }
        }

        $querie = $this->getModel();

        if( !empty( $where ) ){
            $querie = $querie->whereRaw( trim( $where ) );
        }

        $result = $querie->paginate( $limit );

        return $result->isNotEmpty() ? $result->toArray() : [];

    }

    public function createOrUpdate(JsonAbstract $jsonValues, $id=null)
    {
        $return = FALSE;
        $query  = $this->getModel()
                    ->whereRaw("(email='".$jsonValues->get('email')."' or document='".$jsonValues->get('document')."')");

        if( !empty( $id ) ) {
            $query->where( 'id', '!=', $id );
        }

        if( $query->count() == 0 ){
            $instanceModel = $this->getModel();
        }

        if( isset( $instanceModel ) ){

            $flag = TRUE;
            if( !empty( $id ) ) {
                $this->find($id);
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
}
