@php
    $approvedInPreparingAll = isset( $approvedInPreparingAll ) ? $approvedInPreparingAll : FALSE;
    $sectorsNotProcessing   = isset( $sectorsNotProcessing )   ? $sectorsNotProcessing   : [];
@endphp
@foreach( $orders AS $order )

    @define $itemsComplete = 'true';
    @define $cardIcon      = 'minus';
    @define $cardContent   = 'show';
    @define $itsPaid  = 'class="la la-money order-not-paid" title="Pagamento pendente"';

    @if( $order['its_paid'] )
        @define $itsPaid  = 'class="la la-money order-paid" title="Pedido Pago"';
    @endif

    @if( !empty( $currentOrder ) && $currentOrder == $order['sale_code'] )
        @define $cardIcon     = 'minus';
        @define $cardContent  = 'show';
        @define $currentOrder = '';
    @endif

  
    <div class="card box-shadow-0 border-{{$class}}" >
        <div class="card-header card-head-inverse bg-{{$class}} {{$classControl}}">
            <h5 class="card-title text-white"  data-code="{{$order['sale_code']}}" >
                <span class="badge badge-secondary round badge-origin">{{$order['origin']}}</span> n&ordm {{$order['sale_code']}} - {{last( explode(' ', $order['created_at']) )}}
            </h5>
            <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 order-col-header-info text-left" >
                    <div class="order-badge order-badge-{!! strtolower( $order['type'] ) !!} badge border-right-success border-left-success round badge-striped"></div>
                    <div class="order-badge-price font-weight-bold badge border-right-success border-left-success round badge-striped">
                            R$ {{$order['final_price']}}
                    </div>                    
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 order-col-header-info text-right">
                    @component('pages.orders.components.btn-kanban-card-header', [ 'order' => $order ] )
                        @slot('isAction')               APP                            @endslot
                        @slot('cardContent')           {{$cardContent}}                @endslot
                        @slot('itemsComplete')         {{$itemsComplete}}              @endslot
                        @slot('showCardFooter')        {{$showCardFooter}}             @endslot
                        @slot('approvedInPreparingAll'){{$approvedInPreparingAll}}     @endslot
                        @slot('posID')                 {{isset($posID) ? $posID : ''}} @endslot
                    @endcomponent        
                </div>                
            </div>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li>
                        <a data-action="collapse">
                            <i class="ft-{{$cardIcon}} order-collapse-{{$order['sale_code']}}" style="font-size: 1.2rem"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-content card-all collapse {{$cardContent}}">
            <div class="card-body p-t-5">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-7">
                        <ul class="list-group list-group-flush">
                            @foreach( $order['items'] AS $item )
                                @php
                                    $style = array_get( $item, 'product_id_parent', null ) === null ? '' : 'margin-left:10px;'
                                @endphp
                                <li class="list-group-item" title="{{$item['product_name']}}" style="{!! $style !!}">
                                    {{$item['qty'].'x '.$item['product_name']}}
                                    @if( !empty( $item['observation'] ) )
                                    <p class="m-0 truncate" title="{{$item['observation']}}"><small style="font-weight: 600">{{$item['observation']}}</small></p>
                                    @endif
                                    @if($order['state'] != 'new')
                                        @define $classItem = 'order-item';
                                        @if( empty( $item['next_status'] ) || in_array( $item['sector_id'], $sectorsNotProcessing ) )
                                            @define $classItem = '';
                                        @endif
                                        <div>
                                            <span class="badge {{$classItem}} border-left-success badge-order-item badge-striped span-item-{{$item['id']}}" title="atualizar item"
                                                  data-sale-code="{{$order['sale_code']}}" data-id="{{$item['id']}}" data-json-next-status="{{json_encode($item['next_status'])}}"
                                                  data-name="{{$item['product_name']}}">
                                                {{$item['status_label']}}
                                                @if( !empty( $item['next_status'] ) && !in_array( $item['sector_id'], $sectorsNotProcessing ) )
                                                    <i class="ft-refresh-ccw font-weight-bold"></i>
                                                    @define $itemsComplete = 'false';
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-5 payment">
                        @include('pages.orders.sections.monitor-paymethod')
                    </div>
                    <div class="col-md-12">
                        @include('pages.orders.sections.monitor-delivery')
                    </div>
                </div>
            </div>
        </div>
        @if( $order['state'] === 'new' ) 
            @component('pages.orders.components.btn-action', [ 'order' => $order ] )
                @slot('isAction')               APP                            @endslot
                @slot('cardContent')           {{$cardContent}}                @endslot
                @slot('itemsComplete')         {{$itemsComplete}}              @endslot
                @slot('showCardFooter')        {{$showCardFooter}}             @endslot
                @slot('approvedInPreparingAll'){{$approvedInPreparingAll}}     @endslot
                @slot('posID')                 {{isset($posID) ? $posID : ''}} @endslot
            @endcomponent
        @else
        <div class="container card-footer card-all border-top-blue-grey border-top-lighten-5 text-muted {{$cardContent}}">

                <div class="row">
                    <div class="col-md-12 text-right">
                       @component('components.btn-orders-print', [ 'order' => $order ] ) @endcomponent
                    </div>
                </div>
            
        </div>        
        @endif
    </div>
    <a name="anchor-{{$order['sale_code']}}"></a>

@endforeach
