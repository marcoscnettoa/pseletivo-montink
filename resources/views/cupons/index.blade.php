@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-award color-st1"></i>&nbsp;&nbsp;Cupons</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <div class="content-body mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-content mt-1">
                                <div class="table-responsive">
                                    <table class="table table-st1 table-striped table-bordered datatable-st1">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="80" data-orderable="false">#</th>
                                                <th class="text-center" width="60"># ID</th>
                                                <th class="text-left">Código</th>
                                                <th class="text-left">Desconto</th>
                                                <th class="text-left">Valor Mínimo</th>
                                                <th class="text-left">Validade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($cupons->count())
                                            @foreach($cupons as $cupom)
                                                <tr>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('cupons.edit',['id'=>$cupom->id])}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-edit fa-ico-fix-top1px"></i></a>
                                                        <button type="button" href="javascript:void(0);" data-href="{{route('cupons.destroy',['id'=>$cupom->id])}}" data-hash="{{$cupom->id}}" data-method="DELETE" data-type="warning" data-title="Excluir" data-msg="Deseja realmente excluir esta variação de produto?" class="btn btn-sm btn-danger app-confirm"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td class="text-center" nowrap>{{$cupom->id}}</td>
                                                    <td class="text-left" nowrap>{{( $cupom->codigo ? $cupom->codigo : '---' )}}</td>
                                                    <td class="text-left" nowrap>{{( $cupom->desconto ? \App\Helpers\Helper::H_Decimal_DB_ptBR($cupom->desconto) : '---' )}}</td>
                                                    <td class="text-left" nowrap>{{( $cupom->valor_minimo ? \App\Helpers\Helper::H_Decimal_DB_ptBR($cupom->valor_minimo) : '---' )}}</td>
                                                    <td class="text-left" nowrap>{{( $cupom->validade ? \App\Helpers\Helper::H_Data_DB_ptBR($cupom->validade) : '---' )}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{route('cupons.create')}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        /* ... */
    </script>
@endsection
