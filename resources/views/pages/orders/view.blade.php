@extends('layout')

@section('content')

    <section id="text-alignment">
        <div class="row">
            <div class="col-xl-4 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title info">
                                Informações
                                <div class="pull-right">
                                    <span title="@if(array_get($order,'its_paid')) Pedido pago @else Pagamento pendente @endif"
                                          class="badge @if(array_get($order,'its_paid')) badge-success @else badge-danger @endif">
                                          <i class="@if(array_get($order,'its_paid')) ft-thumbs-up @else ft-thumbs-down @endif"></i>
                                    </span>
                                @if( array_get($order,'is_travel') )
                                    <span title="Embalagem para viagem" class="badge badge-warning">
                                        <i class="ft-package"></i>
                                    </span>
                                @endif
                                    @component('components.btn-orders-print', [ 'order' => $order ] ) @endcomponent
                                </div>
                            </h4>
                            <form class="form form-horizontal striped-labels form-bordered">
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Pedido</label>
                                        <div class="col-md-8">
                                           <strong>{{$order['sale_code']}}</strong>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Situação</label>
                                        <div class="col-md-8">
                                            <div class="badge
                                                 @if(!in_array($order['state'],['canceled','closed']))
                                                    @if( $order['state'] == 'complete' ) badge-success @else badge-info @endif
                                                 @else badge-danger @endif"
                                            >
                                                {{array_get($order, 'status_label')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Quando</label>
                                        <div class="col-md-8">
                                            <strong>{{array_get($order,'created_at')}}</strong>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Forma de pagamento</label>
                                        <div class="col-md-8">
                                        @if( empty( array_get( $order, 'payment' ) ) )
                                            <strong>
                                                {{array_get($order,'payment_label')}}
                                                @if( !array_get($order,'its_paid') )
                                                    <span class="badge badge-danger"><i class="ft-thumbs-down"></i> Não pago</span>
                                                @endif

                                            </strong>
                                        @else
                                            @foreach( array_get( $order, 'payment' ) as $payment )
                                                @php
                                                    $method = $payment['method'];
                                                    if( $payment['code'] !== 'money' ){$method .= ' - ' . $payment['flag'];}
                                                    if( $payment['obs'] === 'PAYBACK' ){$method = \Lang::get('default.'.strtolower( 'PAYBACK' ));}
                                                @endphp
                                                <p><strong><i class="la la-check-circle"></i> {{$method}} - R$ {{format_number( $payment['value'], 2 )}}</strong></p>
                                            @endforeach
                                        @endif
                                        </div>
                                    </div>
                                @if( !array_get($order,'is_travel') )
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Buscar no balcão</label>
                                        <div class="col-md-8">
                                            <strong>{{array_get($order,'pick_name')}}</strong>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title info">Cliente</h4>
                            <form class="form form-horizontal striped-labels form-bordered">
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Nome</label>
                                        <div class="col-md-8">
                                            <strong>
                                                    @if ( array_get( $order, 'client_name' ) ) {{array_get($order, 'client_name')}}
                                                @elseif ( array_get( $order, 'user_name' ) )   {{array_get($order, 'user_name')}}
                                                @else Não informado @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Telefones</label>
                                        <div class="col-md-8">
                                            <strong>
                                                    @if ( array_get( $order, 'client_cellphone' ) ) {{array_get($order, 'client_cellphone')}}
                                                @elseif ( array_get( $order, 'user_mobile_fone' ) ) {{array_get($order, 'user_mobile_fone')}}
                                                @else Não informado @endif
                                                @if ( array_get( $order, 'client_phone' ) ) <p>{{array_get($order, 'client_phone')}}</p> @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">E-mail</label>
                                        <div class="col-md-8">
                                            <strong>
                                                    @if ( array_get( $order, 'client_email' ) ) {{array_get($order, 'client_email')}}
                                                @elseif ( array_get( $order, 'user_email' ) )   {{array_get($order, 'user_email')}}
                                                @else Não informado @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">CPF</label>
                                        <div class="col-md-8">
                                            <strong>@if ( array_get( $order, 'user_document' ) ) {{array_get($order, 'user_document')}} @else Não informado @endif</strong>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @if( !empty( $order['delivery'] ) )
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title info">Entrega</h4>
                            <form class="form form-horizontal striped-labels form-bordered">
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Local</label>
                                        <div class="col-md-8">
                                            <strong>{{array_get($order, 'delivery.label')}}</strong>
                                        </div>
                                    </div>
                                @if( array_get($order,'is_travel') )
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">Quando</label>
                                        <div class="col-md-8">
                                            <strong>{{array_get($order,'pick_name')}}</strong>
                                        </div>
                                    </div>
                                @endif

                                @foreach( array_get( $order, 'delivery.attributes' ) AS $attributes )
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="projectinput1">{{$attributes['label']}}</label>
                                        <div class="col-md-8">
                                            <strong>{{$attributes['value']}}</strong>
                                        </div>
                                    </div>
                                @endforeach

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            </div>
            <div class="col-xl-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title info">Itens do pedido</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse open show">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Produto</th>
                                        <th>Preço</th>
                                        <th>Situação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                @foreach( array_get( $order, 'items' ) AS $item )

                                    @php $classI = 'success'; @endphp
                                    @switch($item['state'])
                                        @case('new')
                                        @php $classI = 'warning'; @endphp
                                        @break
                                        @case('closed')
                                        @case('canceled')
                                        @php $classI = 'danger'; @endphp
                                        @break
                                        @case('processing')
                                        @php $classI = 'info'; @endphp
                                        @break
                                    @endswitch

                                    <tr>
                                        <td>{!! $item['product_id'] !!}</td>
                                        <td>
                                            {!! $item['qty'].'x '.$item['product_name'] !!}
                                            @if( !empty( $item['observation'] ) )
                                            <code class="font-small-2 text-bold-600 display-table-cell">{{$item['observation']}}</code>
                                            @endif
                                        </td>
                                        <td>{!! $item['final_price'] !!}</td>
                                        <td><i class="la la-dot-circle-o {!! $classI !!} font-medium-1 mr-1"></i>{!! $item['status_label'] !!}</td>
                                    </tr>

                                    @if( !empty( array_get( $item, 'additional', [] ) ) )
                                        @foreach( $item['additional']  as $additional )
                                            @php $classI = 'success'; @endphp
                                            @switch($item['state'])
                                                @case('new')
                                                @php $classI = 'warning'; @endphp
                                                @break
                                                @case('closed')
                                                @case('canceled')
                                                @php $classI = 'danger'; @endphp
                                                @break
                                                @case('processing')
                                                @php $classI = 'info'; @endphp
                                                @break
                                            @endswitch
                                            <tr style="background-color: #FAFBFC">
                                                <td>&nbsp;</td>
                                                <td style="padding-left: 45px !important;">
                                                    @php
                                                        $qtyPay  = $additional['qty'];
                                                        $qtyFree = $additional['qty_free'];
                                                    @endphp
                                                    {!! $qtyPay.'x '.$additional['product_name'] !!}
                                                    @php
                                                        $obs = $additional['observation'];
                                                        if( $qtyFree > 0 ){
                                                            $obs = ( $qtyFree !== $qtyPay ? $qtyFree.' ' : '' ) . 'GRÁTIS' . (empty( $obs ) ? '' : '. ') . $obs;
                                                        }
                                                    @endphp
                                                    @if( !empty( $obs ) )
                                                        <code class="font-small-2 text-bold-600 display-table-cell">{{trim( $obs )}}</code>
                                                    @endif
                                                </td>
                                                <td>{!! $additional['final_price'] !!}</td>
                                                <td><i class="la la-dot-circle-o {!! $classI !!} font-medium-1 mr-1"></i>{!! $additional['status_label'] !!}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title info">Total</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse open show">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-right">R$ {{$order['grand_total']}}</td>
                                    </tr>
                                @if ($order['discount_percent'] > 0)
                                    <tr>
                                        <td>Desconto ({!! $order['discount_percent'] !!}%)</td>
                                        <td class="pink text-right">(-) R$ {{$order['discount_price']}}</td>
                                    </tr>
                                @endif
                                    <tr>
                                        <td class="text-bold-800">Total</td>
                                        <td class="text-bold-800 text-right"> R$ {{$order['final_price']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if( !empty( $order['observation'] ) )
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title info">Observação da venda</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse open show">
                        <div class="card-body">
                            <blockquote class="blockquote pl-1 border-left-danger border-left-3">
                                <p class="mb-0">{!! $order['observation'] !!}</p>
                            </blockquote>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    {{--<div class="sidebar-detached sidebar-left">
        <div class="sidebar">
            <div class="bug-list-sidebar-content">
                <!-- Predefined Views -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Informações</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- bug-list search -->
                    <div class="card-content show">
                        <div class="card-body border-top-blue-grey border-top-lighten-5">
                            <div class="bug-list-search">
                                <div class="bug-list-search-content">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="projectinput1">Pedido</label>
                                                <div class="col-md-9">
                                                    #0000000001
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /bug-list search -->
                    </div>
                </div>
                <!--/ Predefined Views -->

            </div>
        </div>
    </div>--}}

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let pdvMenus = new PDVMenus();
            pdvMenus.bindNFCe( pdvMenus, true );
            pdvMenus.bindRePrint( pdvMenus, true );
        });
    </script>
@endsection


