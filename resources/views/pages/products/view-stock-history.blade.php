@extends('layout')

@section('content')

    <section class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="cardFilter" class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                        @if( !empty( $stock ) )
                            <h2 style="background-color: #F1F1F4;" class="p-1">Estoque Atual: <strong>{{$stock[0]['qty_ready']}}</strong></h2>
                        @endif
                            <div class="table-responsive">
                                <table class="table table-hover table-xl mb-0 mt-1">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0">Tipo</th>
                                        <th class="border-top-0">Quantidade</th>
                                        <th class="border-top-0">Data</th>
                                        <th class="border-top-0">Funcionário</th>
                                        <th class="border-top-0">Pedido</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $stock as $row )
                                        @php
                                            $employee = $row['employee_name'];
                                            $employee = empty( $employee ) ? '--' : $employee;
                                        @endphp
                                        <tr>
                                            <td class="text-truncate">{{\Lang::get('default.'.strtolower( $row['type'] ))}}</td>
                                            <td class="text-truncate @if( $row['qty'] < 0 ) text-danger @endif">{{$row['qty']}}</td>
                                            <td class="text-truncate">{{$row['created_at']}}</td>
                                            <td class="text-truncate">{{$employee}}</td>
                                            <td class="text-truncate">
                                                @if( !empty( $row['sale_code'] ) )
                                                    <a target="_blank" href="{{route('orders.view', $row['sale_code'])}}">{{$row['sale_code']}}</a>
                                                    <br/>
                                                    <small>{{$row['order_origin'].' - '.\Lang::get('default.'.strtolower( $row['order_type'] ))}}</small>
                                                @else
                                                    --
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row pull-right">
                                @component('components.paginator', ['paginator' => $paginator]) @endcomponent
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
            @include('pages.products.includes.list-grup')
        </nav>
    </section>

@endsection

@section('js')
    <script>

        $( document ).ready(function() {
            {!! js_code_product_page() !!}
        });

    </script>
@endsection
