<?php
/**
 * @SWG\Post(
 *   path="order",
 *   summary="Created order",
 *   operationId="order-create",
 *   tags={"Order"},
 *   @SWG\Parameter(in="body",name="body",description="",required=true,default="",
 *       @SWG\Schema(type="string",
 *          @SWG\Property(property="customer_id", type="string", example="37"),
 *          @SWG\Property(property="final_price", type="float", example="50,40"),
 *       @SWG\Property(property="items", type="array",
 *           @SWG\Items(type="object",
 *               @SWG\Property(property="catalog_id" ,type="integer", example=3),
 *               @SWG\Property(property="qty",type="integer", example=2)
 *           )
 *       ),
 *     )),
 *   @SWG\Response(response=201, description="successful operation. User created and rescued"),
 *   @SWG\Response(response=400, description="operation not completed"),
 * )
 *
 */