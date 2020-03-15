<ul class="list-group list-group-flush">
    @define $icon              = 'la la-group';
    @define $title             = $order['type_label'];
    @define $deliveryPlace     = '';
    @define $customerName      = '';
    @define $customerPhone     = '';
    @define $customerCellPhone = '';

    @if( in_array( $order['type'], [ 'DELIVERY', 'PICKUP' ] ) )
        @define $icon  = 'la la-truck';
    @endif

    @if( $order['type'] === 'DELIVERY' )
        @php
            $deliveryPlace = '<strong>'.$order['delivery_label'].':</strong> ';
            foreach ( $order['delivery_json_info'] as $info ){
                $deliveryPlace .= $info['label'].' '.$info['value'].', ';
            }
            $deliveryPlace = rtrim( $deliveryPlace, ', ' );
        @endphp
    @else
        @define $icon = 'la la-archive';
    @endif

    @php
        $customerName      = $order['client_name'];
        $customerPhone     = $order['client_phone'];
        $customerCellPhone = $order['client_cellphone'];

        $customerName      = !empty( $customerName )      ? $customerName      : $order['user_name'];
        $customerCellPhone = !empty( $customerCellPhone ) ? $customerCellPhone : $order['user_mobile_fone'];

        if( empty( $customerPhone ) && empty( $customerCellPhone ) && !empty( array_get( $order,  'name_call' ) ) ){
            $customerName = 'Chamar por: <strong>' . strtoupper( $order['name_call'] ) . '</strong>';
        }

    @endphp


    @if( !empty( $customerName ) )
    <li class="list-group-item no-padding delivery" style="background: transparent">
        <i class="la la-group icon pull-left" title="{{$title}}"></i>
        <div class="customer-name truncate">{!! ( !empty( $customerName ) ? $customerName : 'Não identificado' ) !!}</div>
        @if( !empty( $customerPhone ) || !empty( $customerCellPhone ) )
        <div class="delivery-customer-cellphone">
        <small>{{mask_string($customerCellPhone)}}</small>
        <small>{{mask_string($customerPhone)}}</small>
        </div>
        @endif
        @if( !empty( $deliveryPlace ) )
            <i class="la la-truck pull-left" title="Delivery"></i>
            <div class="place">
                <small>{!! $deliveryPlace !!}</small>
            </div>
            @if( !empty( array_get( $order, 'delivery_obs' ) ) )
            <div class="place" style="margin-top: -10px">
                <small class="text-danger font-weight-bold">{!! $order['delivery_obs'] !!}</small>
            </div>
            @endif
        @endif
    </li>
    @else
    <li class="list-group-item no-padding delivery" style="background: transparent">
        <i class="la la-group icon pull-left" style="display: none" title="{{$title}}"></i>
        &nbsp;
    </li>
    @endif
    @if( !empty( array_get( $order, 'cashier_name' ) ) )
    <li class="list-group-item deliveryman" style="background: transparent">
        <i class="la la-desktop pull-left" title="Caixa"></i>
        <div>
            <strong>Caixa:</strong> {{ array_get( $order, 'cashier_name' ) }}           
        </div>
    </li>
    @endif
    @if( !empty( array_get( $order, 'deliveryman_name' ) ) )
    <li class="list-group-item deliveryman" style="background: transparent">
        <i class="la la-user pull-left" title="Entregador" data-order-icon="{{$icon}}"></i>
        <div><strong>Entregador(a):</strong> {{ array_get( $order, 'deliveryman_name' ) }}</div>
    </li>
    @endif
</ul>
