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
