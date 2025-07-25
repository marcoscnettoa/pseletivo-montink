@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-tag color-st1"></i>&nbsp;&nbsp;Variações</h3>
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
                                                <th class="text-left">Produto</th>
                                                <th class="text-left">Nome / Variação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($variacoes->count())
                                            @foreach($variacoes as $variacao)
                                                <tr>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('variacoes.edit',['id'=>$variacao->id])}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-edit fa-ico-fix-top1px"></i></a>
                                                        <button type="button" href="javascript:void(0);" data-href="{{route('variacoes.destroy',['id'=>$variacao->id])}}" data-hash="{{$variacao->id}}" data-method="DELETE" data-type="warning" data-title="Excluir" data-msg="Deseja realmente excluir esta variação do produto?" class="btn btn-sm btn-danger app-confirm"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td class="text-center" nowrap>{{$variacao->id}}</td>
                                                    <td class="text-left" nowrap>
                                                        @php
                                                            $imagem             = (($variacao->getProduto && !empty($variacao->getProduto->imagem))?URL('/storage').'/'.$variacao->getProduto->imagem:URL('/').'/assets/images/default.jpg');
                                                            $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{$imagem}}" width="50" alt="Imagem" />
                                                            </div>
                                                            <div class="">
                                                                {{ (($variacao->getProduto && $variacao->getProduto->nome) ? $variacao->getProduto->nome : '---' ) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-left" nowrap>{{( $variacao->nome ? $variacao->nome : '---' )}}</td>
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
                                    <a href="{{route('variacoes.create')}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</a>
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
