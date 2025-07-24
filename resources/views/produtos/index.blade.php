@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-aperture color-st1"></i>&nbsp;&nbsp;Produtos</h3>
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
                                            <th class="text-left">Nome</th>
                                            <th class="text-left" width="120">Preço</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($produtos->count())
                                            @foreach($produtos as $produto)
                                                <tr>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('produtos.edit',['id'=>$produto->id])}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-edit fa-ico-fix-top1px"></i></a>
                                                        <button type="button" href="javascript:void(0);" data-href="{{route('produtos.destroy',['id'=>$produto->id])}}" data-hash="{{$produto->id}}" data-method="DELETE" data-type="warning" data-title="Excluir" data-msg="Deseja realmente excluir este produto?" class="btn btn-sm btn-danger app-confirm"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td class="text-center" nowrap>{{$produto->id}}</td>
                                                    <td class="text-left" nowrap>
                                                        @php
                                                            $imagem             = (!empty($produto->imagem)?URL('/storage').'/'.$produto->imagem:URL('/').'/assets/images/default.jpg');
                                                            $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{$imagem}}" width="50" alt="Imagem" />
                                                            </div>
                                                            <div class="">
                                                                {{( $produto->nome ? $produto->nome : '---' )}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-left" nowrap>R$ {{( $produto->preco ? \App\Helpers\Helper::H_Decimal_DB_ptBR($produto->preco) : '---' )}}</td>
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
                                    <a href="{{route('produtos.create')}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</a>
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
