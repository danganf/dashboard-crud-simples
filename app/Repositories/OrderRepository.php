<?php

namespace App\Repositories;

use Danganf\MyClass\Json\Contracts\JsonAbstract;
use Danganf\Repositories\Contracts\RepositoryAbstract;
use Illuminate\Support\Facades\DB;

class OrderRepository extends RepositoryAbstract
{
    public function __construct(){
        parent::__construct( __CLASS__ );
        return $this;
    }

    public function createOrUpdate( JsonAbstract $json, $id=null ){

        $return = [];

        // BUSCANDO O CLIENTE
        $resultCustomer = $this->getModel()->customer()->getRelated()
                            ->where('status', 1)->where('id', $json->get('customer_id') )
                            ->select('name', 'phone', 'email')->first();

        if( !empty( $resultCustomer ) ){

            $resultCustomer = $resultCustomer->toArray();

            $items = objectToArray( $json->get('items') );

            // BUSCANDO OS ITENS DO PEDIDO
            $resultCatalog = $this->getModel()->items()->getRelated()->catalog()->getRelated()
                ->where('status', 1)
                ->whereIn('id',  pluckMatriz( objectToArray( $items ), 'catalog_id' ) )
                ->select('id', 'sku', 'price')->get()->toArray();

            if( count($items) == count( $resultCatalog ) ){

                $grandTotal = 0;

                foreach( $items  as $key => $row ) {
                    $catalog            = current( search_in_array( $resultCatalog, 'id', $row['catalog_id'] ) );
                    $grandTotal        += ( $catalog['price'] * $row['qty'] );
                    $row['catalog_sku'] = $catalog['sku'];
                    $row['price']       = $catalog['price'];

                    $items[$key] = $row;
                }

                if( $json->get('final_price ') <= $grandTotal ){

                    $this->set( 'customer_id'      , $json->get('customer_id') );
                    $this->set( 'customer_name'    , $resultCustomer['name'] );
                    $this->set( 'customer_email'   , $resultCustomer['email'] );
                    $this->set( 'customer_phone'   , $resultCustomer['phone'] );
                    $this->set( 'grand_total'      , $grandTotal );
                    $this->set( 'final_price'      , $json->get('final_price ') );
                    $this->set( 'discount'         , $grandTotal - $json->get('final_price') );

                    DB::beginTransaction();

                    try{

                        $this->save();
                        $this->find( $this->getModel()->id );

                        foreach (  $items  as $row ) {
                            $modelTmp = $this->getModel()->items()->getRelated();
                            foreach ($row as $key => $value) {
                                $modelTmp->{$key} = !is_null($value) ? (string) $value : null;
                            }
                            $this->getModel()->items()->save($modelTmp);
                        }

                        $return = [
                            'id'         => $this->getModel()->id,
                            'created_at' => $this->getModel()->created_at,
                        ];


                    } catch ( \Exception $e ){
                        DB::rollback();
                        \LogDebug::error( $e->getMessage() );
                        $this->setMsgError( \Lang::get('default.create_error') );
                    }

                    DB::commit();

                } else {
                    $this->setMsgError( \Lang::get('default.value_order_error') );
                }

            } else {
                $this->setMsgError( \Lang::get('default.order_items_not_found') );
            }


        } else{
            $this->setMsgError( \Lang::get('default.customer_not_found') );
        }

        return $return;

    }
}